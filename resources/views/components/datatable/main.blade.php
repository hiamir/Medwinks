@props(['header','modalSize'])
<div
{{--    x-data="{--}}

{{--    toast:$wire.entangle('toastAlert.show'),--}}
{{--    toastShow: false--}}
{{--    }"--}}

{{--     x-init="--}}
{{--    $watch('toast',function(value){--}}
{{--         if(value.alert=='success' || value.alert=='danger'){--}}
{{--            toastShow=true;--}}
{{--            }--}}
{{--     });--}}
{{--md:h-[calc(100%_-_60px--}}

{{--    "--}}
    {{$attributes->merge(['class'=>'flex flex-col w-full items-stretch xs:h-auto )]'])}}
{{--     style="--}}
{{--height: -o-calc(100% - 60px); /* opera */--}}
{{--height: -webkit-calc(100% - 60px); /* google, safari */--}}
{{--height: -moz-calc(100% - 60px); /* firefox */--}}
{{--"--}}
>

    {{$slot}}

{{--    <x-datatable.modal.Auth header="{{$header}}" modalSize="{{$modalSize}}">--}}
{{--        <x-datatable.relogin header="Re-authentication required."></x-datatable.relogin>--}}
{{--    </x-datatable.modal.Auth>--}}



</div>
