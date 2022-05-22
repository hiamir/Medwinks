<?php

namespace App\Http\Livewire\User\Clients;

use App\Http\Livewire\Authenticate;
use App\Mail\ResetPassword;
use App\Mail\Welcome;
use App\Models\Gender;
use App\Models\PermissionExtends;
use App\Models\User;
use App\Traits\Data;
use App\Traits\Query;
use App\Traits\Submit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Datatable extends Authenticate
{
    use WithPagination;
    use Submit;
    use Data;


    protected $listeners = ['myController', 'refreshComponent' => '$refresh'];

    public array
        $myModal = [],
        $user = [],
        $roles,
        $collection = [];
    public $userID;

    public function mount(Request $request)
    {
        $this->resetForm('user');
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


    public function clientDetail($client){
        return redirect()->route('user.client-details', [$client['id']]);
    }


    public function submit()
    {
        switch ($this->myModal['model']) {
            case 'user':
                $this->submitForm($this, 'user', $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->user, $this->rules());
                break;
        }
    }

    public function render()
    {
        if ($this->permission('user-client-view')) {
            $gender = Gender::select('id', 'name')->get();
            $records = User::with('roles')->orderBy('created_at', 'desc')->paginate(10);
            $allRoles = Role::where('guard_name', 'web')->get();
            $records=User::with(['applications','profilePhoto','documents'])->paginate(10);
            return view('livewire.user.clients.datatable', ['records' => $records]);
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
            'user.gender'=>'required'
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

    public function resetForm($form)
    {
        switch ($form) {
            case 'user':
                $this->user = ['name' => '', 'email' => '', 'gender' => ''];
                break;
        }
    }
}
