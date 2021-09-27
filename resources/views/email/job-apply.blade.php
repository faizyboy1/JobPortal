@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
        {{ $job_application->company->company_name }}
        @endcomponent
    @endslot

@lang('email.newJobApplication.subject')
@component('mail::text', ['text' => $content])

@endcomponent

@component('mail::button', ['url' => $url])
    {{ $buttonText }}
@endcomponent

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>{{ $job_application->company->company_name }}
@endif

{{-- Subcopy --}}
@isset($url)
@slot('subcopy')
@component('mail::subcopy')
@lang(
"If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
'into your web browser: [:actionURL](:actionURL)',
[
'actionText' => $buttonText,
'actionURL' => $url
]
)
@endcomponent
@endslot
@endisset
{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ $job_application->company->company_name }}.
        @endcomponent
    @endslot
@endcomponent

