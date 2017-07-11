@component('mail::message')
# Привет {{ $user->name }}
Спасибо за регистрацию.
Пожалуйста, подтвердите ваш email:

@component('mail::button', ['url' => route('verify', $user->verification_token)])
Подтвердить
@endcomponent

Спасибо,<br>
{{ config('app.name') }}
@endcomponent