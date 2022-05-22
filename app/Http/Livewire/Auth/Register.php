<?php

namespace App\Http\Livewire\Auth;

use App\Mail\TwoFactor;
use App\Mail\Welcome;
use App\Models\Admin;
use App\Models\Country;
use App\Models\DefaultProfilePhoto;
use App\Models\Gender;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\Data;
use App\Traits\Datatable\PassportDatable;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Livewire\Component;

class Register extends Component

{

    public array $allRegions = [], $regions = [];
    public array $user = ['name' => '', 'email' => '', 'genderID' => '', 'password' => '', 'password_confirmation' => '','country'=>'','region'=>''];
    public string $password_regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/';
//        $name, $email,$password,$password_confirmation, $genderID;
    use Data;

    public function mount(){
        $this->regions = [];
        $this->allRegions = Data::regions_all_for_select();
    }

    public function updating($field, $value)
    {
        switch ($field) {

            case 'user.country':
                $this->user['region'] ='';

                if($value !== '') {
                    $this->regions = Data::regions_for_select($value);
                    $this->user['region'] ='';
                } else{
                    $this->regions=[];

                }
                break;
        }
    }

    protected function rules()
    {
        return [
            'user.name' => ['required', 'string', 'max:255'],
            'user.email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'user.password' => ['required', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/', 'confirmed', Rules\Password::defaults()],
            'user.genderID' => ['required'],
            'user.country' => 'required',
        ];
    }


    protected $messages = [
        'user.name.required' => 'The Name cannot be empty.',
        'user.name.string' => 'The Name must be a string.',
        'user.name.max' => 'The Name cannot exceed more than 255 characters.',
        'user.email.required' => 'The Email Address cannot be empty.',
        'user.email.string' => 'The Email must be a string.',
        'user.email.max' => 'The Email cannot exceed more than 255 characters.',
        'user.email.email' => 'The Email Address format is not valid.',
        'user.email.unique' => 'This Email Address already exists!.',
        'user.password.required' => 'The Password cannot be empty.',
        'user.password.confirmed' => 'The two Password do not match.',
        "user.password.regex" => "Password must contain minimum 6, at least one uppercase letter, one lowercase letter, one number and one special character",
        'user.genderID.required' => 'Select your gender.',
        'user.country.required' => 'Select your country.',
    ];

    public function register()
    {
        $this->validate();
        $user=new User();
        $user->name = Data::capitalize_each_word($this->user['name']);
        $user->email = Data::all_lower_case($this->user['email']);
        $user->gender_id = $this->user['genderID'];
        $user->password = Hash::make($this->user['password']);
        $user->two_factor_code = Data::generate_two_factor_code();
        $user->two_factor_expires_at = Data::generate_two_factor_expiry();
        $user->countries_id=$this->user['country'];
        $user->regions_id=$this->user['region'];
        $user->save();
        $user->assignRole('user');
//        event(new Registered($user));

        Auth::login($user);
        Mail::to($user->email)->send(new Welcome($user->name, $user->email, $this->user['password']));
        Mail::to($user->email)->send(new TwoFactor($user->name, $user->two_factor_code));
        return redirect(RouteServiceProvider::HOME);
    }

    public function render()
    {
        $countries = Country::select('id', 'name')->get();
        $gender = Gender::select('id', 'name')->get();
        return view('livewire.auth.register', ['gender' => $gender,'countries'=>$countries])->layout('layouts.guest');
    }
}
