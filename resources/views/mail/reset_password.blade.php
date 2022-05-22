@component('mail::message',['superHeader'=>'Security','header'=>'Reset Password','imageUrl'=>asset('storage/images/reset-password.jpg')])
Dear {{$name}},

<p> You recently requested to reset the password for your OMJ Manager account.</p>

<p>Please use the following password to login to your account.
    @component('mail::button', ['url' => 'http://127.0.0.1:8000/login','color'=>'danger'])
        {{$password}}
    @endcomponent
</p>
<p>If you did not request a password reset, please ignore this email or reply to let us know.</p><br>

Thanks,<br>
<span class="signature">{{ config('app.name') }}</span>
@endcomponent
