<?php

namespace App\Http\Livewire\Admin\Gender;

use App\Http\Livewire\Authenticate;
use App\Models\Admin;
use App\Models\DefaultProfilePhoto;
use App\Models\Gender;
use App\Models\User;
use App\Traits\Data;
use App\Traits\Submit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Throwable;

class Datatable extends Authenticate
{
    use WithPagination;
    use Submit;
    use Data;
    use WithFileUploads;


    protected $listeners = ['myController','refreshGenderComponent'=>'$refresh'];

    public
        $myModal = [],
        $gender = [],
        $defaultPhoto = [],
        $photoFile=null,
        $genderID,
        $photoLink=null,
        $defaultProfilePhotoID;


    public function mount(Request $request)
    {
        $this->resetForm('gender');
        $this->resetForm('defaultProfilePhoto');
        $this->modalDetails['model'] = 'gender';
    }

    public function updatingPhotoFile($value){
    }

    protected $messages = [

        'gender.name.required' => 'Gender name is required.',
        'gender.name.min' => ':attribute must be at-least 4 letters long.',
        'gender.name.unique' => ':attribute gender already exists!.',

        'defaultPhoto.name.required' => 'Profile photo name is required.',
        'defaultPhoto.name.min' => ':attribute must be at-least 4 letters long.',
        'defaultPhoto.file.required' => 'Please choose a profile photo to upload',
        'defaultPhoto.file.max' => 'Profile photo must not be greater than 200 kilobytes.',
        'defaultPhoto.file.image' => 'Profile photo must be an image',
    ];

    protected function photoRules()
    {
        switch ($this->myModal['modalType']) {
            case 'add':
                return [
                    'defaultPhoto.name' => 'required|min:4',
                    'defaultPhoto.file' => 'required|image|mimes:jpeg,png,jpg|max:200',
                ];

            case 'update':
                return [
                    'defaultPhoto.name' => 'required|min:4',
                    'defaultPhoto.file' => 'image|mimes:jpeg,png,jpg|max:200',
                ];
        }

    }


    public function myController($value)
    {
        $this->myModal = $value;
        switch ($value['model']) {
            case 'gender':
                switch ($value['formType']) {
                    case 'gender':
                        if ($value['modalType'] === 'update' || $value['modalType'] === 'delete') {
                            $this->genderID = $value['record']['formData']['id'];
                            $this->record = Gender::where('id', $this->genderID)->first();
                        }
                        switch ($value['modalType']) {
                            case 'add':
                                $this->resetForm('gender');
                                $this->record = new Gender();
                                break;

                            case 'update':
                                $this->resetErrorBag();
                                $this->gender['name'] = $value['record']['formData']['name'];
                                break;
                            case 'delete':
                                break;
                        }
                        break;

                    case 'defaultProfilePhoto':
                        if ($value['modalType'] === 'update' || $value['modalType'] === 'delete') {
                            $this->defaultProfilePhotoID = $value['record']['formData']['id'];
//                            dd($this->defaultProfilePhotoID);
                            $this->record = DefaultProfilePhoto::where('id', $this->defaultProfilePhotoID)->first();
                        }
                        switch ($value['modalType']) {
                            case 'add':
                                $this->resetForm('defaultProfilePhoto');
                                break;
                            case 'update':
                                $this->resetErrorBag();
                                $this->defaultPhoto['name'] = $value['record']['formData']['name'];
//                                $this->defaultPhoto['name'] = $this->record->name;
                                $this->defaultPhoto['file'] = '';
                                break;
                            case 'delete':
                                break;
                        }
                        break;

                }
        }
    }

