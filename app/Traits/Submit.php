<?php

namespace App\Traits;

use App\Mail\DocumentDecision;
use App\Mail\DocumentUpdate;
use App\Mail\DocumentUpdateManager;
use App\Mail\PassportUpdate;
use App\Mail\PassportUpdateManager;
use App\Mail\ResetPassword;
use App\Mail\TwoFactor;
use App\Mail\Welcome;
use App\Models\DefaultProfilePhoto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Throwable;
use function PHPUnit\Framework\fileExists;


trait Submit
{
    use Data;
    use Authorize;

    protected array $checkRules = [];
    protected bool $success = false;

    public function submitForm($t, $modal, $type, $formType, $record, $field, $rules = [])
    {
        $this->checkRules = $rules;

        switch ($modal) {
            case 'role':
            case 'permission':

                switch ($type) {
                    case 'add':
                    case 'update':
                        ($modal === 'role') ? $record->name = Data::all_lower_case($field['name']) : $record->name = Data::all_lower_case($field['name']);
                        $record->guard_name = $field['guard_name'];
                        $t->gate($t, $modal, $type, $formType, $record);
                        if ($modal === 'role') $record->permissions()->sync([]);
                        break;

                    case 'delete':
                        $t->gate($t, $modal, $type, $formType, $record);
                        break;
                }
                break;

            case 'user':
            case 'administrator':
                switch ($type) {
                    case 'add':
                        $record->name = Data::capitalize_each_word($field['name']);
                        $record->email = Data::all_lower_case($field['email']);
                        $record->gender_id = Data::all_lower_case($field['gender']);
                        $password = Data::generate_password();
                        $record->password = Hash::make($password);
                        $record->two_factor_code = Data::generate_two_factor_code();
                        $record->two_factor_expires_at = Data::generate_two_factor_expiry();
                        $t->gate($t, $modal, $type, $formType, $record);
                        if ($this->success) {
                            Mail::to($record->email)->send(new Welcome($record->name, $record->email, $password));
                            Mail::to($record->email)->send(new TwoFactor($record->name, $record->two_factor_code));
                        }
                        break;

                    case 'update':
                        $record->name = Data::capitalize_each_word($field['name']);
                        $t->gate($t, $modal, $type, $formType, $record);
                        break;

                    case 'delete':
                        if ($modal === 'user' || $modal === 'administrator') {
                            if ($record->id === Auth::user()->id) {
                                $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'User active!', 'message' => 'The user you are trying to delete is currently active.']);
                                break;
                            }
                        }
                        $t->gate($t, $modal, $type, $formType, $record);
                        break;
                    case 'password-reset':
                        $t->gate($t, $modal, $type, $formType, $record);
                        break;

                }
                break;

            case 'gender':
                switch ($formType) {
                    case 'gender':
                        switch ($type) {
                            case 'add':
                            case 'update':
                                $record->name = Data::capitalize_each_word($field['name']);
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;

                            case 'delete':
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;
                        }
                        break;


                }
                break;

            case 'profile':
                switch ($type) {
                    case 'update':
                        switch ($formType) {
                            case 'info':
                                $record->name = Data::capitalize_each_word($field['name']);
                                $record->email = Data::all_lower_case($field['email']);
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;

                            case 'password-change':

                                $record->password = Hash::make($this->auth['password']);
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;
                        }
                }
                break;

            case 'menu':
                $record->name = Data::capitalize_each_word($field['name']);
                $record->svg = Data::all_lower_case($field['svg']);
                $record->sort = $field['sort'];
                $t->gate($t, $modal, $type, $formType, $record);
                $this->emit('refreshSidebar');
                break;

            case 'menu-items':
                $record->name = Data::capitalize_each_word($field['name']);
                $record->svg = Data::all_lower_case($field['svg']);
                $record->guard = $field['guard'];
                $record->route = Data::all_lower_case($field['route']);
                $record->menu_id = $field['menu_id'];
                $record->permissions_id = $field['permissions_id'];
                $record->sort = $field['sort'];
                $t->gate($t, $modal, $type, $formType, $record);
                $this->reset();
                $this->emit('refreshSidebar');
                break;

