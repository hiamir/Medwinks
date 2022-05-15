<?php

namespace App\Http\Livewire\Auth\Admin;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class AdminLogin extends Component
{
    public $email;
    public $password;
    public $remember = false;
    protected $ipAddress;
    protected $session;
    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];
    protected $messages = [

        'email.required' => 'The Email Address cannot be empty.',
        'email.email' => 'The Email Address format is not valid.',
        'password.required' => 'The Password cannot be empty.',
    ];

    public function mount(Request $request)
    {
        $this->session=$request->session();
        $this->ipAddress = $request->ip();
        (Cookie::get('auth-admin-email')) ? $this->remember = true : $this->remember = false;
    }

    public function login()
    {
        $validate = $this->validate();
        $this->ensureIsNotRateLimited();
        if (!Auth::guard('admin')->attempt($validate, $this->remember)) {

            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
        RateLimiter::clear($this->throttleKey());
        if ($this->remember) {
            Cookie::queue('auth-admin-email', $this->email, 1440);
            Cookie::queue('auth-admin-password', $this->password, 1440);
            $this->remember = true;
        } else {
            Cookie::queue(Cookie::forget('auth-admin-email'));
            Cookie::queue(Cookie::forget('auth-admin-password'));
        }
//        if (Auth::user()->hasRole('admin')) {
//            return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
//        }  else {
        return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
//        }

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
        return Str::lower($this->email) . '|' . $this->ipAddress;
    }

    public function admin_logout()
    {
        Auth::guard('admin')->logout();
        $this->session->invalidate();
        $this->session->regenerateToken();

        return redirect(route('admin.login'));
    }


    public function render()
    {
        return view('livewire.auth.admin.admin-login')->layout('layouts.guest');
    }
}
