<?php

namespace App\Http\Livewire\Admin\Roles;

use App\Http\Livewire\Authenticate;
use App\Models\PermissionExtends;
use App\Models\RoleExtends;
use App\Models\User;
use App\Traits\Data;
use App\Traits\Query;
use App\Traits\Submit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Datatable extends Authenticate
{
    use WithPagination;
    use Submit;
    use Data;

    protected $listeners = ['myController', 'refreshComponent' => '$refresh'];
    public
        $myModal = [],
        $role = [],
        $permissions,
        $allRolePermissions,
        $roleID,
        $rolePermissions;

    public function mount(Request $request)
    {
        $this->resetForm('role');


    }

    protected $messages = [
        'role.name.required' => 'Role name is required.',
        'role.name.min' => ':attribute must be at-least 4 letters long.',
        'role.name.regex' => ':attribute - only lower case alphabets and "-" allowed with no spaces',
        'role.name.unique' => ':attribute role already exists!.',
        'role.guard_name.required' => 'Guard name is required.',
        'role.guard_name.min' => ':attribute must be at-least 4 letters long.',
    ];

    public function myController($value)
    {
        $this->myModal = $value;
        switch ($value['model']) {
            case 'role':
                if ($value['modalType'] === 'update' || $value['modalType'] === 'delete') {
                    $this->roleID = $value['record']['formData']['id'];
                    $this->record = Role::where('id', $this->roleID)->first();
                }
                switch ($value['modalType']) {
                    case 'add':
                        $this->resetForm('role');
                        $this->record = new Role();
                        $this->role['guard_name'] = $this->guardName();
                        break;

                    case 'update':
                        $this->resetErrorBag();
                        $this->role['name'] = $value['record']['formData']['name'];
                        $this->role['guard_name'] = $value['record']['formData']['guard_name'];
                        break;

                    case 'delete':
                        break;
                }
                break;
        }
    }

    public function permissionToggle($data)
    {
        $role = Role::with('permissions')->where('id', $data['roleID'])->first();
        $permission_based_on_guard = Permission::where('guard_name', $role->guard_name)->pluck('id')->toarray();
        $array = [];
        foreach ($data['collection'] as $permissionID) {
            if (in_array($permissionID, $permission_based_on_guard)) array_push($array, intval($permissionID));
        }
        $role->permissions()->sync(($array));
        $this->emit('refreshSidebar');
        $this->emitSelf('refreshComponent');
    }

    public function submit()
    {
        switch ($this->myModal['model']) {
            case 'role':
                $this->submitForm($this, 'role', $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->role, $this->rules());
                break;
        }
    }

    public function render()
    {
        if (Data::is_user_guard_admin() && (in_array('admin', $this->userRoles()['roles']) || in_array('super-admin', $this->userRoles()['roles'])) && $this->permission('admin-roles-view')) {
            (Data::is_user_guard_admin()) ? $this->permissions = Collect(PermissionExtends::with('permissionRoles')->get()) : $this->permissions = null;
            if (in_array('admin', $this->userRoles()['roles']) || in_array('super-admin', $this->userRoles()['roles'])) {

                if(in_array('super-admin', $this->userRoles()['roles']) && in_array('admin', $this->userRoles()['roles'])){
                    $records = RoleExtends::with(['permissions', 'guardPermissions'])->orderBy('guard_name', 'asc')->paginate(10);
                } elseif (in_array('super-admin', $this->userRoles()['roles'])) {
                    $records = RoleExtends::with(['permissions', 'guardPermissions'])->where('guard_name', 'admin')->orderBy('guard_name', 'asc')->paginate(10);
                } else {
                    $records = RoleExtends::with(['permissions', 'guardPermissions'])->where('guard_name', 'web')->orderBy('guard_name', 'asc')->paginate(10);
                }
            }
            return view('livewire.admin.roles.datatable', ['records' => $records]);
        } else {
            return view('livewire.errors.access-denied', ['name' => 'Role']);
        }
    }

    protected function rules()
    {
        return [
            'role.name' => 'required|regex:/^[a-z-]+$/u|min:4|unique:roles,name,' . $this->roleID,
            'role.guard_name' => 'required|min:3',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'role.name' => $this->role['name'],
            'role.guard_name' => $this->role['guard_name'],
        ];
    }

    public function resetForm($form)
    {
        switch ($form) {
            case 'role':
                $this->role = ['name' => '', 'guard_name' => ''];
                break;
        }
    }
}