            case 'country':
                switch ($formType) {
                    case 'country':
                        switch ($type) {
                            case 'add':
                            case 'update':
                                $record['name'] = Data::capitalize_first_word($field['name']);
                                $record['continent'] = Data::all_upper_case($field['continent']);
                                $record['currency_name'] = Data::capitalize_first_word($field['currency_name']);
                                $record['currency_code'] = Data::all_upper_case($field['currency_code']);
                                $record['phone_prefix'] = $field['phone_prefix'];
                                $record['postal_code'] = $field['postal_code'];
                                $record['languages'] = $field['languages'];
                                $record['iso'] = Data::all_upper_case($field['iso']);
                                $record['iso3'] = Data::all_upper_case($field['iso3']);
                                $record['fips'] = Data::all_upper_case($field['fips']);
                                $record['geonameid'] = $field['geonameid'];
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;

                            case 'delete':

                                $t->gate($t, $modal, $type, $formType, $record);
                                break;
                        }
                        break;

                    case 'region':

                        switch ($type) {
                            case 'add':
                            case 'update':
                                $record['name'] = Data::capitalize_first_word($field['name']);
                                $record['timezone_id'] = $field['timezone_id'];
                                $record['country_id'] = $field['country_id'];

                                $t->gate($t, $modal, $type, $formType, $record);
                                break;

                            case 'delete':

                                $t->gate($t, $modal, $type, $formType, $record);
                                break;
                        }
                        break;


                }
                break;
            case 'qualification':
                switch ($formType) {
                    case 'qualification':
                        switch ($type) {
                            case 'add':
                            case 'update':
                                $record->name = Data::capitalize_first_word($field['name']);
                                $record->position = intval($field['position']);
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;

                            case 'delete':
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;
                        }
                        break;
                    case 'degree':
                        switch ($type) {
                            case 'add':
                            case 'update':
                                $record->name = Data::capitalize_first_word($field['name']);
                                $record->acronym = Data::capitalize_first_word($field['acronym']);
                                $record->position = intval($field['position']);
                                $record->qualification_id = $field['qualificationID'];
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;

                            case 'delete':
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;
                        }
                        break;
                }
                break;

            case 'service':
                switch ($formType) {
                    case 'service':
                        switch ($type) {
                            case 'add':
                            case 'update':
                                $record->name = Data::capitalize_each_word($field['name']);
                                $record->abbreviation = $field['abbreviation'];
                                $record->description = $field['description'];

                                $t->gate($t, $modal, $type, $formType, $record);
                                break;

                            case 'delete':
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;
                        }
                        break;
                    case 'serviceRequirement':

                        switch ($type) {
                            case 'add':
                            case 'update':
                                $record->name = Data::capitalize_each_word($field['name']);
                                $record->description = $field['description'];
                                $record->service_id = $field['serviceID'];
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;

                            case 'delete':
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;
                        }
                        break;
                }
                break;

            case 'service-requirement':

                switch ($formType) {

                    case 'service-requirement':

                        switch ($type) {
                            case 'add':
                            case 'update':
                                $record->name = Data::capitalize_each_word($field['name']);
                                $record->description = $field['description'];
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;

                            case 'delete':
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;
                        }
                        break;
                }
                break;

            case 'university':
                switch ($formType) {
                    case 'university':
                        switch ($type) {
                            case 'add':
                            case 'update':
                                $record->name = Data::capitalize_each_word($field['name']);
                                $record->abbreviation = Data::capitalize_each_word($field['abbreviation']);
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;

                            case 'delete':
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;
                        }
                        break;

                }
                break;

            case 'passport':
            case 'client-details':

