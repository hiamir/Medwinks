<?php

namespace App\Http\Livewire\User\ServiceRequirements;

use App\Http\Livewire\Authenticate;
use App\Models\service;
use App\Models\serviceRequirement;
use App\Traits\Data;
use App\Traits\Submit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;
use phpDocumentor\Reflection\Types\Integer;
use Spatie\Permission\Models\Permission;

class Datatable extends Authenticate
{
    use WithPagination;
    use Submit;
    use Data;

    public $serviceID, $serviceRequirementID;

    protected $listeners = ['myController'];

    public array $myModal = [], $serviceRequirement = [];

    public function mount(Request $request)
    {
        $this->resetForm('service-requirement');
    }

    protected $messages = [
        'service.name.required' => 'service name is required.',
        'service.name.min' => ':attribute must be at-least 4 letters long.',
        'service.name.unique' => ':attribute service already exists!.',
        'service.description.required' => 'description is required.',
        'service.description.gt' => 'description must be positive integer',
        'service.description.unique' => ':attribute description already taken!',
    ];

    public function myController($value)
    {
        $this->myModal = $value;
        switch ($value['model']) {
            case 'service-requirement':
                switch ($value['formType']) {
                    case 'service-requirement':

                        if ($value['modalType'] === 'update' || $value['modalType'] === 'delete') {
                            $this->serviceRequirementID = $value['record']['formData']['id'];
                            $this->record = ServiceRequirement::where('id', $this->serviceRequirementID)->first();
                        }
                        switch ($value['modalType']) {
                            case 'add':
                                $this->resetForm('service-requirement');
                                $this->record = new serviceRequirement();
                                break;

                            case 'update':
                                $this->resetErrorBag();
                                $this->serviceRequirement['name'] = $value['record']['formData']['name'];
                                $this->serviceRequirement['description'] = $value['record']['formData']['description'];

                                break;

                            case 'delete':
                                break;
                        }
                        break;
                }
                break;
        }
    }

    public function submit()
    {

        switch ($this->myModal['model']) {
            case 'service-requirement':
                switch ($this->myModal['formType']) {
                    case 'service-requirement':
                        $this->submitForm($this, 'service-requirement', $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->serviceRequirement, $this->serviceRequirementRules());
                        break;
                }
        }
    }

    public function render()
    {
        if ($this->permission('user-service-requirement-view')) {
            $records = serviceRequirement::orderBy('name', 'asc')->paginate(20);
            return view('livewire.user.service-requirements.datatable', ['records' => $records]);
        } else {
            return view('livewire.errors.access-denied', ['name' => 'service requirements']);
        }
    }


    protected function serviceRequirementRules()
    {
        return [
            'serviceRequirement.name' => 'required|min:4|unique:service_requirements,name,' . $this->serviceRequirementID,
            'serviceRequirement.description' => 'required|min:3|max:1000'
        ];
    }

    protected function validationAttributes()
    {
        return [
            'serviceRequirement.name' => $this->serviceRequirement['name'],
        ];
    }

    public function resetForm($form)
    {
        switch ($form) {

            case 'service-requirement':
                $this->serviceRequirement = ['name' => '', 'description' => ''];
                break;
        }
    }
}
