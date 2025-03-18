@component('mail::message')
# Nouveau message de contact

**De :** {{ $data['name'] }}  
**Email :** {{ $data['email'] }}  
**Sujet :** {{ $data['subject'] }}

**Message :**  
{{ $data['message'] }}

---
Ce message a été envoyé via le formulaire de contact de {{ config('app.name') }}.
@endcomponent
