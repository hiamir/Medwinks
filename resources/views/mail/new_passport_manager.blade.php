@component('mail::message',['superHeader'=>'New passport','header'=>'New','imageUrl'=>asset('storage/images/new-application.jpg')])
    <p>Dear Manager,</p>
    <p>You have a new passport was added to review from <strong>"{{$name}}"</strong>.</p>
    <p>Please login to your account to find out more on this document. @component('mail::button', ['url' => 'https://login.medwinks.com/login','color'=>'danger']) <span>Login</span> @endcomponent</p>
    <p>Have a wonderful day!</p>
    <span class="signature">{{ config('app.name') }}</span>
@endcomponent
