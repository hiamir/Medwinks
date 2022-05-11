<?php

namespace App\Http\Livewire\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class VerifyEmail extends Component
{
    protected $userRequest;

    public function mount(Request $request)
    {

        if (auth()->check()) {
            if ($request->user()->hasVerifiedEmail()) {
                return redirect()->intended(RouteServiceProvider::HOME);
            }
            $this->userRequest = $request->user();
        }else{
            return redirect()->route('login');
        }

//        $request->user()->sendEmailVerificationNotification();
    }
//    public function __invoke()
//    {
//        if ($request->user()->hasVerifiedEmail()) {
//            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
//        }
//
//        if ($request->user()->markEmailAsVerified()) {
//            event(new Verified($request->user()));
//        }
//
//        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    public function send_verification()
    {
//    if ($request->user()->hasVerifiedEmail()) {
//        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
//    }
        dd($this->userRequest);
        Auth::user()->sendEmailVerificationNotification();
    }

//    }

    public function authorize()
    {
        if (!hash_equals((string)$this->route('id'),
            (string)$this->user()->getKey())) {
            return false;
        }

        if (!hash_equals((string)$this->route('hash'),
            sha1($this->user()->getEmailForVerification()))) {
            return false;
        }

        return true;
    }

    public function fulfill()
    {
        if (!$this->user()->hasVerifiedEmail()) {
            $this->user()->markEmailAsVerified();

            event(new Verified($this->user()));
        }
    }

    public function render()
    {
        return view('livewire.auth.verify-email')->layout('layouts.guest');;
    }
}
