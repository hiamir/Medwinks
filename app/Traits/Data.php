<?php

namespace App\Traits;

use App\Mail\TwoFactor;
use App\Models\Country;
use App\Models\Degree;
use App\Models\Gender;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\qualification;
use App\Models\Region;
use App\Models\ServiceRequirement;
use App\Models\Timezone;
use App\Models\University;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

trait Data
{
    public static function capitalize_each_word($data)
    {
        return ucwords($data);
    }

    public static function all_upper_case($data)
    {
        return strtoupper($data);
    }

    public static function all_lower_case($data)
    {
        return strtolower($data);
    }

    //   DATA DIFFERENCE

    public static function capitalize_first_word($data)
    {
        return ucfirst($data);
    }

    //  GENERATE RANDOM PASSWORD
    public static function generate_password()
    {
        return Str::random(8);
//        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
//        return substr($random, 0, 10);
    }

    public static function guard(): string
    {
        return Auth::getDefaultDriver();
    }


    //CHECK ADMIN GUARD
    public static function is_user_guard_admin()
    {
        return Auth::guard('admin')->check();
    }

    //CHECK WEB GUARD
    public static function is_user_guard_web()
    {
        return Auth::guard('web')->check();
    }

    // ROUTE NAMES WITH SEARCH

    public function routeNames($guard): array
    {
        $actions = [];

        foreach (Route::getRoutes()->get() as $value) {
            array_push($actions, $value->getAction('as'));
//            if ($this->startsWith($value->getAction('as'), $guard . ".")) {
//                array_push($actions, $value->getAction('as'));
//            }
        }
        return $actions;
    }

    // ROUTE NAMES WITH SEARCH

    public function all_routes(): array
    {
        $actions = [];
        foreach (Route::getRoutes()->get() as $value) {
            array_push($actions, $value->getAction('as'));
        }
        return $actions;
    }


    public function startsWith($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }


    // AUTHORIZATION LOGIN SESSION

    public function authorizeUser($value)
    {
        if (Session::has('authorizeOperation')) {
            if (time() > Session::get('authorizeOperation')['time']) {
                Session::forget('authorizeOperation');
                if (!Session::has('authorizeOperation')) {
                    $this->emit('authorizeLogin', [true, $value]);
                    return false;
                } else {
                    return true;

                }
            } else {
                return true;
            }
        } else {
            $this->emit('authorizeLogin', [true, $value]);
            return false;
        }
    }

    //  ALL USER ROUTES ARRAY FOR SELECT
    public static function all_user_routes()
    {
        $routeCollection = Route::getRoutes();
        $routes = [];
        foreach ($routeCollection as $value) {
            if (str_contains($value->getName(), 'admin.') || str_contains($value->getName(), 'user.')) {
                array_push($routes, $value->getName());
            }
        }
        return $routes;
    }

    //  GET MENU ARRAY FOR SELECT
    public static function menu_for_select()
    {
        $menu = json_decode(Menu::select('id', 'name')->get(), true);
        foreach ($menu as $key => $value) {
            $menuArray[$value['id']] = $value['name'];
        }
        return $menuArray;
    }

    //  GET MENU ARRAY FOR SELECT
    public static function timezone_for_select()
    {
        $timzone = json_decode(Timezone::select('id', 'name')->get(), true);
        foreach ($timzone as $key => $value) {
            $timzoneArray[$value['id']] = $value['name'];
        }
        return $timzoneArray;
    }

    //  GET MENU ARRAY FOR SELECT
    public static function gender_for_select()
    {
        $genderArray = [];
        $gender = json_decode(Gender::select('id', 'name')->get(), true);
        foreach ($gender as $key => $value) {
            $genderArray[$value['id']] = $value['name'];
        }
        return $genderArray;
    }

    //  GET UNIVERSITIES ARRAY FOR SELECT
    public static function universities_for_select()
    {
        $universityArray = [];
        $university = json_decode(University::select('id', 'name')->get(), true);
        foreach ($university as $key => $value) {
            $universityArray[$value['id']] = $value['name'];
        }
        return $universityArray;
    }

