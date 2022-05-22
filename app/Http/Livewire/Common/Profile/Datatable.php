<?php

namespace App\Http\Livewire\Common\Profile;

use App\Http\Livewire\Authenticate;
use App\Models\Admin;
use App\Models\DefaultProfilePhoto;
use App\Models\User;
use App\Traits\Data;
use App\Traits\Submit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Throwable;

class Datatable extends Authenticate
{
    use WithPagination;
    use Submit;
    use Data;

    use WithFileUploads;

    protected $session = null;
    protected string $password_regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/';
    public
        $form,
        $myModal = [],
        $genderArray = [],
        $isEdit = false,
        $openLogin = true,
        $tabs = [1, 2],
        $tabContentGuard = [2],
        $tabContent = 1,
        $tabPrevious = 0;
    public string $password = '';
    public string $genderName='';
    public string $email = '';
    public string $header = '';
    public array $user = ['name' => '', 'email' => '', 'gender' => '', 'photo' => ''];
    public array $auth = ['current_password' => '', 'password' => '', 'password_confirmation' => ''];


    protected $listeners = ['authSuccess', 'myController', 'refreshProfileComponent' => '$refresh'];

    public function mount(Request $request)
    {
        $this->genderArray = $this->gender_for_select();
        $this->resetForm('auth');
        $this->resetForm('info');
//        $this->modalDetails = ['model' => 'profile', 'record' => $this->record, 'modalType' => 'update'];
    }

    public function updatingIsEdit($value)
    {
        $this->resetForm('info');
        $this->emitSelf('refreshProfileComponent');
    }


    protected $messages = [
        'user.name.required' => 'Please give your full name',
        'user.name.min' => 'Your name must be at-least 4 characters long',
        'user.email.required' => 'your email address is required',
        'user.email.email' => 'This is not a valid email address',

        'user.photo.required' => 'Please choose a profile photo to upload',
        'user.photo.max' => 'Profile photo must not be greater than 200 kilobytes.',
        'user.photo.image' => 'Profile photo must be an image',

        'auth.current_password.required' => 'The Password cannot be empty.',
        'auth.password.required' => 'New Password cannot be empty.',
        'auth.password.regex' => 'Password must contain: 1 uppercase letter, 1 lowercase letter, 1 number and a special character',
        'auth.password_confirmation.required' => 'Password confirmation is required.',
        'auth.password.min' => 'Password must contain minimum 8 characters long.',
        'auth.password.confirmed' => 'The two Password do not match.',
        'auth.password_confirmation' => 'Confirm Password cannot be empty.',

    ];

    protected function photoRules()
    {
        return [
            'user.photo' => 'required|image|mimes:jpeg,png,jpg|max:200',
        ];
    }

    protected function profileRules()
    {
        return [
            'user.name' => 'required|min:4',
            'user.gender' => 'required',
        ];
    }

    protected function passwordRules()
    {
        return [
            'auth.current_password' => 'required|current_password',
            'auth.password' => 'required|min:8|regex:' . $this->password_regex . '|confirmed',
            'auth.password_confirmation' => 'required',
        ];
    }


    public function authSuccess($value)
    {
        $this->tabPrevious = $value;
        $this->tabContent = $value;
        $this->dispatchBrowserEvent('login-modal', ['show' => false]);
        $this->modalDetails['modalType'] = 'update';
    }


    public function openTab($id)
    {
        switch ($id) {
            case '1':
            case '2':
//                if ($id === 1) $this->modalDetails = ['model' => 'profile', 'modalType' => 'update'];
//                if ($id === 2) $this->modalDetails = ['model' => 'profile', 'modalType' => 'update'];

                if (auth()->user()) {
                    $this->resetForm('info');

                }
                $this->myController($this->modalDetails);
                $this->myModal = $this->modalDetails;
                if (in_array($id, $this->tabContentGuard)) {

                    if ($this->authorizeUser($id)) {

                        $this->tabPrevious = $id;
                        $this->tabContent = $id;


                    } else {
                        $this->dispatchBrowserEvent('login-modal', ['show' => true]);
                        if (!in_array($this->tabPrevious, $this->tabContentGuard)) {
                            $this->tabContent = $this->tabPrevious;
                        } else {
                            $diff = array_diff($this->tabs, $this->tabContentGuard);
                            (empty($diff)) ? $this->tabContent = 0 : $this->tabContent = $diff[array_key_first($diff)];
                        }
                    }
                } else {

                    $this->tabContent = $id;
                }
                break;
        }
    }


    public function myController($value)
    {
        $this->myModal = $value;
        switch ($value['modalType']) {
            case 'update':
            case 'password-update':
                if ($value['modalType'] === 'update' || $value['modalType'] === 'password-update') {
                    $this->record = $this->auth();
                }
                $this->resetErrorBag();
                break;
        }
    }

    public function submitPhoto($id)
    {

//        $photoValidate = $this->validate($this->photoRules());
        try {
            DB::transaction(function () use($id){
                (Data::guard() === 'admin') ? $upload = Admin::where('id', auth()->user()->id)->first() : $upload = User::where('id', auth()->user()->id)->first();
//                $filename = explode('.', $this->user['photo']->getFilename());
//                $newFileName = Auth::user()->id . '-profile-photo.' . $filename[1];
//                $filename = $this->user['photo']->storeAs('public/images/profile', $newFileName);
                $upload->default_profile_photo_id = $id;
                $upload->save();

                $this->emitSelf('refreshProfileComponent');
                $this->emit('refreshHeaderComponent');
                $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => 'Profile photo was updated!']);
            });
        } catch (Throwable $e) {
            DB::rollback();
            $this->dispatchBrowserEvent('toast', ['alert' => 'danger', 'message' => 'There was an error updating profile photo!']);
        }

    }


    public function submit()
    {
        switch ($this->myModal['formType']) {
            case 'info':

                $this->submitForm($this, 'profile', $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->user, $this->profileRules());
                $this->isEdit = false;
                break;
            case 'password-change':
                $this->submitForm($this, 'profile', $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->auth, $this->passwordRules());
                $this->resetForm('auth');
                break;
        }
    }

    protected function auth()
    {
        if (Data::guard()==='admin') return (Admin::select('id', 'name', 'email')->where('id', auth()->user()->id)->first());
        if (Data::guard()==='web') return (User::select('id', 'name', 'email')->where('id', auth()->user()->id)->first());
    }

    public function render()
    {
       if (Data::guard()==='admin') {
           $profile=Admin::with('profilePhoto')->where('id',auth()->user()->id)->first();
       }else{
           $profile=User::with('profilePhoto')->where('id',auth()->user()->id)->first();
       }
        $gender = $this->genderArray;
        $defaultProfilePhotos=DefaultProfilePhoto::where('gender_id',auth()->user()->gender_id)->get();
        return view('livewire.common.profile.datatable', ['profile' => $profile, 'gender' => $gender,
            'defaultProfilePhotos'=>$defaultProfilePhotos]);
    }



    public function resetForm($form)
    {
        switch ($form) {
            case 'info':
                $this->user['name'] = Auth::user()->name;
                $this->user['email'] = Auth::user()->email;
              $this->user['gender'] = Auth::user()->gender_id;
                $this->genderName = $this->genderArray[Auth::user()->gender_id];
                break;
            case 'auth':
                $this->auth = ['current_password' => '', 'password' => '', 'password_confirmation' => null];
                break;
        }
    }
}