                switch ($formType) {
                    case 'passport':
                        switch ($type) {
                            case 'add':
                            case 'update':
                                if ($field['user_id'] === 0 || $field['user_id'] === '' || $field['user_id'] === null) {
                                    $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'User not defined!', 'message' => 'The user for this passport is not defined. Please select user first to create passport']);
                                } else {
                                    $record['passport_number'] = Data::all_upper_case($field['passport_number']);
                                    $record['given_name'] = Data::capitalize_first_word($field['given_name']);
                                    $record['sur_name'] = Data::capitalize_first_word($field['sur_name']);
                                    $record['date_of_birth'] = ($field['date_of_birth']);
                                    $record['issue_date'] = $field['issue_date'];
                                    $record['expiry_date'] = $field['expiry_date'];
                                    $record['countries_id'] = $field['country'];
                                    $record['regions_id'] = $field['region'];
                                    $record['file'] = $field['file'];
                                    $record['active'] = $field['active'];
                                    $record['user_id'] = $field['user_id'];
                                    $record['accepted'] = $field['accepted'];;
                                    $record['rejected'] = $field['rejected'];;
                                    $record['revision'] = $field['revision'];;

                                    $t->gate($t, $modal, $type, $formType, $record);
                                    if ($this->success && $type === 'update') {
                                        $user = User::find($this->record['user_id']);
                                        Mail::to($user->email)->send(new PassportUpdate($user->name, $this->record['passport_number']));
                                        $managers = User::role('manager')->get();
                                        if (count($managers) > 0) {
                                            foreach ($managers as $manager) {
                                                Mail::to($manager->email)->send(new PassportUpdateManager($user->name, $manager->name, $this->record['passport_number']));
                                            }
                                        }
                                    }
                                }

                                break;

                            case 'delete':

                                $t->gate($t, $modal, $type, $formType, $record);
                                break;
                        }
                        break;

                    case 'document':
                        switch ($type) {
                            case 'add':
                            case 'update':
                                if ($field['user_id'] === 0 || $field['user_id'] === '' || $field['user_id'] === null) {
                                    $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'User not defined!', 'message' => 'The user for this passport is not defined. Please select user first to create passport']);
                                } else {
                                    $record['name'] = Data::capitalize_first_word($field['name']);
                                    $record['service_requirement_id'] = $field['service_requirement_id'];
                                    $record['notes'] = $field['notes'];
                                    $record['user_id'] = $field['user_id'];
                                    $record['accepted'] = 0;
                                    $record['rejected'] = 0;
                                    $record['revision'] = 0;
                                    if ($type === 'update') {
                                        $user = User::find($record['user_id']);
                                        Mail::to($user->email)->send(new DocumentUpdate($user->name, $record['name']));
                                        $managers = User::role('manager')->get();
                                        if (count($managers) > 0) {
                                            foreach ($managers as $manager) {
                                                Mail::to($manager->email)->send(new DocumentUpdateManager($user->name, $manager->name, $record['name']));
                                            }
                                        }
                                    }


                                    if (is_object($field['file'])) $record['file'] = $field['file'];

                                    $t->gate($t, $modal, $type, $formType, $record);
                                }
                                break;

                            case 'delete':
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;
                        }
                        break;

                    case 'region':

                        switch ($type) {
                            case 'add':
                            case 'update':
                                $record['name'] = Data::capitalize_first_word($field['name']);
                                $record['timezone_id'] = $field['timezone_id'];
                                $record['country_id'] = $field['country_id'];

                                $t->gate($t, $modal, $type, $formType, $record);
                                break;

                            case 'delete':

                                $t->gate($t, $modal, $type, $formType, $record);
                                break;
                        }
                        break;


                }
                break;
            case 'document':
