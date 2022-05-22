<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Http\Livewire\Authenticate;
use App\Models\Country;
use App\Models\PermissionExtends;
use App\Models\Region;
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



    public function mount(Request $request)
    {
    }

    protected $messages = [

    ];

    public function myController($value)
    {

    }

    public function submit()
    {

    }

    public function render()
    {
        if ($this->permission('admin-dashboard-view')) {
            return view('livewire.admin.dashboard.datatable');
        } else {
            return view('livewire.errors.access-denied',['name'=>'Dashboard']);
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
