<?php

namespace App\Http\Livewire\Admin\Menu;

use App\Http\Livewire\Authenticate;
use App\Models\Menu;
use App\Models\PermissionExtends;
use App\Traits\Data;
use App\Traits\Query;
use App\Traits\Submit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Datatable extends Authenticate
{
    use WithPagination;
    use Submit;
    use Data;

    public $menuID;

    protected $listeners = ['myController'];

    public

        $myModal = [],
        $permission = [];

    public function mount(Request $request)
    {
        $this->resetForm('menu');
    }

    protected $messages = [
        'menu.name.required' => 'Menu name is required.',
        'menu.name.min' => 'Menu must be at-least 4 letters long.',
        'menu.name.unique' => ':attribute menu already exists!.',
        'menu.svg.required' => 'Svg is required.',
        'menu.svg.min' => ':attribute must be at-least 4 letters long.',
        'menu.sort.required' => 'Sort number is required',
        'menu.sort.integer' => 'Sort must be a integer value',
        'menu.sort.gt' => 'Sort number must be > 0',
        'menu.sort.unique' => ':attribute number already taken!',
    ];

    public function myController($value)
    {
        $this->myModal = $value;
        switch ($value['model']) {
            case 'menu':
                if ($value['modalType'] === 'update' || $value['modalType'] === 'delete') {
                    $this->menuID=$value['record']['formData']['id'];
                    $this->record = Menu::where('id', $this->menuID)->first();
                }
                switch ($value['modalType']) {
                    case 'add':
                        $this->resetForm('menu');
                        $this->record = new Menu();
                        break;

                    case 'update':
                        $this->resetErrorBag();
                        $this->menu['name'] = $value['record']['formData']['name'];
                        $this->menu['svg'] = $value['record']['formData']['svg'];
                        $this->menu['sort'] = $value['record']['formData']['sort'];
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
            case 'menu':
                $this->submitForm($this, 'menu', $this->myModal['modalType'], $this->myModal['formType'],$this->record, $this->menu, $this->rules());
                break;
        }
    }

    public function render()
    {
        if ($this->permission('admin-menu-view')) {
            $records = Menu::orderBy('updated_at', 'desc')->paginate(20);
            return view('livewire.admin.menu.datatable', ['records' => $records]);
        } else {
            $this->dispatchBrowserEvent('access-denied', true);
            return view('livewire.errors.access-denied',['name'=>'Menu']);
        }


    }

    protected function rules()
    {
        return [
            'menu.name' => 'required|min:4|unique:menus,name,' . $this->menuID,
            'menu.svg' => 'min:3|unique:menus,svg,' . $this->menuID,
            'menu.sort' => 'required|numeric|gt:0|unique:menus,sort,' . $this->menuID,
        ];
    }

    protected function validationAttributes()
    {
        return [
            'menu.name' => $this->menu['name'],
            'menu.svg' => $this->menu['svg'],
            'menu.sort' => $this->menu['sort'],
        ];
    }

    public function resetForm($form)
    {
        switch ($form) {
            case 'menu':
                $this->menu = ['name' => '', 'svg' => '', 'sort' => ''];
                break;
        }
    }
}
