@component('mail::message')
# Votre nouveau code organisateur

Bonjour,

Suite à votre demande, voici votre nouveau code organisateur pour {{ $platformName }} :

@component('mail::panel')
{{ $newCode }}
@endcomponent

Utilisez ce code pour vous connecter à l'application mobile. Pour des raisons de sécurité, nous vous recommandons de ne pas partager ce code.

Si vous n'êtes pas à l'origine de cette demande, veuillez contacter immédiatement notre support.

Cordialement,<br>
L'équipe {{ $platformName }}
@endcomponent
