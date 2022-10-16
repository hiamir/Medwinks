<x-datatable.main
x-data="{
    documents:{},
    routeName:$wire.entangle('routeName'),
    chats: $wire.entangle('chats'),
    filterDocumentRecord:$wire.entangle('filterDocumentRecord'),
    sortUser:$wire.entangle('sortUser')
    documentID:$persist($wire.entangle('documentID')),
}"
x-init="documents={{$documents->getCollection()}}
    documentsCount={{$documentsCount}};

    console.log(documents);
    "
>


{{--    --}}{{--    ADD BUTTON  --}}
{{--    <x-datatable.insert name="Add"--}}
{{--                        @click.prevent=" $wire.newDocument "></x-datatable.insert>--}}

    {{--    DATATABLE FILTER --}}
    <x-datatable.filter></x-datatable.filter>

    {{--    DATATABLE  --}}
    <x-datatable.table :dataRecord="$documents">
        <x-datatable.documents.data-table ></x-datatable.documents.data-table>
    </x-datatable.table>

    {{--                PHOTOVIEW MODAL STARTS HERE      --}}
    <x-datatable.photo-view></x-datatable.photo-view>

    {{--                CHAT MODAL STARTS HERE      --}}
    <x-datatable.chat></x-datatable.chat>

    {{--                DELETE MODAL STARTS HERE      --}}
    <x-datatable.modal.delete></x-datatable.modal.delete>
</x-datatable.main>

