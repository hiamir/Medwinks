@props(['header','modalSize'])
<div x-data="{
    modalOpen:false,
    confirmModal:false,
    openModal: $wire.entangle('openModal'),
    toast:$wire.entangle('toastAlert'),
    toastShow: false
    }"

     x-init="
     modalOpen=openModal;
    $watch('toast',function(value){
         if(value.alert=='success' || value.alert=='danger'){
            toastShow=true;
            }
     });
     $watch('openModal',function(value){
         if(!value){
            modalOpen=false;
            }
    });
    "

>

    {{$slot}}

{{--    <x-datatable.modal.Auth header="{{$header}}" modalSize="{{$modalSize}}">--}}
{{--        <x-datatable.relogin header="Re-authentication required."></x-datatable.relogin>--}}
{{--    </x-datatable.modal.Auth>--}}


    {{--    MODAL BACKDROP --}}
    <x-datatable.modal.backdrop></x-datatable.modal.backdrop>
</div>
