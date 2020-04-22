@component('mail::message')
#  ######## Team
 

<p> Bienvenue chez Nous Cher client {{ $data['name'] }} </p>
<p>Votre login est:{{ $data['login'] }}</p>
<p>your password is :{{ $data['password'] }}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
