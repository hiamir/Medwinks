<x-datatable.main
x-data="{
    applications:{},
    allApplicationsCount:0,
    reviewApplicationsCount:0,
    acceptedApplicationsCount:0,
    rejectedApplicationsCount:0,
    revisionApplicationsCount:0,
    routeName:'',
    routeName:$wire.entangle('routeName'),
    chats: $wire.entangle('chats'),
    filterRecord:$wire.entangle('filterRecord')
}"
x-init="applications={{$applications->getCollection()}}
    applicationsCount={{$applicationsCount}};
    "
>


    {{--    ADD BUTTON  --}}
    <x-datatable.insert name="Add"
                        @click.prevent=" $wire.newApplication "></x-datatable.insert>

    {{--    DATATABLE FILTER --}}
    <x-datatable.filter></x-datatable.filter>

    {{--    DATATABLE  --}}
    <x-datatable.table :dataRecord="$applications">
        <x-datatable.applications.data ></x-datatable.applications.data>
    </x-datatable.table>

    {{--                PHOTOVIEW MODAL STARTS HERE      --}}
    <x-datatable.photo-view></x-datatable.photo-view>

    {{--                CHAT MODAL STARTS HERE      --}}
    <x-datatable.chat></x-datatable.chat>

    {{--                DELETE MODAL STARTS HERE      --}}
    <x-datatable.modal.delete></x-datatable.modal.delete>
</x-datatable.main>

