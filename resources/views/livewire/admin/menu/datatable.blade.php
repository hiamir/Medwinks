<x-datatable.main
    x-data="{
        menus: null,
        permissionRecord:$wire.entangle('menu'),
    }"
    x-init="
        errorCount= {{ count($errors) }}
        menus={{$records->getCollection()}};
        console.log(menus);
    "
>


    {{--    ADD BUTTON  --}}
    <x-datatable.insert name="Add" @click.prevent="MyModal('add','menu',{'formData':{} });"></x-datatable.insert>

    {{--    DATATABLE FILTER --}}
    <x-datatable.filter></x-datatable.filter>

    {{--    DATATABLE  --}}
    <x-datatable.table :dataRecord="$records">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Svg
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Sort
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
            <template x-for="menu in menus">
                </tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td x-text="menu.name" scope="row"
                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"></td>
                    <td  scope="row" class="px-6 py-4 text-center"> <x-svg.main x-data="{svg:menu.svg}" type="alpine"> </x-svg.main> </td>
                    <td x-text="menu.sort" scope="row" class="px-6 py-4 text-center"></td>
                    <td x-text="menu.created_at" class="px-6 py-4 text-center"></td>
                    <td x-text="menu.updated_at" class="px-6 py-4 text-center"></td>
                    <td class="px-8 py-4 text-right space-x-2 overflow-hidden">
                        <div class="flex flex-row justify-end">
                            <x-datatable.update-icon class="mx-1"
                                                     @click.prevent="MyModal('update','menu',{'formData':menu});"></x-datatable.update-icon>
                            <x-datatable.delete-icon class="ml-1"
                                                     @click.prevent="MyModal('delete','menu',{'formData':menu});"></x-datatable.delete-icon>
                        </div>
                    </td>
                </tr>
                </tbody>
            </template>
        </table>
    </x-datatable.table>

    <x-datatable.modal.add-update>
        <x-form wire:submit.prevent="submit" class="space-y-6" novalidate autocomplete="off">
            <div class="mt-4">
                <x-label for="Manu name" :value="__('Menu name')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="menu.name"
                             x-bind:value="(errorCount === 0) ? dataRecord.name : $wire.menu.name" name="name"
                             placeholder="Enter a unique menu name"
                    ></x-input>
                </div>
                <x-forms.form-error field="menu.name"></x-forms.form-error>
            </div>
            <div class="mt-4">
                <x-label for="Svg icon" :value="__('Menu name')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="menu.svg"
                             x-bind:value="(errorCount === 0) ? dataRecord.svg : $wire.menu.svg" name="svg"
                             placeholder="Enter a svg name"
                    ></x-input>
                </div>
                <x-forms.form-error field="menu.svg"></x-forms.form-error>
            </div>

            <div class="mt-4">
                <x-label for="Sort" :value="__('Sort')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="menu.sort"
                             x-bind:value="(errorCount === 0) ? dataRecord.sort : $wire.menu.sort" name="sort"
                             placeholder="Enter sort number"
                    ></x-input>
                </div>
                <x-forms.form-error field="menu.sort"></x-forms.form-error>
            </div>


            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>

        </x-form>
    </x-datatable.modal.add-update>


    {{--                DELETE MODAL STARTS HERE      --}}
    <x-datatable.modal.delete></x-datatable.modal.delete>
</x-datatable.main>