    public function submit()
    {
        switch ($this->myModal['model']) {
            case 'gender':
                switch ($this->myModal['formType']) {
                    case 'gender':
                        $this->submitForm($this, 'gender', $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->gender, $this->rules());
                        break;

                    case 'defaultProfilePhoto':
                        switch ($this->myModal['modalType']) {
                            case 'add':
                                ($this->permission('admin-default-profile-photo-create')) ? $this->submitPhoto() : $this->AccessDeniedModal('create', 'Default Profile Photo');
                                break;
                            case 'update':
                                ($this->permission('admin-default-profile-photo-update')) ? $this->submitPhoto() : $this->AccessDeniedModal('update', 'Default Profile Photo');
                                break;
                            case 'delete':
                                if ($this->permission('admin-default-profile-photo-delete')) {
                                    try {
                                        DB::transaction(function () {
//                                            $record = DefaultProfilePhoto::where('id', $this->myModal['record']['formData']['id'])->first();

                                            $this->record->delete();
                                            if (Storage::exists('public/images/profile/' . $this->record->file)) {
                                                Storage::delete('public/images/profile/' . $this->record->file);
                                            }
                                            $this->dispatchBrowserEvent('delete-modal', ['show' => false]);
                                            $this->dispatchBrowserEvent('toast', ['alert' => 'danger', 'message' => 'Profile photo was deleted!']);
                                            $this->emitSelf('refreshGenderComponent');
//$this->record=null;
//$this->reset();
//$this->myModal=null;
                                        });

                                    } catch (Throwable $e) {
                                        DB::rollback();
                                        $this->dispatchBrowserEvent('toast', ['alert' => 'danger', 'message' => 'There was an error Adding profile photo!']);
                                    }

                                } else {
                                    $this->AccessDeniedModal('delete', 'Default Profile Photo');
                                }
                        }
                        break;
                }
                break;
        }
    }


    public function submitPhoto()
    {
        $genderID = null;
        switch ($this->myModal['modalType']) {
            case 'add':
                $genderID = $this->modalDetails['record']['gender'];
                break;

            case 'update':

                break;
        }
        $photoValidate = $this->validate($this->photoRules());
        try {
            DB::transaction(function () use ($genderID) {
                $upload = null;
                switch ($this->myModal['modalType']) {
                    case 'add':
                        $upload = new DefaultProfilePhoto();
                        $upload->gender_id = $genderID;
                        break;

                    case 'update':
                        $upload = DefaultProfilePhoto::where('id', $this->myModal['record']['formData'])->first();
                        break;
                }

                $upload->name = $this->defaultPhoto['name'];
                $upload->save();
                if ($this->defaultPhoto['file']) {
                    $filename = explode('.', $this->defaultPhoto['file']->getFilename());
                    $newFileName = 'default-profile-photo-' . $upload->id . '.' . $filename[1];
                    $this->defaultPhoto['file']->storeAs('public/images/profile', $newFileName);
                    $upload->file = $newFileName;
                }
                $upload->save();
               $this->defaultPhoto['file']=null;
            });

            $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => 'Profile photo was updated!']);
        } catch (Throwable $e) {
            DB::rollback();
            $this->dispatchBrowserEvent('toast', ['alert' => 'danger', 'message' => 'There was an error adding profile photo!']);
        }

        $this->dispatchBrowserEvent('add-update-modal', ['show' => false]);
        $this->emitSelf('refreshGenderComponent');
    }


    public function render()
    {
        if ($this->permission('admin-gender-view')) {
            $records = Gender::with('default_profile_photos')->orderBy('name', 'Asc')->paginate(20);
            return view('livewire.admin.gender.datatable', ['records' => $records]);
        } else {
            return view('livewire.errors.access-denied', ['name' => 'Gender']);
        }


    }

    protected function rules()
    {
        return [
            'gender.name' => 'required|min:4|unique:genders,name,' . $this->genderID,
        ];
    }

    protected function validationAttributes()
    {
        return [
            'gender.name' => $this->gender['name'],
        ];
    }

    public function resetForm($form)
    {
        switch ($form) {
            case 'gender':
                $this->gender = ['name' => ''];
                break;

            case 'defaultProfilePhoto':
                $this->defaultPhoto = ['name' => ''];
                $this->defaultPhoto = ['file' => null];
                break;
        }

    }
}
