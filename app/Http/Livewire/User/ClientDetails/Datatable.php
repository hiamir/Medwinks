<?php

namespace App\Http\Livewire\User\ClientDetails;

use App\Http\Livewire\Authenticate;
use App\Mail\AdditionalDocumentsRequired;
use App\Mail\ResetPassword;
use App\Mail\Welcome;
use App\Models\Application;
use App\Models\Comments;
use App\Models\Country;
use App\Models\Document;
use App\Models\Gender;
use App\Models\Passport;
use App\Models\PermissionExtends;
use App\Models\ServiceRequirement;
use App\Models\User;
use App\Rules\ImageRule;
use App\Traits\Authorize;
use App\Traits\Data;
use App\Traits\Datatable\DocumentDatable;
use App\Traits\Datatable\DocumentPassportCommon;
use App\Traits\Datatable\PassportDatable;
use App\Traits\Query;
use App\Traits\Submit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Validation\Rules;
use PhpParser\Comment\Doc;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Datatable extends Authenticate
{
    use WithPagination;
    use WithFileUploads;
    use Authorize;
    use Submit;
    use DocumentPassportCommon;
    use PassportDatable;
    use DocumentDatable;


    protected $listeners = ['myController', 'refreshComponent' => '$refresh'];
    public string $filterRecord = 'all',$clientTab='application';
    public string $confirmationType = '', $universityName = '', $degreeName = '', $decision = '';
    public array $allRequirements = [];
    public $photo;
    public bool $rejectCheckbox = false;


    public $additionalRequirements;
    public array
        $myModal = [],
        $user = [],
        $selectedRequirements = [],
        $requiredDocuments = [],
        $roles,
        $confirmationModalData = ['show' => false, 'type' => '', 'title' => '', 'message' => ''],
        $collection = [];


    public ?int $appID = null;


    public function updatingRejectCheckbox($value)
    {
        $tempConfirmationType = $this->confirmationType;
        if ($value === true) {
            if ($this->confirmationType === 'accept') {
                if ($this->rejectCheckbox === true) $this->confirmationType = 'accept';
            } elseif ($this->confirmationType === 'revise') {
                if ($this->rejectCheckbox === true) $this->confirmationType = 'reject';
            }
            $this->dispatchBrowserEvent('confirmation-modal', ['show' => true, 'type' => 'Reject', 'title' => 'Reject Application',
                'message' => 'You have chosen to reject this application. Are you sure you want to perform this action?']);
        } else {
            $this->confirmationType = $tempConfirmationType;
            $this->dispatchBrowserEvent('confirmation-modal', $this->confirmationModalData);
        }
    }


//    public function rejectDocument($docID)
//    {
//        if ($this->isAccessRejectDocument($docID)) {
//            $this->documentType = 'document';
//            $this->confirmationType = 'reject';
//            $doc = Document::with('serviceRequirement')->where('id', $docID)->first();
//            $this->docName = $doc->serviceRequirement->first()->name;
//            $this->documentID = $docID;
//            $this->dispatchBrowserEvent('confirmation-modal', ['show' => true, 'type' => $this->confirmationType, 'title' => 'Reject Document?', 'message' => 'Are you sure you want to reject &nbsp<strong> ' . $this->docName . '</strong>?']);
//        } else {
//            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Document Finalized!', 'message' => 'This document already submitted and decision was finalized']);
//        }
//
//    }
//
//    public function reviseDocument($docID)
//    {
//        $this->documentType = 'document';
//        $this->confirmationType = 'revision';
//        $doc = Document::with('serviceRequirement')->where('id', $docID)->first();
//        $this->docName = $doc->serviceRequirement->first()->name;
//        $this->documentID = $docID;
//        $this->dispatchBrowserEvent('confirmation-modal', ['show' => true, 'type' => $this->confirmationType, 'title' => 'Revise Document?', 'message' => 'Are you sure you want to revise &nbsp<strong> ' . $this->docName . '</strong>?']);
//    }


    public function applicationDecision($appID)
    {
//        $this->documentType = 'application';
        $this->rejectCheckbox = false;
//        $application = Application::with(['passports' => function ($q) {
//            $q->first();
//        }])->with(['service'])
//            ->with(['selectedDocuments' => function ($q) {
//                $q->with('serviceRequirement')->where('user_id', $this->userID)->get();
//
//            }])
//            ->with('additionalRequirements')
//            ->where('id', $appID)->first();
        $application = $this->application($appID);
        $intersect = ((array_intersect($application['selectedDocuments'], $application['applicationAdditionalRequirements'])));
        $allRequirements = $application['allServiceRequirement'];
        $diffRequirements = array_diff($allRequirements, array_merge($application['selectedDocuments']));

        if ($application['record']->accepted === 0 && $application['record']->rejected === 0 && ($application['record']->revision === 0 || $application['record']->revision === 1)) {
            $this->applicationID = $application['record']->id;
            if (in_array(0, (json_decode($application['record']->selectedDocuments->pluck('accepted'), true)))
                || (count($diffRequirements) > 0)) {
                $this->confirmationType = 'revision';
                $this->confirmationModalData = ['show' => true, 'type' => 'Revise', 'title' => 'Revise Application', 'message' => '
            <p class="flex flex-col justify-center items-center">
            <span class="flex mb-1">This application requires revision </span><span class="flex font-bold text-yellow-400"> ' . $application['record']->service->name . '?</span></p>'];
            } else {
                $this->confirmationType = 'accept';
                $this->confirmationModalData = ['show' => true, 'type' => 'Accept', 'title' => 'Accept Application', 'message' => '
            <p class="flex flex-col justify-center items-center">
            <span class="flex mb-1">This application can be accepted </span><span class="flex font-bold text-yellow-400"> ' . $application['record']->service->name . '?</span></p>'];
            }
            $this->dispatchBrowserEvent('confirmation-modal', $this->confirmationModalData);
        } else {
            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Application Finalized!', 'message' => 'You cannot alter or change application status as final decision was already made ' . $application['record']->updated_at]);
        }

    }

    protected function application($appID)
    {
        $application = Application:: with(['service' => function ($q) {
            $q->with('requirements')->get();
        }])->with('selectedDocuments')->where('id', $appID)->first();

        $selectedDocuments = json_decode($application->selectedDocuments()->pluck('service_requirement_id'), true);
        $applicationRequirements = json_decode($application->service->requirements()->pluck('service_requirements.id'), true);
        $applicationAdditionalRequirements = json_decode($application->additionalRequirements()->pluck('service_requirements.id'), true);
        $allServiceRequirement = array_unique(array_merge($selectedDocuments, $applicationRequirements, $applicationAdditionalRequirements));

        return [
            'record' => $application,
            'selectedDocuments' => $selectedDocuments,
            'applicationRequirements' => $applicationRequirements,
            'applicationAdditionalRequirements' => $applicationAdditionalRequirements,
            'allServiceRequirement' => $allServiceRequirement
        ];
    }


    public function getAdditionalRequirements($appID)
    {
        $check = Application::find($appID);
        if (($check->accepted === 0 && $check->rejected === 0 && $check->revision === 1) || ($check->accepted === 0 && $check->rejected === 0 && $check->revision === 0)) {
            $this->additionalRequirements = [];
            $this->appID = $appID;
            $application = $this->application($appID);

            $diffRequirements = array_diff($this->allRequirements, array_merge($application['selectedDocuments'], $application['applicationAdditionalRequirements']));
            $this->additionalRequirements = json_decode(ServiceRequirement::select('id', 'name')->whereIn('id', $diffRequirements)->get(), true);
            if (count($this->additionalRequirements) > 0) {
                $this->dispatchBrowserEvent('requirement-modal', ['show' => true, 'title' => 'Additional Requirements', 'message' => 'If you didnt find the required documents. Please add requirement under "Service Requirements"']);
            } else {
                $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Requirements Unavailable!', 'message' => 'The service require documents either exhausted or unavaible. Please add requirement under "Service Requirements" first. ']);
            }
        } else {
            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Application Finalized!', 'message' => 'Cannot alter or update! This Application is already finalized the decision.']);
        }

    }

    public function getAllDocuments($appID): array
    {
        $application = Application::with(['selectedDocuments' => function ($s) {
            $s->with('serviceRequirement')->get();
        }])->with(['service' => function ($q) {
            $q->with('requirements')->get();
        }])->where('id', $appID)->first();
        $applicationRequirements = json_decode($application->service->requirements->pluck('id'), true);
        $applicationAdditionalRequirements = json_decode($application->additionalRequirements->pluck('id'), true);
        $applicationRequirements = (array_merge($applicationRequirements, $applicationAdditionalRequirements));

        $selectedDocuments = json_decode($application->selectedDocuments()->get()->pluck('service_requirement_id'), true);
        $difference = array_diff($applicationRequirements, $selectedDocuments);
//        return json_decode(ServiceRequirement::whereIn('id',$difference)->get(),true);
    }

    public function submitData()
    {
        $application = Application::with(['service', 'additionalRequirements'])->findOrFail($this->appID);
        try {
            DB::transaction(function () use ($application) {
                if ($application !== null && count($this->selectedRequirements) > 0) {
                    $application->additionalRequirements()->syncWithoutDetaching($this->selectedRequirements);
                    $user = User::find($application->users_id);
                    $serviceName = $application->service->name;
                    $requirements = $application->additionalRequirements()->get();
                    Mail::to($user->email)->send(new AdditionalDocumentsRequired($user->name, $serviceName, $requirements));
                    $this->dispatchBrowserEvent('requirement-modal', ['show' => false]);
                    $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => 'Document requirements were added!']);
                }
            });
        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => $e->getCode(), 'message' => 'There was error syncing requirements' . $e->getMessage()]);
        }

    }

    public function removeAdditionalRequirements($appID, $id)
    {
        $application = Application::find($appID);
        $application->additionalRequirements()->detach($id);
    }

    public function isAdditionalDocuments($appID)
    {
        $application = Application::with(['selectedDocuments' => function ($s) {
            $s->with('serviceRequirement')->get();
        }])->with(['service' => function ($q) {
            $q->with('requirements')->get();
        }])->where('id', $appID)->first();


        $applicationAdditionalRequirements = json_decode($application->additionalRequirements->pluck('id'), true);


        $selectedDocuments = json_decode($application->selectedDocuments()->get()->pluck('service_requirement_id'), true);

        $arrayDiff = array_diff($selectedDocuments, $applicationAdditionalRequirements);
        dd($arrayDiff);

    }

    public function myController($value)
    {
        $this->myModal = $value;
    }

    public function filterAdditionalRequirements($app)
    {
        dd($app);
    }


    public function render()
    {
        if ($this->permission('user-client-view')) {
            $profile = User::with(['passports', 'profilePhoto', 'documents'])->where('id', $this->userID)->first();
            $filterRecord = $this->filterRecord;

            if(Session::has('documentID')){
                $this->documentID=Session::get('documentID');
                Session::forget('documentID');
            }
            if(Session::has('clientTab')){
                $this->clientTab=Session::get('clientTab');
                Session::forget('clientTab');
            }

            $applications = Application::with(['passports', 'service'])
                ->where('users_id', $this->userID)
                ->with(['selectedDocuments' => function ($sd) {
                    $sd->with('serviceRequirement')->get();
                }])
                ->with(['additionalRequirements' => function ($ar) {
                    $ar->with(['applications' => function ($a) {
                    }]);
                }])
                ->where(function ($w) use ($filterRecord) {
                    switch ($filterRecord) {
                        case 'review':
                            $w->where('accepted', 0)->where('rejected', 0)->where('revision', 0);
                            break;
                        case 'accepted':
                            $w->where('accepted', 1)->where('rejected', 0)->where('revision', 0);
                            break;
                        case 'rejected':
                            $w->where('accepted', 0)->where('rejected', 1)->where('revision', 0);
                            break;
                        case 'revision':
                            $w->where('accepted', 0)->where('rejected', 0)->where('revision', 1);
                            break;
                    }
                })->orderBy('created_at', 'desc')->paginate(10);


                    $applicationCount = Application:: select(DB::raw("COUNT(*) AS allApplicationCount"))
                        ->selectRaw("
                        SUM(CASE WHEN (applications.accepted = '0' AND applications.rejected = '0' AND applications.revision = '0') THEN 1 ELSE 0 END) AS reviewApplicationsCount,
                        SUM(CASE WHEN (applications.accepted = '1' AND applications.rejected = '0' AND applications.revision = '0') THEN 1 ELSE 0 END) AS acceptedApplicationsCount,
                        SUM(CASE WHEN (applications.accepted = '0' AND applications.rejected = '1' AND applications.revision = '0') THEN 1 ELSE 0 END) AS rejectedApplicationsCount,
                        SUM(CASE WHEN (applications.accepted = '0' AND applications.rejected = '0' AND applications.revision = '1') THEN 1 ELSE 0 END) AS revisionApplicationsCount
                        ")
                        ->where('users_id', $this->userID)
                        ->first();


                    if (count($applications) > 0) {
                        $this->universityName = $applications->first()->university->name;
                        $this->degreeName = $applications->first()->degree->name;
                    }
                    $passports = passport::with('applications')->where('user_id', $this->userID)->orderBy('active', 'DESC')
                        ->orderBy('accepted', 'DESC')->orderBy('revision', 'DESC')->orderBy('rejected', 'DESC')->get();
//            $passports = Passport::with('applications')->where('user_id', $this->userID)->orderBy('created_at', 'desc')->get();
//            $countries = Data::countries_for_select();
                    $countries = Country::select('id', 'name')->get();
                    $documents = ServiceRequirement::with(['documents' => function ($q) {
                        $q->with('applications')->where('user_id', $this->userID);
                    }])->paginate(20);

//                    switch ($this->filterRecord) {
//                        case 'all':
//                            $applications = $data->paginate(20);;
//
//                            break;
//
//                        case 'review':
//                            $applications = $data->where('accepted', 0)->where('rejected', 0)->where('revision', 0)->paginate(20);
//
//                            break;
//
//                        case 'accepted':
//                            $applications = $data->where('accepted', 1)->where('rejected', 0)->where('revision', 0)->paginate(20);
//
//                            break;
//
//                        case 'rejected':
//                            $applications = $data->where('accepted', 0)->where('rejected', 1)->where('revision', 0)->paginate(20);
//
//                            break;
//
//                        case 'revision':
//                            $applications = $data->where('accepted', 0)->where('rejected', 0)->where('revision', 1)->paginate(20);
//                            break;
//                    }

                    return view('livewire.user.client-details.datatable',
                        [
                            'routeName' => Route::currentRouteName(),
                            'profile' => $profile,
                            'applications' => $applications,
                            'passports' => $passports,
                            'documents' => $documents,
                            'countries' => $countries,
                            'applicationsCount' => $applicationCount
                        ]);
                } else {
                $this->dispatchBrowserEvent('access-denied', true);
                return view('livewire.errors.access-denied', ['name' => 'Users']);
            }
    }


//    protected function validationAttributes()
//    {
//        return [
//            'passport.passport_number' => ($this->passport['passport_number'] != '') ? $this->passport['passport_number'] : 'Passport number',
//            'passport.given_name' => ($this->passport['given_name'] != '') ? $this->passport['given_name'] : 'Given name',
//            'passport.sur_name' => ($this->passport['sur_name'] != '') ? $this->passport['sur_name'] : 'Sur name',
//            'passport.date_of_birth' => ($this->passport['date_of_birth'] != '') ? $this->passport['date_of_birth'] : 'Date of birth',
//            'passport.issue_date' => ($this->passport['issue_date'] != '') ? $this->passport['issue_date'] : 'Issue date',
//            'passport.expiry_date' => ($this->passport['expiry_date'] != '') ? $this->passport['expiry_date'] : 'Expiry date',
//            'passport.country' => 'Country',
//            'passport.region' => 'Region',
//            'passport.file' => ($this->passport['file'] != '') ? $this->passport['file'] : 'Passport',
//        ];
//    }

//    protected function messages()
//    {
//        return [
//            'passport.passport_number.required' => 'Required',
//            'passport.given_name.required' => 'Required',
//            'passport.given_name.min' => 'Name must be min 4 character long',
//            'passport.sur_name.required' => 'Required',
//            'passport.sur_name.min' => 'Name must be min 4 character long',
//            'passport.date_of_birth.required' => 'Required',
//            'passport.date_of_birth.date' => ":attribute must be valid date",
//            'passport.date_of_birth.date_format' => ":attribute must have 'Y-m-d' format",
//            'passport.date_of_birth.before_or_equal' => ":attribute must be today or before today's date",
//            'passport.issue_date.required' => "Required",
//            'passport.issue_date.date' => ":attribute must be valid date",
//            'passport.issue_date.date_format' => ":attribute date must have 'Y-m-d' format",
//            'passport.issue_date.before_or_equal' => ":attribute date must be today or before today's date",
//            'passport.expiry_date.required' => "Required",
//            'passport.expiry_date.date' => ":attribute must be valid date",
//            'passport.expiry_date.date_format' => ":attribute date must have 'Y-m-d' format",
//            'passport.expiry_date.before_or_equal' => ":attribute date must be today or before today's date",
//            'passport.country.required' => 'Required',
//            'passport.region' => 'Required',
//            'passport.file.required' => 'Upload image file for :attribute',
//            'passport.file.image' => ':attribute must be a image',
//            'passport.file.mimes' => ":attribute image allowed formats 'jpg,png,jpeg,gif,svg'",
//            'passport.file.max' => ":attribute must not exceed 500kb file size",
//        ];
//    }


    }
