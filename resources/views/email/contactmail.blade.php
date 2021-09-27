@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            @lang('email.contact.subject')
        @endcomponent
    @endslot
{{-- Body --}}
    <p>@lang('app.email') - {{ $email->email }}<br>
    @lang('app.name') - {{ $email->name }}</p>
    {{ $email->message }}
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
            © {{ date('Y') }} {{ config('app.name') }}.
        @endcomponent
    @endslot
@endcomponent