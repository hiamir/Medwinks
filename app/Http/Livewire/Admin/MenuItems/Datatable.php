<?php

namespace App\Http\Livewire\Admin\MenuItems;

use App\Http\Livewire\Authenticate;
use App\Models\MenuItem;
use App\Traits\Data;
use App\Traits\Query;
use App\Traits\Submit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Datatable extends Authenticate
{
    use WithPagination;
    use Submit;
    use Data;

    protected $listeners = ['myController'];

    protected $model = "menu-items";

    public

        $myModal = [],
        $menuArray = [],
        $svgToggle = false,
        $permissionArray = [],
        $routeArray = [],
        $menuItemID,
        $menuItem = [];

    public function mount(Request $request)
    {
        $this->resetForm('menuItem');

    }

    protected $messages = [

        'menuItem.name.required' => 'Menu name is required.',
        'menuItem.guard.required' => 'Guard name is required.',
        'menuItem.guard.min' => ':attribute must be at-least 4 letters long.',
        'menuItem.svg.required' => 'Svg name is required.',
        'menuItem.svg.min' => ':attribute must be at-least 3 letters long.',
        'menuItem.menu_id.required' => 'Menu menu_id is required.',
        'menuItem.menu_id.min' => 'Menu must be at-least 4 letters long.',
        'menuItem.route.required' => 'route is required.',
        'menuItem.route.min' => ':attribute must be at-least 4 letters long.',
        'menuItem.route.unique' => ':attribute already exists.',
        'menuItem.route.regex' => ':attribute must lower case. Allowed ' . ' only',
        'menuItem.permissions_id.required' => 'Menu permission is required.',
        'menuItem.sort.required' => 'Sort number is required',
        'menuItem.sort.integer' => 'Sort must be a integer value',
        'menuItem.sort.gt' => 'Sort number must be > 0',
    ];

    public function myController($value)
    {
        $this->myModal = $value;
        switch ($value['model']) {
            case 'menu-items':
                if ($value['modalType'] === 'update' || $value['modalType'] === 'delete') {
                    $this->menuItemID = $value['record']['formData']['id'];
                    $this->record = MenuItem::where('id', $this->menuItemID)->first();
                }
                switch ($value['modalType']) {
                    case 'add':
                        $this->resetForm('menuItem');
                        $this->menuArray = Data::menu_for_select();
                        $this->permissionArray = $this->permissions_for_select();
                        $this->routeArray = Data::routes_for_select();

                        $this->record = new MenuItem();
                        break;

                    case 'update':
                        $this->resetErrorBag();
                        $this->menuArray = Data::menu_for_select();
                        $this->routeArray = Data::routes_for_select([$this->record->route]);
                        $this->permissionArray =$this->permissions_for_select([$this->record->permissions_id]);
                        if ($this->record->menu_id == 1) $this->svgToggle = true;
                        $this->menuItem['name'] = $value['record']['formData']['name'];
                        $this->menuItem['svg'] = $value['record']['formData']['svg'];
                        $this->menuItem['guard'] = $value['record']['formData']['guard'];
                        $this->menuItem['route'] = $value['record']['formData']['route'];
                        $this->menuItem['sort'] = $value['record']['formData']['sort'];
                        $this->menuItem['menu_id'] = $value['record']['formData']['menu_id'];
                        $this->menuItem['permissions_id'] = $value['record']['formData']['permissions_id'];
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
            case 'menu-items':
                $this->submitForm($this, 'menu-items', $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->menuItem, $this->rules());
                break;
        }
    }

    public function render()
    {
        if ($this->permission('admin-menu-items-view')) {
            $records = MenuItem::with(['menu' => function ($q) {
                $q->orderBy('name');
            }])->with('permissions')->paginate(10);
            return view('livewire.admin.menu-items.datatable', ['records' => $records]);
        } else {
            $this->dispatchBrowserEvent('access-denied', true);
            return view('livewire.errors.access-denied', ['name' => 'Menu Items']);
        }

    }

    protected function rules()
    {
        if ($this->svgToggle) {
            return [
                'menuItem.name' => 'required',
                'menuItem.guard' => 'required|min:3',
                'menuItem.svg' => 'required|min:3',
                'menuItem.menu_id' => 'required',
                'menuItem.route' => 'required|min:4|regex:/^[a-z,\.-]+$/|unique:menu_items,route,' . $this->menuItemID,
                'menuItem.permissions_id' => 'required'
            ];
        } else {
            return [
                'menuItem.name' => 'required',
                'menuItem.guard' => 'required|min:3',
                'menuItem.menu_id' => 'required',
                'menuItem.route' => 'required|min:4|regex:/^[a-z,\.-]+$/|unique:menu_items,route,' . $this->menuItemID,
                'menuItem.permissions_id' => 'required',
                'menuItem.sort' => 'required|numeric|gt:0',
            ];
        }
    }

    protected
    function validationAttributes()
    {
        return [
            'menuItem.name' => $this->menuItem['name'],
            'menuItem.guard' => $this->menuItem['guard'],
            'menuItem.svg' => $this->menuItem['svg'],
            'menuItem.route' => $this->menuItem['route'],
            'menuItem.sort' => $this->menuItem['sort'],
        ];
    }

    public function resetForm($form)
    {
        switch ($form) {
            case 'menuItem':
                $this->menuItem = ['name' => '', 'svg' => '', 'guard' => '', 'route' => '', 'sort' => '', 'menu_id' => '', 'permissions_id' => ''];
                break;
        }
    }
}