//            case 'client-details':
                switch ($formType) {
                    case 'document':
                        switch ($type) {
                            case 'add':
                            case 'update':
                                if ($field['user_id'] === 0 || $field['user_id'] === '' || $field['user_id'] === null) {
                                    $this->dispatchBrowserEvent('error-modal', ['show' => true, 'type' => 'error', 'title' => 'User not defined!', 'message' => 'The user for this passport is not defined. Please select user first to create passport']);
                                } else {
                                    $record['name'] = Data::capitalize_first_word($field['name']);
                                    $record['service_requirement_id'] = $field['service_requirement_id'];
                                    $record['notes'] = $field['notes'];
                                    $record['user_id'] = $field['user_id'];
                                    $record['accepted'] = 0;
                                    $record['rejected'] = 0;
                                    $record['revision'] = 0;
                                    if ($type === 'update') {
                                        $user = User::find($record['user_id']);
                                        Mail::to($user->email)->send(new DocumentUpdate($user->name, $record['name']));
                                        $managers = User::role('manager')->get();
                                        if (count($managers) > 0) {
                                            foreach ($managers as $manager) {
                                                Mail::to($manager->email)->send(new DocumentUpdateManager($user->name, $manager->name, $record['name']));
                                            }
                                        }
                                    }


                                    if (is_object($field['file'])) $record['file'] = $field['file'];

                                    $t->gate($t, $modal, $type, $formType, $record);
                                }
                                break;

                            case 'delete':
                                $t->gate($t, $modal, $type, $formType, $record);
                                break;
                        }
                        break;

                    case 'region':

                        switch ($type) {
                            case 'add':
                            case 'update':
                                $record['name'] = Data::capitalize_first_word($field['name']);
                                $record['timezone_id'] = $field['timezone_id'];
                                $record['country_id'] = $field['country_id'];

                                $t->gate($t, $modal, $type, $formType, $record);
                                break;

                            case 'delete':

                                $t->gate($t, $modal, $type, $formType, $record);
                                break;
                        }
                        break;


                }
        }
    }

    protected function gate($t, $modal, $type, $formType, $record)
    {
        (Data::guard() === 'web') ? $guard = 'user' : $guard = Data::guard();
        switch ($modal) {
            case 'administrator':
            case 'user':
            case 'gender':
            case 'defaultProfilePhoto':

            case 'role':
            case 'permission':
            case 'menu':
            case 'menu-items':
            case 'university':
            case 'passport':
            case 'document':
                switch ($type) {
                    case 'add':

                        ($this->permission($guard . '-' . $modal . '-create')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, $formType, $record);
                        break;
                    case 'update':
                        ($this->permission($guard . '-' . $modal . '-update')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, $formType, $record);
                        break;
                    case 'delete':
                        ($this->permission($guard . '-' . $modal . '-delete')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, $formType, $record);
                        break;

                    case 'password-reset':
                        ($this->permission($guard . '-' . $modal . '-password-reset')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, $formType, $record);
                        break;
                }
                break;

            case 'profile':
                switch ($formType) {
                    case 'info':
                    case 'password-change':

                        ($this->permission($guard . '-' . $modal . '-' . $formType)) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, $formType, $record);

                        break;
                }
                break;

            case 'country':
                switch ($formType) {
                    case 'country':
                    case 'region':
                        switch ($type) {
                            case 'add':
                                ($this->permission($guard . '-' . $formType . '-create')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, $formType, $record);
                                break;
                            case 'update':
                                ($this->permission($guard . '-' . $formType . '-update')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, $formType, $record);
                                break;
                            case 'delete':
                                ($this->permission($guard . '-' . $formType . '-delete')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, $formType, $record);
                                break;
                        }
                        break;
                }
                break;

            case 'qualification':
                switch ($formType) {
                    case 'qualification':
                    case 'degree':
                        switch ($type) {
                            case 'add':
                                ($this->permission($guard . '-' . $formType . '-create')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, $formType, $record);
                                break;
                            case 'update':
                                ($this->permission($guard . '-' . $formType . '-update')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, $formType, $record);
                                break;
                            case 'delete':
                                ($this->permission($guard . '-' . $formType . '-delete')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, $formType, $record);
                                break;
                        }
                        break;
                }
                break;

            case 'client-details':
                switch ($formType) {
                    case 'document':
                    case 'passport':
                        switch ($type) {
                            case 'add':
                                ($this->permission($guard . '-' . $modal . '-' . $formType . '-create')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, $formType, $record);
                                break;
                            case 'update':
                                ($this->permission($guard . '-' . $modal . '-' . $formType . '-update')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, $formType, $record);
                                break;
                            case 'delete':
                                ($this->permission($guard . '-' . $modal . '-' . $formType . '-delete')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, $formType, $record);
                                break;
                        }
                        break;
                }
                break;

            case 'service':
                switch ($formType) {
                    case 'service':
                        switch ($type) {
                            case 'add':
                                ($this->permission($guard . '-' . $formType . '-create')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, $formType, $record);
                                break;
                            case 'update':
                                ($this->permission($guard . '-' . $formType . '-update')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, $formType, $record);
                                break;
                            case 'delete':
                                ($this->permission($guard . '-' . $formType . '-delete')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, $formType, $record);
                                break;
                        }
                        break;
                    case 'serviceRequirement':

                        switch ($type) {
                            case 'add':
                                ($this->permission($guard . '-' . 'service-requirement' . '-create')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, 'service-requirement', $record);
                                break;
                            case 'update':
                                ($this->permission($guard . '-' . 'service-requirement' . '-update')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, 'service-requirement', $record);
                                break;
                            case 'delete':
                                ($this->permission($guard . '-' . 'service-requirement' . '-delete')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, 'service-requirement', $record);
                                break;
                        }
                        break;
                }
                break;

            case 'service-requirement':
                switch ($formType) {

                    case 'service-requirement':

                        switch ($type) {
                            case 'add':
                                ($this->permission($guard . '-' . 'service-requirement' . '-create')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, 'service-requirement', $record);
                                break;
                            case 'update':
                                ($this->permission($guard . '-' . 'service-requirement' . '-update')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, 'service-requirement', $record);
                                break;
                            case 'delete':
                                ($this->permission($guard . '-' . 'service-requirement' . '-delete')) ? $this->execute($t, $modal, $type, $formType, $record) : $this->unauthorized($modal, $type, 'service-requirement', $record);
                                break;
                        }
                        break;
                }
                break;
            default:

                $this->unauthorized($modal, $type, $formType, $record);
        }
    }

    protected function unauthorized($modal, $type, $formType, $record)
    {

        $addName = [
            'administrator' => 'Administrator',
            'users' => 'User',
            'gender' => 'Gender',
            'profile' => 'Profile',
            'defaultProfilePhoto' => 'Default profile photo',
            'role' => 'Role',
            'permission' => 'Permission',
            'country' => 'Country',
            'region' => 'Region',
            'menu' => 'Menu',
            'menu-items' => 'Menu Items',
            'qualification' => 'Qualification',
            'university' => 'University',
            'passport' => 'Passport',
            'service' => 'Service',
            'serviceRequirement' => 'Service requirement',
            'document' => 'Document',
            'client-details' => 'Client details'
        ];

        switch ($modal) {

            case 'administrator':
            case 'user':
            case 'gender':
            case 'country':
            case 'defaultProfilePhoto':
            case 'profile':
            case 'role':
            case 'permission':
            case 'menu':
            case 'menu-items':
            case 'qualification':
            case 'university':
            case 'document':


                if ($modal === 'qualification' && $formType === 'degree') $addName['qualification'] = 'Degree';

                switch ($type) {
                    case 'add':
                        $this->AccessDeniedModal('create', $addName[$modal]);
                        break;

                    case 'update':

                        $this->AccessDeniedModal('update', $record->name);
                        break;

                    case 'delete':
                        $this->AccessDeniedModal('delete', $record->name);
                        break;

                    case 'password-reset':
                        $this->AccessDeniedModal('reset password', $record->name);
                        break;
                }
                break;

            case 'passport':
                switch ($type) {
                    case 'add':
                        $this->AccessDeniedModal('create', $addName[$modal]);
                        break;

                    case 'update':

                        $this->AccessDeniedModal('update', $record->passport_number);
                        break;

                    case 'delete':
                        $this->AccessDeniedModal('delete', $record->passport_number);
                        break;
                }
                break;


            case 'service':
                switch ($formType) {
                    case 'service':
                        switch ($type) {
                            case 'add':
                                $this->AccessDeniedModal('create', 'Service');
                                break;

                            case 'update':
                                $this->AccessDeniedModal('update', $record->name);
                                break;

                            case 'delete':
                                $this->AccessDeniedModal('delete', $record->name);
                                break;
                        }
                        break;
                    case 'service-requirement':
                        switch ($type) {
                            case 'add':
                                $this->AccessDeniedModal('create', 'Service requirement');
                                break;

                            case 'update':

                                $this->AccessDeniedModal('update', $record->name);
                                break;

                            case 'delete':
                                $this->AccessDeniedModal('delete', $record->name);
                                break;
                        }
                        break;
                }
                break;

            case 'service-requirement':
                switch ($formType) {
                    case 'service-requirement':
                        switch ($type) {
                            case 'add':
                                $this->AccessDeniedModal('create', 'Service requirement');
                                break;

                            case 'update':

                                $this->AccessDeniedModal('update', $record->name);
                                break;

                            case 'delete':
                                $this->AccessDeniedModal('delete', $record->name);
                                break;
                        }
                        break;
                }
                break;

            case 'client-details':
                switch ($formType) {
                    case 'passport':
                        switch ($type) {
                            case 'add':
                                $this->AccessDeniedModal('create', 'Passport');
                                break;

                            case 'update':
                                $this->AccessDeniedModal('update', $record->name);
                                break;

                            case 'delete':
                                $this->AccessDeniedModal('delete', $record->name);
                                break;
                        }
                        break;
                    case 'document':
                        switch ($type) {
                            case 'add':
                                $this->AccessDeniedModal('create', 'Document');
                                break;

                            case 'update':
                                $this->AccessDeniedModal('update', $record->name);
                                break;

                            case 'delete':
                                $this->AccessDeniedModal('delete', $record->name);
                                break;
                        }
                        break;
                    case 'service-requirement':
                        switch ($type) {
                            case 'add':
                                $this->AccessDeniedModal('create', 'Service requirement');
                                break;

                            case 'update':

                                $this->AccessDeniedModal('update', $record->name);
                                break;

                            case 'delete':
                                $this->AccessDeniedModal('delete', $record->name);
                                break;
                        }
                        break;
                }
                break;


            default:
                if ($type === 'password-reset') $this->AccessDeniedModal('', '', 'You are not authorized to perform this operation');
        }

    }

    protected function execute($t, $modal, $type, $formType, $record)
    {


        switch ($type) {

            case 'add':
            case 'update':
                try {
                    ($this->checkRules) ? $t->validate($this->checkRules) : $t->validate();

                    switch ($modal) {

                        case 'user':
                            $this->success = $record->save();
                            $this->record->assignRole('user');
                            $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => ($type === 'add') ? $record->name . ' added successfully!' : $record->name . ' updated successfully!']);
                            break;

                        case 'profile':
                            $this->success = $record->save();
                            switch ($type) {
                                case 'update':
                                    switch ($formType) {
                                        case 'info':
                                            $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => $record->name . ' updated successfully!']);
                                            break;
                                        case 'password-change':
                                            $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => 'Password changed successfully!']);
                                            break;
                                    }
                                    break;
                            }
                            break;

                        case 'gender':
                            $this->success = $record->save();
                            switch ($formType) {
                                case 'gender':
                                    break;

                                case 'defaultProfilePhoto':
                                    break;
                            }
                            break;

                        case 'passport':
                            if (is_object($this->record['file'])) {
                                $file = $this->record['file'];
                                $this->record['file'] = ($this->fileRename($this->record['file'], 'passport', $this->record['passport_number']));
                                $this->success = $record->save();
                                $this->uploadFile($file, 'passports', $this->record['file']);
                            } else {
                                $this->success = $record->save();
                            }

                            $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => 'Passport added successfully!']);
                            break;

                        case 'document':
                            if (is_object($this->record['file'])) {
                                $this->success = $record->save();
                                $file = $this->record['file'];
                                $this->record['file'] = ($this->fileRename($this->record['file'], 'document', $this->record->id . '-' . $this->record['service_requirement_id']));

                                $this->uploadFile($file, 'documents', $this->record['file']);
                                $record->save();
                            } else {
                                $this->success = $record->save();
                            }
                            $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => 'Document added successfully!']);
                            break;

                        case 'client-details':

                            switch ($formType) {
                                case 'passport':
                                    if (is_object($record['file'])) {
                                        $file = $record['file'];
                                        $this->record['file'] = ($this->fileRename($record['file'], 'passport', $record['passport_number']));
                                        $this->success = $record->save();
                                        $this->uploadFile($file, 'passports', $record['file']);
                                    } else {
                                        $this->success = $record->save();
                                    }
                                    $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => 'Passport added successfully!']);
                                    break;

                                case 'document':
                                    if (is_object($this->record['file'])) {
                                        $this->success = $record->save();
                                        $file = $this->record['file'];
                                        $this->record['file'] = ($this->fileRename($this->record['file'], 'document', $this->record->id . '-' . $this->record['service_requirement_id']));

                                        $this->uploadFile($file, 'documents', $this->record['file']);
                                        $record->save();
                                    } else {
                                        $this->success = $record->save();
                                    }
                                    $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => 'Document added successfully!']);
                                    break;
                                default:
                                    $this->success = $record->save();
                                    $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => ($type === 'add') ? $record->name . ' added successfully!' : $record->name . ' updated successfully!']);
                                    break;
                            }

                            break;
                        default:
                            $this->success = $record->save();
                            $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => ($type === 'add') ? $record->name . ' added successfully!' : $record->name . ' updated successfully!']);
                            break;
                    }

                } catch (\Illuminate\Validation\ValidationException $e) {
                    $this->validationErrors = $e->errors();
                    ($this->checkRules) ? $t->validate($this->checkRules) : $t->validate();
//                    $this->emitSelf('notify-error');
//                    $this->dispatchBrowserEvent('toast', ['alert' => 'danger', 'message' => $e->getMessage()]);


                }
