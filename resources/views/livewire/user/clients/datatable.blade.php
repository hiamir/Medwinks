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
        error={{$errors}},
        errorCount= {{ count($errors) }}
        users={{$records->getCollection()}}
    {{--        console.log(users);--}}
        "
>


    {{--    --}}{{--    ADD BUTTON  --}}
    {{--    <x-datatable.insert name="Add" @click.prevent="MyModal('add','user',{'formData':{} });"></x-datatable.insert>--}}

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
                    Applications
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Documents
                </th>
                {{--                <th scope="col" class="px-6 py-3 text-center">--}}
                {{--                    Roles--}}
                {{--                </th>--}}
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
                    <th scope="row" class="flex items-center py-4 px-6 text-gray-900 whitespace-nowrap dark:text-white">
                        <template x-if="user.default_profile_photo_id !== null">
                            <img class="w-10 h-10 rounded-full" :src="'{{asset('storage/images/profile')}}'+'/'+user.profile_photo.file+'?ver='+Math.floor((Math.random()*100)+1)" :alt="user.name+' image'">
                        </template>

                        <template x-if="user.default_profile_photo_id === null">
                            <img class="w-10 h-10 rounded-full" :src="'{{asset('storage/images/profile/default.jpg')}}'" :alt="user.name+' image'">
                        </template>

                        <div class="pl-3">
                            <div class="text-base font-semibold" x-text="user.name"></div>
                            <div class="font-normal text-gray-500" x-text="user.email"></div>
                        </div>
                    </th>
                    <td class="px-6 py-4 text-center">
                        <button type="button" class="cursor-default text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg
                        text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600  dark:focus:ring-gray-700"
                        :class="{ '!bg-green-900/[0.3] !border-green-900/[0.5]' : user.applications.length > 0}"
                        >
                            <span x-show="user.applications.length > 0" x-text="user.applications.length + ' submitted'"></span>
                            <span x-show="user.applications.length === 0" class="whitespace-nowrap" x-text="'No submission'"></span>
                        </button>
                    </td>
                    <td scope="row" class="px-6 py-4 text-center">
                        <span
                            class="cursor-default bg-gray-100 shadow-sm text-gray-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded mr-2 dark:bg-gray-700 dark:text-gray-300">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                   stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                              <span class="pl-1 text-sm inline-flex whitespace-nowrap" x-text="user.documents.length+' submitted'"></span>
                            </span>
                    </td>
                    {{--                    <td class="px-6 py-4 text-center ">--}}
                    {{--                        <x-svg.main x-show="rolesShow != user.id"--}}
                    {{--                                    @click.prevent="rolesShow = rolesShow === user.id ? null :  rolesShow = user.id"--}}
                    {{--                                    type="arrow-circle-down"></x-svg.main>--}}
                    {{--                        <x-svg.main x-show="rolesShow === user.id"--}}
                    {{--                                    @click.prevent="rolesShow = rolesShow === user.id ? null :  rolesShow = user.id "--}}
                    {{--                                    type="arrow-circle-up"></x-svg.main>--}}
                    {{--                    </td>--}}
                    <td class="px-6 py-4 text-center whitespace-nowrap"><span x-text="user.created_at"></span></td>
                    <td class="px-6 py-4 text-center whitespace-nowrap"><span x-text="user.updated_at"></span></td>
                    <td class="px-6 py-4 text-right space-x-2 overflow-hidden text-right">
                        <div class="flex flex-row justify-end">
{{--                            <x-datatable.password-icon--}}
{{--                                x-on:click.prevent="MyModal('password-reset','user',{'formData':user}); "></x-datatable.password-icon>--}}
{{--                            <x-datatable.update-icon class="ml-1"--}}
{{--                                                     x-on:click.prevent="MyModal('update','user',{'formData':user}); userData=user;"></x-datatable.update-icon>--}}
{{--                            <x-datatable.delete-icon class="ml-1"--}}
{{--                                                     x-on:click.prevent="MyModal('delete','user',{'formData':user});"></x-datatable.delete-icon>--}}
                            <x-forms.button @click.prevent="$wire.clientDetail(user)" color="primary" class="!m-0">Details</x-forms.button>

                        </div>
                    </td>
                </tr>

                {{--                <tr x-id="['text-input']" x-data="{--}}
                {{--                        assignedPermissions() {--}}
                {{--                           let obj = [];--}}
                {{--                            user.roles.forEach(function (item) {--}}
                {{--                                obj.push(item.id);--}}
                {{--                            });--}}
                {{--                        return obj;--}}
                {{--                        }--}}
                {{--                    }"--}}
                {{--                    x-init="--}}
                {{--                        collection[user.name]=assignedPermissions(user.roles);--}}

                {{--                        $watch('toggle',function(value){--}}
                {{--                            this.toggle=!this.toggle;--}}
                {{--                            if(success===false) collection[user.name]=assignedPermissions(user.roles);--}}
                {{--                        });--}}

                {{--                    "--}}
                {{--                    :class="{'table-row':rolesShow === user.id,  'hidden':rolesShow != user.id }"--}}
                {{--                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"--}}
                {{--                >--}}
                {{--                    <td  colspan="9" class="px-6 py-4 justify-center items-center text-center">--}}
                {{--                        <template x-for="[id,role] in Object.entries(allRoles)" :key="role.id">--}}
                {{--                            <label  :id="'user-label'+'-'+user.id+'-'+role.id"--}}
                {{--                                    x-on:change="--}}
                {{--                                    MyModal('roleToggle','user',{ 'userID':user.id, 'roleID':role.id, 'collection':collection[user.name]} );"--}}
                {{--                                    $wire.roleToggle({ 'userID':user.id, roleID:role.id, 'collection':collection[user.name] });"--}}
                {{--                                    :for="'user-toggle'+'-'+user.id+'-'+role.id"--}}
                {{--                                    class="inline-flex relative items-center cursor-pointer py-2 border border-gray-400 dark:border-gray-700 rounded-2xl p-3 mx-2 my-2">--}}
                {{--                                <input x-model="collection[user.name]" type="checkbox"--}}
                {{--                                       :value="role.id"--}}
                {{--                                       :id="'user-toggle'+'-'+user.id+'-'+role.id" class="sr-only peer"--}}
                {{--                                >--}}
                {{--                                <div class="w-9 h-5 bg-gray-200 rounded-full--}}
                {{--                                    peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300--}}
                {{--                                    dark:peer-focus:ring-gray-800 peer dark:bg-gray-700 peer-checked:after:translate-x-full--}}
                {{--                                    peer-checked:after:border-white after:content-[''] after:absolute after:top-[10px] after:left-[14px]--}}
                {{--                                    after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all--}}
                {{--                                    dark:border-gray-600 peer-checked:bg-blue-600"--}}
                {{--                                     :class="{'peer-focus:ring-red-300 dark:peer-focus:ring-red-800 peer-checked:bg-red-600 dark:bg-gray-800' : (role.guard_name=='admin')}"--}}
                {{--                                ></div>--}}
                {{--                                <span x-text="role.name" class="capitalize ml-1.5 text-xs font-medium text-gray-100 dark:text-gray-300"></span>--}}
                {{--                            </label>--}}

                {{--                        </template>--}}
                {{--                    </td>--}}
                {{--                </tr>--}}

                </tbody>
            </template>
        </table>
    </x-datatable.table>

    {{--    <x-datatable.modal.add-update>--}}
    {{--        <x-form wire:submit.prevent="submit" class="space-y-6" novalidate autocomplete="off">--}}

    {{--            <div class="mt-4">--}}
    {{--                <x-label for="Full name" :value="__('Full name')"></x-label>--}}
    {{--                <div class="relative">--}}
    {{--                    <x-input x-model="userRecord.name" x-bind:value="(errorCount === 0) ? userData.name : $wire.user.name" name="name"--}}
    {{--                             placeholder="Enter a user full name"--}}
    {{--                    ></x-input>--}}
    {{--                </div>--}}
    {{--                <x-forms.form-error x-show="error['user.name'] != null" field="user.name"></x-forms.form-error>--}}
    {{--            </div>--}}

    {{--            <div class="mt-4">--}}
    {{--                <x-label for="User email" :value="__('User email')"></x-label>--}}
    {{--                <div class="relative">--}}
    {{--                    <x-input x-model="userRecord.email" x-bind:value="(errorCount === 0) ? userData.email : $wire.user.email" name="email"--}}
    {{--                             placeholder="Enter a unique user email"--}}
    {{--                    ></x-input>--}}
    {{--                </div>--}}
    {{--                <x-forms.form-error field="user.email"></x-forms.form-error>--}}
    {{--            </div>--}}

    {{--            <!-- Gender -->--}}
    {{--            <div class="mb-4">--}}
    {{--                <x-label for="gender" :value="__('Your Gender')"/>--}}
    {{--                <div class="relative">--}}
    {{--                    <div  x-data="{arrayData:[userData.gender_id]}"--}}
    {{--                          x-init=" $watch('userData.gender_id',function(value){arrayData=[]; arrayData.push(value); console.log(arrayData)}); "--}}
    {{--                          class="flex">--}}
    {{--                        <template x-for="sex in gender" :key="sex.id">--}}
    {{--                            <div class="flex items-center mr-4">--}}
    {{--                                <input @change.prevent="arrayData=[]; arrayData.push(sex.id); userRecord.gender=sex.id; console.log(arrayData)" x-model="arrayData" :value="sex.id"  :id="'gender-'+sex.id" type="radio"  :name="sex.name"--}}
    {{--                                     :checked="true"  class="cursor-pointer w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600--}}
    {{--                                   dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">--}}
    {{--                                <label for="inline-radio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"><span--}}
    {{--                                        x-text="sex.name"></span></label>--}}
    {{--                            </div>--}}
    {{--                        </template>--}}

    {{--                    </div>--}}
    {{--                    <x-forms.form-error field="user.gender"></x-forms.form-error>--}}
    {{--                </div>--}}
    {{--            </div>--}}

    {{--            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>--}}

    {{--        </x-form>--}}
    {{--    </x-datatable.modal.add-update>--}}


    {{--                DELETE MODAL STARTS HERE      --}}
    <x-datatable.modal.delete></x-datatable.modal.delete>
    {{--    <x-datatable.modal.password></x-datatable.modal.password>--}}
</x-datatable.main>

