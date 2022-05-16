<?php

namespace App\Http\Livewire\Admin\Role;

use App\Traits\Data;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Datatable extends Component
{
    use WithPagination;
    use Data;

    public
        $openModal = true,
        $confirmModalStatus = true,
        $toastAlert=[],
        $modalType = null,
        $record,
        $roleID,
        $role = ['name' => '', 'guard_name' => ''];
    protected $messages = [

        'role.name.required' => 'Role name is required.',
        'role.name.regex' => ':attribute - only lower case alphabets allowed with no spaces',
        'role.name.min' => ':attribute must be at-least 4 letters long.',
        'role.name.unique' => ':attribute role already exists!.',
        'role.guard_name.required' => 'Guard name is required.',
        'role.guard_name.min' => ':attribute must be at-least 4 letters long.',
    ];

    public function addButton()
    {
        $this->reset();
        $this->modalType = 'add';
        $this->record = new Role();

    }


    public function editButton($id)
    {
        $this->resetErrorBag();
        $this->modalType = 'update';
        $this->roleID = $id;
        $this->record = Role::where('id', $id)->first();
        $this->role['id'] = $this->record->id;
        $this->role['name'] = $this->record->name;
        $this->role['guard_name'] = $this->record->guard_name;
    }

    public function deleteButton($id)
    {
        $this->modalType = 'delete';
        $this->roleID = $id;
        $this->record = Role::where('id', $id)->first();
    }


    public function submit()
    {
        switch ($this->modalType) {
            case 'add':
            case 'update':
                $this->validate();
                $this->record->name = Data::all_lower_case($this->role['name']);
                $this->record->guard_name = $this->role['guard_name'];
                $this->record->save();
                $this->openModal = false;
                ($this->modalType=='add')? $this->toastAlert=['alert'=>'success','message'=>$this->record->name.' added successfully!'] :  $this->toastAlert=['alert'=>'success','message'=>$this->record->name.' updated successfully!'];
                break;

            case 'delete':
                $this->record->delete();
                $this->confirmModalStatus = !$this->confirmModalStatus;
                $this->toastAlert=['alert'=>'danger','message'=>$this->record->name.' deleted successfully!'];
                break;

        }

    }

    public function render()
    {
        $records = Role::paginate(2);
        return view('livewire.admin.role.datatable', ['records' => $records]);


    }

    protected function rules()
    {
        return [
            'role.name' => 'required|regex:/^[a-z]+$/u|min:4|unique:roles,name,' . $this->roleID,
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
}
