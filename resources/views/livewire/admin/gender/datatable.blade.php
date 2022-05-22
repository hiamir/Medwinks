<x-datatable.main
    x-data="{
        gender: [],
        error:null,
        file:null,
        validationError:[],
        photoShow:null,
        imageExists:[],
        fileName:null,

        clicked:false,
        modalDetails:$wire.entangle('modalDetails'),
        defaultPhoto:$wire.entangle('defaultPhoto'),
        photoFile:$wire.entangle('photoFile')

    }"
    x-init="
     error={{($errors)}}
        Object.entries(error).forEach(entry=>{
                validationError[entry[0]]=entry[1][0];
           });
            errorCount= {{ count($errors) }}
        gender={{$records->getCollection()}};


    "
>


    {{--    ADD BUTTON  --}}
    <x-datatable.insert name="Add" @click.prevent="MyModal('add','gender',{'formData':{} });"></x-datatable.insert>

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
                <th scope="col" class="px-6 py-3 text-center">
                    Profile Photos
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
            <template x-for="(sex, index) in gender" :key="index">
                <tbody>

                <tr class="bg-white  dark:bg-gray-800 dark:border-gray-700"
                    :class="(index === gender.length-1) ? '' : 'border-b'">

                    <td x-text="sex.name" scope="row"
                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap" width="20%"></td>
                    <td class="px-6 py-4 text-center " width="40%">
                        <x-svg.main x-show="photoShow != sex.id"
                                    @click.prevent="photoShow = photoShow === sex.id ? null :  photoShow = sex.id"
                                    type="arrow-circle-down"></x-svg.main>
                        <x-svg.main x-show="photoShow === sex.id"
                                    @click.prevent="photoShow = photoShow === sex.id ? null :  photoShow = sex.id "
                                    type="arrow-circle-up"></x-svg.main>
                    </td>
                    <td x-text="sex.created_at" class="px-6 py-4 text-center" width="25%"></td>
                    <td x-text="sex.updated_at" class="px-6 py-4 text-center" width="25%"></td>
                    <td class="px-6 py-4 text-right space-x-2 overflow-hidden" width="10%">
                        <div class="flex flex-row justify-end">
                            <x-datatable.update-icon class="mx-1"
                                                     @click.prevent="MyModal('update','gender',{'formData':sex});"></x-datatable.update-icon>
                            <x-datatable.delete-icon class="ml-1"
                                                     @click.prevent="MyModal('delete','gender',{'formData':sex});"></x-datatable.delete-icon>
                        </div>
                    </td>
                </tr>
                {{--  PHOTO SHOW TOGGLE  --}}
                <tr :class="{'table-row':photoShow === sex.id,  'hidden':photoShow != sex.id }"
                    class="bg-white  dark:bg-gray-900 dark:border-gray-700"
                >
                    <td wire:ignore colspan="9" class="px-6 py-6 text-center">
                        <div class="flex flex-row justify-center items-center ">
                        <span

                            @click.prevent="MyModal('add','defaultProfilePhoto',{'formData':{},'gender':sex.id})"
                            class="flex  justify-center items-center cursor-pointer border-2 border-gray-100  rounded-full h-[70px] w-[70px]  text-gray-200  text-xs px-4 py-2 mx-3 hover:text-gray-200 bg-blue-800 hover:bg-blue-900">
                            <span x-text="'Add Photo'"></span>
                        </span>

                            <template x-for="(photo, index) in (sex.default_profile_photos)" :key="index">
                                <div
                                    x-data="{}"

                                    x-init="
                                    fileName='{{asset('storage/images/profile')}}'+'/'+photo.file;
                                        checkIfImageExists(photo.id,fileName);
                                    $watch('AddUpdateModal',function(){checkIfImageExists(photo.id,fileName);})


