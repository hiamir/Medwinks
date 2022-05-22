<?php

namespace App\Http\Livewire\User\Applications\Submissions;

use App\Http\Livewire\Authenticate;
use App\Models\Application;
use App\Models\service;
use App\Models\serviceRequirement;
use App\Traits\Data;
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
    use Submit;
    use Data;


    protected $listeners = ['myController'];
    public string $filterRecord = 'all';

    public array $chats = [];

    public function mount(Request $request){

    }



    public function updatingFilterRecord($value)
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
        $application = (Application::find($app['id'])->comments()->orderby('created_at', 'desc')->get());
        $this->chats = json_decode($application, true);
        $this->dispatchBrowserEvent('chat-modal', ['show' => true, 'title' => 'Comment History']);
        if ($app['users_id'] === auth()->user()->id) {
            foreach ($application as $a) {
                $a->opened = 1;
                $a->save();
            }
        }

    }


    public function render()
    {
        if(session()->has('code') && in_array(session('code'), ['all','review','accepted','rejected','revision'])){
                    $this->filterRecord=session('code');
                    session()->forget('code');
        }


        if (Data::is_user_guard_web() && (in_array('user', $this->userRoles()['roles']) || in_array('manager', $this->userRoles()['roles'])) &&
            ($this->permission('user-submit-application-view') || $this->permission('user-all-applications-view'))) {

            if ($this->routeName === 'user.application-all-submissions' && $this->isUserManager) {
                $data = Application::orderBy('created_at', 'desc')
                    ->with(['user', 'passports', 'university', 'degree', 'service', 'selectedDocuments']);

                $applicationCount=Application:: select(DB::raw("COUNT(*) AS allApplicationCount"))
                    ->selectRaw("
                        SUM(CASE WHEN (applications.accepted = '0' AND applications.rejected = '0' AND applications.revision = '0') THEN 1 ELSE 0 END) AS reviewApplicationsCount,
                        SUM(CASE WHEN (applications.accepted = '1' AND applications.rejected = '0' AND applications.revision = '0') THEN 1 ELSE 0 END) AS acceptedApplicationsCount,
                        SUM(CASE WHEN (applications.accepted = '0' AND applications.rejected = '1' AND applications.revision = '0') THEN 1 ELSE 0 END) AS rejectedApplicationsCount,
                        SUM(CASE WHEN (applications.accepted = '0' AND applications.rejected = '0' AND applications.revision = '1') THEN 1 ELSE 0 END) AS revisionApplicationsCount
                        ")
                    ->first();

            } else {
                $data = Application::orderBy('created_at', 'desc')
                    ->with('passports')
                    ->with(['university', 'degree', 'service', 'selectedDocuments'])
                    ->where('users_id', auth()->user()->id);

                $applicationCount=Application:: select(DB::raw("COUNT(*) AS allApplicationCount"))
                    ->selectRaw("
                        SUM(CASE WHEN (applications.accepted = '0' AND applications.rejected = '0' AND applications.revision = '0') THEN 1 ELSE 0 END) AS reviewApplicationsCount,
                        SUM(CASE WHEN (applications.accepted = '1' AND applications.rejected = '0' AND applications.revision = '0') THEN 1 ELSE 0 END) AS acceptedApplicationsCount,
                        SUM(CASE WHEN (applications.accepted = '0' AND applications.rejected = '1' AND applications.revision = '0') THEN 1 ELSE 0 END) AS rejectedApplicationsCount,
                        SUM(CASE WHEN (applications.accepted = '0' AND applications.rejected = '0' AND applications.revision = '1') THEN 1 ELSE 0 END) AS revisionApplicationsCount
                        ")
                    ->where('users_id', auth()->user()->id)
                    ->first();
            }
            switch ($this->filterRecord) {
                case 'all':
                    $applications = $data->paginate(10);;

                    break;

                case 'review':
                    $applications = $data->where('accepted', 0)->where('rejected', 0)->where('revision', 0)->paginate(10);

                    break;

                case 'accepted':
                    $applications = $data->where('accepted', 1)->where('rejected', 0)->where('revision', 0)->paginate(10);

                    break;

                case 'rejected':
                    $applications = $data->where('accepted', 0)->where('rejected', 1)->where('revision', 0)->paginate(10);

                    break;

                case 'revision':

                    $applications = $data->where('accepted', 0)->where('rejected', 0)->where('revision', 1)->paginate(10);

                    break;
            }

//            $allApplicationsCount = count($data->get());
//            $reviewApplicationsCount = count($data->where('accepted', 0)->where('rejected', 0)->where('revision', 0)->get());
//            $acceptedApplicationsCount = count($data->where('accepted', 1)->where('rejected', 0)->where('revision', 0)->get());
//            $rejectedApplicationsCount =count($data->where('accepted', 0)->where('rejected', 1)->where('revision', 0)->get());
//            $revisionApplicationsCount = count($data->where('accepted', 0)->where('rejected', 0)->where('revision', 1)->get());

            return view('livewire.user.applications.submissions.datatable',
                [
                    'routeName' => $this->routeName,
                    'applications' => $applications,
                    'applicationsCount' => $applicationCount

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
