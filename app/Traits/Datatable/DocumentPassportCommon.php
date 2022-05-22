<?php

namespace App\Traits\Datatable;

use App\Mail\ApplicationDecision;
use App\Mail\DocumentDecision;
use App\Mail\PassportDecision;
use App\Models\Application;
use App\Models\Comments;
use App\Models\Document;
use App\Models\Passport;
use App\Models\ServiceRequirement;
use App\Models\User;
use App\Traits\Data;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


trait DocumentPassportCommon
{
    use General;

    public ?int $passportID = null, $checkNoPassports = null;
    public string $comments = "", $documentType = "", $confirmationType = '';
    public array $chats = [], $requirements = [],
        $document = ['name' => '', 'notes' => '', 'service_requirement_id' => '', 'user_id' => 0, 'file' => '', 'isFileExists' => false],
        $passport = [
        'passport_number' => '',
        'given_name' => '',
        'sur_name' => '',
        'date_of_birth' => '',
        'issue_date' => '',
        'expiry_date' => '',
        'country' => null,
        'region' => null,
        'active' => '',
        'file' => '',
        'user_id' => null,
        'isFileExists' => false
    ];

    public bool $isPermission, $isApplicationZone = false;
    public string $tempName, $path = '', $docName = '', $passName = '';
    public $file = "", $nowDate;

    public function mount(Request $request)
    {
        $this->userID = $request->user;
        $this->allRequirements = json_decode((ServiceRequirement::select('id')->pluck('id')), true);
        $this->nowDate = Carbon::now()->format('Y-m-d');
        $this->requirements = Data::requirement_for_select();
        if ($this->documentType === 'passport') {
            $this->regions = [];
            $this->allRegions = Data::regions_all_for_select();
        }
        if ($this->documentType === 'document') {
//            $this->resetDocument();

        }
    }

    public function updating($field, $value)
    {
        switch ($field) {

            case 'passport.country':
                $this->regions = Data::regions_for_select($value);
                break;

            case'passport.file':
            case'document.file':
                $this->file=$value;
                ($value === 'passport.file') ? $this->passport['file'] = $value : $this->document['file'] = $value;
                $acceptedExt = ['jpg', 'png', 'jpeg', 'doc', 'pdf', 'docx'];
                if (is_object($value)) {
                    $this->file = $value;
                    $this->tempName = $value->getClientOriginalName();
                    $ext = explode('.', $this->tempName);

                    if (in_array(end($ext), $acceptedExt)) {
                        $this->tempUrl = $value->temporaryUrl();
                    } else {
                        $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Extension Error!', 'message' => 'This file extension is not allowed.']);
                    }


                }
                break;
        }
    }

