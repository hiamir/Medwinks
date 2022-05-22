<?php

namespace App\Traits\Datatable;

use App\Models\Application;
use App\Models\Document;
use App\Models\User;
use App\Rules\ImageRule;
use App\Traits\Authorize;
use App\Traits\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use function PHPUnit\Framework\fileExists;

trait DocumentDatable
{

    use Authorize;

//
    public ?int $applicationID = null, $documentID = null, $requirementTabID = null, $userID = null;


    public array $myModal = [],

        $chats = [];

    public $tempUrl = '';

//    public function mount(Request $request)
//    {
//        $this->resetDocument();
//        $this->requirements = Data::requirement_for_select();
//    }


    public function acceptDocument($docID)
    {
        $this->documentType = 'document';
        $this->confirmationType = 'accept';

        $check = Document::with(['applications' => function ($q) {
            $q->where('accepted', 0)->where('rejected', 0)->where('revision', 0);
        }])->where('id', $docID)->first();

        $countApplicationsLinked = count($check->applications);

        if ($countApplicationsLinked === 0 || ($check->accepted===0 && $check->rejected===0 && $check->revision===0  ) ) {

            $doc = Document::where('id', $docID)->first();
            $this->documentID = $doc['id'];
            $this->dispatchBrowserEvent('confirmation-modal', ['show' => true, 'type' => $this->confirmationType, 'title' => 'Accept Document?', 'message' => 'Are you sure you want to Accept document &nbsp<strong> ' . $doc['name'] . '</strong>?']);
        } else {
            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Document Link!', 'message' => 'Cannot update or alter this document as its linked with other applications']);
        }
    }

    public function rejectDocument($docID)
    {
        $this->documentType = 'document';
        $this->confirmationType = 'reject';
        $check = Document::with(['applications' => function ($q) {
            $q->where('accepted', 0)->where('rejected', 0)->where('revision', 0);
        }])->where('id', $docID)->first();

        $countApplicationsLinked = count($check->applications);

        if ($countApplicationsLinked === 0) {
            $this->documentType = 'document';
            $this->confirmationType = 'reject';
            $doc = Document::where('id', $docID)->first();
            $this->documentID = $doc['id'];
            $this->dispatchBrowserEvent('confirmation-modal', ['show' => true, 'type' => $this->confirmationType, 'title' => 'Reject Document?', 'message' => 'Are you sure you want to reject document &nbsp<strong> ' . $doc['name'] . '</strong>?']);
        } else {
            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Document Link!', 'message' => 'Cannot update or alter this document as its linked with other applications']);
        }

    }

    public function reviseDocument($docID)
    {
        $this->documentType = 'document';
        $this->confirmationType = 'revision';
        $doc = Document::with('serviceRequirement')->where('id', $docID)->first();
        $this->docName = $doc->serviceRequirement->first()->name;
        $this->documentID = $docID;
        $this->dispatchBrowserEvent('confirmation-modal', ['show' => true, 'type' => $this->confirmationType, 'title' => 'Revise Document?', 'message' => 'Are you sure you want to revise &nbsp<strong> ' . $this->docName . '</strong>?']);
    }



    public function allRequirements()
    {
        return Data::requirement_for_select();
    }


    public function documentChat($doc)
    {
        $this->dispatchBrowserEvent('chat-modal', ['show' => true, 'title' => 'Comment History']);
        $documents = Document::find($doc['id'])->comments()->orderby('created_at', 'desc')->get();
        if ($doc['user_id'] === auth()->user()->id) {
            foreach ($documents as $document) {
                $document->opened = 1;
                $document->save();
            }
        }
        $this->chats = json_decode($documents, true);
    }

