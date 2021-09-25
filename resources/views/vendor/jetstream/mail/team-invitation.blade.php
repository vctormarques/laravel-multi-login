@component('mail::message')
{{ __('Você foi convidade para se juntar à :team equipe!', ['team' => $invitation->team->name]) }}

@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
{{ __('Se você não possui uma conta, você pode criar uma clicando no botão abaixo. Depois de criar uma conta, você pode clicar no botão de aceitação do convite neste e-mail para aceitar o convite da equipe:') }}

@component('mail::button', ['url' => route('register')])
{{ __('Criar uma contax') }}
@endcomponent

{{ __('Se você já possui uma conta, pode aceitar este convite clicando no botão abaixo:') }}

@else
{{ __('Você pode aceitar este convite clicando no botão abaixo:') }}
@endif


@component('mail::button', ['url' => $acceptUrl])
{{ __('Aceitar Convite') }}
@endcomponent

{{ __('Se você não esperava receber um convite para esta equipe, pode descartar este e-mail.') }}
@endcomponent
