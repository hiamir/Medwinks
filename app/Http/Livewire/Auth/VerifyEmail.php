<?php

namespace App\Http\Livewire\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Traits\Data;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class VerifyEmail extends Component
{
    public array $verificationCode = ['', '', '', '', '', ''];
    public array $msg = ['type' => '', 'action' => '', 'message' => ''];
    public $expiringAt;
    public ?bool $isCodeMatched=null;
    public bool $isCodeExpired = true;
    public $user;

    use Data;

    protected $listeners = ['checkVerifyCodeExpired','refreshVerifyEmailComponent' => '$refresh'];

    public function mount(Request $request)
    {

        if (auth()->check()) {
            if ($request->user()->hasVerifiedEmail()) {
                return redirect()->intended(RouteServiceProvider::HOME);
            }
            $this->user = Auth::user();
            $this->expiringAt = auth()->user()->two_factor_expires_at;
            $this->checkCodeExpired();

        } else {
            return redirect()->route('login');
        }
    }

    public function checkVerifyCodeExpired(){
        $this->checkCodeExpired();
}

    public function authorize(): bool
    {
        if (!hash_equals((string)$this->route('id'),
            (string)$this->user->getKey())) {
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


    public function resendCode()
    {
        $this->resetTwoFactorCode(auth()->user());
        $this->expiringAt = auth()->user()->two_factor_expires_at;
//        $this->msgReset();
        $this->msg = ['type' => 'success', 'action' => 'newCodeSent', 'message' => "Your new Two Factor Authentication code was sent to your email"];
    }

    public function verifyCode()
    {

        foreach ($this->verificationCode as $code) {
            if (!is_int(intval($code)) || $code === null || $code === '') {
                $this->isCodeMatched = null;
                break;
            } else {
                $this->isCodeMatched = true;
            }
        }
        if ($this->isCodeMatched && Auth::guard('web')->check()) {
            $two_factor_code = auth()->user()->two_factor_code;

            if ((implode('', $this->verificationCode)) === strval($two_factor_code)) {
                $user = Auth::user();
                $user->email_verified_at = now();
                $user->save();
                return redirect(route('user.dashboard'));
            } else {
                if (auth()->user()->two_factor_expires_at < now()) {
                    $this->checkCodeExpired();
                } else {
                    $this->isCodeMatched=false;
                    $this->verificationCodeReset();
                    $this->msg = ['type' => 'error', 'action' => 'match', 'message' => "Your Two Factor Code do not match"];
                }

            }
        }
    }


    protected function msgReset()
    {
        $this->msg = ['type' => '', 'action' => '', 'message' => ''];
    }

    protected function checkCodeExpired()
    {
        if ($this->isCodeExpired()) {
            $this->isCodeExpired = true;
            $this->msg = ['type' => 'error', 'action' => 'expired', 'message' => "Your Two Factor Code expired!"];
        } else {
            $this->isCodeExpired = false;
//            $this->msgReset();
        }
    }

    protected function verificationCodeReset()
    {
        $this->verificationCode = ['', '', '', '', '', ''];
    }

    public function render()
    {

        return view('livewire.auth.verify-email')->layout('layouts.guest');
    }
}
