@component('mail::message',['superHeader'=>ucfirst('Application Decision'),'header'=>ucfirst($decision),'imageUrl'=>asset('storage/images/new-application.jpg')])
    <p>Dear {{$name}},</p>
    <p>The decision for your document for the requested service was made</p>
    @switch($decision)
        @case ('accept')
            <p>The Application for <strong>"{{$serviceName}}"</strong> got <strong> accepted. </strong></p>
        @break;
        @case ('reject')
            <p>The Application for <strong>"{{$serviceName}}"</strong> got <strong> rejected. </strong></p>
        @break;
        @case ('revision')
        <p>The Application for <strong>"{{$serviceName}}"</strong> needs <strong> revision. </strong></p>
        @break;
    @endswitch
    <p>Please login to your account to find out more on your application status. @component('mail::button', ['url' => 'http://127.0.0.1:8000/login','color'=>'danger']) Login @endcomponent </p>
    <p>Have a wonderful day!</p>
    <span class="signature">{{ config('app.name') }}</span>
@endcomponent