"

                                    class="flex px-3">
                                    <div class="relative flex flex-col w-full justify-center items-center">
                                        <div
                                            @click.prevent="MyModal('update','defaultProfilePhoto',{'formData':photo});"
                                            class="flex h-[70px] w-[70px] cursor-pointer rounded-full overflow-hidden border-2 border-gray-100 ">

                                            <template x-for="p in result">

                                                <template x-if="p.id === photo.id && p.show === true">
                                                    <img class="flex object-cover "
                                                         :src="'{{asset('storage/images/profile')}}'+'/'+photo.file+'?ver='+Math.floor((Math.random()*100)+1)"
                                                         alt="">
                                                </template>

                                            </template>
                                            <img class="flex object-cover "
                                                 :src="'{{asset('storage/images/profile')}}'+'/not-found.jpg?ver='+Math.floor((Math.random()*100)+1)"
                                                 alt="">
                                        </div>
                                        <x-svg.main type="delete"
                                                    @click.prevent="MyModal('delete','defaultProfilePhoto',{'formData':photo});"
                                                    class="flex absolute -top-1 -right-0 z-50 ml-2 dark:text-red-900 dark:hover:text-red-700"
                                        ></x-svg.main>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </td>
                </tr>

                </tbody>
            </template>
            <tbody x-show="gender.length === 0 ">
            <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
                <td colspan="6" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"> No
                    records available!
                </td>
            </tr>
            </tbody>
        </table>
    </x-datatable.table>

    <x-datatable.modal.add-update x-show="modalDetails.model==='gender' && modalDetails.formType==='gender'">
        <x-form wire:submit.prevent="submit" class="space-y-6" novalidate autocomplete="off">
            <div class="mt-4">
                <x-label for="Name" :value="__('Name')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="gender.name"
                             x-bind:value="(errorCount === 0) ? dataRecord.name : $wire.gender.name" name="name"
                             placeholder="Enter a unique gender"
                    ></x-input>
                </div>
                <x-forms.form-error field="gender.name"></x-forms.form-error>
            </div>

            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>

        </x-form>
    </x-datatable.modal.add-update>


    <x-datatable.modal.add-update
        x-show="modalDetails.model==='gender' && modalDetails.formType==='defaultProfilePhoto'">
        <x-form
            hasFiles="true"
            x-on:submit.prevent="$wire.submit" class="space-y-6" novalidate autocomplete="off">

            <div class="mt-4">
                <x-label for="Name" :value="__('Name')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="defaultPhoto.name"
                             x-bind:value="(errorCount === 0) ? dataRecord.name : $wire.defaultPhoto.name"
                             name="defaultPhoto.name"
                             placeholder="Enter a name for the profile photo"
                    ></x-input>
                </div>
                <x-forms.form-error field="defaultPhoto.name"></x-forms.form-error>
            </div>


            <div class="max-w-full bg-white  rounded-lg border border-gray-200 dark:bg-gray-900/[0.3] dark:border-gray-700">
                <div class="flex w-full text-center justify-center items-center">

                    @if (isset($defaultPhoto['file']) && !is_string($defaultPhoto['file']))
                        @if($defaultPhoto['file']->temporaryUrl())
                            <div class="flex flex-col justify-center items-center">
                                <div x-show="defaultPhoto.file"
                                     class="flex rounded-full  w-[70px] h-[70px] overflow-hidden border-2 border-gray-100 mt-4">
                                    <img class="flex object-cover hover:bg-blend-darken w-[70px] h-[70px]"
                                         src="{{ $defaultPhoto['file']->temporaryUrl() }}">
                                </div>
                                <div class="flex w-full text-xs dark:text-gray-400 pt-2">{{ $defaultPhoto['file']->getClientOriginalName() }}</div>
                            </div>
                        @endif

                    @endif

                </div>
                <div class="flex justify-end p-4"
                     :class="{ 'pb-2' : validationError['defaultPhoto.file'] != null  }">
                    <div class="flex flex-col w-full justify-center">
                        <div class="flex  w-[100%]">
                            <div class="flex w-full">
                                <div class="relative w-full">
                                    <label class="flex cursor-pointer justify-center dark:bg-gray-900/[0.6] dark:hover:bg-gray-900 text-center uppercase border  dark:border-gray-700 dark:text-gray-300
                                                p-2.5 rounded text-xs tracking"><span class="flex">Choose a profile photo</span>

                                        <input wire:model="defaultPhoto.file" name="defaultPhoto.file" class="hidden block w-full text-xs text-gray-900 bg-gray-50
                                                rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400
                                                focus:outline-none dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400"
                                               id="profile_photo" type="file">
                                        <span wire:model="defaultPhoto.file"></span>
                                    </label>
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="flex flex-col justify-end ml-3">
                        <x-forms.submit class="flex flex-col p-0"><span x-text="'Upload'"></span></x-forms.submit>
                    </div>
                </div>
                <x-forms.error x-show="validationError['defaultPhoto.file'] != null"
                               x-text="validationError['defaultPhoto.file']"
                               class="!mx-4 !my-0 !mb-3"></x-forms.error>
            </div>
        </x-form>
    </x-datatable.modal.add-update>

    {{--                DELETE MODAL STARTS HERE      --}}
    <x-datatable.modal.delete></x-datatable.modal.delete>
</x-datatable.main>

