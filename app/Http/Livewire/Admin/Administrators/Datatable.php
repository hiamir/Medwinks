<?php

namespace App\Http\Livewire\Admin\Administrators;

use App\Http\Livewire\Authenticate;
use App\Mail\ResetPassword;
use App\Mail\Welcome;
use App\Models\PermissionExtends;
use App\Models\Admin;
use App\Models\User;
use App\Traits\Authorize;
use App\Traits\Data;
use App\Traits\Query;
use App\Traits\Submit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Datatable extends Authenticate
{
    use WithPagination;
    use Submit;
    use Data;


    protected $listeners = ['myController', 'refreshAdminComponent' => '$refresh'];

    public

        $myModal = [],
        $admin = [],
        $roles,
        $collection=[],
        $adminID;

    public function mount(Request $request)
    {
        $this->resetForm('admin');

    }

    protected $messages = [
        'admin.name.required' => 'The Name cannot be empty.',
        'admin.name.string' => ':attribute must be a string.',
        'admin.name.min' => 'The Name must have minimum 4 characters.',
        'admin.name.max' => ':attribute cannot exceed more than 255 characters.',
        'admin.email.required' => 'The Email Address cannot be empty.',
        'admin.email.string' => ':attribute Email must be a string.',
        'admin.email.max' => ':attribute cannot exceed more than 255 characters.',
        'admin.email.email' => ':attribute is not a valid email Address.',
        'admin.email.unique' => ':attribute Email Address already exists!.',
        'admin.password.required' => 'The Password cannot be empty.',
        'admin.password.confirmed' => 'The two Password do not match.',
    ];

    public function myController($value)
    {
        $this->myModal = $value;
        switch ($value['model']) {
            case 'administrator':
                if ($value['modalType'] === 'update' || $value['modalType'] === 'delete' || $value['modalType'] === 'password-reset') {
                    $this->adminID = $value['record']['formData']['id'];
                    $this->record = Admin::where('id', $this->adminID)->first();
                }
                switch ($value['modalType']) {
                    case 'add':
                        $this->resetForm('admin');
                        $this->record = new User();
                        break;

                    case 'update':
                        $this->resetErrorBag();
                        $this->admin['name'] = $value['record']['formData']['name'];
                        $this->admin['email'] = $value['record']['formData']['email'];
                        break;

                    case 'delete':
                    case 'password-reset':
                        break;
                }
                break;
        }
    }

    public function roleToggle($data)
    {
        $admin = Query::admin($data['adminID']);
        if (($this->permission('admin-administrator-role-toggle'))) {

            $roles_based_on_guard = Role::where('guard_name', 'admin')->pluck('id')->toArray();
            $array = [];
            foreach ($data['collection'] as $roleID) {
                if (in_array($roleID, $roles_based_on_guard)) array_push($array, intval($roleID));
            }
            $admin->roles()->sync(($array));
            $this->emit('userLoginListener');
            $this->emitSelf('refreshAdminComponent');
        } else {
            $this->dispatchBrowserEvent('access-denied-modal', ['show' => true, 'message' => 'You are not authorized to change roles for "' . $admin->name ]);

            $this->emitSelf('refreshAdminComponent');
        }

    }

    public function submit()
    {

        switch ($this->myModal['model']) {
            case 'administrator':
                $this->submitForm($this, 'administrator', $this->myModal['modalType'],  $this->myModal['formType'],$this->record, $this->admin, $this->rules());
                break;
        }
    }

    public function render()
    {
        if ($this->permission('admin-administrator-view')) {
            $records = Admin::with('roles')->orderBy('created_at', 'desc')->paginate(10);
            $allRoles = Role::where('guard_name', 'admin')->get();
            return view('livewire.admin.administrators.datatable', ['records' => $records,'allRoles'=>$allRoles]);
        } else {
            $this->dispatchBrowserEvent('access-denied', true);
            return view('livewire.errors.access-denied',['name'=>'Administrators']);
        }


    }

    protected function rules()
    {
        return [
            'admin.name' => 'required|min:4',
            'admin.email' => 'required|email|unique:admins,email,' . $this->adminID,
//            'admin.password' => 'required', 'confirmed',Password::defaults()
        ];
    }

    protected function validationAttributes()
    {
        return [
            'admin.name' => $this->admin['name'],
            'admin.email' => $this->admin['email'],
        ];
    }

    public function resetForm($form)
    {
        switch ($form) {
            case 'admin':
                $this->admin = ['name' => '', 'email' => ''];;
                break;
        }
    }
}
