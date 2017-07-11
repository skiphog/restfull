@component('mail::message')
# Привет {{ $user->name }}
Пожалуйста, подтвердите ваш new email.
@component('mail::button', ['url' => route('verify', $user->verification_token)])
Подтвердить
@endcomponent
Спасибо, <br>
{{ config('app.name') }}
@endcomponent