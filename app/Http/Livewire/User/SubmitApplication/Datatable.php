<?php

namespace App\Http\Livewire\User\SubmitApplication;

use App\Http\Livewire\Authenticate;
use App\Mail\NewApplication;
use App\Mail\NewApplicationManager;
use App\Mail\ResetPassword;
use App\Mail\Welcome;
use App\Models\Application;
use App\Models\Degree;
use App\Models\Document;
use App\Models\Gender;
use App\Models\Passport;
use App\Models\PermissionExtends;
use App\Models\Service;
use App\Models\ServiceRequirement;
use App\Models\University;
use App\Models\User;
use App\Traits\Data;
use App\Traits\Query;
use App\Traits\Submit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rules;
use phpDocumentor\Reflection\Types\Collection;
use phpDocumentor\Reflection\Types\InterfaceString;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Datatable extends Authenticate
{
    use WithPagination;
    use Submit;
    use Data;


    protected $listeners = ['myController', 'refreshComponent' => '$refresh'];
    public ?int  $step = 1, $serviceRequirementID = null, $serviceRequirementsCount = null;
    public array
        $myModal = [],
        $user = [],
        $roles,
        $serviceRequirements = [],
        $selectedDocuments = [],
        $finalSelectedDocument=[],
        $documents = [],
        $universities = [],
        $qualifications = [],
        $degreeData = [],
        $collection = [],
        $application = [];
    public bool $rejectCheckbox=false;

    public $userID, $tempName, $tempUrl, $path = '', $fileView = '', $universityID = "",$serviceName="";


    public function mount(Request $request)
    {
        $this->resetApplication();
        $this->dispatchBrowserEvent('success-modal', ['show' => true, 'title' => 'Application created', 'message' => 'Your application was submitted successfully!']);
        $this->universities = Data::universities_for_select();
        $this->qualifications = Data::qualifications_for_select();
    }

    public function updating($element, $value)
    {
        switch ($element) {
            case 'application.qualificationID':
                $this->application['degreeID'] = "";
                $this->degreeData = Data::degrees_for_select($value);
                break;

            case 'application.serviceID':
                $this->serviceRequirements = json_decode( ServiceRequirement::whereHas('service',function($q) use($value){
                    $q->where('services.id',$value);
                })->with(['documents' => function ($d) {
                $d->where('user_id', auth()->user()->id)->where('rejected',0);
            }])->get(), true);
//                $this->serviceRequirements = json_decode(ServiceRequirement::select('id', 'name', 'description')->with(['documents' => function ($q) {
//                    $q->where('user_id', auth()->user()->id);
//                }])->with(['service'=>function($s) use($value){
//                    $s->where('services.id',$value)->get();
//                }])->get(), true);
//                dd($this->serviceRequirements);
                $this->serviceRequirementsCount = count($this->serviceRequirements);
                break;
        }
    }


    public function export($file)
    {
        if ($this->permission('user-submit-application-document-download')) {
            if (Storage::exists('public/images/documents/' . $file)) {
                return Storage::download('public/images/documents/' . $file);

            } else {
                $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Image not found!', 'message' => 'The image you are looking for doesnt exists!.']);
                return null;
            }
        } else {
            $this->AccessDeniedModal('download', 'document');
        }
    }

    public function photoView($file)
    {
        if ($this->permission('user-submit-application-document-view')) {
            if (Storage::exists('public/images/documents/' . $file)) {
                $this->fileView = $file;
                $this->dispatchBrowserEvent('photo-view-modal', ['show' => true]);
            } else {
                $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Image not found!', 'message' => 'The image you are looking for doesnt exists!.']);
            }
        } else {
            $this->AccessDeniedModal('view', 'view document');
        }
    }


    protected $messages = [
        'user.name.required' => 'The Name cannot be empty.',
        'user.name.string' => ':attribute must be a string.',
        'user.name.min' => 'The Name must have minimum 4 characters.',
        'user.name.max' => ':attribute cannot exceed more than 255 characters.',
        'user.email.required' => 'The Email Address cannot be empty.',
        'user.email.string' => ':attribute Email must be a string.',
        'user.email.max' => ':attribute cannot exceed more than 255 characters.',
        'user.email.email' => ':attribute is not a valid email Address.',
        'user.email.unique' => ':attribute Email Address already exists!.',
        'user.password.required' => 'The Password cannot be empty.',
        'user.password.confirmed' => 'The two Password do not match.',
        'user.gender.required' => 'Select a gender',
    ];

    public function myController($value)
    {
        $this->myModal = $value;
        switch ($value['model']) {
            case 'user':
                if ($value['modalType'] === 'update' || $value['modalType'] === 'delete' || $value['modalType'] === 'password-reset') {
                    $this->userID = $value['record']['formData']['id'];
                    $this->record = User::where('id', $this->userID)->first();
                }
                switch ($value['modalType']) {
                    case 'add':
                        $this->resetForm('user');
                        $this->record = new User();
                        break;

                    case 'update':
                        $this->resetErrorBag();
                        $this->user['name'] = $value['record']['formData']['name'];
                        $this->user['email'] = $value['record']['formData']['email'];
                        $this->user['gender'] = $value['record']['formData']['gender_id'];


                        break;
                    case 'delete':
                    case 'password-reset':
                        break;
                }
                break;
        }
    }


    public function submit()
    {
        $user = auth()->user();
        if (
            $this->checkApplicationPassport($this->application['passportID']) &&
            $this->checkApplicationUniversity($this->application['universityID']) &&
            $this->checkApplicationDegree($this->application['degreeID']) &&
            $this->checkApplicationService($this->application['serviceID']) &&
            $this->checkApplicationDocuments($this->application['documents'])
        ) {
            try {
                DB::transaction(function () use ($user) {
                    $newApplication = new Application();
                    $newApplication->passports_id = $this->application['passportID'];
                    $newApplication->universities_id = $this->application['universityID'];
                    $newApplication->degrees_id = $this->application['degreeID'];
                    $newApplication->services_id = $this->application['serviceID'];
                    $newApplication->users_id = auth()->user()->id;
                    $newApplication->save();

                    $serviceName=$this->serviceName;
                    $newApplication->selectedDocuments()->sync($this->finalSelectedDocument);
                    Mail::to($user->email)->send(new NewApplication($user->name,$serviceName));
                    Mail::to(config('app.admin_email'))->send(new NewApplicationManager(auth()->user()->name,$user->name,$serviceName));
                    $this->step = 1;
                    $this->universityID = "";
                    $this->serviceID = null;
                    $this->resetApplication();
                    $this->dispatchBrowserEvent('success-modal', ['show' => true, 'title' => 'Application created', 'message' => 'Your application was submitted successfully!']);
                    sleep(3);
                    Redirect::route('user.application-submissions');

                });
            } catch (\exception $e) {
                DB::rollback();
                $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Error: ' . $e->getCode(), 'message' => $e->getMessage()]);
            }


        } else {
            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Data mismatch error!', 'message' => 'Some data has been tampered or data mismatched. Please contact administrator if error exists again!']);
        }
    }

    public function checkApplicationPassport($id): bool
    {
        return Passport::where('user_id', auth()->user()->id)->where('id', $id)->first() !== null;
    }

    public function checkApplicationUniversity($id): bool
    {
        return University::where('id', $id)->first() !== null;
    }


    public function checkApplicationDegree($id): bool
    {
        return Degree::where('id', $id)->first() !== null;
    }

    public function checkApplicationService($id): bool
    {
        return (Service::where('id', $id)->first() !== null);
    }

    public function checkApplicationDocuments($selectedDocuments)
    {
        $docs = [];
        $service = Service::with('requirements')->where('id', $this->application['serviceID'])->get();
        $serviceRequirementCount = count($service->first()->requirements);
        $documents = Document::where('user_id', auth()->user()->id)->get();
        if ((count($this->application['documents']) === 0 && count($selectedDocuments) === 0) && $serviceRequirementCount === 0) {
            return true;
        } else {
            if($selectedDocuments===$this->application['documents']){
                foreach ($documents as $document) {
                    array_push($docs, $document->id);
                }

                $sel = [];
                $match=true;

                foreach ($selectedDocuments as $selectedDocument) {

                    array_push($sel,$selectedDocument['did']);
//                    $check = array_diff($selectedDocument, $doc) == [];
//                    if ($check) array_push($match, ['d' => $selectedDocument, $check]);
                }
                foreach( $sel as $s){
                    if(!in_array($s, $docs)){
                        return false;
                    }else{
                        $this->finalSelectedDocument=$sel;
                    }
                }
                return (count($selectedDocuments) === count($sel));
            }else{
                return false;
            }

        }

    }

    public function render()
    {
        if (Data::is_user_guard_web() && (in_array('user', $this->userRoles()['roles']) || in_array('manager', $this->userRoles()['roles'])) && $this->permission('user-submit-application-view')) {
            $passport = Passport::with(['country', 'region'])->where('user_id', auth()->user()->id)->where('active', true)->first();
            if($passport === null) $passport="[]";
            $services = Service::select('id', 'name', 'abbreviation')->get();
            return view('livewire.user.submit-application.datatable', ['passport' => $passport, 'services' => $services]);
        } else {
            $this->dispatchBrowserEvent('access-denied', true);
            return view('livewire.errors.access-denied', ['name' => 'Users']);
        }


    }

    protected function rules()
    {
        return [
            'user.name' => 'required|min:4',
            'user.email' => 'required|email|unique:users,email,' . $this->userID,
            'user.gender' => 'required'
//            'user.password' => 'required', 'confirmed',Password::defaults()
        ];
    }


    protected function validationAttributes()
    {
        return [
            'user.name' => $this->user['name'],
            'user.email' => $this->user['email'],
        ];
    }

    public function resetApplication()
    {
        $this->application = ['passportID' => null, 'universityID' => "", 'qualificationID' => "", 'degreeID' => "", 'serviceID' => "", 'documents' => []];
    }
}
