<?php

namespace App\Traits\Datatable;

use App\Models\Application;
use App\Models\Document;
use App\Models\Passport;
use App\Traits\Authorize;
use App\Traits\Data;
use Illuminate\Support\Facades\Storage;

trait General
{
    use Authorize;
    use Data;

    public string $photoType = 'document', $fileView = '';



    public function export($file)
    {
        switch ($this->photoType) {
            case 'passport':
                if ($this->permission('user-passport-download')) {
                    if (Storage::exists('public/images/passports/' . $file)) {
                        return Storage::download('public/images/passports/' . $file);
                    } else {
                        $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Image not found!', 'message' => 'The image you are looking for doesnt exists!.']);
                        return null;
                    }
                } else {
                    $this->AccessDeniedModal('download', 'document');
                }
                break;
            case 'document':
                if ($this->permission('user-document-download')) {
                    if (Storage::exists('public/images/documents/' . $file)) {
                        return Storage::download('public/images/documents/' . $file);
                    } else {
                        $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Image not found!', 'message' => 'The image you are looking for doesnt exists!.']);
                        return null;
                    }
                } else {
                    $this->AccessDeniedModal('download', 'document');
                }
                break;
        }
    }

    public function photoView($file, $type = null)
    {
        switch ($type) {
            case 'passport':
                $this->photoType = 'passport';
                if ($this->permission('user-passport-view')) {
                    if (Storage::exists('public/images/passports/' . $file)) {
                        $this->fileView = $file;
                        $this->dispatchBrowserEvent('photo-view-modal', ['show' => true]);
                    } else {
                        $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Image not found!', 'message' => 'The image you are looking for doesnt exists!.']);
                    }
                } else {
                    $this->AccessDeniedModal('view', 'view document');
                }
                break;


            default:
                $this->photoType = 'document';
                if ($this->permission('user-document-view')) {
                    if (Storage::exists('public/images/documents/' . $file)) {
                        $this->fileView = $file;
                        $this->dispatchBrowserEvent('photo-view-modal', ['show' => true]);
                    } else {
                        $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Image not found!', 'message' => 'The image you are looking for doesnt exists!.']);
                    }
                } else {
                    $this->AccessDeniedModal('view', 'view document');
                }
                break;
        }

    }

    public function checkPermission($permission): bool
    {
        return ($this->permission($permission) === true ? 1 : 0);
    }

    public function isFileExists($filename): bool
    {
        return file_exists($filename);
    }




//    public function submit()
//    {
//        switch ($this->myModal['model']) {
//            case 'client-details':
//            case 'passport':
//                switch ($this->myModal['formType']) {
//                    case 'passport':
//                        if ($this->myModal['modalType'] === 'update' || $this->myModal['modalType'] === 'delete') {
//
//                            $this->record = passport::with('applications')->where('id', $this->myModal['record']['formData']['id'])->first();
//                            $this->passportID = $this->record->id;
//                        }
//                        switch ($this->myModal['modalType']) {
//                            case 'delete':
//                                if (count($this->record->applications) === 0) {
//                                    if (($this->record->accepted === 1 && $this->record->rejected === 0 && $this->record->revision === 0) || ($this->record->accepted === 0 && $this->record->rejected === 1 && $this->record->revision === 0)) {
//                                        $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Passport Decision!', 'message' => 'Cannot delete as passport decision was finalized']);
//                                    } else {
//                                        $this->submitForm($this, $this->myModal['model'], $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->passport, $this->passportRules());
//                                    }
//                                } else {
//                                    $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Passport Link!', 'message' => 'Cannot delete as one or more of the applications are using this passport']);
//                                }
//
//                                break;
//                        }
//                        break;
//                }
//                break;
//
//            case 'document':
//
//                switch ($this->myModal['formType']) {
//                    case 'document':
//                        if ($this->myModal['modalType'] === 'update' || $this->myModal['modalType'] === 'delete') {
//
//                            $this->record = Document::with('applications')->where('id', $this->myModal['record']['formData']['id'])->first();
//                            $this->documentID = $this->record->id;
//                        }
//                        switch ($this->myModal['modalType']) {
//
//                            case 'delete':
//
//                                if ($this->permission('user-document-delete')) {
//                                    if (count($this->record->applications) === 0) {
//                                        if (($this->record->accepted === 1 && $this->record->rejected === 0 && $this->record->revision === 0) || ($this->record->accepted === 0 && $this->record->rejected === 1 && $this->record->revision === 0)) {
//                                            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Document Decision!', 'message' => 'Cannot delete as document decision was finalized']);
//                                        } else {
//                                            $this->submitForm($this, $this->myModal['model'], $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->document, $this->documentRules());
//                                        }
//                                    } else {
//                                        $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'document Link!', 'message' => 'Cannot delete as one or more of the applications are using this document']);
//                                    }
//                                } else {
//                                    $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'Access Denied!', 'message' => 'You are not authorized to delete documents']);
//                                }
//                                break;
//                        }
//                        break;
//                }
//                break;
//        }
//    }
}
