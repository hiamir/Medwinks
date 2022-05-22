<x-datatable.main
    x-data="{
        universities: null,
        universityRecord: {},
    }"
    x-init="
        errors={{$errors}}
        errorCount= {{ count($errors) }}
        universities={{$records->getCollection()}};
    "
>


    {{--    ADD BUTTON  --}}
    <x-datatable.insert name="Add" @click.prevent="MyModal('add','university',{'formData':{} }); universityRecord={}"></x-datatable.insert>

    {{--    DATATABLE FILTER --}}
    <x-datatable.filter></x-datatable.filter>

    {{--    DATATABLE  --}}
    <x-datatable.table :dataRecord="$records">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3" width="40%">
                    University
                </th>
                <th scope="col" class="px-6 py-3 text-center" width="10%">
                    Abbreviation
                </th>
                <th scope="col" class="px-6 py-3 text-center" width="20%">
                    Created on
                </th>
                <th scope="col" class="px-6 py-3 text-center" width="20%">
                    Updated on
                </th>
                <th scope="col" class="px-6 py-3 text-right" width="10%">
                    Action
                </th>
            </tr>
            </thead>
            <template x-for="university in universities">
               <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td x-text="university.name" scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"></td>
                    <td x-text="university.abbreviation" scope="row" class="px-6 py-4 text-center"></td>
                    <td class="px-6 py-4 text-center"><span x-text="university.created_at"></span></td>
                    <td class="px-6 py-4 text-center"><span x-text="university.updated_at"></span></td>
                    <td class="px-8 py-4 text-right space-x-2 overflow-hidden">
                        <div class="flex flex-row justify-end">
                            <x-datatable.update-icon class="mx-1"
                                                     @click.prevent="MyModal('update','university',{'formData':university});  universityRecord=university;"></x-datatable.update-icon>
                            <x-datatable.delete-icon class="ml-1"
                                                     @click.prevent="MyModal('delete','university',{'formData':university});"></x-datatable.delete-icon>
                        </div>
                    </td>
                </tr>
                </tbody>
            </template>
            <tbody x-show="universities.length === 0 ">
            <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
                <td colspan="6" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"> No
                    records available!
                </td>
            </tr>
            </tbody>
        </table>
    </x-datatable.table>

    <x-datatable.modal.add-update  x-show="modalDetails.formType==='university'">
        <x-form wire:submit.prevent="submit" class="space-y-6" novalidate autocomplete="off">

            <div class="mt-4">
                <x-label for="University name" :value="__('University name')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="university.name"
                             x-bind:value="(errorCount === 0) ? universityRecord.name : $wire.university.name"
                             name="name"
                             placeholder="Enter a unique university name"
                    ></x-input>
                </div>
                <x-forms.form-error field="university.name"></x-forms.form-error>
            </div>


            <div class="mt-4">
                <x-label for="Abbreviation" :value="__('Abbreviation')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="university.abbreviation"
                             x-bind:value="(errorCount === 0) ? universityRecord.abbreviation : $wire.university.abbreviation" name="abbreviation"
                             placeholder="Enter a unique university abbreviation"
                    ></x-input>
                </div>
                <x-forms.form-error field="university.abbreviation"></x-forms.form-error>
            </div>

            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>

        </x-form>
    </x-datatable.modal.add-update>


    {{--                DELETE MODAL STARTS HERE      --}}
    <x-datatable.modal.delete></x-datatable.modal.delete>
</x-datatable.main>