    public function submitConfirmation()
    {
        if ($this->confirmationType === 'accept' || $this->confirmationType === 'reject' || $this->confirmationType === 'revision') {
            switch ($this->documentType) {
                case 'passport':
                    $passport = Passport::where('id', $this->passportID)->first();
                    $user = User::find($passport['user_id']);
                    try {
                        switch ($this->confirmationType) {
                            case 'accept':
                                if ($this->permission('user-passport-accept')) {
                                    $passport->accepted = 1;
                                    $passport->rejected = 0;
                                    $passport->revision = 0;
                                    $passport->save();
                                    if ($this->comments !== "") {
                                        $comment = new comments();
                                        $comment->comment = $this->comments;
                                        $passport->comments()->save($comment);
                                    }
                                    $this->dispatchBrowserEvent('confirmation-modal', ['show' => false]);
                                    $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => $passport->passport_number . ' accepted!']);
                                } else {
                                    $this->AccessDeniedModal('accept', $passport->passport_number);
                                }
                                break;

                            case 'revision':

                                if ($this->permission('user-passport-revision')) {
                                    $passport->accepted = 0;
                                    $passport->rejected = 0;
                                    $passport->revision = 1;
                                    $passport->file = '';
                                    $passport->save();

                                    if (file_exists('/storage/images/passports/' . $passport->file)) {
                                        unlink('/storage/images/passports/' . $passport->file);
                                    }

                                    if ($this->comments !== "") {
                                        $comment = new comments();
                                        $comment->comment = $this->comments;
                                        $passport->comments()->save($comment);
                                    }

                                    $this->dispatchBrowserEvent('confirmation-modal', ['show' => false]);
                                    $this->dispatchBrowserEvent('toast', ['alert' => 'warning', 'message' => $passport->passport_number . ' needs revision!']);
                                } else {
                                    $this->AccessDeniedModal('revision', $passport->passport_number);
                                }
                                break;

                            case 'reject':
                                if ($this->permission('user-passport-reject')) {
                                    $passport->accepted = 0;
                                    $passport->rejected = 1;
                                    $passport->revision = 0;
                                    $passport->save();
                                    if ($this->comments !== "") {
                                        $comment = new comments();
                                        $comment->comment = $this->comments;
                                        $passport->comments()->save($comment);
                                    }
                                    $this->dispatchBrowserEvent('confirmation-modal', ['show' => false]);
                                    $this->dispatchBrowserEvent('toast', ['alert' => 'danger', 'message' => $passport->passport_number . ' rejected!']);
                                } else {
                                    $this->AccessDeniedModal('reject', $passport->passport_number);
                                }
                                break;
                        }
                    } catch (\Exception $e) {
                        $this->toast('danger', 'Error:  ' . $e->getMessage());
                    }
                    if ($passport) {
                        Mail::to($user->email)->send(new PassportDecision($user->name, $this->docName, $this->confirmationType));
                    }
                    break;

                case 'document':
                    $document = Document::where('id', $this->documentID)->first();
                    $user = User::find($document['user_id']);
                    try {
                        DB::transaction(function () use ($document, $user) {
                            switch ($this->confirmationType) {
                                case 'accept':
                                    if ($this->permission('user-document-accept') && $document->accepted === 0 && $document->rejected === 0 && $document->revision === 0) {
                                        $document->accepted = 1;
                                        $document->rejected = 0;
                                        $document->revision = 0;
                                        $document->save();
                                        if ($this->comments !== "") {
                                            $comment = new comments();
                                            $comment->comment = $this->comments;
                                            $document->comments()->save($comment);
                                        }

                                        $this->dispatchBrowserEvent('confirmation-modal', ['show' => false]);
                                        $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => $document->name . ' accepted!']);
                                    } else {
                                        $this->AccessDeniedModal('accept', $document->name);
                                    }
                                    break;

                                case 'reject':
                                    if ($this->permission('user-document-reject')) {
                                        $document->accepted = 0;
                                        $document->rejected = 1;
                                        $document->revision = 0;
                                        $document->save();
                                        if ($this->comments !== "") {
                                            $comment = new comments();
                                            $comment->comment = $this->comments;
                                            $document->comments()->save($comment);
                                        }
                                        $this->dispatchBrowserEvent('confirmation-modal', ['show' => false]);
                                        $this->dispatchBrowserEvent('toast', ['alert' => 'warning', 'message' => $document->name . ' needs revision!']);
                                    } else {
                                        $this->AccessDeniedModal('reject', $document->name);
                                    }
                                    break;

                                case 'revision':

                                    if ($this->permission('user-document-revision')) {
                                        $document->accepted = 0;
                                        $document->rejected = 0;
                                        $document->revision = 1;
                                        $document->file = '';
                                        $document->save();

                                        if (file_exists('/storage/images/documents/' . $document->file)) {
                                            unlink('/storage/images/documents/' . $document->file);
                                        }

                                        if ($this->comments !== "") {
                                            $comment = new comments();
                                            $comment->comment = $this->comments;
                                            $document->comments()->save($comment);
                                        }


                                        $this->dispatchBrowserEvent('confirmation-modal', ['show' => false]);
                                        $this->dispatchBrowserEvent('toast', ['alert' => 'danger', 'message' => $document->passport_number . ' rejected!']);

                                    } else {
                                        $this->AccessDeniedModal('revise', $document->name);
                                    }
                                    break;
                            }
                        });
                    } catch (\Exception $e) {
                        DB::rollback();
                        $this->toast('danger', 'Error:  ' . $e->getMessage());
                    }
                    if ($document) {
                        Mail::to($user->email)->send(new DocumentDecision($user->name, $this->docName, $this->confirmationType));
                    }
