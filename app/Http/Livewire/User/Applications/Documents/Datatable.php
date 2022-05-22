<?php

namespace App\Http\Livewire\User\Applications\Documents;

use App\Http\Livewire\Authenticate;
use App\Models\Application;
use App\Models\Document;
use App\Models\service;
use App\Models\serviceRequirement;
use App\Traits\Data;
use App\Traits\Datatable\DocumentDatable;
use App\Traits\Datatable\DocumentPassportCommon;
use App\Traits\Datatable\General;
use App\Traits\Submit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;
use phpDocumentor\Reflection\Types\Integer;
use Spatie\Permission\Models\Permission;

class Datatable extends Authenticate
{
    use WithPagination;
    use General;
    use DocumentDatable;
    use DocumentPassportCommon;
    use Submit;
    use Data;


    protected $listeners = ['myController'];
    public string $filterDocumentRecord = 'all', $sortUser = 'asc';

    public array $chats = [];

    public function mount(Request $request)
    {

    }


    public function updatingFilterDocumentRecord($value)
    {
    }


    protected $messages = [

    ];

    public function myController($value)
    {
    }

    public function applicationDetails($id)
    {
        Redirect::route('user.application', [$id]);
    }

    public function userDetails($id)
    {
        Redirect::route('user.client-details', [$id]);
    }


    public function applicationChat($app)
    {
        $document = (Document::find($app['id'])->comments()->orderby('created_at', 'desc')->get());
        $this->chats = json_decode($document, true);
        $this->dispatchBrowserEvent('chat-modal', ['show' => true, 'title' => 'Comment History']);
        if ($app['users_id'] === auth()->user()->id) {
            foreach ($document as $a) {
                $a->opened = 1;
                $a->save();
            }
        }

    }




    public function render()
    {
        if (session()->has('code') && in_array(session('code'), ['all', 'review', 'accepted', 'rejected', 'revision'])) {
            $this->filterDocumentRecord = session('code');
            session()->forget('code');
        }


        if (Data::is_user_guard_web() && (in_array('user', $this->userRoles()['roles']) || in_array('manager', $this->userRoles()['roles'])) &&
            ($this->permission('user-all-applications-document-view'))) {
            $sortUser=$this->sortUser;
            $data = Document::orderBy('documents.created_at', 'desc')->with(['user','serviceRequirement']);

//            $data=Document::with('user')->join('users','user_id','=','users.id');
            $documentCount = Document:: select(DB::raw("COUNT(*) AS allDocumentCount"))
                ->selectRaw("
                        SUM(CASE WHEN (documents.accepted = '0' AND documents.rejected = '0' AND documents.revision = '0') THEN 1 ELSE 0 END) AS reviewDocumentsCount,
                        SUM(CASE WHEN (documents.accepted = '1' AND documents.rejected = '0' AND documents.revision = '0') THEN 1 ELSE 0 END) AS acceptedDocumentsCount,
                        SUM(CASE WHEN (documents.accepted = '0' AND documents.rejected = '1' AND documents.revision = '0') THEN 1 ELSE 0 END) AS rejectedDocumentsCount,
                        SUM(CASE WHEN (documents.accepted = '0' AND documents.rejected = '0' AND documents.revision = '1') THEN 1 ELSE 0 END) AS revisionDocumentsCount
                        ")
                ->first();

            switch ($this->filterDocumentRecord) {
                case 'all':
                    $documents = $data->paginate(10);;
                    break;

                case 'review':
                    $documents = $data->where('accepted', 0)->where('rejected', 0)->where('revision', 0)->paginate(10);
                    break;

                case 'accepted':
                    $documents = $data->where('accepted', 1)->where('rejected', 0)->where('revision', 0)->paginate(10);
                    break;

                case 'rejected':
                    $documents = $data->where('accepted', 0)->where('rejected', 1)->where('revision', 0)->paginate(10);
                    break;

                case 'revision':
                    $documents = $data->where('accepted', 0)->where('rejected', 0)->where('revision', 1)->paginate(10);
                    break;
            }

//            $allDocumentsCount = count($data->get());
//            $reviewDocumentsCount = count($data->where('accepted', 0)->where('rejected', 0)->where('revision', 0)->get());
//            $acceptedDocumentsCount = count($data->where('accepted', 1)->where('rejected', 0)->where('revision', 0)->get());
//            $rejectedDocumentsCount =count($data->where('accepted', 0)->where('rejected', 1)->where('revision', 0)->get());
//            $revisionDocumentsCount = count($data->where('accepted', 0)->where('rejected', 0)->where('revision', 1)->get());

            return view('livewire.user.applications.documents.datatable',
                [
                    'routeName' => $this->routeName,
                    'documents' => $documents,
                    'documentsCount' => $documentCount

                ]);
        } else {
            return view('livewire.errors.access-denied', ['name' => 'applications']);
        }
    }

    public function newApplication()
    {
        return redirect('/submit-application');
    }

    protected function serviceRules()
    {

    }

    protected function serviceRequirementRules()
    {

    }

    protected function validationAttributes()
    {

    }

    public function resetForm($form)
    {

    }
}
