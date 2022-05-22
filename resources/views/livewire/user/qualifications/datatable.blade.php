<x-datatable.main
    x-data="{
        qualifications: null,
        qualificationRecord: {},
        degreeRecord: {},
        degreesShow:null,
        degreeQualificationID:$wire.entangle('degreeQualificationID'),
    }"
    x-init="
        errors={{$errors}}
        errorCount= {{ count($errors) }}
        qualifications={{$records->getCollection()}};
    "
>


    {{--    ADD BUTTON  --}}
    <x-datatable.insert name="Add" @click.prevent="MyModal('add','qualification',{'formData':{} }); qualificationRecord={}"></x-datatable.insert>

    {{--    DATATABLE FILTER --}}
    <x-datatable.filter></x-datatable.filter>

    {{--    DATATABLE  --}}
    <x-datatable.table :dataRecord="$records">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Qualification
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Degrees
                </th>

                <th scope="col" class="px-6 py-3 text-center">
                    Position
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Created on
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Updated on
                </th>
                <th scope="col" class="px-6 py-3 text-right">
                    Action
                </th>
            </tr>
            </thead>
            <template x-for="qualification in qualifications">
               <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td x-text="qualification.name" scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"></td>
                    <td class="px-6 py-4 text-center ">
                        <x-svg.main x-show="degreesShow != qualification.id"
                                    @click.prevent="degreesShow = degreesShow === qualification.id ? null :  degreesShow = qualification.id; degreeQualificationID=qualification.id"
                                    type="arrow-circle-down"></x-svg.main>
                        <x-svg.main x-show="degreesShow === qualification.id"
                                    @click.prevent="degreesShow = degreesShow === qualification.id ? null :  degreesShow = qualification.id "
                                    type="arrow-circle-up"></x-svg.main>
                    </td>
                    <td x-text="qualification.position" scope="row" class="px-6 py-4 text-center"></td>
                    <td class="px-6 py-4 text-center"><span x-text="qualification.created_at"></span></td>
                    <td class="px-6 py-4 text-center"><span x-text="qualification.updated_at"></span></td>
                    <td class="px-8 py-4 text-right space-x-2 overflow-hidden">
                        <div class="flex flex-row justify-end">
                            <x-datatable.update-icon class="mx-1"
                                                     @click.prevent="MyModal('update','qualification',{'formData':qualification});  qualificationRecord=qualification;"></x-datatable.update-icon>
                            <x-datatable.delete-icon class="ml-1"
                                                     @click.prevent="MyModal('delete','qualification',{'formData':qualification});"></x-datatable.delete-icon>
                        </div>
                    </td>
                </tr>



                <tr
                    :class="{'table-row':degreesShow === qualification.id,  'hidden':degreesShow != qualification.id }"
                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                    <td  colspan="9" class="px-6 py-4 text-center">
                         <span
                             @click.prevent="MyModal('add','degree',{'formData':qualification}); degreeRecord={}"
                             x-text="'Add Degree'"
                             class="cursor-pointer border rounded-2xl border-blue-800 text-gray-200
                             text-xs px-4 py-2 hover:text-gray-200 bg-blue-800 hover:bg-blue-900">
                         </span>

                        <template x-for="degree in qualification.degrees">
                            <div class="flex inline-flex">

                                <x-datatable.sub-delete-icon>

                                                        <span
                                                            @click.prevent="MyModal('update','degree',{'formData':degree}); degreeRecord=degree"
                                                            class="flex ml-1 relative z-0  py-1.5 ">
                                                            <span x-text="degree.name"></span></span>
                                    <x-svg.main type="delete"
                                                @click.prevent="MyModal('delete','degree',{'formData':degree});"
                                                class="flex relative z-50 ml-2 dark:hover:text-gray-200"
                                    ></x-svg.main>

                                </x-datatable.sub-delete-icon>
                            </div>
                        </template>
                    </td>
                </tr>






                </tbody>
            </template>
            <tbody x-show="qualifications.length === 0 ">
            <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
                <td colspan="6" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"> No
                    records available!
                </td>
            </tr>
            </tbody>
        </table>
    </x-datatable.table>

    <x-datatable.modal.add-update  x-show="modalDetails.formType==='qualification'">
        <x-form wire:submit.prevent="submit" class="space-y-6" novalidate autocomplete="off">

            <div class="mt-4">
                <x-label for="Qualification name" :value="__('Qualification name')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="qualification.name"
                             x-bind:value="(errorCount === 0) ? qualificationRecord.name : $wire.qualification.name"
                             name="name"
                             placeholder="Enter a unique qualification name"
                    ></x-input>
                </div>
                <x-forms.form-error field="qualification.name"></x-forms.form-error>
            </div>



            <div class="mt-4">
                <x-label for="Position" :value="__('Position')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="qualification.position"
                             x-bind:value="(errorCount === 0) ? qualificationRecord.position : $wire.qualification.position" name="position"
                             placeholder="Enter a unique position number"
                    ></x-input>
                </div>
                <x-forms.form-error field="qualification.position"></x-forms.form-error>
            </div>

            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>

        </x-form>
    </x-datatable.modal.add-update>


    <x-datatable.modal.add-update  x-show="modalDetails.formType==='degree'">
        <x-form wire:submit.prevent="submit" class="space-y-6" novalidate autocomplete="off">

            <div class="mt-4">
                <x-label for="Degree name" :value="__('Degree name')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="degree.name"
                             x-bind:value="(errorCount === 0) ? degreeRecord.name : $wire.degree.name"
                             name="degree_name"
                             placeholder="Enter a unique degree name"
                    ></x-input>
                </div>
                <x-forms.form-error field="degree.name"></x-forms.form-error>
            </div>

            <div class="mt-4">
                <x-label for="Degree acronym" :value="__('Degree acronym')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="degree.acronym"
                             x-bind:value="(errorCount === 0) ? degreeRecord.acronym : $wire.degree.acronym"
                             name="degree_acronym"
                             placeholder="Enter a unique degree acronym"
                    ></x-input>
                </div>
                <x-forms.error x-text="errors.acronym"></x-forms.error>
                <x-forms.form-error field="degree.acronym"></x-forms.form-error>
            </div>

            <div class="mt-4">
                <x-label for="Position" :value="__('Position')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="degree.position"
                             x-bind:value="(errorCount === 0) ? degreeRecord.position : $wire.degree.position"
                             name="degree_position"
                             placeholder="Enter a unique position number"
                    ></x-input>
                </div>
                <x-forms.form-error field="degree.position"></x-forms.form-error>
            </div>

            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>

        </x-form>
    </x-datatable.modal.add-update>

    {{--                DELETE MODAL STARTS HERE      --}}
    <x-datatable.modal.delete></x-datatable.modal.delete>
</x-datatable.main>

