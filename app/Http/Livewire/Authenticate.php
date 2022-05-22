<?php

namespace App\Http\Livewire;

use App\Traits\Data;
use Carbon\Carbon;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Authenticate extends Component
{
    use Data;

    public bool $darkMode = true, $authError = false,$isUserManager=false;
    public $returnValue,
        $ipAddress,
        $submitName,
        $modalType = null,
        $userRoleActive = '', $adminRoleActive = '',
        $activeRoleName = '',
        $roleActive, $roleActiveName,
        $routeName='',
        $authSubHeader = "",
        $recordID = null;

    public $record = null;
    public array
        $validationErrors = [],
        $authRoles = [],
        $modalDetails = ['model' => '', 'modalType' => '', 'formType' => '', 'record' => [], 'toggle' => false],
        $toastAlert = ['show' => false, 'alert' => '', 'message' => ''],
        $login = ['email' => '', 'password' => ''];


    public function boot()
    {
        $this->routeName=$this->routeName();
        $this->isUserManager=(auth()->user()->hasRole('manager'));
        $this->setLoginEmail();
        $this->adminRoleActive = Session::get('adminRoleActive');
        $this->userRoleActive = Session::get('userRoleActive');
    }

public function redirectBack(){
    return redirect()->back();
}

public function routeName(){
        return Route::currentRouteName();
}

    public bool $openModal = false, $openAuthModal = false, $openConfirmationModal = false;

    protected $listeners = ['authorizeLogin', 'openModal', 'openConfirmationModal', 'showToast', 'subHeader', 'userLoginListener'];

    protected $rules = [
        'login.email' => 'required|email',
        'login.password' => 'required',
    ];

    protected $messages = [
        'login.email.required' => 'The Email Address cannot be empty.',
        'login.email.email' => 'Enter a valid email ID.',
        'login.password.required' => 'The Password cannot be empty.',
    ];

    protected function setLoginEmail()
    {
        $this->login['email'] = Auth::user()->email;
    }

    public function showToast($value)
    {
        $this->toastAlert = $value;
    }


    public function userLoginListener()
    {
//       $this->authRoles= $this->authRoles();
        $this->emit('updateAuthRolesListener');
    }


    public function subHeader($value)
    {
        $this->emit('subHeader', $value);
        $this->authSubHeader = $value;
    }


    public function authorizeLogin($value)
    {
        $this->resetErrorBag();
        $this->reset();
        $this->authError = false;
        $this->setLoginEmail();
        $this->openAuthModal = $value[0];
        $this->returnValue = $value[1];
    }

    public function refreshComponent()
    {
        $this->openAuthModal = true;
    }

    public function mount(Request $request)
    {

        $this->ipAddress = $request->ip();


    }

    public function LoginSubmit()
    {
        $validate = $this->validate();
        $this->ensureIsNotRateLimited();

        if (Auth::guard(Data::guard())->attempt(['email' => $this->login['email'], 'password' => $this->login['password']])) {
            Session::put('authorizeOperation', ['time' => Carbon::now()->addSeconds(10)->timestamp]);
            $this->emit('authorizeLogin', [false, null]);
            $this->emit('authSuccess', $this->returnValue);
        } else {
            $this->authError = true;
//            Session::forget('authorizeOperation');
        }
    }

    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey()
    {
        return Str::lower($this->login['email']) . '|' . $this->ipAddress;
    }

}
