@component('mail::message')

<!-- Title of mail -->
# {{ $details['title'] ?? '' }}

@if (isset($details['panel']) && $details['panel']!='')
@component('mail::panel')
{{ $details['panel'] ?? ''}}
@endcomponent
@endif

{{ $details['body'] ?? ''}}
@if (isset($details['link']) && $details['link'] !='' && isset($details['link_title']) && $details['link_title'] != '')
@component('mail::button', ['url' => $details['link']])
{{ $details['link_title'] }}
@endcomponent
@endif

Thanks,<br>
{{ config('app.name') ?? '' }}
@endcomponent
