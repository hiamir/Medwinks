<?php

namespace App\Http\Livewire\Admin\Permissions;

use App\Http\Livewire\Authenticate;
use App\Models\Country;
use App\Models\PermissionExtends;
use App\Models\Region;
use App\Models\RoleExtends;
use App\Traits\Data;
use App\Traits\Submit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Datatable extends Authenticate
{
    use WithPagination;
    use Submit;
    use Data;

    public $permissionID;

    protected $listeners = ['myController'];

    public

        $myModal = [],
        $permission = [];

    public function mount(Request $request)
    {
        $this->resetForm('permission');
    }

    protected $messages = [

        'permission.name.required' => 'Permission name is required.',
        'permission.name.regex' => ':attribute - only lower case alphabets and "-" allowed with no spaces',
        'permission.name.min' => ':attribute must be at-least 4 letters long.',
        'permission.name.unique' => ':attribute permission already exists!.',
        'permission.guard_name.required' => 'Guard name is required.',
        'permission.guard_name.min' => ':attribute must be at-least 4 letters long.',
    ];

    public function myController($value)
    {

        $this->myModal = $value;
        switch ($value['model']) {
            case 'permission':
                if ($value['modalType'] === 'update' || $value['modalType'] === 'delete') {
                    $this->permissionID=$value['record']['formData']['id'];
                    $this->record = Permission::where('id', $this->permissionID)->first();
                }
                switch ($value['modalType']) {
                    case 'add':
                        $this->resetForm('permission');
                        $this->record = new Permission();
                        if(!in_array('admin',$this->userRoles()['roles']) &&  in_array('super-admin',$this->userRoles()['roles'])) $this->permission['guard_name']=$this->guardName();
                        if(in_array('admin',$this->userRoles()['roles']) &&  !in_array('super-admin',$this->userRoles()['roles'])) $this->permission['guard_name']='web';
                        break;

                    case 'update':
                        $this->resetErrorBag();
                        $this->permission['name'] = $value['record']['formData']['name'];
                        $this->permission['guard_name'] = $value['record']['formData']['guard_name'];
                        break;
                    case 'delete':
                        break;
                }
                break;
        }
    }

    public function submit()
    {
        switch ($this->myModal['model']) {
            case 'permission':

                $this->submitForm($this, 'permission', $this->myModal['modalType'],  $this->myModal['formType'],$this->record, $this->permission, $this->rules());
                break;
        }
    }

    public function render()
    {

        if (Data::is_user_guard_admin() && (in_array('admin',$this->userRoles()['roles']) || in_array('super-admin',$this->userRoles()['roles'])) && $this->permission('admin-permission-view')) {

            if(in_array('admin',$this->userRoles()['roles']) || in_array('super-admin',$this->userRoles()['roles'])){
                if (in_array('admin', $this->userRoles()['roles']) && in_array('super-admin', $this->userRoles()['roles'])) {
                    $records = PermissionExtends::with('permissionRoles')->orderBy('guard_name', 'asc')->paginate(20);
                }
                elseif(in_array('super-admin',$this->userRoles()['roles'])){
                    $records = PermissionExtends::with('permissionRoles')->where('guard_name','admin')->orderBy('guard_name', 'asc')->paginate(20);
                }else{
                    $records = PermissionExtends::with('permissionRoles')->where('guard_name','web')->orderBy('guard_name', 'asc')->paginate(20);
                }
            }
            return view('livewire.admin.permissions.datatable', ['records' => $records]);
        } else {
            return view('livewire.errors.access-denied',['name'=>'Permissions']);
        }


    }

    protected function rules()
    {
        return [
            'permission.name' => 'required|regex:/^[a-z-]+$/u|min:4|unique:permissions,name,' . $this->permissionID,
            'permission.guard_name' => 'required|min:3',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'permission.name' => $this->permission['name'],
            'permission.guard_name' => $this->permission['guard_name'],
        ];
    }

    public function resetForm($form)
    {
        switch ($form) {
            case 'permission':
                $this->permission = ['name' => '', 'guard_name' => ''];
                break;
        }
    }
}
