<?php

namespace App\Traits\Datatable;

use App\Models\Application;
use App\Models\Passport;
use App\Rules\ImageRule;
use App\Traits\Data;
use App\Traits\Submit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

trait PassportDatable
{

//    use WithFileUploads;
//    use WithPagination;
//    use Submit;
//    use Data;

//    public string $photoType = 'passport', $tempName, $path = '', $fileView = '', $docName = '', $passName = '';
    public ?int $countryID = null, $regionID = null, $userID = null;
    public array $allRegions = [], $regions = [];
    public $tempUrl = '';


//    public function mount(Request $request)
//    {
//        $this->regions = [];
//        $this->resetPassport();
//
//        $this->regions = [];
//        $this->allRegions = Data::regions_all_for_select();
//    }


    public function passportChat($pass)
    {
        $this->dispatchBrowserEvent('chat-modal', ['show' => true, 'title' => 'Comment History']);
        $passport = Passport::find($pass['id'])->comments()->orderby('created_at', 'desc')->get();
        if ($pass['user_id'] === auth()->user()->id) {
            foreach ($passport as $p) {
                $p->opened = 1;
                $p->save();
            }
        }
        $this->chats = json_decode($passport, true);
    }

    public function acceptPassport($passID)
    {
        $this->documentType = 'passport';
        $this->confirmationType = 'accept';
        $pass = Passport::where('id', $passID)->first();
        $this->passportID = $pass['id'];
        $this->dispatchBrowserEvent('confirmation-modal', ['show' => true, 'type' => $this->confirmationType, 'title' => 'Accept Passport?', 'message' => 'Are you sure you want to accept passport &nbsp<strong> ' . $pass['passport_number'] . '</strong>?']);
    }

    public function rejectPassport($passID)
    {
        $this->documentType = 'passport';
        $this->confirmationType = 'reject';
//        $check=Passport::with('applications')->where('id', $passID)->get();
        $check = Passport::with(['applications' => function ($q) {
            $q->where('accepted', 0)->where('rejected', 0)->where('revision', 0);
        }])->where('id', $passID)->first();

        $countApplicationsLinked = count($check->applications);

        if ($countApplicationsLinked === 0) {
            $this->documentType = 'passport';
            $this->confirmationType = 'reject';
            $pass = Passport::where('id', $passID)->first();
            $this->passportID = $pass['id'];
            $this->dispatchBrowserEvent('confirmation-modal', ['show' => true, 'type' => $this->confirmationType, 'title' => 'Reject Passport?', 'message' => 'Are you sure you want to reject passport &nbsp<strong> ' . $pass['passport_number'] . '</strong>?']);
        } else {
            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Passport Link!', 'message' => 'Cannot update or alter this passport as its linked with other applications']);
        }

    }

    public function revisePassport($passID)
    {
        $this->documentType = 'passport';
        $this->confirmationType = 'revision';
        $pass = Passport::where('id', $passID)->first();
        $this->passName = $pass->passport_number;
        $this->passportID = $passID;
        $this->dispatchBrowserEvent('confirmation-modal', ['show' => true, 'type' => $this->confirmationType, 'title' => 'Revise Passport?', 'message' => 'Are you sure you want to send for revise &nbsp<strong> ' . $this->passName . '</strong>?']);
    }

    public function passportUpdate($passport)
    {
        $check = Passport::with(['applications' => function ($q) {
            $q->where('accepted', 0)->where('rejected', 0)->where('revision', 0);
        }])->where('id', $passport['id'])->first();
        $countApplicationsLinked = count($check->applications);
        if ($countApplicationsLinked === 0) {
            $this->dispatchBrowserEvent('my-modal', ['action' => 'add', 'formType' => 'passport', 'data' => $passport]);
        } else {
            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Passport Link!', 'message' => 'Cannot update or alter this passport as its linked with other applications']);
        }
    }

    public function passportView($file)
    {
        if ($this->permission('user-client-details-document-view') || $this->permission('user-application-submissions-document-view')) {
            if (Storage::exists('public/images/passports/' . $file)) {
                $this->fileView = $file;
                $this->dispatchBrowserEvent('photo-view-modal', ['show' => true]);
            } else {
                $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Image not found!', 'message' => 'The image you are looking for doesnt exists!.']);
            }
        } else {
            $this->AccessDeniedModal('view', 'view document');
        }
    }

