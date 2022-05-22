<x-datatable.main
    x-data="{
        serviceRequirementRecord: {},
        serviceShow:null,
        serviceRequirements:{},
        serviceRequirementID:$wire.entangle('serviceRequirementID'),
    }"
    x-init="
        errors={{$errors}}
        errorCount= {{ count($errors) }}
        serviceRequirements={{$records->getCollection()}}
    "
>


    {{--    ADD BUTTON  --}}
    <x-datatable.insert name="Add"
                        @click.prevent="MyModal('add','service-requirement',{'formData':{} }); serviceRequirementRecord={}"></x-datatable.insert>

    {{--    DATATABLE FILTER --}}
    <x-datatable.filter></x-datatable.filter>

    {{--    DATATABLE  --}}
    <x-datatable.table :dataRecord="$records">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3" width="20%">
                    Service Requirement
                </th>

                <th scope="col" class="px-6 py-3 text-center max-w-md"  width="40%">
                    Description
                </th>
                <th scope="col" class="px-6 py-3 text-center"  width="15%">
                    Created on
                </th>
                <th scope="col" class="px-6 py-3 text-center" width="15%">
                    Updated on
                </th>
                <th scope="col" class="px-6 py-3 text-right"  width="10%">
                    Action
                </th>
            </tr>
            </thead>
            <template x-for="requirement in serviceRequirements">
                <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td x-text="requirement.name" scope="row"
                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"></td>
                    <td x-text="requirement.description" scope="row"
                        class="px-6 py-4 font-medium text-center "></td>
                    <td class="px-6 py-4 text-center"><span x-text="requirement.created_at"></span></td>
                    <td class="px-6 py-4 text-center"><span x-text="requirement.updated_at"></span></td>
                    <td class="px-8 py-4 text-right space-x-2 overflow-hidden">
                        <div class="flex flex-row justify-end">
                            <x-datatable.update-icon class="mx-1"
                                                     @click.prevent="MyModal('update','service-requirement',{'formData':requirement});  serviceRequirementRecord=requirement;"></x-datatable.update-icon>
                            <x-datatable.delete-icon class="ml-1"
                                                     @click.prevent="MyModal('delete','service-requirement',{'formData':requirement});"></x-datatable.delete-icon>
                        </div>
                    </td>
                </tr>
                </tbody>
            </template>
            <tbody x-show="serviceRequirements.length === 0 ">
            <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
                <td colspan="6" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"> No
                    records available!
                </td>
            </tr>
            </tbody>
        </table>
    </x-datatable.table>



    <x-datatable.modal.add-update x-show="modalDetails.formType==='service-requirement'">
        <x-form wire:submit.prevent="submit" class="space-y-6" novalidate autocomplete="off">

            <div class="mt-4">
                <x-label for="Service Requirement name" :value="__('serviceRequirement name')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="serviceRequirement.name"
                             x-bind:value="(errorCount === 0) ? serviceRequirementRecord.name : $wire.serviceRequirement.name"
                             name="serviceRequirement_name"
                             placeholder="Enter a unique service Requirement name"
                    ></x-input>
                </div>
                <x-forms.form-error field="serviceRequirement.name"></x-forms.form-error>
            </div>

            <div class="mt-4">
                <x-label for="Service Requirement description" :value="__('serviceRequirement description')"></x-label>
                <div class="relative">

                    <x-textarea wire:model.defer="serviceRequirement.description"
                                x-bind:value="(errorCount === 0) ? serviceRequirementRecord.description : $wire.serviceRequirement.description"
                                name="serviceRequirement_description"
                                placeholder="Enter service requirement description"
                    ></x-textarea>
                </div>
                <x-forms.form-error field="serviceRequirement.description"></x-forms.form-error>
            </div>

            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>

        </x-form>
    </x-datatable.modal.add-update>

    {{--                DELETE MODAL STARTS HERE      --}}
    <x-datatable.modal.delete></x-datatable.modal.delete>
</x-datatable.main>

