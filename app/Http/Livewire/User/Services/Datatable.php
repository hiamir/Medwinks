<?php

namespace App\Http\Livewire\User\Services;

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

    public ?int $clickedServiceID=null;
    public array $myModal = [], $service = [], $serviceRequirement = [], $selectedCheckbox=[];

    public function mount(Request $request)
    {
        $this->resetForm('service');
        $this->resetForm('serviceRequirement');
    }

    public function updatingSelectedCheckbox($value){
    }

    public function updateRequirements($id,$selectedCheckbox){
$service=Service::where('id',$id)->first();
$service->requirements()->sync($selectedCheckbox);
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
            case 'service':
                switch ($value['formType']) {
                    case 'service':
                        if ($value['modalType'] === 'update' || $value['modalType'] === 'delete') {
                            $this->serviceID = $value['record']['formData']['id'];
                            $this->record = service::where('id', $this->serviceID)->first();
                        }
                        switch ($value['modalType']) {
                            case 'add':
                                $this->resetErrorBag();
                                $this->resetForm('service');
                                $this->record = new service();
                                break;

                            case 'update':
                                $this->resetErrorBag();
                                $this->service['name'] = $value['record']['formData']['name'];
                                $this->service['abbreviation'] = $value['record']['formData']['abbreviation'];
                                $this->service['description'] = $value['record']['formData']['description'];
                                break;

                            case 'delete':
                                break;
                        }
                        break;

                    case 'serviceRequirement':

                        if ($value['modalType'] === 'update' || $value['modalType'] === 'delete') {
                            $this->serviceRequirementID = $value['record']['formData']['id'];
                            $this->record = ServiceRequirement::where('id', $this->serviceRequirementID)->first();
                        }
                        switch ($value['modalType']) {
                            case 'add':
                                $this->resetForm('serviceRequirement');
                                $this->serviceRequirement['serviceID']=$this->myModal['record']['formData']['id'];
                                $this->record = new serviceRequirement();
                                break;

                            case 'update':
                                $this->resetErrorBag();
                                $this->serviceRequirement['name'] = $value['record']['formData']['name'];
                                $this->serviceRequirement['description'] = $value['record']['formData']['description'];
                                $this->serviceRequirement['serviceID']=$this->myModal['record']['formData']['id'];

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
            case 'service':
                switch ($this->myModal['formType']) {
                    case 'service':
                        $this->submitForm($this, 'service', $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->service, $this->serviceRules());
                        break;

                    case 'serviceRequirement':

                        $this->submitForm($this, 'service', $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->serviceRequirement, $this->serviceRequirementRules());
                        break;
                }

        }
    }

    public function render()
    {
        if ($this->permission('user-service-view')) {
            $records = service::with('requirements')->orderBy('name', 'asc')->paginate(20);
            $requirements=ServiceRequirement::all();
            return view('livewire.user.services.datatable', ['records' => $records,'requirements'=>$requirements]);
        } else {
            return view('livewire.errors.access-denied', ['name' => 'services']);
        }
    }

    protected function serviceRules()
    {
        return [
            'service.name' => 'required|min:4|unique:services,name,' . $this->serviceID,
            'service.description' => 'required|min:3|max:1000'
        ];
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
            'service.name' => $this->service['name'],
            'serviceRequirement.name' => $this->serviceRequirement['name'],
        ];
    }

    public function resetForm($form)
    {
        switch ($form) {
            case 'service':
                $this->service = ['name' => '', 'description' => ''];
                break;

            case 'serviceRequirement':
                $this->serviceRequirement = ['name' => '', 'description' => ''];
                break;
        }
    }
}
