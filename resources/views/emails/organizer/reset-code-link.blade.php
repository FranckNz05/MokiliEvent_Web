@component('mail::message')
# Réinitialisation de votre code organisateur

Bonjour,

Vous avez demandé la réinitialisation de votre code organisateur sur {{ $platformName }}.

Pour procéder à la réinitialisation, veuillez cliquer sur le bouton ci-dessous. Ce lien est valable pendant {{ $expiryHours }} heures.

@component('mail::button', ['url' => $resetUrl])
Réinitialiser mon code
@endcomponent

Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer cet email.

Cordialement,<br>
L'équipe {{ $platformName }}

@component('mail::subcopy')
Si le bouton ne fonctionne pas, copiez et collez ce lien dans votre navigateur : {{ $resetUrl }}
@endcomponent
@endcomponent
