@component('mail::message',['superHeader'=>'Document Decision','header'=>ucfirst($decision),'imageUrl'=>asset('storage/images/new-application.jpg')])
    <p>Dear {{$name}},</p>
    <p>The document <strong>"{{$documentName}}"</strong>@if($decision==='revision') needs @else got @endif <strong> @if($decision==='reject') rejected @endif @if($decision==='accept') accepted @endif  @if($decision==='revision') revision @endif </strong></p>
    <p>Please login to your account to find out more on your application status. @component('mail::button', ['url' => 'http://127.0.0.1:8000/login','color'=>'danger']) <span>Login</span> @endcomponent</p>
    <p>Have a wonderful day!</p>
    <span class="signature">{{ config('app.name') }}</span>
@endcomponent
