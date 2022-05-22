<?php

namespace App\Http\Livewire\User\Documents;

use App\Http\Livewire\Authenticate;
use App\Models\Document;
use App\Models\serviceRequirement;
use App\Traits\Data;
use App\Traits\Datatable\DocumentDatable;
use App\Traits\Submit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use phpDocumentor\Reflection\Types\Integer;
use Spatie\Permission\Models\Permission;

class Datatablebck extends Authenticate
{
    use DocumentDatable;

    protected $listeners = ['myController'];

    public function mount(Request $request)
    {
        $this->resetForm('document');
        $this->requirement = Data::requirement_for_select();
    }

    protected $messages = [
        'document.name.required' => 'Document name is required.',
        'document.name.min' => ':attribute must be at-least 4 letters long.',
        'document.service_requirement_id.required' => 'Choose a service requirement to upload the file',
        'document.service_requirement_id.exists' => 'Service requirements doesnt exits',
        'document.notes.min' => 'Notes but be minimum 4 characters long',
        'document.file.required' => 'Upload image file for :attribute',
        'document.file.image' => ':attribute must be a image',
        'document.file.mimes' => ":attribute image allowed formats 'jpg,png,jpeg,gif,svg'",
        'document.file.max' => ":attribute must not exceed 500kb file size",
    ];



//    public function myController($value)
//    {
//        $this->myModal = $value;
//        switch ($value['model']) {
//            case 'document':
//                switch ($value['formType']) {
//                    case 'document':
//                        if ($value['modalType'] === 'update' || $value['modalType'] === 'delete') {
//                            $this->documentID = $value['record']['formData']['id'];
//                            $this->record = Document::where('id', $this->documentID)->first();
//                        }
//                        switch ($value['modalType']) {
//                            case 'add':
//                                $this->resetErrorBag();
//                                $this->resetForm('document');
//                                $this->record = new document();
//                                $this->document['user_id'] = auth()->user()->id;
//
//                                break;
//
//                            case 'update':
//                                $this->resetErrorBag();
//                                $this->document['id'] = $this->record->id;
//                                $this->document['name'] = $value['record']['formData']['name'];
//                                $this->document['service_requirement_id'] = $value['record']['formData']['service_requirement_id'];
//                                $this->document['notes'] = $value['record']['formData']['notes'];
//                                if(is_object($value['record']['formData']['file'])) $this->document['file'] = $value['record']['formData']['file'];
//                                $value['record']['formData']['user_id'] = auth()->user()->id;
//                                $this->document['user_id'] = $value['record']['formData']['user_id'];
//                                $this->path = 'storage/images/documents/' . $value['record']['formData']['file'];
//
//                                (file_exists($this->path)) ? $this->document['isFileExists'] = true : $this->document['isFileExists'] = false;
//                                break;
//
//                            case 'delete':
//
//                                break;
//                        }
//                        break;
//                }
//                break;
//        }
//    }

//    public function submit()
//    {
//        switch ($this->myModal['model']) {
//            case 'document':
//                switch ($this->myModal['formType']) {
//                    case 'document':
//                        switch ($this->myModal['modalType']) {
//                            case 'add':
//                                $this->submitForm($this, 'document', $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->document, $this->documentRules());
//                                break;
//                            case 'update':
//                                $this->submitForm($this, 'document', $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->document, $this->documentUpdateRules());
//                                break;
//                            case 'delete':
//                                $this->submitForm($this, 'document', $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->document, $this->documentRules());
//                                break;
//                        }
//                        break;
//                }
//        }
//    }

    public function export($file)
    {

        if(Storage::exists('public/images/documents/'.$file)){
            return Storage::download('public/images/documents/'.$file);

        }else{
            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title'=> 'Image not found!', 'message' => 'The image you are looking for doesnt exists!.']);
            return null;
        }
    }

    public function photoView($file){

        if(Storage::exists('public/images/documents/'.$file)){
            $this->fileView=$file;
            $this->dispatchBrowserEvent('photo-view-modal',['show'=>true]);
        }else{
            $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title'=> 'Image not found!', 'message' => 'The image you are looking for doesnt exists!.']);
        }

    }

    public function render()
    {

        if ($this->permission('user-document-view')) {
            $records = ServiceRequirement::with(['documents'=>function($q){
                $q->where('user_id',auth()->user()->id);
            }])->orderBy('created_at', 'asc')->paginate(10);

            return view('livewire.user.documents.datatable', ['records' => $records]);
        } else {
            return view('livewire.errors.access-denied', ['name' => 'documents']);
        }
    }

    protected function documentRules()
    {
        return [
            'document.name' => 'required|min:4',
            'document.service_requirement_id' => 'required|exists:service_requirements,id',
            'document.notes' => 'min:4',
            'document.file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:500',
        ];
    }

    protected function documentUpdateRules()
    {
        if(is_object($this->document['file'])){
            return [
                'document.name' => 'required|min:4',
                'document.service_requirement_id' => 'required|exists:service_requirements,id',
                'document.notes' => 'min:4',
                'document.file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:500',
            ];
        }else{
            return [
                'document.name' => 'required|min:4',
                'document.service_requirement_id' => 'required|exists:service_requirements,id',
                'document.notes' => 'min:4',
            ];
        }
    }

    protected function validationAttributes()
    {
        return [
            'document.file' => 'Document',
            'document.name' => $this->document['name'],
        ];
    }

    public function resetForm($form)
    {
        switch ($form) {
            case 'document':
                $this->document = ['name' => '', 'notes' => '', 'service_requirement_id' => '', 'user_id' => 0, 'file' => '', 'isFileExists' => false];
                break;
        }
    }
}
