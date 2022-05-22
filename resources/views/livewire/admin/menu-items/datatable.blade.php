<x-datatable.main
    x-data="{
        menuItems: null,
{{--        menuItemItemRecord:$wire.entangle('menuItem'),--}}
    }"
    x-init="
        errorCount= {{ count($errors) }}
        menuItems={{$records->getCollection()}};
    "
>


    {{--    ADD BUTTON  --}}
    <x-datatable.insert name="Add" @click.prevent="MyModal('add','menu-items',{'formData':{} });"></x-datatable.insert>

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
                    Guard
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    SVG
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Folder
                </th>
                <th scope="col" class="px-6 py-3">
                    Route
                </th>
                <th scope="col" class="px-6 py-3">
                    Permission
                </th>
                <th scope="col" class="px-6 py-3">
                    Sort
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Created on
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Updated on
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Action
                </th>
            </tr>
            </thead>
            <template x-for="menuItem in menuItems">
                <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td x-text="menuItem.name" scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"></td>
                    <td x-text="menuItem.guard" scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"></td>
                    <td  scope="row" class="px-6 py-4 text-center"> <x-svg.main x-data="{svg:menuItem.svg}" type="alpine"> </x-svg.main> </td>
                    <td  scope="row" class="px-6 py-4 text-center">
                        <button x-text="menuItem.menu.name" type="button" class="text-gray-500 border border-gray-500
                            focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-xs px-2 py-1.5 text-center
                            dark:border-gray-600 dark:text-gray-400  dark:focus:ring-gray-800" disabled>
                        </button>
                    </td>
                    <td x-text="menuItem.route" scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"></td>
                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"><template x-if="menuItem.permissions!= null"><span x-text="menuItem.permissions.name"></span></template></td>
                    <td x-text="menuItem.sort" scope="row" class="px-6 py-4 text-center"></td>
                    <td x-text="menuItem.created_at" class="px-6 py-4 text-center"></td>
                    <td x-text="menuItem.updated_at" class="px-6 py-4 text-center"></td>
                    <td class="px-8 py-4 text-right space-x-2 overflow-hidden">
                        <div class="flex flex-row justify-end">
                            <x-datatable.update-icon class="mx-1"
                                                     @click.prevent="MyModal('update','menu-items',{'formData':menuItem});"></x-datatable.update-icon>
                            <x-datatable.delete-icon class="ml-1"
                                                     @click.prevent="MyModal('delete','menu-items',{'formData':menuItem});"></x-datatable.delete-icon>
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
                <x-label for="Menu Item name" :value="__('Menu item name')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="menuItem.name"
                             x-bind:value="(errorCount === 0) ? dataRecord.name : $wire.menuItem.name" name="name"
                             placeholder="Enter a unique menu item name"
                    ></x-input>
                </div>
                <x-forms.form-error field="menuItem.name"></x-forms.form-error>
            </div>
            <div class="mt-4">
                <x-label for="Guard name" :value="__('Guard name')"></x-label>
                <div class="relative">
                    <x-forms.select
                        x-bind:value="(errorCount === 0) ? dataRecord.guard : $wire.menuItem.guard"
                        wire:model.defer="menuItem.guard" name="Guard name"
                        :values="['admin'=>'Administrator','web'=>'User']"
                        placeholder="Choose a Guard">

                    </x-forms.select>
                </div>
                <x-forms.form-error field="menuItem.guard" class="mb-0"></x-forms.form-error>
            </div>
            <div class="mt-4">
                <x-label for="Svg icon" :value="__('Svg Icon')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="menuItem.svg"
                             x-bind:value="(errorCount === 0) ? dataRecord.svg : $wire.menuItem.svg" name="svg.add"
                             placeholder="Enter a svg name"
                    ></x-input>
                </div>
                <x-forms.form-error field="menuItem.svg"></x-forms.form-error>
            </div>

            <div class="mt-4">
                <x-label for="Folder" :value="__('Folder')"></x-label>
                <div class="relative">
                    <x-forms.select
                        x-bind:value="(errorCount === 0) ? dataRecord.menu_id : $wire.menuItem.menu_id"
                        wire:model.defer="menuItem.menu_id" name="Menu name"
                        :values=$menuArray
                        placeholder="Choose a Folder">

                    </x-forms.select>
                </div>
                <x-forms.form-error field="menuItem.menu_id" class="mb-0"></x-forms.form-error>
            </div>

            <div class="mt-4">
                <x-label for="Route" :value="__('Route')"></x-label>
                <div class="relative">
                    <x-forms.select
                        x-bind:value="(errorCount === 0) ? dataRecord.route : $wire.menuItem.route"
                        wire:model.defer="menuItem.route" name="Route"
                        :values=$routeArray
                        placeholder="Choose a Route">

                    </x-forms.select>
                </div>
                <x-forms.form-error field="menuItem.route" class="mb-0"></x-forms.form-error>
            </div>

            <div class="mt-4">
                <x-label for="Permission" :value="__('Permission')"></x-label>
                <span x-init="console.log(dataRecord)"></span>
                <div class="relative">
                    <x-forms.select
                        x-bind:value="(errorCount === 0) ? dataRecord.permissions_id : $wire.menuItem.permissions_id"
                        wire:model.defer="menuItem.permissions_id" name="Permissions"
                        :values=$permissionArray
                        placeholder="Choose a Permission">

                    </x-forms.select>
                </div>
                <x-forms.form-error field="menuItem.permissions_id" class="mb-0"></x-forms.form-error>
            </div>

            <div class="mt-4">
                <x-label for="Sort" :value="__('Menu name')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="menuItem.sort"
                             x-bind:value="(errorCount === 0) ? dataRecord.sort : $wire.menuItem.sort" name="svg"
                             placeholder="Enter a svg name"
                    ></x-input>
                </div>
                <x-forms.form-error field="menuItem.sort"></x-forms.form-error>
            </div>


            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>

        </x-form>
    </x-datatable.modal.add-update>


    {{--                DELETE MODAL STARTS HERE      --}}
    <x-datatable.modal.delete></x-datatable.modal.delete>
</x-datatable.main>