    protected function passportRules()
    {
        return [
            'passport.passport_number' => ['required', 'unique:passports,passport_number,' . $this->passportID],
            'passport.given_name' => 'required|min:4',
            'passport.sur_name' => 'required|min:4',
            'passport.date_of_birth' => 'required|date|before_or_equal:today',
            'passport.issue_date' => 'required|date|before_or_equal:today',
            'passport.expiry_date' => 'required|date|after:issue_date',
            'passport.country' => 'required',
            'passport.region' => '',
            'passport.file' => 'required|mimes:jpg,png,jpeg,gif|max:500'
        ];
    }

    protected function passportUpdateRules($file = null)
    {

        return [
            'passport.passport_number' => ['required', 'unique:passports,passport_number,' . $this->passportID],
            'passport.given_name' => 'required|min:4',
            'passport.sur_name' => 'required|min:4',
            'passport.date_of_birth' => 'required|date|before_or_equal:today',
            'passport.issue_date' => 'required|date|before_or_equal:today',
            'passport.expiry_date' => 'required|date|after:issue_date',
            'passport.country' => 'required',
            'passport.region' => '',
            'passport.file' => 'required|mimes:jpg,png,jpeg,gif|max:500'
//            'passport.file' => (!is_object($this->passport['file'])) ? new ImageRule('update', 'passports', $file) : '|mimes:jpg,png,jpeg,gif,svg,doc,docx,pdf|max:500',
        ];
    }


    public function regionData($countryID)
    {
        return Data::regions_for_select($countryID);
    }


    public function myController($value)
    {
        $this->tempUrl = '';
        $this->documentType = 'passport';
        $this->myModal = $value;
    }


    public function isPassportApplied($id): bool
    {
        $application = Application::where('passports_id', $id)->get();
        return count($application) === 0;

    }
    public function submit()
    {

        switch ($this->myModal['model']) {

            case 'client-details':
            case 'passport':
                $this->documentType = 'passport';
                if(is_object($this->file)) $this->passport['file']=$this->file;
                switch ($this->myModal['formType']) {
                    case 'passport':
                        if ($this->myModal['modalType'] === 'update' || $this->myModal['modalType'] === 'delete') {

                            $this->record = passport::with('applications')->where('id', $this->myModal['record']['formData']['id'])->first();
                            $this->passportID = $this->record->id;
                        }
                        switch ($this->myModal['modalType']) {

                                case 'delete':
                                if (count($this->record->applications) === 0) {
                                    if (($this->record->accepted === 1 && $this->record->rejected === 0 && $this->record->revision === 0) || ($this->record->accepted === 0 && $this->record->rejected === 1 && $this->record->revision === 0)) {
                                        $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Passport Decision!', 'message' => 'Cannot delete as passport decision was finalized']);
                                    } else {
                                        $this->submitForm($this, $this->myModal['model'], $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->passport, $this->passportRules());
                                    }
                                } else {
                                    $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Passport Link!', 'message' => 'Cannot delete as one or more of the applications are using this passport']);
                                }

                                break;
                        }
                        break;
                }
                break;
        }
    }

