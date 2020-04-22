@component('mail::message')
# L'equipe de ########

Bienvenue parmi notre equipe de Travail
<p>Votre login est:{{ $data['login'] }}</p>
<p>Votre Mot de passe est:{{ $data['password'] }}</p>
<p>Votre role dans notre projet est:{{ $data['role']}}</p>


Thanks,<br>


{{ config('app.name') }}
@endcomponent