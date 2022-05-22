<x-datatable.main
    x-data="{
        admins: null,
        collectionRevert:[],
        allRoles:null,
        rolesShow:null,
        roles:$wire.entangle('roles'),
        collection:$wire.entangle('collection')
    }"

    x-init="
        console.log('roles: '+allRoles);
        error={{$errors}},
        errorCount= {{ count($errors) }}
        admins={{$records->getCollection()}}
        allRoles={{$allRoles}}
    {{--        console.log(admins);--}}
        "
>


    {{--    ADD BUTTON  --}}
    <x-datatable.insert name="Add" @click.prevent="MyModal('add','administrator',{'formData':{} });"></x-datatable.insert>

    {{--    DATATABLE FILTER --}}
    <x-datatable.filter></x-datatable.filter>

    {{--    DATATABLE  --}}
    <x-datatable.table :dataRecord="$records">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    User name
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Guard name
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Roles
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
            <template x-for="admin in admins">
                <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td x-text="admin.name" scope="row"
                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"></td>
                    </td>
                    <td x-text="admin.email" scope="row" class="px-6 py-4 text-center"></td>
                    <td class="px-6 py-4 text-center ">
                        <x-svg.main x-show="rolesShow != admin.id"
                                    @click.prevent="rolesShow = rolesShow === admin.id ? null :  rolesShow = admin.id"
                                    type="arrow-circle-down"></x-svg.main>
                        <x-svg.main x-show="rolesShow === admin.id"
                                    @click.prevent="rolesShow = rolesShow === admin.id ? null :  rolesShow = admin.id "
                                    type="arrow-circle-up"></x-svg.main>
                    </td>
                    <td class="px-6 py-4 text-center"><span x-text="admin.created_at"></span></td>
                    <td class="px-6 py-4 text-center"><span x-text="admin.updated_at"></span></td>
                    <td class="px-8 py-4 text-right space-x-2 overflow-hidden text-right">
                        <div class="flex flex-row justify-end">
                            <x-datatable.password-icon @click.prevent="MyModal('password-reset','administrator',{'formData':admin});"></x-datatable.password-icon>
                            <x-datatable.update-icon class="ml-1"
                                                     @click.prevent="MyModal('update','administrator',{'formData':admin});"></x-datatable.update-icon>
                            <x-datatable.delete-icon class="ml-1"
                                                     @click.prevent="MyModal('delete','administrator',{'formData':admin});"></x-datatable.delete-icon>
                        </div>
                    </td>
                </tr>

                <tr x-id="['text-input']" x-data="{
                        assignedPermissions() {
                           let obj = [];
                            admin.roles.forEach(function (item) {
                                obj.push(item.id);
                            });
                        return obj;
                        }
                    }"
                    x-init="
                        collection[admin.name]=assignedPermissions(admin.roles);

                        $watch('toggle',function(value){
                            this.toggle=!this.toggle;
                            if(success===false) collection[admin.name]=assignedPermissions(admin.roles);
                        });

                    "
                    :class="{'table-row':rolesShow === admin.id,  'hidden':rolesShow != admin.id }"
                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                    <td  colspan="9" class="px-6 py-4 justify-center items-center text-center">
                        <template x-for="[id,role] in Object.entries(allRoles)" :key="role.id">
                            <label  :id="'admin-label'+'-'+admin.id+'-'+role.id"
                                    x-on:change="
                                    $wire.roleToggle({ 'adminID':admin.id, roleID:role.id, 'collection':collection[admin.name] });"
                                    :for="'admin-toggle'+'-'+admin.id+'-'+role.id"
                                    class="inline-flex relative items-center cursor-pointer py-2 border border-gray-400 dark:border-gray-700 rounded-2xl p-3 mx-2 my-2">
                                <input x-model="collection[admin.name]" type="checkbox"
                                       :value="role.id"
                                       :id="'admin-toggle'+'-'+admin.id+'-'+role.id" class="sr-only peer"
                                >
                                <div class="w-9 h-5 bg-gray-200 rounded-full
                                    peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300
                                    dark:peer-focus:ring-gray-800 peer dark:bg-gray-700 peer-checked:after:translate-x-full
                                    peer-checked:after:border-white after:content-[''] after:absolute after:top-[10px] after:left-[14px]
                                    after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all
                                    dark:border-gray-600 peer-checked:bg-blue-600"
                                     :class="{'peer-focus:ring-red-300 dark:peer-focus:ring-red-800 peer-checked:bg-red-600 dark:bg-gray-800' : (role.guard_name=='admin')}"
                                ></div>
                                <span x-text="role.name" class="capitalize ml-1.5 text-xs font-medium text-gray-100 dark:text-gray-300"></span>
                            </label>

                        </template>
                    </td>
                </tr>
                </tbody>
            </template>
        </table>
    </x-datatable.table>

    <x-datatable.modal.add-update>
        <x-form wire:submit.prevent="submit" class="space-y-6" novalidate autocomplete="off">

            <div class="mt-4">
                <x-label for="Full name" :value="__('Full name')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="admin.name" x-bind:value="(errorCount === 0) ? dataRecord.name : $wire.admin.name" name="name"
                             placeholder="Enter a admin full name"
                    ></x-input>
                </div>
                <x-forms.form-error x-show="error['admin.name'] != null" field="admin.name"></x-forms.form-error>
            </div>

            <div class="mt-4">
                <x-label for="User email" :value="__('User email')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="admin.email" x-bind:value="(errorCount === 0) ? dataRecord.email : $wire.admin.email" name="email"
                             placeholder="Enter a unique admin email"
                    ></x-input>
                </div>
                <x-forms.form-error field="admin.email"></x-forms.form-error>
            </div>

            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>

        </x-form>
    </x-datatable.modal.add-update>


    {{--                DELETE MODAL STARTS HERE      --}}
    <x-datatable.modal.delete></x-datatable.modal.delete>
    <x-datatable.modal.password ></x-datatable.modal.password>
</x-datatable.main>

