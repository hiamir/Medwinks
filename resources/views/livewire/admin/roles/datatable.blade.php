<x-datatable.main
    x-data="{
        roles: null,
        collection:[],
        permissionsShow:null,
        permissions:$wire.entangle('permissions'),
        }"
    x-init="
        errorCount= {{ count($errors) }}
        roles={{$records->getCollection()}};
        if( permissions === null) permissions={{$permissions}};
        "
>

    {{--    ADD BUTTON  --}}
    <x-datatable.insert name="Add" @click.prevent="MyModal('add','role',{'formData':{} });"></x-datatable.insert>

    {{--    DATATABLE FILTER --}}
    <x-datatable.filter></x-datatable.filter>

    {{--    DATATABLE  --}}
    <x-datatable.table :dataRecord="$records">
        <table x-id="['permission-toggle']" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Role name
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Guard name
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Permissions
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

            <template x-for="role in roles">
                <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td x-text="role.name" scope="row" class="capitalize px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"></td>
                    <td x-text="role.guard_name" scope="row" class="px-6 py-4 text-center"></td>
                    <td class="px-6 py-4 text-center ">
                        <x-svg.main x-show="permissionsShow != role.id"
                                    @click.prevent="permissionsShow = permissionsShow === role.id ? null :  permissionsShow = role.id"
                                    type="arrow-circle-down"></x-svg.main>
                        <x-svg.main x-show="permissionsShow === role.id"
                                    @click.prevent="permissionsShow = permissionsShow === role.id ? null :  permissionsShow = role.id "
                                    type="arrow-circle-up"></x-svg.main>
                    </td>
                    <td class="px-6 py-4 text-center"><span x-text="role.created_at"></span></td>
                    <td class="px-6 py-4 text-center"><span x-text="role.updated_at"></span></td>
                    <td class="px-6 py-4 text-right space-x-2 overflow-hidden">
                        <div class="flex flex-row justify-end">
                            <x-datatable.update-icon class="mx-1"
                                                     @click.prevent="MyModal('update','role',{'formData':role});"></x-datatable.update-icon>
                            <x-datatable.delete-icon class="ml-1"
                                                     @click.prevent="MyModal('delete','role',{'formData':role});"></x-datatable.delete-icon>
                        </div>
                    </td>
                </tr>
                <tr x-id="['text-input']" x-data="{
                        assignedPermissions() {
                           let obj = [];
                            role.permissions.forEach(function (item) {
                                obj.push(item.id);
                            });
                        return obj;
                        }
                    }"
                    x-init="
                        collection[role.name]=assignedPermissions(role.permissions);
                        $watch('role',function(value){
                            collection[role.name]=assignedPermissions();
                    })"
                    :class="{'table-row':permissionsShow === role.id,  'hidden':permissionsShow != role.id }"
                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                    <td  colspan="9" class="px-6 py-4 text-center">
                        <template x-for="[id,permission] in Object.entries(role.guard_permissions)" :key="permission.id">
                                <label  :id="'permission-label'+-+role.id+'-'+permission.id" x-on:change="$wire.permissionToggle({ 'roleID':role.id, permissionID:permission.id, 'collection':collection[role.name] })"
                                       :for="'permission-toggle'+-+role.id+'-'+permission.id"
                                       class="inline-flex relative items-center cursor-pointer py-2 border border-gray-400 dark:border-gray-700 rounded-2xl p-3 mx-2 my-2">
                                    <input x-model="collection[role.name]" type="checkbox"
                                           :value="permission.id"
                                           :id="'permission-toggle'+-+role.id+'-'+permission.id" class="sr-only peer"
                                    >
                                    <div class="w-9 h-5 bg-gray-200 rounded-full
                                    peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300
                                    dark:peer-focus:ring-gray-800 peer dark:bg-gray-700 peer-checked:after:translate-x-full
                                    peer-checked:after:border-white after:content-[''] after:absolute after:top-[10px] after:left-[14px]
                                    after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all
                                    dark:border-gray-600 peer-checked:bg-blue-600"
                                        :class="{'peer-focus:ring-red-300 dark:peer-focus:ring-red-800 peer-checked:bg-red-600 dark:bg-gray-800' : (permission.guard_name=='admin')}"
                                    ></div>
                                    <span x-text="permission.name" class="ml-1.5 text-xs font-medium text-gray-100 dark:text-gray-300"></span>
                                </label>
                        </template>
                    </td>
                </tr>
                </tbody>
            </template>
        </table>
    </x-datatable.table>

    <x-datatable.modal.add-update>
        <x-form x-on:submit.prevent="$wire.submit"  class="space-y-6" novalidate autocomplete="off">
            <div class="mt-4">
                <x-label for="Role name" :value="__('Role name')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="role.name"
                             x-bind:value="(errorCount === 0) ? dataRecord.name : $wire.role.name" name="name"
                             placeholder="Enter a unique role name"
                    ></x-input>
                </div>
                <x-forms.form-error field="role.name"></x-forms.form-error>
            </div>

{{--            <div class="mt-4">--}}
{{--                <x-label for="Guard name" :value="__('Guard name')"></x-label>--}}
{{--                <div class="relative">--}}
{{--                    <x-forms.select x-bind:value="(errorCount === 0) ? dataRecord.guard_name : $wire.role.guard_name"--}}
{{--                                    wire:model.defer="role.guard_name" name="Guard name"--}}
{{--                                    :values="['admin'=>'Administrator','web'=>'User']"--}}
{{--                                    placeholder="Choose a Guard">--}}

{{--                    </x-forms.select>--}}
{{--                </div>--}}
{{--                <x-forms.form-error field="role.guard_name" class="mb-0"></x-forms.form-error>--}}
{{--            </div>--}}

            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>

        </x-form>
    </x-datatable.modal.add-update>


    {{--                DELETE MODAL STARTS HERE      --}}
    <x-datatable.modal.delete></x-datatable.modal.delete>
</x-datatable.main>