    //  GET QUALIFICATIONS ARRAY FOR SELECT
    public static function qualifications_for_select()
    {
        $qualificationArray = [];
        $qualifications = json_decode(Qualification::select('id', 'name')->get(), true);
        foreach ($qualifications as $key => $value) {
            $qualificationArray[$value['id']] = $value['name'];
        }
        return $qualificationArray;
    }

//  GET DEGREES ARRAY FOR SELECT
    public static function degrees_for_select($id): array
    {
        $degreeArray = [];
        $degrees = json_decode(Degree::select('id', 'name')->where('qualification_id', $id)->get(), true);
        if (count($degrees) > 0) {
            foreach ($degrees as $key => $value) {
                $degreeArray[$value['id']] = $value['name'];
            }
        }
        return $degreeArray;
    }

    //  GET COUNTRY ARRAY FOR SELECT
    public static function countries_for_select(): array
    {
        $countryArray = [];
        $country = json_decode(Country::select('id', 'name')->get(), true);
        foreach ($country as $key => $value) {
            $countryArray[$value['id']] = $value['name'];
        }
        return $countryArray;
    }


    public static function regions_all_for_select(): array
    {
        $regionAllArray = [];
        $regions = json_decode(Region::select('id', 'name', 'country_id')->get(), true);
        foreach ($regions as $key => $value) {
            $regionAllArray[$value['id']] = ['name' => $value['name'], 'countryID' => $value['country_id']];
        }
        return $regionAllArray;
    }

    //  GET REGION ARRAY FOR SELECT
    public static function regions_for_select($id): array
    {
        $regionArray = [];
        $regions = json_decode(Region::select('id', 'name')->where('country_id', $id)->get(), true);
        foreach ($regions as $key => $value) {
            $regionArray[$value['id']] = $value['name'];
        }
        return $regionArray;
    }

    //  GET REGION ARRAY FOR SELECT
    public static function regions_for_select_id_name($id): array
    {
        $regionArray = [];
        $regions = json_decode(Region::select('id', 'name')->where('country_id', $id)->get(), true);
        foreach ($regions as $key => $value) {
            $regionArray['id'] = $value['id'];
            $regionArray['name'] = $value['name'];
        }
        return $regionArray;
    }

    //  GET COUNTRY ARRAY FOR SELECT
    public static function requirement_for_select(): array
    {
        $requirementArray = [];
        $requirement = json_decode(ServiceRequirement::select('id', 'name')->get(), true);
        foreach ($requirement as $key => $value) {
            $requirementArray[$value['id']] = $value['name'];
        }
        return $requirementArray;
    }


    //  GET PERMISSIONS ARRAY FOR SELECT
    public function permissions_for_select($id = null)
    {
        $assignedPermissions = json_decode(MenuItem::pluck('permissions_id'));
        if (isset($id)) $assignedPermissions = array_diff($assignedPermissions, $id);
        if (in_array('super-admin', $this->userRoles()['roles'])) {
            $permissions = json_decode(Permission::select('id', 'name')->where('guard_name', 'admin')->get(), true);
        } elseif (in_array('admin', $this->userRoles()['roles'])) {
            $permissions = json_decode(Permission::select('id', 'name')->where('guard_name', 'web')->get(), true);
        }

        $permissionArray = [];
        foreach ($permissions as $key => $value) {
            $permissionArray[$value['id']] = $value['name'];
        }

        $permissionKeys = (array_diff(array_keys($permissionArray), $assignedPermissions));
        return array_intersect_key($permissionArray, array_flip($permissionKeys));
    }

    //  GET ROUTES ARRAY FOR SELECT
    public static function routes_for_select($id = null)
    {
        $array = [];
        $assignedRoutes = json_decode(MenuItem::pluck('route'));

        if (isset($id)) $assignedRoutes = array_diff($assignedRoutes, $id);
        foreach (Data::all_user_routes() as $key => $value) {
            $array[$value] = $value;
        }
        return array_diff($array, $assignedRoutes);
    }


    public function reauthorizeUser($value)
    {
        Session::forget('authorizeOperation');
        return $this->authorizeUser($value);
    }

    //CLOSE MODAL
    public function closeModal()
    {
        $this->emit('openModal', false);
        $this->emit('openConfirmationModal', false);
    }

    //CLOSE CONFIRMATION MODAL
    public function closeConfirmationModal()
    {
        $this->emit('openConfirmationModal', false);
    }

    //TOAST MESSAGE
    public function toast($alert, $message)
    {
        $this->emit('showToast', ['show' => true, 'alert' => $alert, 'message' => $message]);
    }