    public function submitPassport()
    {

        switch ($this->myModal['model']) {

            case 'client-details':
            case 'passport':
                $this->documentType = 'passport';
                if(is_object($this->file)) $this->passport['file']=$this->file;
                switch ($this->myModal['formType']) {
                    case 'passport':
                        if ($this->myModal['modalType'] === 'update' || $this->myModal['modalType'] === 'delete') {

                            $this->record = passport::with('applications')->where('id', $this->myModal['record']['formData']['id'])->first();
                            $this->passportID = $this->record->id;
                        }
                        switch ($this->myModal['modalType']) {

                            case 'add':

                                if ($this->permission('user-passport-create')) {
                                    $this->resetErrorBag();
                                    $this->validationErrors = [];
                                    $this->record = new passport();
                                    ($this->myModal['model'] === 'passport') ? $this->passport['user_id'] = auth()->user()->id : $this->passport['user_id'] = $this->userID;
                                    $this->passport['accepted'] = 0;
                                    $this->passport['rejected'] = 0;
                                    $this->passport['revision'] = 0;
                                    $this->checkNoPassports = count(Passport::where('user_id', $this->passport['user_id'])->get());


                                    ($this->checkNoPassports === 0 && Carbon::createFromFormat('Y-m-d', $this->passport['expiry_date'])->gt($this->nowDate)) ? $this->passport['active'] = 1 : $this->passport['active'] = 0;

                                    $this->submitForm($this, $this->myModal['model'], $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->passport, $this->passportRules());
                                } else {
                                    $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Access Denied!', 'message' => 'You are not authorized to create dcouments']);
                                }
                                break;

                            case 'update':
                                if (($this->record->accepted === 0 && $this->record->rejected === 0 && $this->record->revision === 1)) {
                                    $this->resetErrorBag();
                                    $this->passport['user_id'] = $this->record->user_id;
                                    $this->passport['accepted'] = 0;
                                    $this->passport['rejected'] = 0;
                                    $this->passport['revision'] = 0;
                                    if ($this->passport['file'] !== '') {
                                        $img = $this->passport['file'];
                                        $this->path = 'storage/images/passports/' . $img;
                                        (file_exists($this->path)) ? $this->passport['isFileExists'] = true : $this->passport['isFileExists'] = false;
                                    }
                                    $this->submitForm($this, $this->myModal['model'], $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->passport, $this->passportUpdateRules($this->passport['file']));
                                } else {
                                    $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Passport Decision!', 'message' => 'Cannot update as passport decision was finalized']);
                                }
                                break;

                            case 'delete':
                                if (count($this->record->applications) === 0) {
                                    if (($this->record->accepted === 1 && $this->record->rejected === 0 && $this->record->revision === 0) || ($this->record->accepted === 0 && $this->record->rejected === 1 && $this->record->revision === 0)) {
                                        $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Passport Decision!', 'message' => 'Cannot delete as passport decision was finalized']);
                                    } else {
                                        $this->submitForm($this, $this->myModal['model'], $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->passport, $this->rules());
                                    }
                                } else {
                                    $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Passport Link!', 'message' => 'Cannot delete as one or more of the applications are using this passport']);
                                }

                                break;
                        }
                        break;
                }
                break;
        }
    }

    public function makePassportActive($id)
    {
        $userID = null;
        ($this->userID === null) ? $userID = auth()->user()->id : $userID = $this->userID;
        $passport = Passport::where('id', $id)->where('user_id', $userID)->first();
        if($passport !== null){
            $expiryDate = Carbon::createFromFormat('Y-m-d', $passport->expiry_date);
            if ($this->checkActive($passport,$userID,$expiryDate)) {
                $passport->Active = 1;
                $passport->save();
                $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => $passport->passport_number.' is now active passport!']);
            }
        }

    }

    protected function checkActive($passport,$userID,$expiryDate): bool
    {


        if (Carbon::createFromFormat('Y-m-d', $expiryDate)->lt($this->nowDate)) {
//            $this->dispatchBrowserEvent('toast', ['alert' => 'danger', 'message' => 'Cannot activate password! Passport expired!']);
            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Active failed!', 'message' => '<div class="flex flex-col w-full"><div class="">Active failed as passport expired on </div><div class="font-bold">' . Carbon::parse($expiryDate)->format('F j, Y') . '</div></div>']);
            $this->passport['active'] = 0;
            return false;
        }
            elseif(($passport->file === '' || !file_exists("/storage/images/passports/".$passport->file))){
                $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Active failed!', 'message' => '<div class="flex flex-col w-full"><div class="">Active failed as no passport file given. </div></div>']);
                return false;
        } else {
            $passports = Passport::where('user_id', $userID)->get();
            foreach ($passports as $passport) {
                if ($passport->active === 1) {
                    $passport->active = 0;
                    $passport->save();
                }
            }
            return true;
        }
    }

//    public function seeMyPassport()
//    {
//        $this->user_id = auth()->user()->id;
//        $this->resetPage();
////        $this->emitSelf('refreshPassportComponent');
//    }

//    public function seeAllPassport()
//    {
//        $this->user_id = '%';
//        $this->resetPage();
////        $this->emitSelf('refreshPassportComponent');
//    }

    public function resetPassport()
    {
        $this->passport =
            [
                'passport_number' => '',
                'given_name' => '', 'sur_name' => '',
                'date_of_birth' => '',
                'issue_date' => '',
                'expiry_date' => '',
                'country' => '',
                'region' => '',
                'active' => '',
                'file' => '',
                'user_id' => 0,
                'isFileExists' => false
            ];
    }

}
