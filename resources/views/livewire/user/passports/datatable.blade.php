@inject('Data', 'App\Http\Livewire\User\Passports\Datatable')
<x-datatable.main
    x-data=" Passport($wire,{ 'passports': {}}) "
    x-init="
        passports={{$records->getCollection()}}
        countries={{$countries}}
        "
>

    {{--    DATATABLE FILTER --}}
    <x-datatable.filter></x-datatable.filter>

    {{--    DATATABLE  --}}
    <x-datatable.table :dataRecord="$records">
        <div class="flex bg-gray-900 rounded-xl">
            <x-datatable.passports.data></x-datatable.passports.data>
        </div>
        <div class="block mt-3">
        {{$records->links()}}
        </div>
    </x-datatable.table>

    {{--                PASSPORT ADDUPDATE MODAL STARTS HERE      --}}
    <x-datatable.passports.create-update></x-datatable.passports.create-update>

    {{--                PHOTOVIEW MODAL STARTS HERE      --}}
    <x-datatable.photo-view></x-datatable.photo-view>

    {{--                CONFIRMATION MODAL STARTS HERE      --}}
    <x-datatable.modal.confirmation>
        <template x-if="documentType === 'passport' &&  (confirmationType === 'accept' || confirmationType === 'reject') ">
            <span
                class="flex justify-center items-center border border-red-500 bg-red-600 rounded-lg px-4 py-2 my-3 mt-4">
            <p class="flex font-bold text-white text-xs w-full text-center"
               x-text="'NOTE: This will be the final decision on this application. Once committed, the process cannot be reversed'"></p>
                </span>
        </template>
        <div class="flex lg:w-2xl flex-col p-3 mt-4 w-full border border-gray-700 rounded-2xl">
            <x-bundle.textarea x-data="commentsData" class="flex  flex-col w-full"><textarea class="flex min-w-2xl"
                                                                                             x-bind="bindComments"></textarea>
            </x-bundle.textarea>
        </div>
        <template x-if="documentType === 'document'">
            <div class="flex w-full items-center p-4 mt-4 rounded-2xl border border-gray-200 dark:border-gray-700"
                 :class="{ 'bg-red-600 dark:bg-gray-900 border-gray-200 dark:border-gray-700' : rejectCheckbox===true, 'bg-gray-600 dark:bg-gray-800/[0.5] border-gray-500 dark:border-gray-700' : rejectCheckbox===false}"
            >
                <input @change="$wire.rejectCheckbox" id="link-checkbox" x-model="rejectCheckbox" type="checkbox"
                       value=""
                       class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="link-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">No, I would
                    like to<span class="py-4 mx-1 w-full text-sm font-bold text-red-900 dark:text-red-500"
                                 :class="{ 'text-yellow-400' : rejectCheckbox === true }"
                    >Reject</span>this application completely.</label>
            </div>
        </template>
    </x-datatable.modal.confirmation>


    {{--                CHAT MODAL STARTS HERE      --}}
    <x-datatable.chat></x-datatable.chat>

    {{--                DELETE MODAL STARTS HERE      --}}
    <x-datatable.modal.delete ></x-datatable.modal.delete>
</x-datatable.main>}

