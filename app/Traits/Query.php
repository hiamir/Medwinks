<?php

namespace App\Traits;


use App\Http\Livewire\Admin\Countries;
use App\Models\Admin;
use App\Models\GuardTypes;
use App\Models\LogTypes;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

trait Query
{

    // CHECK GUARD

    public static function auth_guard(): string
    {
     return (auth()->guard('admin')->check()? 'admin':'web');

    }

    //AUTH GUARD FOR ADMIN

    public static function auth_guard_for_admin(): string
    {
        return (Auth::user()->hasRole('Super Admin') ?  'admin' : 'web');
    }



    //  Admin FILTER ID

    public static function admin($id)
    {
        return Admin::findorfail($id);
    }

//  USER FILTER ID

    public static function user($id)
    {
        return User::findorfail($id);
    }

//  ROLE BY NAME

    public static function getRoleName($id)
    {
        return Role::findorfail($id)->name;
    }

    //  ROLE RECORD FROM NAME

    public static function role_record_from_name($name)
    {
        return Role::where('name',$name)->first();
    }

    //  ROLE GUARD FROM NAME

    public static function role_guard_from_name($name)
    {
        return Role::where('name',$name)->first()->guard_name;
    }

//  ROLE EXISTS

    public static function roleInUserExists($name)
    {
        if ((User::whereHas("roles", function ($q) use ($name) { $q->where("name", $name); })->get())->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }

    // CHECK IF AUTH HAS ROLE

    public static function check_if_auth_has_role($checkRole){
       $userRole= json_decode(auth()->user()->roles->pluck('name'));
       return in_array(Data::capitalize_first_word($checkRole),$userRole);
    }


    //  ROLE WITH USERS EXISTS

    public static function role_with_users($id)
    {
        return Role::with('users')->findOrFail($id);
    }


    // PERMISSION FILTER ID

    public static function permissionAll()
    {
        return Permission::all();
    }

    // PERMISSION FILTER ID

    public static function permission_all_with_guard($guard)
    {
        return Permission::where('guard_name',$guard)->get();
    }

    // PERMISSION FILTER ID

    public static function permission($id)
    {
        return Permission::findorfail($id);
    }

    // PERMISSION FILTER BY ID

    public static function permission_check_by_id($id)
    {
        return Permission::where('id',$id)->exists();
    }

    // PERMISSION FILTER BY NAME

    public static function permission_check_by_name($name)
    {
        return Permission::where('name',$name)->exists();
    }



    // PERMISSION FILTER ID BY NAME

    public static function permission_id_by_name($name)
    {
        return Permission::where('name',$name)->first()->id;
    }

    // PERMISSION FILTER ID WITH NAME

    public static function permission_name_from_id($id)
    {
        return Permission::findorfail($id)->name;
    }

    //  PERMISSION FILTER ID

    public static function permissionInRoleExists($name)
    {
        if ((Role::whereHas("permissions", function ($q) use ($name) { $q->where("name", $name); })->get())->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }


    // PERMISSION WITH GUARD ADMIN
    public static function permission_with_admin_guard(){
       return  Permission::where('guard_name', 'admin')->get();
    }

    // PERMISSION WITH GUARD WEB
    public static function permission_with_web_guard(){
        return Permission::where('guard_name', 'web')->get();
    }


    //  PERMISSION EXISTS

    public static function permissionsViaRole($id)
    {
        $role = self::role($id);
        dd($role->permissions);
    }

    public static function role($id)
    {
        return Role::findorfail($id);
    }

    //  PERMISSION WITH ROLES EXISTS

    public static function permission_with_roles($id)
    {
        return Permission::with('roles')->findOrFail($id);
    }


    //  COUNTRY FILTER ID
//
//    public static function country($id)
//    {
//        return \App\Models\Countries::findorfail($id);
//    }

//    //  COUNTRY FILTER ID
//
//    public static function region($id)
//    {
//        return \App\Models\Regions::findorfail($id);
//    }
//
//    //  COUNTRY FILTER BY COUNTRY ID
//
//    public static function region_sort_country($id)
//    {
//        return \App\Models\Regions::where('countries_id',$id)->get();
//    }
//
//
//    //  COUNTRY FILTER ID WITH REGIONS
//
//    public static function country_with_regions($id)
//    {
//        return \App\Models\Countries::with('regions')->findorfail($id);
//    }

//    //  MENU FOLDER ALL
//
//    public static function menu_folders_all()
//    {
//        return \App\Models\MenuFolders::all();
//    }
//
//    //  MENU FOLDER FILTER ID
//
//    public static function menu_folder($id)
//    {
//        return \App\Models\MenuFolders::findorfail($id);
//    }
//
//    //  MENU FOLDER ID WITH LINKS
//
//    public static function menu_folder_with_links($id)
//    {
//        return \App\Models\MenuFolders::with('links')->findorfail($id);
//    }
//
//    //  MENU CATEGORY ALL
//
//    public static function menu_lists_all()
//    {
//        return \App\Models\MenuLists::all();
//    }
//
//    //  MENU CATEGORY ID WITH LINKS
//
//    public static function menu_category_with_links($id)
//    {
//        return \App\Models\MenuCategories::with('links')->findorfail($id);
//    }
//
//    //  MENU FOLDER FILTER ID
//
//    public static function menu_list($id)
//    {
//        return \App\Models\MenuLists::findorfail($id);
//    }
//
//    //  MENU CATEGORY FILTER ID
//
//    public static function menu_category($id)
//    {
//        return \App\Models\MenuCategories::findorfail($id);
//    }
//
//    //  MENU CATEGORY ALL
//
//    public static function menu_categories_all()
//    {
//        return \App\Models\MenuCategories::all();
//    }
//
//    //  MENU LINK FILTER ID
//
//    public static function menu_link($id)
//    {
//        return \App\Models\MenuLinks::findorfail($id);
//    }
//
//    //  MENU LINK ALL
//
//    public static function menu_links_with_route($route)
//    {
//        return \App\Models\MenuLinks::where('route',$route)->first();
//    }
//
//    //  MENU LINK ALL
//
//    public static function menu_links_all()
//    {
//        return \App\Models\MenuLinks::all();
//    }
//
//    //  COMPANY FILTER ID
//
//    public static function company($id)
//    {
//        return \App\Models\Companies::findorfail($id);
//    }
//
//    //  COMPANY ALL
//
//    public static function companies_all()
//    {
//        return \App\Models\Companies::all();
//    }
//
//    //  COMPANY WITH DIVISIONS
//
//    public static function company_with_divisions($id)
//    {
//        return \App\Models\Companies::with('divisions')->findorfail($id);
//    }
//
//    //  COMPANY FILTER ID
//
//    public static function division($id)
//    {
//        return \App\Models\divisions::findorfail($id);
//    }
//
//    //  PHONE TYPE ID
//
//    public static function phone_type_all()
//    {
//        return \App\Models\PhoneType::all();
//    }
//
//    //  PHONE TYPE ID
//
//    public static function phone_type($id)
//    {
//        return \App\Models\PhoneType::findorfail($id);
//    }
//
//    //  ADDRESS TYPE ID
//
//    public static function address_type_all()
//    {
//        return \App\Models\AddressType::all();
//    }
//
//    //  ADDRESS TYPE ID
//
//    public static function address_type($id)
//    {
//        return \App\Models\AddressType::findorfail($id);
//    }
//
//
//    //  ADDRESS ID
//
//    public static function address_all()
//    {
//        return \App\Models\Addresses::all();
//    }
//
//    //  ADDRESS TYPE ID
//
//    public static function address($id)
//    {
//        return \App\Models\Addresses::findorfail($id);
//    }
//
//
//
//    //  GUARD TYPE ID BY SLUG
//
//    public static function guard_type_id_from_auth_guard()
//    {
//        return GuardTypes::where('name',Query::auth_guard())->first()->id;
//    }
//
//
//    //  PASSPORT FILTER ID
//
//    public static function passport($id)
//    {
//        return \App\Models\Passports::findorfail($id);
//    }
//
//    //  PASSPORT ALL
//
//    public static function passport_all()
//    {
//        return \App\Models\Passports::all();
//    }
//
//
//    //  SERVICES FILTER ID
//
//    public static function service($id)
//    {
//        return \App\Models\Services::findorfail($id);
//    }
//
//    //  SERVICES ALL
//
//    public static function service_all()
//    {
//        return \App\Models\Services::all();
//    }
//
//    //  SERVICES ALL
//
//    public static function service_with_requirement($id)
//    {
//        return \App\Models\Services::with('service_requirements')->where('id',$id)->first();
//    }
//
//    //  SERVICES FILTER ID
//
//    public static function service_requirement($id)
//    {
//        return \App\Models\ServiceRequirements::findorfail($id);
//    }
//
//    //  SERVICES ALL
//
//    public static function service_requirement_all()
//    {
//        return \App\Models\ServiceRequirements::all();
//    }
//
//    //  PROCESS FILTER ID
//
//    public static function process($id)
//    {
//        return \App\Models\Processes::findorfail($id);
//    }
//
//    //  PROCESS ALL
//
//    public static function process_all()
//    {
//        return \App\Models\Processes::all();
//    }
//
//    //  STEP FILTER ID
//
//    public static function step($id)
//    {
//        return \App\Models\Steps::findorfail($id);
//    }
//
//    //  STEP ALL
//
//    public static function step_all()
//    {
//        return \App\Models\Steps::all();
//    }
//
//
//    //  EDUCATION FILTER ID
//
//    public static function education($id)
//    {
//        return \App\Models\Educations::findorfail($id);
//    }
//
//    //  EDUCATION TYPES FILTER ID
//
//    public static function education_with_types($id)
//    {
//        return \App\Models\Educations::with('education_types')->findorfail($id);
//    }
//
//    //  EDUCATION ALL
//
//    public static function education_all()
//    {
//        return \App\Models\Educations::all();
//    }
//
//
//    //  EDUCATION FILTER ID
//
//    public static function education_type($id)
//    {
//        return \App\Models\EducationTypes::findorfail($id);
//    }
//
//    //  EDUCATION ALL
//
//    public static function education_type_all()
//    {
//        return \App\Models\EducationTypes::all();
//    }
//
//    //  EDUCATION TYPES FILTER ID
//
//    public static function education_type_with_educations($id)
//    {
//        return \App\Models\Educations::with('educations')->findorfail($id);
//    }
//
//
//    //  UNIVERSITY FILTER ID
//
//    public static function university($id)
//    {
//        return \App\Models\Universities::findorfail($id);
//    }
//
//    //  UNIVERSITY ALL
//
//    public static function university_all()
//    {
//        return \App\Models\Universities::all();
//    }
//
//    //  STATUS FILTER ID
//
//    public static function status($id)
//    {
//        return \App\Models\Status::findorfail($id);
//    }
//
//    //  STATUS FILTER REFERENCE
//
//    public static function status_by_reference($ref)
//    {
//        return \App\Models\Status::where('reference',$ref)->first();
//    }
//
//    //  STATUS ALL
//
//    public static function status_all()
//    {
//        return \App\Models\Status::all();
//    }
//
//    //  MODELS FILTER ID
//
//    public static function model($id)
//    {
//        return \App\Models\Models::findorfail($id);
//    }
//
//    //  MODELS ALL
//
//    public static function model_all()
//    {
//        return \App\Models\Models::all();
//    }
//
//
//    //  APPLICATIONS FILTER ID
//
//    public static function application($id)
//    {
//        return \App\Models\Applications::findorfail($id);
//    }
//
//    //  APPLICATIONS ALL
//
//    public static function application_all()
//    {
//        return \App\Models\Applications::all();
//    }
}




