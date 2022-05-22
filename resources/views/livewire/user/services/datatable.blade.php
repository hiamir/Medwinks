<x-datatable.main
    x-data="{
        services: null,
        serviceRecord: {},
        serviceRequirementRecord: {},
        serviceShow:null,
        serviceRequirementID:$wire.entangle('serviceRequirementID'),
        requirements:{},
        clickedServiceID:$wire.entangle('clickedServiceID'),
selectedCheckbox : []
    }"
    x-init="
        errors={{$errors}}
        errorCount= {{ count($errors) }}
        services={{$records->getCollection()}}
        requirements={{$requirements}}
        console.log(requirements);
"
>


    {{--    ADD BUTTON  --}}
    <x-datatable.insert name="Add"
                        @click.prevent="MyModal('add','service',{'formData':{} }); serviceRecord={}"></x-datatable.insert>

    {{--    DATATABLE FILTER --}}
    <x-datatable.filter></x-datatable.filter>

    {{--    DATATABLE  --}}
    <x-datatable.table :dataRecord="$records">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3" width="30%">
                    Service
                </th>
                <th scope="col" class="px-6 py-3 text-center" width="20%">
                    Abbreviation
                </th>
                <th scope="col" class="px-6 py-3 text-center" width="10%">
                    Service Requirements
                </th>
                <th scope="col" class="px-6 py-3 text-center" width="15%">
                    Created on
                </th>
                <th scope="col" class="px-6 py-3 text-center" width="15%">
                    Updated on
                </th>
                <th scope="col" class="px-6 py-3 text-right" width="10%">
                    Action
                </th>
            </tr>
            </thead>
            <template x-for="service in services">
                <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td x-text="service.name" scope="row"
                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"></td>
                    <td x-text="service.abbreviation" scope="row"
                        class="px-6 py-4 font-medium text-center  text-gray-900 dark:text-white whitespace-nowrap"></td>
                    <td class="px-6 py-4 text-center ">
                        <x-svg.main x-show="serviceShow != service.id"
                                    @click.prevent="serviceShow = serviceShow === service.id ? null :  serviceShow = service.id; clickedServiceID=service.id"
                                    type="arrow-circle-down"></x-svg.main>
                        <x-svg.main x-show="serviceShow === service.id"
                                    @click.prevent="serviceShow = serviceShow === service.id ? null :  serviceShow = service.id "
                                    type="arrow-circle-up"></x-svg.main>
                    </td>
                    <td class="px-6 py-4 text-center"><span x-text="service.created_at"></span></td>
                    <td class="px-6 py-4 text-center"><span x-text="service.updated_at"></span></td>
                    <td class="px-8 py-4 text-right space-x-2 overflow-hidden">
                        <div class="flex flex-row justify-end">
                            <x-datatable.update-icon class="mx-1"
                                                     @click.prevent="MyModal('update','service',{'formData':service});  serviceRecord=service;"></x-datatable.update-icon>
                            <x-datatable.delete-icon class="ml-1"
                                                     @click.prevent="MyModal('delete','service',{'formData':service});"></x-datatable.delete-icon>
                        </div>
                    </td>
                </tr>


                <tr

                    :class="{'table-row':serviceShow === service.id,  'hidden':serviceShow != service.id }"
                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                    <td colspan="9" class="px-6 py-4 text-center">
                        <div class="flex flex-col justify-center items-center">
                         <div class="flex border border-yellow-500 rounded-3xl px-3 py-1 bg-yellow-400 text-gray-900 font-semibold text-xs mb-3" x-text="'Required Documents'"> </div>
                            <div class="flex flex-row justify-center items-center">
                            <template x-for="requirement in requirements" :key="requirement.id">
                                <div

                                    x-data="{ 'selectedCheckbox' : [] }"
                                    x-init="
                                        selectedCheckbox=[];
                                        service.requirements.forEach(function(val){
                                        selectedCheckbox.push(val.id);
                                    });

                                        "
                                    class="flex justify-center items-center">
                                    <div class="flex items-center mr-5">
                                        <input  @change="$wire.updateRequirements(service.id,selectedCheckbox);" x-model="selectedCheckbox" :id="'requirement-' + service.id + '-' + requirement.id" type="checkbox" :value="requirement.id"
                                               class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label :id="'requirement-label-' + service.id + '-' + requirement.id" for="inline-checkbox"
                                               class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300" x-text="requirement.name"> </label>
                                    </div>
                                </div>
                            </template>
                            </div>
                        </div>
                    </td>
                </tr>


                </tbody>
            </template>
            <tbody x-show="services.length === 0 ">
            <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
                <td colspan="6" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"> No
                    records available!
                </td>
            </tr>
            </tbody>
        </table>
    </x-datatable.table>

    <x-datatable.modal.add-update x-show="modalDetails.formType==='service'">
        <x-form wire:submit.prevent="submit" class="space-y-6" novalidate autocomplete="off">

            <div class="mt-4">
                <x-label for="Service name" :value="__('Service name')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="service.name"
                             x-bind:value="(errorCount === 0) ? serviceRecord.name : $wire.service.name"
                             name="name"
                             placeholder="Enter a unique service name"
                    ></x-input>
                </div>
                <x-forms.form-error field="service.name"></x-forms.form-error>
            </div>

            <div class="mt-4">
                <x-label for="Service abbreviation" :value="__('Service abbreviation')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="service.abbreviation"
                             x-bind:value="(errorCount === 0) ? serviceRecord.abbreviation : $wire.service.abbreviation"
                             name="abbreviation"
                             placeholder="Enter a unique service abbreviation"
                    ></x-input>
                </div>
                <x-forms.form-error field="service.abbreviation"></x-forms.form-error>
            </div>

            <div class="mt-4">
                <x-label for="service description" :value="__('service description')"></x-label>
                <div class="relative">
                    <x-textarea wire:model.defer="service.description"
                                x-bind:value="(errorCount === 0) ? serviceRecord.description : $wire.service.description"
                                name="service_description"
                                placeholder="Enter service description"
                    ></x-textarea>
                </div>
                <x-forms.form-error field="service.description"></x-forms.form-error>
            </div>

            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>

        </x-form>
    </x-datatable.modal.add-update>


    <x-datatable.modal.add-update x-show="modalDetails.formType==='serviceRequirement'">
        <x-form wire:submit.prevent="submit" class="space-y-6" novalidate autocomplete="off">


            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>

        </x-form>
    </x-datatable.modal.add-update>

    {{--                DELETE MODAL STARTS HERE      --}}
    <x-datatable.modal.delete></x-datatable.modal.delete>
</x-datatable.main>

