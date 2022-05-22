@component('mail::message',['superHeader'=>'New Member','header'=>'Welcome','imageUrl'=>asset('storage/images/welcome.jpg')])
    <p>Dear {{$name}},</p>
    <p>We’re sending this email to confirm that your account at Editorial Manager was created successfully.</p>
    <p>Your registration details:</p>
    <p>
    <div class="message-table">
        <table >
        <tr>
            <td class="left-title">Username:</td>
            <td class="right-value">{{$email}}</td>
        </tr>
        <tr>
            <td class="left-title">Password:</td>
            <td class="right-value">{{$password}}</td>
        </tr>
    </table>
    </div>
    </p>
    <p>Please change your password once you log-in</p>
    <p> We&#8217;re glad you&#8217;re here!</p>
    <span class="signature">{{ config('app.name') }}</span>
@endcomponent