    public function documentCheck($id)
    {
        $check = Document::with('applications')->where('id', $id)->first();
        $isApplicationAccepted = json_decode($check->applications()->pluck('accepted'), true);
        $isApplicationRejected = json_decode($check->applications()->pluck('rejected'), true);
        $isApplicationRevision = json_decode($check->applications()->pluck('revision'), true);

        if ($check->accepted === 0 && $check->rejected === 0 && $check->revision === 0) {

        }

        if (($check->accepted === 1 || $check->rejected === 1) && ($check->revision === 0)) {
            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Document Finalized!', 'message' => 'Cannot alter or update! This document is already finalized the decision.']);
        } else if (($check->revision === 0) && ((count($check->applications()->get()) > 0) || (in_array(1, $isApplicationAccepted)) || (in_array(1, $isApplicationRejected)))) {
            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Document Used!', 'message' => 'Cannot alter or update! This document is used in other applications.']);
        }
//        $check = Document::whereHas('applications',function($q){
//            $q->where('accepted', 0)->where('rejected', 0)->where('revision', 0)->orWhere('revision', 1);
//        })->where('id', $id)->get();

    }

    public function checkFileExists($path)
    {

        return file_exists($path);
    }


//    public function myController($value)
//    {
//        $this->myModal = $value;
//        switch ($value['model']) {
//            case 'user':
//                if ($value['modalType'] === 'update' || $value['modalType'] === 'delete' || $value['modalType'] === 'password-reset') {
//                    $this->userID = $value['record']['formData']['id'];
//                    $this->record = User::where('id', $this->userID)->first();
//                }
//                switch ($value['modalType']) {
//                    case 'add':
//                        $this->resetForm('user');
//                        $this->record = new User();
//                        break;
//
//                    case 'update':
//                        $this->resetErrorBag();
//                        $this->user['name'] = $value['record']['formData']['name'];
//                        $this->user['email'] = $value['record']['formData']['email'];
//                        $this->user['gender'] = $value['record']['formData']['gender_id'];
//
//
//                        break;
//                    case 'delete':
//                    case 'password-reset':
//                        break;
//                }
//                break;
//            case 'document':
//            case 'client-details':
//                switch ($value['formType']) {
//                    case 'document':
//                        if ($value['modalType'] === 'update' || $value['modalType'] === 'delete') {
//                            $this->documentID = $value['record']['formData']['id'];
////                            ($this->requirementTabID !== null)? $this->documentID=$this->requirementTabID :
//                            $this->record = Document::with('applications')->where('id', $this->documentID)->first();
//                        }
//                        switch ($value['modalType']) {
//
//                            case 'add':
//                                $this->resetErrorBag();
//                                $this->resetDocument();
//                                $this->record = new document();
//                                if ($this->requirementTabID !== null) $this->document['service_requirement_id'] = $this->requirementTabID;
//                                ($this->userID !== null) ? $this->document['user_id'] = $this->userID : $this->document['user_id'] = auth()->user()->id;
//                                break;
//
//                            case 'update':
//                                if ($this->isAccessUpdateDocument($this->record->id)) {
//
//                                    $this->resetErrorBag();
//                                    $this->document['id'] = $this->record->id;
//                                    $this->document['name'] = $value['record']['formData']['name'];
//                                    $this->document['service_requirement_id'] = $value['record']['formData']['service_requirement_id'];
//                                    $this->document['notes'] = $value['record']['formData']['notes'];
//                                    if (is_object($value['record']['formData']['file'])) $this->document['file'] = $value['record']['formData']['file'];
//                                    $value['record']['formData']['user_id'] = auth()->user()->id;
//                                    $this->document['user_id'] = $this->record->user_id;
//                                    $this->path = 'storage/images/documents/' . $value['record']['formData']['file'];
//
//                                    (file_exists($this->path)) ? $this->document['isFileExists'] = true : $this->document['isFileExists'] = false;
//                                } else {
//                                    $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Document Finalized!', 'message' => 'This document already submitted and decision was finalized']);
//                                }
//
//                                break;
//
//                            case 'delete':
//
//                                $this->documentCheck($this->record->id);
//                                if (count($this->record->applications()->get()) > 0) $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Document Used!', 'message' => 'Cannot alter or update! This document is used in applications.']);
//                                break;
//                        }
//                        break;
//
//                }
//                break;
//        }
//    }

