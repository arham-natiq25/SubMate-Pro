<x-mail::message>

<p>This message is for your email activation:</p>

@php
    $activationLink = url('/activation/' . $token);
@endphp


<a href="{{ $activationLink }}">
    <button class="btn btn-primary">
        Activate Your Account
    </button>
</a>
<p>
    Thank you for choosing {{ config('app.name') }}. Click the button above to activate your account and start enjoying our services.
</p>

<p>
    If you didn't request this activation or have any questions, please contact our support team at {{ config('mail.support_email') }}.
</p>

<p>Thanks,<br>
    {{ config('app.name') }}
</p>
</x-mail::message>
