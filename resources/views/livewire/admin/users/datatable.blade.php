<x-datatable.main
    x-data="{
        users: null,
        collectionRevert:[],
        allRoles:null,
        rolesShow:null,
        roles:$wire.entangle('roles'),
        collection:$wire.entangle('collection'),
        userRecord: $wire.entangle('user').defer,
        userData:{},
        gender:{}
    }"

    x-init="
    $watch('userData',function(value){
        console.log(value);
    })
        console.log('roles: '+allRoles);
        error={{$errors}},
        errorCount= {{ count($errors) }}
        users={{$records->getCollection()}}
        allRoles={{$allRoles}}
        gender={{$gender}}
{{--        console.log(users);--}}
    "
>


    {{--    ADD BUTTON  --}}
    <x-datatable.insert name="Add" @click.prevent="MyModal('add','user',{'formData':{} });"></x-datatable.insert>

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

            <template x-for="user in users">
                <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td x-text="user.name" scope="row"
                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"></td>
                    </td>
                    <td x-text="user.email" scope="row" class="px-6 py-4 text-center"></td>
                    <td class="px-6 py-4 text-center ">
                        <x-svg.main x-show="rolesShow != user.id"
                                    @click.prevent="rolesShow = rolesShow === user.id ? null :  rolesShow = user.id"
                                    type="arrow-circle-down"></x-svg.main>
                        <x-svg.main x-show="rolesShow === user.id"
                                    @click.prevent="rolesShow = rolesShow === user.id ? null :  rolesShow = user.id "
                                    type="arrow-circle-up"></x-svg.main>
                    </td>
                    <td class="px-6 py-4 text-center"><span x-text="user.created_at"></span></td>
                    <td class="px-6 py-4 text-center"><span x-text="user.updated_at"></span></td>
                    <td class="px-6 py-4 text-right space-x-2 overflow-hidden text-right">
                        <div class="flex flex-row justify-end">
                            <x-datatable.password-icon x-on:click.prevent="MyModal('password-reset','user',{'formData':user}); "></x-datatable.password-icon>
                            <x-datatable.update-icon class="ml-1"
                                                    x-on:click.prevent="MyModal('update','user',{'formData':user}); userData=user;" ></x-datatable.update-icon>
                            <x-datatable.delete-icon class="ml-1"
                                                     x-on:click.prevent="MyModal('delete','user',{'formData':user});"></x-datatable.delete-icon>
                        </div>
                    </td>
                </tr>

                <tr x-id="['text-input']" x-data="{
                        assignedPermissions() {
                           let obj = [];
                            user.roles.forEach(function (item) {
                                obj.push(item.id);
                            });
                        return obj;
                        }
                    }"
                    x-init="
                        collection[user.name]=assignedPermissions(user.roles);

                        $watch('toggle',function(value){
                            this.toggle=!this.toggle;
                            if(success===false) collection[user.name]=assignedPermissions(user.roles);
                        });

                    "
                    :class="{'table-row':rolesShow === user.id,  'hidden':rolesShow != user.id }"
                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                    <td  colspan="9" class="px-6 py-4 justify-center items-center text-center">
                        <template x-for="[id,role] in Object.entries(allRoles)" :key="role.id">
                            <label  :id="'user-label'+'-'+user.id+'-'+role.id"
                                    x-on:change="
{{--                                    MyModal('roleToggle','user',{ 'userID':user.id, 'roleID':role.id, 'collection':collection[user.name]} );"--}}
                                    $wire.roleToggle({ 'userID':user.id, roleID:role.id, 'collection':collection[user.name] });"
                                    :for="'user-toggle'+'-'+user.id+'-'+role.id"
                                    class="inline-flex relative items-center cursor-pointer py-2 border border-gray-400 dark:border-gray-700 rounded-2xl p-3 mx-2 my-2">
                                <input x-model="collection[user.name]" type="checkbox"
                                       :value="role.id"
                                       :id="'user-toggle'+'-'+user.id+'-'+role.id" class="sr-only peer"
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
                    <x-input x-model="userRecord.name" x-bind:value="(errorCount === 0) ? userData.name : $wire.user.name" name="name"
                             placeholder="Enter a user full name"
                    ></x-input>
                </div>
                <x-forms.form-error x-show="error['user.name'] != null" field="user.name"></x-forms.form-error>
            </div>

            <div class="mt-4">
                <x-label for="User email" :value="__('User email')"></x-label>
                <div class="relative">
                    <x-input x-model="userRecord.email" x-bind:value="(errorCount === 0) ? userData.email : $wire.user.email" name="email"
                             placeholder="Enter a unique user email"
                    ></x-input>
                </div>
                <x-forms.form-error field="user.email"></x-forms.form-error>
            </div>

            <!-- Gender -->
            <div class="mb-4">
                <x-label for="gender" :value="__('Your Gender')"/>
                <div class="relative">
                    <div  x-data="{arrayData:[userData.gender_id]}"
                          x-init=" $watch('userData.gender_id',function(value){arrayData=[]; arrayData.push(value); console.log(arrayData)}); "
                          class="flex">
                        <template x-for="sex in gender" :key="sex.id">
                            <div class="flex items-center mr-4">
                                <input @change.prevent="arrayData=[]; arrayData.push(sex.id); userRecord.gender=sex.id; console.log(arrayData)" x-model="arrayData" :value="sex.id"  :id="'gender-'+sex.id" type="radio"  :name="sex.name"
                                     :checked="true"  class="cursor-pointer w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600
                                   dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="inline-radio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"><span
                                        x-text="sex.name"></span></label>
                            </div>
                        </template>

                    </div>
                    <x-forms.form-error field="user.gender"></x-forms.form-error>
                </div>
            </div>

            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>

        </x-form>
    </x-datatable.modal.add-update>


    {{--                DELETE MODAL STARTS HERE      --}}
    <x-datatable.modal.delete></x-datatable.modal.delete>
    <x-datatable.modal.password></x-datatable.modal.password>
</x-datatable.main>

