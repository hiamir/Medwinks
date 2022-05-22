@component('mail::message',['superHeader'=>'Document Updated','header'=>'Update','imageUrl'=>asset('storage/images/new-application.jpg')])
    <p>Dear {{$name}},</p>
    <p>The document <strong>{{$documentName}}</strong> was updated!</p>
    <p>Please login to your account to find out more on your application status. @component('mail::button', ['url' => 'http://127.0.0.1:8000/login','color'=>'danger']) <span>Login</span> @endcomponent</p>
    <p>Have a wonderful day!</p>
    <span class="signature">{{ config('app.name') }}</span>
@endcomponent
