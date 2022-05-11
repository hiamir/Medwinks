<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Request;

class VerifyEmailController extends FormRequest
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        Session::put('url.intended',\Illuminate\Support\Facades\Request::fullUrl());
        if (auth()->check()) {
//            dd($request->user()->hasVerifiedEmail());
            if ($request->user()->hasVerifiedEmail()) {
                return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
            }

            if ($request->user()->markEmailAsVerified()) {
                event(new Verified($request->user()));
            }
            return redirect()->route('dashboard');
        }else{

            return redirect()->route('login');
        }



    }

    public function rules()
    {
        return [
            //
        ];
    }
}
