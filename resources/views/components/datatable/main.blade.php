<div x-data="{
    modalOpen:false,
    confirmModal:false,
    openModal: $wire.entangle('openModal'),
    toast:$wire.entangle('toastAlert'),
    toastShow: false
    }"

     x-init="
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
    ">
    {{$slot}}
    {{--    MODAL BACKDROP --}}
    <x-datatable.modal.backdrop></x-datatable.modal.backdrop>
</div>
