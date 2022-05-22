@inject('Data', 'App\Http\Livewire\Admin\Permissions\Datatable')
<x-datatable.main
    x-data="{
        permissions: null,
        permissionRecord:$wire.entangle('permission'),
    }"
    x-init="
        errorCount= {{ count($errors) }}
        permissions={{$records->getCollection()}};
    "
>


    {{--    ADD BUTTON  --}}
    <x-datatable.insert name="Add" @click.prevent="MyModal('add','permission',{'formData':{} });"></x-datatable.insert>

    {{--    DATATABLE FILTER --}}
    <x-datatable.filter></x-datatable.filter>

    {{--    DATATABLE  --}}
    <x-datatable.table :dataRecord="$records">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Permission name
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Guard name
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Created on
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Updated on
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
            </thead>
            <template x-for="permission in permissions">
                </tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td x-text="permission.name" scope="row"
                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"></td>
                    <td x-text="permission.guard_name" scope="row" class="px-6 py-4 text-center"></td>
                    <td class="px-6 py-4 text-center"><span x-text="permission.created_at"></span></td>
                    <td class="px-6 py-4 text-center"><span x-text="permission.updated_at"></span></td>
                    <td class="px-8 py-4 text-right space-x-2 overflow-hidden">
                        <div class="flex flex-row justify-end">
                            <x-datatable.update-icon class="mx-1"
                                                     @click.prevent="MyModal('update','permission',{'formData':permission});"></x-datatable.update-icon>
                            <x-datatable.delete-icon class="ml-1"
                                                     @click.prevent="MyModal('delete','permission',{'formData':permission});"></x-datatable.delete-icon>
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
                <x-label for="Permission name" :value="__('Permission name')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="permission.name"
                             x-bind:value="(errorCount === 0) ? dataRecord.name : $wire.permission.name" name="name"
                             placeholder="Enter a unique permission name"
                    ></x-input>
                </div>
                <x-forms.form-error field="permission.name"></x-forms.form-error>
            </div>
            @if(in_array('admin',$this->userRoles()['roles']) &&  in_array('super-admin',$this->userRoles()['roles']))
                <div class="mt-4">
                    <x-label for="Guard name" :value="__('Guard name')"></x-label>
                    <div class="relative">
                        <x-forms.select
                            x-bind:value="(errorCount === 0) ? dataRecord.guard_name : $wire.permission.guard_name"
                            wire:model.defer="permission.guard_name" name="Guard name"
                            :values="['admin'=>'Administrator','web'=>'User']"
                            placeholder="Choose a Guard">

                        </x-forms.select>
                    </div>
                    <x-forms.form-error field="permission.guard_name" class="mb-0"></x-forms.form-error>
                </div>
            @endif

            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>

        </x-form>
    </x-datatable.modal.add-update>


    {{--                DELETE MODAL STARTS HERE      --}}
    <x-datatable.modal.delete></x-datatable.modal.delete>
</x-datatable.main>

