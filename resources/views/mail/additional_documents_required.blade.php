@component('mail::message',['superHeader'=>'Additional Requirements','header'=>ucfirst('Requirement'),'imageUrl'=>asset('storage/images/new-application.jpg')])
    <p>Dear {{$name}},</p>
    <p>Your application for the service <strong>"{{$serviceName}}"</strong> required other documents inorder to process.
        your application.</p>
    <p><strong>Required documents</strong></p>
    <ul>
        @foreach($requirements as $requirement)
            <li>{{$requirement->name}}</li>
        @endforeach
    </ul>
    <p>Please login to your account to find out more on your application status. @component('mail::button', ['url' => 'http://127.0.0.1:8000/login','color'=>'danger']) <span>Login</span> @endcomponent</p>
    <p>Have a wonderful day!</p>
    <span class="signature">{{ config('app.name') }}</span>
@endcomponent
