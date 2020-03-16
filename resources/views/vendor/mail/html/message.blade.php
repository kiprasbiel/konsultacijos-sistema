@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header')
            VŠĮ "Promas LT"
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}
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
            {{ date('Y') }} VŠĮ "Promas LT"
        @endcomponent
    @endslot
@endcomponent
