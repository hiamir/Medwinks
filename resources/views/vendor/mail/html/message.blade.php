@component('mail::layout')
    {{-- Header --}}
    @slot('header')

        {{-- logo --}}
        @component('mail::logo', ['url' => asset('storage/images/logo.svg'),'href'=>'www.medwinks.com','preheader'=>'Medwinks']) @endcomponent

        {{-- Image --}}
        @component('mail::image', ['url' => $imageUrl,'href'=>'http://127.0.0.1:8000/login'])  @endcomponent

        {{-- Super Header --}}
        @component('mail::superheader') {{$superHeader}} @endcomponent

        {{-- Header --}}
        @component('mail::header') {{$header}} @endcomponent

        @component('mail::underline') @endcomponent
    @endslot

    {{-- Body --}}
    {{$slot}}
{{--    {{ Illuminate\Mail\Markdown::parse($slot) }}--}}


    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
        @endcomponent
    @endslot
@endcomponent
