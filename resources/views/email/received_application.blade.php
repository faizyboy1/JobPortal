@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
        {{ $jobApplication->company->company_name }}
        @endcomponent
    @endslot
{{-- Body --}}
    @lang('email.hello') {{ $jobApplication->full_name }}!

    @lang('email.applicationReceived.text')
{{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset
{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ $jobApplication->company->company_name }}.
        @endcomponent
    @endslot
@endcomponent