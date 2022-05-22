<?php

namespace App\Http\Livewire\User\Applications\Application;

use App\Http\Livewire\Authenticate;
use App\Models\Application;
use App\Models\Document;
use App\Models\service;
use App\Models\serviceRequirement;
use App\Traits\Data;
use App\Traits\Datatable\DocumentDatable;
use App\Traits\Datatable\General;
use App\Traits\Submit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use Livewire\WithPagination;
use phpDocumentor\Reflection\Types\Integer;
use Spatie\Permission\Models\Permission;

class Datatable extends Authenticate
{

    use WithPagination;
    use Submit;
    use Data;

//    use DocumentDatable;


    public ?int $applicationID = null;
    public array $userDocuments = [], $selectedDocuments = [], $additionalRequirements = [];

    protected $listeners = ['myController'];


    public function mount(Request $request)
    {


        $this->applicationID = $request->id;


    }


    protected $messages = [

    ];

//    public function applicationChat($app)
//    {
//        $this->dispatchBrowserEvent('chat-modal', ['show' => true, 'title' => 'Comment History']);
//        $applicationChat = Application::find($app['id'])->comments()->orderby('created_at', 'desc')->get();
//        if ($app['users_id'] === auth()->user()->id) {
//            foreach ($applicationChat as $a) {
//                $a->opened = 1;
//                $a->save();
//            }
//        }
//        $this->chats = json_decode($applicationChat, true);
//    }


    public function addAdditionalRequirements($appID, $reqID)
    {
        $requirementName = ServiceRequirement::find($reqID)->name;
        $applicationDocuments = Application::with('documents')->where('id', $appID)->first();
        $this->userDocuments = json_decode(Document::where('user_id', $applicationDocuments->users_id)->where('service_requirement_id', $reqID)->get(), true);
        $this->applicationID = $appID;
        $this->dispatchBrowserEvent('requirement-modal', ['show' => true, 'title' => 'Available "' . $requirementName . '" documents', 'message' => 'Select your document for ' . $requirementName]);
    }

    public function submitData()
    {
        $application = Application::with('documents')->findOrFail($this->applicationID);
        if (count($this->selectedDocuments) > 1) {
            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Multiple selection!', 'message' => 'Please select one document!']);
        } else if (count($this->selectedDocuments) <= 0) {
            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Selection Error!', 'message' => 'No document selected, please select one document!']);
        } else {
            $application->selectedDocuments()->syncWithoutDetaching($this->selectedDocuments);
            $this->dispatchBrowserEvent('requirement-modal', ['show' => false]);
        }

    }


    public function render()
    {

        if (Data::is_user_guard_web() && (in_array('user', $this->userRoles()['roles']) || in_array('manager', $this->userRoles()['roles'])) && $this->permission('user-submit-application-view')) {

            $selectedDocs = json_decode(Application::with('selectedDocuments')->where('id', $this->applicationID)->first()->selectedDocuments->pluck('id'), true);

            if($this->isUserManager){
                $application = Application::with(['passports','university', 'degree',])->with(['service' => function ($s) {
                    $s->with('requirements')->get();
                }])
                    ->with(['additionalRequirements' => function ($a) {
                        $a->with(['documents' => function ($d) {
                            $d->with(['applications' => function ($a) {
                                $a->with('selectedDocuments')->get();
                            }])->where('user_id', auth()->user()->id)->get();
                        }])->get();
                    }])->with(['selectedDocuments' => function ($q) {
                        $q->with('serviceRequirement')->get();
                    }])->where('id', $this->applicationID)->first();
                if ($application->seen !== true) {
                    $application->seen = true;
                    $application->save();
                }
            }else{
                $application = Application::with(['passports' => function ($q) {
                    $q->where('user_id', auth()->user()->id)->first();
                }])->with(['university', 'degree',])->with(['service' => function ($s) {
                    $s->with('requirements')->get();
                }])
                    ->with(['additionalRequirements' => function ($a) {
                        $a->with(['documents' => function ($d) {
                            $d->with(['applications' => function ($a) {
                                $a->with('selectedDocuments')->get();
                            }])->where('user_id', auth()->user()->id)->get();
                        }])->get();
                    }])->with(['selectedDocuments' => function ($q) {
                        $q->with('serviceRequirement')->get();
                    }])->where('users_id', auth()->user()->id)
                    ->where('id', $this->applicationID)->first();
                if ($application->seen !== true) {
                    $application->seen = true;
                    $application->save();
                }
            }






            $applicationRequirements = json_decode($application->service->requirements->pluck('id'), true);
            $applicationAdditionalRequirements = json_decode($application->additionalRequirements->pluck('id'), true);
            $applicationRequirements = (array_merge($applicationRequirements, $applicationAdditionalRequirements));

            $selectedDocuments = json_decode($application->selectedDocuments()->get()->pluck('service_requirement_id'), true);
            $difference = array_diff($applicationRequirements, $selectedDocuments);

            $this->additionalRequirements = json_decode(ServiceRequirement::whereIn('id', $difference)->get(), true);


            return view('livewire.user.applications.application.datatable', ['application' => $application]);
        } else {
            return view('livewire.errors.access-denied', ['name' => 'applications', '']);
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
