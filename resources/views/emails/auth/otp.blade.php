@component('mail::message')
# Vérification de votre compte

Merci de vous être inscrit sur MokiliEvent !

Voici votre code de vérification :

@component('mail::panel')
# {{ $otp }}
@endcomponent

Ce code est valable pendant 10 minutes.

Si vous n'avez pas créé de compte sur MokiliEvent, vous pouvez ignorer cet email.

Merci,<br>
{{ config('app.name') }}
@endcomponent
