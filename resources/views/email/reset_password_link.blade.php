<x-mail::message>


<p>This message is for your Password Reset:</p>


{{-- // WE NEED TO MODIFY THIS SO THAT AFTER GETTING MAIL WE REDIRECT TO ANOTHER CONTROLLER FROM WHERE WE PASS TOKEN AFTER THAT FROM FORM SUBMT IT TO OTHER CONTROLLER --}}
{{-- AND UPDATE FROM THAT CONTROLLER --}}

@php
    $activationLink = url('/reset-password/' . $token);
@endphp


<a href="{{ $activationLink }}">
    <button class="btn btn-danger">
       Change Your Password
    </button>
</a>
<p>
    Thank you for choosing {{ config('app.name') }}. Click the button above to reset your account password and start enjoying our services.
</p>

<p>
    If you didn't request this updation or have any questions, please contact our support team at {{ config('mail.support_email') }}.


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
