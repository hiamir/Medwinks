@component('mail::message',['superHeader'=>'New Application','header'=>'Submission','imageUrl'=>asset('storage/images/new-application.jpg')])
    <p>Dear {{$manager_name}},</p>
    <p>You have a new application from {{$name}}.</p>
    <p>The client is requesting for <strong>"{{$serviceName}}"</strong> service.</p>
    <p>Please login to your account to find out more on this document. @component('mail::button', ['url' => 'https://login.medwinks.com/login','color'=>'danger']) <span>Login</span> @endcomponent</p>
    <p>Have a wonderful day!</p>
    <p>Good luck</p>
    <span class="signature">{{ config('app.name') }}</span>
@endcomponent
