@component('mail::message',['superHeader'=>'New Application','header'=>'Submission','imageUrl'=>asset('storage/images/new-application.jpg')])
    <p>Dear {{$name}},</p>
    <p>We’ve got your application.</p>
    <p>You have requested for <strong>"{{$serviceName}}"</strong> service. One of our team member will review your application and email the decision on your submitted documents. The response will be sent to the email address you’ve indicated within 1 business days. If it’s urgent, we encourage you to call us at 800 000 00 00.</p>
    <p>Have a wonderful day!</p>
    <p>Good luck</p>
    <span class="signature">{{ config('app.name') }}</span>
@endcomponent