//                } catch (ModelNotFoundException $exception) {
//                    $this->dispatchBrowserEvent('toast', ['alert' => 'danger', 'message' => $exception->getMessage()]);
//                }
                $this->dispatchBrowserEvent('add-update-modal', ['show' => false]);

                break;

            case 'password-reset':

                switch ($modal) {
                    case 'user':
                    case 'administrator':
                        $password = Data::generate_password();
                        $record->password = Hash::make($password);
                        $record->save();
                        $this->dispatchBrowserEvent('reset-password-modal', ['show' => false]);
                        $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => 'Password for ' . $record->name . ' was generated!']);
                        Mail::to($record->email)->send(new ResetPassword($record->name, $record->email, $password));
                        break;
                }
                break;

            case 'delete':
                try {
                    switch ($modal) {
                        case 'document':
                            $file=$record->file;
                            $this->success = $record->delete();
                            if($this->success ) {
                                if(fileExists('/storage/images/documents/' . $file)) unlink('./storage/images/documents/' . $file);
                            }
                            $this->dispatchBrowserEvent('delete-modal', ['show' => false]);
                            $this->dispatchBrowserEvent('toast', ['alert' => 'danger', 'message' => $record->name . ' deleted successfully!']);
                            break;
                            break;
                        case 'client-details':
                            switch ($formType) {
                                case 'passport':
                                    unlink('storage/images/passports/' . $record->file);
                                    break;

                                case 'document':
                                    unlink('storage/images/documents/' . $record->file);
                                    break;
                            }


                            $this->dispatchBrowserEvent('delete-modal', ['show' => false]);

                            $this->dispatchBrowserEvent('toast', ['alert' => 'danger', 'message' => $record->name . ' deleted successfully!']);
                            break;

                        default:
                            $this->success = $record->delete();
                            $this->dispatchBrowserEvent('delete-modal', ['show' => false]);

                            $this->dispatchBrowserEvent('toast', ['alert' => 'danger', 'message' => $record->name . ' deleted successfully!']);
                            break;
                    }
                }
                catch
                    (ModelNotFoundException $exception) {
                        $this->dispatchBrowserEvent('delete-modal', ['show' => false]);
                        $this->toast('danger', 'Error:  ' . $exception->getMessage());
                    }
                break;
        }
    }

        protected function uploadFile($record, $folder, $name)
        {
            try {
                DB::transaction(function () use ($record, $folder, $name) {
                    $this->fileStore($record, $folder, $name);
                    $this->dispatchBrowserEvent('toast', ['alert' => 'success', 'message' => 'File uploaded successfully!']);
                });

            } catch (Throwable $e) {
                DB::rollback();
                $this->dispatchBrowserEvent('toast', ['alert' => 'danger', 'message' => 'There was an error uploading photo!']);
            }
        }

    }