    public function myController($value)
    {
        $this->tempUrl = '';
        $this->documentType = 'document';
        $this->myModal = $value;
    }


    public function submitDocument()
    {
        switch ($this->myModal['model']) {
            case 'client-details':
            case 'document':

                switch ($this->myModal['formType']) {
                    case 'document':
                        $this->documentType = 'document';
                        if ($this->myModal['modalType'] === 'update' || $this->myModal['modalType'] === 'delete') {

                            $this->record = Document::with('applications')->where('id', $this->myModal['record']['formData']['id'])->first();
                            $this->documentID = $this->record->id;
                        }
                        switch ($this->myModal['modalType']) {

                            case 'add':
                                if ($this->permission('user-document-create')) {
                                    $this->resetErrorBag();
                                    $this->validationErrors = [];

                                    $this->record = new document();
                                    ($this->myModal['model'] === 'document') ? $this->document['user_id'] = auth()->user()->id : $this->document['user_id'] = $this->userID;
                                    $this->document['service_requirement_id'] = $this->requirementTabID;
                                    $this->document['accepted'] = 0;
                                    $this->document['rejected'] = 0;
                                    $this->document['revision'] = 0;
                                    $this->submitForm($this, $this->myModal['model'], $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->document, $this->documentRules());
                                } else {
                                    $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Access Denied!', 'message' => 'You are not authorized to create documents']);
                                }
                                break;

                            case 'update':
                                if ($this->permission('user-document-update')) {
                                    if (($this->record->accepted === 0 && $this->record->rejected === 0 && $this->record->revision === 1) || $this->isUserManager === true) {
                                        $this->resetErrorBag();

                                        if ((count($this->record->applications) > 0) && $this->document['service_requirement_id'] !== $this->record->service_requirement_id) {
                                            $this->document['service_requirement_id'] = $this->record->service_requirement_id;
                                            $this->dispatchBrowserEvent('add-update-modal', ['show' => false]);
                                            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Folder Change Error!', 'message' => 'Cannot change folder as this document is linked to another applications!']);
                                            break;
                                        }

                                        $this->document['user_id'] = $this->record->user_id;
                                        $this->document['accepted'] = 0;
                                        $this->document['rejected'] = 0;
                                        $this->document['revision'] = 1;
                                        $this->path = 'storage/images/documents/' . $this->document['file'];
                                        (file_exists($this->path)) ? $this->document['isFileExists'] = true : $this->document['isFileExists'] = false;

                                        $this->submitForm($this, $this->myModal['model'], $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->document, $this->documentUpdateRules($this->document['file']));
                                    } else {
                                        $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Document Decision!', 'message' => 'Cannot update as document is under review']);
                                    }
                                } else {
                                    $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Access Denied!', 'message' => 'You are not authorized to update documents']);
                                }
                                break;

                            case 'delete':
                                if ($this->permission('user-document-delete')) {
                                    if (count($this->record->applications) === 0) {
                                        if (($this->record->accepted === 1 && $this->record->rejected === 0 && $this->record->revision === 0)) {
                                            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Document Decision!', 'message' => 'Cannot delete as document decision was finalized']);
                                        } else {
                                            $this->submitForm($this, $this->myModal['model'], $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->document, $this->rules());
                                        }
                                    } else {
                                        $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'document Link!', 'message' => 'Cannot delete as one or more of the applications are using this document']);
                                    }
                                } else {
                                    $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Access Denied!', 'message' => 'You are not authorized to delete documents']);
                                }
                                break;
                        }
                        break;
                }
                break;
        }
    }