//                    $this->emit('refreshComponent');
                    break;

                case 'application':


                    try {
                        $application = Application::with(['user', 'service'])->where('id', $this->applicationID)->first();

                        $user = $application->user()->first();
                        switch ($this->confirmationType) {
                            case 'accept':
                                if ($this->permission('user-document-accept')) {

                                    if ($this->rejectCheckbox) {
                                        $application->accepted = 0;
                                        $application->rejected = 1;
                                        $application->revision = 0;
                                    } else {
                                        $application->accepted = 1;
                                        $application->rejected = 0;
                                        $application->revision = 0;
                                    }
                                    $application->save();
                                    $this->rejectCheckbox = false;
                                    if ($this->comments !== "") {
                                        $comment = new comments();
                                        $comment->comment = $this->comments;
                                        $application->comments()->save($comment);
                                    }
                                    $this->dispatchBrowserEvent('confirmation-modal', ['show' => false]);
                                    ($this->rejectCheckbox) ? $this->dispatchBrowserEvent('toast', ['alert' => 'danger', 'message' => 'Application rejected!']) : $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => 'Application accepted!']);

                                } else {
                                    $this->AccessDeniedModal('accept', 'Application');
                                }
                                break;

                            case 'reject':
                                if ($this->permission('user-document-reject')) {
                                    $application->accepted = 0;
                                    $application->rejected = 1;
                                    $application->revision = 0;
                                    $application->save();
                                    if ($this->comments !== "") {
                                        $comment = new comments();
                                        $comment->comment = $this->comments;
                                        $application->comments()->save($comment);
                                    }
                                    $this->dispatchBrowserEvent('confirmation-modal', ['show' => false]);
                                    $this->dispatchBrowserEvent('toast', ['alert' => 'danger', 'message' => 'Application rejected!']);
                                } else {
                                    $this->AccessDeniedModal('reject', 'Application');
                                }
                                break;

                            case 'revision':
                                if ($this->permission('user-document-revision')) {
                                    if ($this->rejectCheckbox) {
                                        $application->accepted = 0;
                                        $application->rejected = 1;
                                        $application->revision = 0;
                                    } else {
                                        $application->accepted = 0;
                                        $application->rejected = 0;
                                        $application->revision = 1;
                                    }

                                    $application->save();
                                    $this->rejectCheckbox = false;
                                    if ($this->comments !== "") {
                                        $comment = new comments();
                                        $comment->comment = $this->comments;
                                        $application->comments()->save($comment);
                                    }
                                    $this->dispatchBrowserEvent('confirmation-modal', ['show' => false]);
                                    ($this->rejectCheckbox) ? $this->dispatchBrowserEvent('toast', ['alert' => 'danger', 'message' => 'Application rejected!']) : $this->dispatchBrowserEvent('toast', ['alert' => 'warning', 'message' => 'Application needs revision!']);
                                } else {
                                    $this->AccessDeniedModal('reject', 'Application');
                                }
                                break;
                        }
                    } catch (\Exception $e) {
                        $this->toast('danger', 'Error:  ' . $e->getMessage());
                    }
                    if ($application) {
                        Mail::to($user->email)->send(new ApplicationDecision($user->name, $application->service()->first()->name, $this->confirmationType));

//                        dispatch(new ApplicationDecision($user->name, $application->service()->first()->name, $this->confirmationType));
                    }
                    break;
            }


        } else {
            $this->toast('danger', 'Error submitting request. Contact administrator!');
        }

    }

    protected function messages()
    {
        switch ($this->documentType) {
            case 'passport':
                return [
                    'passport.passport_number.required' => 'Required',
                    'passport.given_name.required' => 'Required',
                    'passport.given_name.min' => 'Name must be min 4 character long',
                    'passport.sur_name.required' => 'Required',
                    'passport.sur_name.min' => 'Name must be min 4 character long',
                    'passport.date_of_birth.required' => 'Required',
                    'passport.date_of_birth.date' => ":attribute must be valid date",
                    'passport.date_of_birth.date_format' => ":attribute must have 'Y-m-d' format",
                    'passport.date_of_birth.before_or_equal' => ":attribute must be today or before today's date",
                    'passport.issue_date.required' => "Required",
                    'passport.issue_date.date' => ":attribute must be valid date",
                    'passport.issue_date.date_format' => ":attribute date must have 'Y-m-d' format",
                    'passport.issue_date.before_or_equal' => ":attribute date must be today or before today's date",
                    'passport.expiry_date.required' => "Required",
                    'passport.expiry_date.date' => ":attribute must be valid date",
                    'passport.expiry_date.date_format' => ":attribute date must have 'Y-m-d' format",
                    'passport.expiry_date.before_or_equal' => ":attribute date must be today or before today's date",
                    'passport.country' => 'Required',
                    'passport.region' => 'Required',
                    'passport.file.required' => 'Upload image file for :attribute',
                    'passport.file.image' => ':attribute must be a image',
                    'passport.file.mimes' => ":attribute image allowed formats 'jpg,png,jpeg,gif,svg'",
                    'passport.file.max' => ":attribute must not exceed 500kb file size"
                ];

            case 'document':
                return [
                    'document.name.required' => "Document name is required",
                    'document.name.min' => ":attribute must be min 4 character long",
                    'document.name.max' => ":attribute must be max 10 character long",
                    'document.notes.min' => ":attribute must be min 4 character long",
                    'document.service_requirement_id.numeric' => ":attribute must be min positive integer",
                    'document.service_requirement_id.gt' => ":attribute must be greater than 0",
                    'document.service_requirement_id.required' => "Requirement ID is required",
                    'document.service_requirement_id.exits' => ":attribute already exits",
                ];

        }


    }

    protected function validationAttributes(): array
    {
        switch ($this->documentType) {
            case 'passport':
                return [
                    'passport.passport_number' => ($this->passport['passport_number'] != '') ? $this->passport['passport_number'] : 'Passport number',
                    'passport.given_name' => ($this->passport['given_name'] != '') ? $this->passport['given_name'] : 'Given name',
                    'passport.sur_name' => ($this->passport['sur_name'] != '') ? $this->passport['sur_name'] : 'Sur name',
                    'passport.date_of_birth' => ($this->passport['date_of_birth'] != '') ? $this->passport['date_of_birth'] : 'Date of birth',
                    'passport.issue_date' => ($this->passport['issue_date'] != '') ? $this->passport['issue_date'] : 'Issue date',
                    'passport.expiry_date' => ($this->passport['expiry_date'] != '') ? $this->passport['expiry_date'] : 'Expiry date',
                    'passport.country' => 'Country',
                    'passport.region' => 'Region',
                    'passport.file' => ($this->passport['file'] != '') ? $this->passport['file'] : 'Passport',
                ];

            case 'document':
                return [
                    'document.file' => 'Document',
                    'document.name' => $this->document['name'],
                ];
        }
    }
}