    public function AccessDeniedModal($type, $name, $default = null)
    {
        $this->dispatchBrowserEvent('add-update-modal', ['show' => false]);
        $this->dispatchBrowserEvent('delete-modal', ['show' => false]);
        $this->dispatchBrowserEvent('reset-password-modal', ['show' => false]);
        $this->dispatchBrowserEvent('confirmation-modal', ['show' => false]);
        ($default === null) ?
            $this->dispatchBrowserEvent('access-denied-modal', ['show' => true, 'message' => '<span>You are not authorized to ' . $type . ' <span class="font-bold"><br>"' . $name . '"</span></span>']) :
            $this->dispatchBrowserEvent('access-denied-modal', ['show' => true, 'message' => $default]);
    }

    public function dispatchEvent($eventName,$title,$message){
        $this->dispatchBrowserEvent($eventName, ['show' => true, 'title'=>$title,'message' => $message]);
    }

    //GENERATE TWO FACTOR
    static public function generate_two_factor_code()
    {
        return rand(100000, 999999);
    }

    //GENERATE TWO FACTOR EXPIRY
    static public function generate_two_factor_expiry()
    {
        return Carbon::now()->addMinutes(10);
    }


    //RESET TWO FACTOR
    public function resetTwoFactorCode($t)
    {
        $t->timestamps = false;
        $t->email_verified_at = null;
        $t->two_factor_code = $code = Data::generate_two_factor_code();
        $t->two_factor_expires_at = Data::generate_two_factor_expiry();
        $t->save();

        Mail::to($t->email)->queue(new TwoFactor($t->name, $t->two_factor_code, true));

        return $code;
    }

    protected function isCodeExpired(): bool
    {
        return (auth()->user()->two_factor_expires_at < now());
    }

    public function fileRename($recordFile, $name, $tag)
    {
        $filename = explode('.', $recordFile->getFilename());
        return Auth::user()->id . '-' . $name . '-' . $tag . '.' . $filename[1];
    }

    public function fileStore($recordFile, $folder, $name)
    {
        $recordFile->storeAs('public/images/' . $folder, $name);
    }

    public function checkImage($file): bool
    {
        $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
        $contentType = $file->getClientMimeType();

        return in_array($contentType, $allowedMimeTypes);
    }

    //GET USER ROLES
    public function userRoles($roleName = null)
    {
//        dd($roleName);
        $authRoles = [];
        if (Data::guard() === 'admin') {
            $admin = Auth::guard('admin')->user();
            $authRoles = $admin->getRoleNames()->toArray();
            $authRoleActive = 'adminRoleActive';
            if (count($admin->getRoleNames()->toArray()) > 0) {
                Session::put('adminRoles', $admin->getRoleNames()->toArray());
                ($roleName === null) ? Session::put('adminRoleActive', $admin->getRoleNames()->toArray()[0]) : Session::put('adminRoleActive', $roleName);
            }

        } else {
            $user = Auth::guard('web')->user();
            $authRoles = $user->getRoleNames()->toArray();
            $authRoleActive = 'userRoleActive';
            if (count($user->getRoleNames()->toArray()) > 0) {
                Session::put('userRoles', $user->getRoleNames()->toArray());
                ($roleName === null) ? Session::put('userRoleActive', $user->getRoleNames()->toArray()[0]) : Session::put('userRoleActive', $roleName);
            }
        }
        $this->activeRoleName = $this->roleInfo(Session::get($authRoleActive));
        return ['roles' => $authRoles, 'active' => $authRoleActive];
    }


    //GUARD BASED ON ROLE
    public function guardName(): string
    {
        if (in_array('super-admin', $this->userRoles()['roles']) && in_array('admin', $this->userRoles()['roles'])) {
            return 'admin';
        } elseif (in_array('super-admin', $this->userRoles()['roles'])) {
            return 'admin';
        } elseif (in_array('admin', $this->userRoles()['roles'])) return 'web';
    }

    public function roleInfo($role)
    {
        $roleInfo = ['super-admin' => 'Super Administrator', 'admin' => 'Administrator', 'manager' => 'Manager', 'user' => 'User'];
        $roleInfoKeys = array_keys($roleInfo);
        if (in_array(self::all_lower_case($role), $roleInfoKeys)) {
            return $roleInfo[$role];
        } else {
            return null;
        }
    }

}
