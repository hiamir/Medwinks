<?php

namespace App\Http\Livewire\User\Universities;

use App\Http\Livewire\Authenticate;
use App\Models\Country;
use App\Models\Degree;
use App\Models\PermissionExtends;
use App\Models\university;
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

    public $universityID;

    protected $listeners = ['myController'];

    public array $myModal = [], $university = [];

    public function mount(Request $request)
    {
        $this->resetForm('university');
    }

    protected $messages = [
        'university.name.required' => 'Qualification name is required.',
        'university.name.min' => ':attribute must be at-least 4 letters long.',
        'university.name.unique' => ':attribute university already exists!.',
        'university.abbreviation.required' => 'Abbreviation is required.',
        'university.abbreviation.unique' => ':attribute abbreviation already taken!',
    ];

    public function myController($value)
    {
        $this->myModal = $value;
        switch ($value['model']) {
            case 'university':
                switch ($value['formType']) {
                    case 'university':
                        if ($value['modalType'] === 'update' || $value['modalType'] === 'delete') {
                            $this->universityID = $value['record']['formData']['id'];
                            $this->record = University::where('id', $this->universityID)->first();
                        }
                        switch ($value['modalType']) {
                            case 'add':
                                $this->resetErrorBag();
                                $this->resetForm('university');
                                $this->record = new university();
                                break;

                            case 'update':
                                $this->resetErrorBag();
                                $this->university['name'] = $value['record']['formData']['name'];
                                $this->university['abbreviation'] = $value['record']['formData']['abbreviation'];
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
            case 'university':
                switch ($this->myModal['formType']) {
                    case 'university':

                        $this->submitForm($this, 'university', $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->university, $this->rules());
                        break;
                }

        }
    }

    public function render()
    {
        if ($this->permission('user-university-view')) {
            $records = University::orderBy('name', 'asc')->paginate(20);
            return view('livewire.user.universities.datatable', ['records' => $records]);
        } else {
            return view('livewire.errors.access-denied', ['name' => 'Universities']);
        }
    }

    protected function rules()
    {
        return [
            'university.name' => 'required|min:4|unique:universities,name,' . $this->universityID,
            'university.abbreviation' => 'required|unique:universities,abbreviation,' . $this->universityID,
        ];
    }


    protected function validationAttributes()
    {
        return [
            'university.name' => $this->university['name'],
            'university.abbreviation' => $this->university['abbreviation'],
        ];
    }

    public function resetForm($form)
    {
        $this->university = match ($form) {
            'university' => ['name' => '', 'abbreviation' => ''],
        };
    }
}
