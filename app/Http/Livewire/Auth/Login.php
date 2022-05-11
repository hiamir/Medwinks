<?php

namespace App\Http\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Illuminate\Http\Request;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;
    protected $ipAddress;
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
        $this->ipAddress = $request->ip();
        (Cookie::get('auth-email')) ? $this->remember = true : $this->remember = false;
    }

    public function login()
    {
        $validate = $this->validate();
        $this->ensureIsNotRateLimited();
        if (!Auth::attempt($validate, $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
        RateLimiter::clear($this->throttleKey());
        if ($this->remember) {
            Cookie::queue('auth-email', $this->email, 1440);
            Cookie::queue('auth-password', $this->password, 1440);
            $this->remember = true;
        } else {
            Cookie::queue(Cookie::forget('auth-email'));
            Cookie::queue(Cookie::forget('auth-password'));
        }
//        if (Auth::user()->hasRole('admin')) {
//            return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
//        }  else {
        redirect(Session::get('url.intended'));
        return (Session::has('url.intended')) ? redirect(Session::get('url.intended')) :  redirect()->intended(RouteServiceProvider::HOME);
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


    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.guest');
    }
}