//
//    public function export($file)
//    {
//        if ($this->permission('user-client-details-document-download') || $this->permission('user-application-submissions-document-download')) {
//            switch ($this->photoType) {
//                case 'passport':
//                    if (Storage::exists('public/images/passports/' . $file)) {
//                        return Storage::download('public/images/passports/' . $file);
//
//                    } else {
//                        $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Image not found!', 'message' => 'The image you are looking for doesnt exists!.']);
//                        return null;
//                    }
//                    break;
//
//                case 'document':
//                    if (Storage::exists('public/images/documents/' . $file)) {
//                        return Storage::download('public/images/documents/' . $file);
//
//                    } else {
//                        $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Image not found!', 'message' => 'The image you are looking for doesnt exists!.']);
//                        return null;
//                    }
//                    break;
//            }
//
//        } else {
//            $this->AccessDeniedModal('download', 'document');
//        }
//    }

//    public function passportView($file)
//    {
//        if ($this->permission('user-client-details-document-view') || $this->permission('user-application-submissions-document-view')) {
//            if (Storage::exists('public/images/passports/' . $file)) {
//                $this->fileView = $file;
//                $this->dispatchBrowserEvent('photo-view-modal', ['show' => true]);
//            } else {
//                $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Image not found!', 'message' => 'The image you are looking for doesnt exists!.']);
//            }
//        } else {
//            $this->AccessDeniedModal('view', 'view document');
//        }
//    }

//    public function photoView($file, $type = null)
//    {
//        switch ($type) {
//            case 'passport':
//                $this->photoType = 'passport';
//                if ($this->permission('user-client-details-document-view') || $this->permission('user-application-submissions-document-view')) {
//                    if (Storage::exists('public/images/passports/' . $file)) {
//                        $this->fileView = $file;
//                        $this->dispatchBrowserEvent('photo-view-modal', ['show' => true]);
//                    } else {
//                        $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Image not found!', 'message' => 'The image you are looking for doesnt exists!.']);
//                    }
//                } else {
//                    $this->AccessDeniedModal('view', 'view document');
//                }
//                break;
//
//
//            default:
//                $this->photoType = 'document';
//                if ($this->permission('user-client-details-document-view') || $this->permission('user-application-submissions-document-view')) {
//                    if (Storage::exists('public/images/documents/' . $file)) {
//                        $this->fileView = $file;
//                        $this->dispatchBrowserEvent('photo-view-modal', ['show' => true]);
//                    } else {
//                        $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Image not found!', 'message' => 'The image you are looking for doesnt exists!.']);
//                    }
//                } else {
//                    $this->AccessDeniedModal('view', 'view document');
//                }
//                break;
//        }
//
//    }

    protected function documentRules()
    {
        return [
            'document.name' => 'required|min:5|max:25',
            'document.service_requirement_id' => 'required|exists:service_requirements,id|numeric|gt:0',
            'document.notes' => 'min:4',
            'document.file' => 'required|mimes:jpg,png,jpeg,gif,doc,docx,pdf|max:500',
        ];
    }

    protected function documentUpdateRules($file = null)
    {
        if (is_object($file)) {
            return [
                'document.name' => 'required|min:5|max:25',
                'document.service_requirement_id' => 'required|exists:service_requirements,id',
                'document.notes' => 'min:4',
                'document.file' => 'required|mimes:jpg,png,jpeg,gif,doc,docx,pdf|max:500',
            ];
        }
        else {
            return [
                'document.name' => 'required|min:4|max:10',
                'document.service_requirement_id' => 'required|exists:service_requirements,id',
                'document.notes' => 'min:4',
                'document.file' => 'required|mimes:jpg,png,jpeg,gif,doc,docx,pdf|max:500',
            ];
        }
    }


    public function resetDocument()
    {
        $this->document = [
            'name' => '',
            'notes' => '',
            'service_requirement_id' => '',
            'user_id' => 0,
            'file' => '',
            'isFileExists' => false
        ];
    }


}
