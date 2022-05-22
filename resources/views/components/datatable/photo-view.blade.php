<x-datatable.modal.photo-view x-show="AddUpdateModal.formType==='view'">
    <img x-show="$wire.fileView !=='' &&  $wire.photoType === 'passport'" class="rounded-xl"
         :src=" ($wire.fileView !=='' &&  $wire.photoType === 'passport' ) ? '/storage/images/passports/'+$wire.fileView+'?ver='+Math.floor((Math.random()*100)+1) : '' ;  "
         alt="">

    <img  x-show="$wire.fileView !=='' &&  $wire.photoType === 'document'" class="rounded-xl"
         :src=" ($wire.fileView !=='' &&  $wire.photoType === 'document' ) ? '/storage/images/documents/'+$wire.fileView+'?ver='+Math.floor((Math.random()*100)+1) : '' ; "
         alt="">
</x-datatable.modal.photo-view>
