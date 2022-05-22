<?php

namespace App\Http\Livewire\Layouts\Page;

use App\Http\Livewire\Authenticate;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Traits\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Traits\Authorize;

class Sidebar extends Authenticate
{
    use Authorize;
    use Data;

    public array $menuList = [], $menuSecurity = ['admin-user-view'], $userRoles = [];
    public $userMenu;

    protected $listeners = ['refreshSidebar' => '$refresh', 'sideBarRefreshData', 'updateAuthRolesListener'];

    public function mount(Request $request)
    {
        $this->makeUserRoles();
        if (Auth::getDefaultDriver() === 'admin') {
            $this->authRoles = $this->userRoles($this->adminRoleActive);
            $this->roleActive = Session::get($this->userRoles($this->adminRoleActive)['active']);
            $this->roleActiveName = $this->roleInfo(Session::get($this->userRoles($this->adminRoleActive)['active']));
        } else {
            $this->userRoles($this->userRoleActive);
            $this->roleActive = Session::get($this->userRoles($this->userRoleActive)['active']);
            $this->roleActiveName = $this->roleInfo(Session::get($this->userRoles($this->userRoleActive)['active']));
        }


//        dd($this->authRoles);
//        $this->userRoles=$this->userRoles();
//        (Data::guard()==='admin') ? $authRoleActive='adminRoleActive' : $authRoleActive='userRoleActive';
//        $this->activeRoleName=$this->roleInfo(Session::get($authRoleActive));

//       $this->userMenu=(auth()->user()->getAllPermissions()->pluck('name')->toArray());
//       $this->menuList=array_intersect( $this->userMenu,$this->menuSecurity);
    }


    protected function makeUserRoles()
    {
        $this->userRoles = [];
        foreach ($this->userRoles($this->userRoleActive)['roles'] as $key => $role) {
            $this->userRoles[$key] = ['role' => $role, 'name' => $this->roleInfo($role)];
        }
    }

//    public function changeRole($role){
//
//        $this->roleActive=$role;
//
//        $this->authRoles=$this->userRoles($this->roleActive);
//        $this->makeUserRoles($role);
//        $this->roleActiveName=$this->roleInfo($role);
//    }

    public function updateAuthRolesListener()
    {
        $this->makeUserRoles();
    }

    public function updatingRoleActive($value)
    {
        $this->userRoles = $this->userRoles($value);
        $this->makeUserRoles();
        if (Data::is_user_guard_admin()) {
            $this->roleActive = Session::get('adminRoleActive');
        } else {
            $this->roleActive = Session::get('userRoleActive');
        }
    }

    public function countItems($items)
    {
        foreach ($items as $item) {
            if($item->permissions !==null){
                if ($this->permission($item->permissions->name)) return true;
            }else{
                return false;
            }

        }
    }

    public function render()
    {
        $guard = Auth::getDefaultDriver();

        $navigation = Menu::with(['menuItems' => function ($q) use ($guard) {
            $q->with('permissions');
            $q->where('guard', 'like', $guard)->orderBy('sort', 'asc');
        }])->orderBy('sort', 'asc')->get();


//              dd($navigation);
        return view('livewire.layouts.page.sidebar')->with(['navigation' => $navigation]);
    }
}
