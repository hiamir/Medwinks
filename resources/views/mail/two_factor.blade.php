@component('mail::message',['superHeader'=>'Security','header'=>'Two Factor Code','imageUrl'=>asset('storage/images/two-factor.jpg')])
    Dear {{$name}},
    @if(!$requestCode)
        <p>Two-factor authentication adds an extra layer of security to your {{ config('app.name') }} access.</p>
        <p>In addition to your primary email and password, you need to enter a code given below on you phone or desktop.
            @component('mail::highlight', ['color'=>'danger'])
                {{$code}}
            @endcomponent
        </p>
    @else
        <p>You have requestCodeed for an new Two Factor Authentication code. Please enter the code given below on you phone or desktop in-order to verify your email address</p>
        <p>
            @component('mail::highlight', ['color'=>'danger'])
                {{$code}}
            @endcomponent
        </p>
    @endif
    <p>Your code will expire in 5 minutes. If you find this email suspicious, please let us know.</p><br>
    Thanks,<br>
    <span class="signature">{{ config('app.name') }}</span>
@endcomponent

