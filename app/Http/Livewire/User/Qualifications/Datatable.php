<?php

namespace App\Http\Livewire\User\Qualifications;

use App\Http\Livewire\Authenticate;
use App\Models\Country;
use App\Models\Degree;
use App\Models\PermissionExtends;
use App\Models\qualification;
use App\Models\qualification_degree;
use App\Models\Region;
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

    public $qualificationID, $degreeID, $degreeQualificationID;

    protected $listeners = ['myController'];

    public array $myModal = [], $qualification = [], $degree = [];

    public function mount(Request $request)
    {
        $this->resetForm('qualification');
        $this->resetForm('degree');
    }

    protected $messages = [
        'qualification.name.required' => 'Qualification name is required.',
        'qualification.name.min' => ':attribute must be at-least 4 letters long.',
        'qualification.name.unique' => ':attribute qualification already exists!.',
        'qualification.position.required' => 'Position is required.',
        'qualification.position.gt' => 'Position must be positive integer',
        'qualification.position.unique' => ':attribute position already taken!',
    ];

    public function myController($value)
    {
        $this->myModal = $value;
        switch ($value['model']) {
            case 'qualification':
                switch ($value['formType']) {
                    case 'qualification':
                        if ($value['modalType'] === 'update' || $value['modalType'] === 'delete') {
                            $this->qualificationID = $value['record']['formData']['id'];
                            $this->record = Qualification::where('id', $this->qualificationID)->first();
                        }
                        switch ($value['modalType']) {
                            case 'add':
                                $this->resetErrorBag();
                                $this->resetForm('qualification');
                                $this->record = new qualification();
                                break;

                            case 'update':
                                $this->resetErrorBag();
                                $this->qualification['name'] = $value['record']['formData']['name'];
                                $this->qualification['position'] = $value['record']['formData']['position'];
                                break;

                            case 'delete':
                                break;
                        }
                        break;

                    case 'degree':

                        if ($value['modalType'] === 'update' || $value['modalType'] === 'delete') {
                            $this->degreeID = $value['record']['formData']['id'];
                            $this->record = Degree::where('id', $this->degreeID)->first();
                        }
                        switch ($value['modalType']) {
                            case 'add':

                                $this->resetForm('degree');
                                $this->degree['qualificationID']=$this->degreeQualificationID;
                                $this->record = new degree();
                                break;

                            case 'update':
                                $this->resetErrorBag();
                                $this->degree['name'] = $value['record']['formData']['name'];
                                $this->degree['acronym'] = $value['record']['formData']['acronym'];
                                $this->degree['position'] = $value['record']['formData']['position'];
                                $this->degree['qualificationID']=$this->degreeQualificationID;

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
            case 'qualification':
                switch ($this->myModal['formType']) {
                    case 'qualification':
                        $this->submitForm($this, 'qualification', $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->qualification, $this->qualificationRules());
                        break;

                    case 'degree':

                        $this->submitForm($this, 'qualification', $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->degree, $this->degreeRules());
                        break;
                }

        }
    }

    public function render()
    {
        if ($this->permission('user-qualification-view')) {
            $records = Qualification::with('degrees')->orderBy('position', 'asc')->paginate(20);
            return view('livewire.user.qualifications.datatable', ['records' => $records]);
        } else {
            return view('livewire.errors.access-denied', ['name' => 'Qualifications']);
        }
    }

    protected function qualificationRules()
    {
        return [
            'qualification.name' => 'required|min:4|unique:qualifications,name,' . $this->qualificationID,
            'qualification.position' => 'required|integer|gt:0|unique:qualifications,position,' . $this->qualificationID,
        ];
    }

    protected function degreeRules()
    {
        return [
            'degree.name' => 'required|min:4|unique:degrees,name,' . $this->degreeID,
            'degree.acronym' => '',
            'degree.position' => 'required|integer|gt:0'
        ];
    }

    protected function validationAttributes()
    {
        return [
            'qualification.name' => $this->qualification['name'],
            'qualification.position' => $this->qualification['position'],
            'degree.name' => $this->degree['name'],
            'degree.acronym' => $this->degree['acronym'],
            'degree.position' => $this->degree['position'],
        ];
    }

    public function resetForm($form)
    {
        switch ($form) {
            case 'qualification':
                $this->qualification = ['name' => '', 'position' => ''];
                break;

            case 'degree':
                $this->degree = ['name' => '', 'acronym' => '', 'position' => '','qualificationID'=>''];
                break;
        }
    }
}
