<x-datatable.main>

    {{--    DATATABLE  --}}
    <div
        x-data="{
            profile:{},
            error:null,
            validationError:[],
            errorName:null,
            defaultProfilePhotos:[],
            isEdit:$wire.entangle('isEdit'),
            tab:$wire.entangle('tabContent'),
            user:$wire.entangle('user'),
            genderName:$wire.entangle('genderName')
            }"
        x-init="
        profile={{$profile}}
            defaultProfilePhotos={{$defaultProfilePhotos}}
            $watch('tab',function(value){
                this.tab=value;
                 modalDetails.modalType='update'
            });

            $watch('isEdit',function(value){
                modalDetails.modalType='update'
            })


                error={{($errors)}}
            Object.entries(error).forEach(entry=>{
                 validationError[entry[0]]=entry[1][0];
            })
"
        class="flex flex-col h-full w-full items-stretch"
    >

        <div
            x-init="
        $watch('AccessDeniedModal',function(value){MyModal('update','info',{user });})
        $watch('toast',function(value){MyModal('update','info',{'formData':user});})
        MyModal('update','info',{'formData':user});"
            class="flex  w-full border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">

                <li @click.prevent="$wire.openTab(1); MyModal('update','info',{'formData':user});"
                    class="mr-2 cursor-pointer">
                    <a
                        :class="(tab===1) ? 'active border-b-2 text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500':'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'"
                        class="inline-flex p-4 rounded-t-lg border-b-2 border-transparent  group">
                        <svg
                            :class="(tab===1) ? 'text-blue-600 dark:text-blue-500': 'group-hover:text-gray-500 dark:group-hover:text-gray-300'"
                            class="mr-2 w-5 h-5  dark:text-gray-500 " fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Profile
                    </a>
                </li>

                <li @click.prevent="$wire.openTab(2); MyModal('update','password-change',{'formData':user}); "
                    class="mr-2 cursor-pointer">
                    <a :class="(tab===2) ? 'active border-b-2 text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500':'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 '"
                       class="inline-flex p-4 rounded-t-lg border-b-2 border-transparent group" aria-current="page">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             :class="(tab===2) ? 'text-blue-600 dark:text-blue-500': 'group-hover:text-gray-500 dark:group-hover:text-gray-300'"
                             class="mr-2 w-5 h-5 dark:text-gray-500  " viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z"
                                  clip-rule="evenodd"/>
                        </svg>
                        Password

                    </a>
                </li>

            </ul>
        </div>

        <div class="tab-content flex h-full pt-8 pb-4" id="tabs-tabContent">
            <div

                x-show="tab===1"
                class="flex flex-wrap py-4 xs:w-full h-full tab-pane fade show  items-center justify-center"
                id="tabs-home" role="tabpanel"
                aria-labelledby="tabs-home-tab">

                <div
                    class=" relative flex flex-col   p-4 xs:w-full w-md-[50%] max-w-md bg-white rounded-lg border border-gray-200 drop-shadow-md2c sm:p-6 lg:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <div class="absolute flex right-2 top-2">
                        <label for="small-toggle"
                               class="inline-flex flex-col  relative items-center mb-1 cursor-pointer">
                            <input @change="isEdit=!isEdit" x-model="isEdit" type="checkbox" value="" id="small-toggle"
                                   class="sr-only peer">
                            <div
                                class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class="flex flex-col w-full justify-center items-center">
                        <template x-if="profile.profile_photo !=null">
                            <template x-if="profile.profile_photo.file">
                                <div
                                    class="flex h-[100px] w-[100px] rounded-full overflow-hidden border-2 border-gray-100 mt-4">
                                    <img class="flex object-cover "
                                         :src="'{{asset('storage/images/profile')}}'+'/'+profile.profile_photo.file+'?ver='+Math.floor((Math.random()*100)+1)"
                                         alt="">
                                </div>
                            </template>
                        </template>
                        <template x-if="profile.profile_photo == null">
                            <div
                                class="flex h-[100px] w-[100px] rounded-full overflow-hidden border-2 border-gray-100 mt-4">
                                <img class="flex object-cover "
                                     src="{{asset('storage/images/profile/default.jpg')}}?ver={{time()}}" alt="">
                            </div>
                        </template>

                    </div>

                    <x-form
                        x-show="isEdit"
                        hasFiles="true"
                        x-on:submit.prevent="$wire.submitPhoto" class="space-y-6" novalidate autocomplete="off">

                        <div x-show="isEdit"
                             class="max-w-sm bg-white  rounded-lg border border-gray-200 dark:bg-gray-900/[0.3] dark:border-gray-700">
                            <div class="flex w-full text-center justify-center items-center py-3 space-x-3">

                                <template x-for="(photo,index) in defaultProfilePhotos" :key="index">

                                    <div @click.prevent="$wire.submitPhoto(photo.id)"
                                         class="flex flex-col justify-center items-center ">
                                        <div
                                            class="flex h-[50px] w-[50px] cursor-pointer rounded-full overflow-hidden border-2 border-gray-100 hover:border-3">
                                            <img class="flex object-cover hover:bg-blend-darken w-[50px] h-[50px] "
                                                 :src="'{{asset('storage/images/profile')}}'+'/'+photo.file+'?ver='+Math.floor((Math.random()*100)+1)">
                                        </div>
                                    </div>
                                </template>

                            </div>
                            {{--                            <div class="flex justify-end p-4"--}}
                            {{--                                 :class="{ 'pb-2' : validationError['user.photo'] != null  }">--}}
                            {{--                                <div class="flex flex-col w-full justify-center">--}}
                            {{--                                    <div class="flex  w-[100%]">--}}
                            {{--                                        <div class="flex w-full">--}}
                            {{--                                            <div class="relative w-full">--}}
                            {{--                                                <label class="flex cursor-pointer justify-center dark:bg-gray-900/[0.6] dark:hover:bg-gray-900 text-center uppercase border  dark:border-gray-700 dark:text-gray-300--}}
                            {{--                                                p-2.5 rounded text-xs tracking"><span class="flex">Choose a profile photo</span>--}}

                            {{--                                                    <input wire:model="user.photo" name="user.photo" class="hidden block w-full text-xs text-gray-900 bg-gray-50--}}
                            {{--                                                rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400--}}
                            {{--                                                focus:outline-none dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400"--}}
                            {{--                                                           id="profile_photo" type="file">--}}
                            {{--                                                    <span wire:model="user.photo"></span>--}}
                            {{--                                                </label>--}}
                            {{--                                            </div>--}}

                            {{--                                        </div>--}}

                            {{--                                    </div>--}}

                            {{--                                </div>--}}
                            {{--                                <div x-show="isEdit" class="flex flex-col justify-end ml-3">--}}
                            {{--                                    <x-forms.submit class="flex flex-col p-0"><span x-text="'Upload'"></span>--}}
                            {{--                                    </x-forms.submit>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <x-forms.error x-show="validationError['user.photo'] != null"--}}
                            {{--                                           x-text="validationError['user.photo']"--}}
                            {{--                                           class="!mx-4 !my-0 !mb-3"></x-forms.error>--}}
                        </div>
                    </x-form>


                    <div x-show="!isEdit">
                        <div class="mt-4">
                            <x-label for="Full name" :value="__('Full name')"></x-label>
                            <div class="relative">
                                <span x-text="user.name"
                                      class="flex font-semibold text-sm border-gray-700 rounded-lg border w-full p-2.5  mt-1 text-gray-800 dark:text-gray-100"></span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-label for="Your email" :value="__('Your email')"></x-label>
                            <div class="relative">
                                <span x-text="user.email"
                                      class="flex font-semibold text-sm border-gray-700 rounded-lg border w-full p-2.5  mt-1 text-gray-800 dark:text-gray-100"></span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-label for="Your gender" :value="__('Your gender')"></x-label>
                            <div class="relative">
                                <span x-text="genderName"
                                      class="flex font-semibold text-sm border-gray-700 rounded-lg border w-full p-2.5  mt-1 text-gray-800 dark:text-gray-100"></span>
                            </div>
                        </div>

                    </div>


                    <x-form x-show="isEdit"
                            x-init=""
                            x-on:submit.prevent="$wire.submit" class="space-y-6" novalidate autocomplete="off">
                        <div class="mt-4">
                            <x-label for="Full name" :value="__('Full name')"></x-label>
                            <div class="relative">
                                <x-input x-show="isEdit" wire:model.defer="user.name"
                                         x-bind:value="$wire.user.name" name="name"
                                         placeholder="Enter a unique user name"
                                ></x-input>
                            </div>
                            <x-forms.error x-text="validationError['user.name']"></x-forms.error>
                        </div>
                        <div class="mt-4">
                            <x-label for="You email" :value="__('Your email')"></x-label>
                            <div class="relative">
                                <x-forms.input-disabled x-show="isEdit" wire:model.defer="user.email"
                                                        x-bind:value="$wire.user.email" name="email"
                                                        placeholder="Enter a unique user name"
                                ></x-forms.input-disabled>
                            </div>


                            <div class="mt-4">
                                <x-label for="Gender" :value="__('Your gender')"></x-label>
                                <div class="relative">
                                    <x-forms.select
                                        x-bind:value="(error.length === 0) ? user.gender : $wire.user.gender"
                                        wire:model.defer="user.gender" name="Guard name"
                                        :values="$gender" disabled
                                        placeholder="Choose a gender">

                                    </x-forms.select>
                                </div>
                            </div>

                            <x-forms.error x-text="validationError['user.gender']"></x-forms.error>
                        </div>


                        <x-forms.submit><span x-text="'update '+ user.name"></span></x-forms.submit>

                    </x-form>

                </div>


            </div>
            <div x-show="tab===2"
                 class="flex flex-wrap py-4 xs:w-full h-full tab-pane fade show  items-center justify-center"
                 id="tabs-profile"
                 role="tabpanel" aria-labelledby="tabs-profile-tab">

                <div
                    class="p-4 xs:w-full w-md-[50%] max-w-md bg-white rounded-lg border border-gray-200 drop-shadow-md2c sm:p-6 lg:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex justify-center">
                        <img src="{{asset('storage/images/password.svg')}}" class="mb-5 h-[200px] self-center" alt="">
                    </div>


                    <x-form
                        x-init=""
                        wire:submit.prevent="submit" class="space-y-6" novalidate autocomplete="on">
                        <div class="mt-0">
                            <x-label for="Current password" :value="__('Current password')"/>
                            <div class="relative">
                                <x-input name="current_password" type="password"
                                         placeholder="Enter your current password" autocomplete="on"
                                         wire:model.defer="auth.current_password"></x-input>
                            </div>
                            <x-forms.error x-text="validationError['auth.current_password']"></x-forms.error>
                        </div>

                        <div class="mt-4">
                            <x-label for="New password" :value="__('New password')"/>
                            <div class="relative">
                                <x-input name="password" type="password" placeholder="Enter new password"
                                         autocomplete="on"
                                         wire:model.defer="auth.password"></x-input>
                            </div>
                            <x-forms.error x-text="validationError['auth.password']"></x-forms.error>
                        </div>

                        <div class="mt-4">
                            <x-label for="Confirm password" :value="__('Confirm password')"/>
                            <div class="relative">
                                <x-input name="password_confirmation" type="password" autocomplete="on"
                                         placeholder="Re-enter your new password"
                                         wire:model.defer="auth.password_confirmation">
                                </x-input>
                            </div>
                            <x-forms.error x-text="validationError['auth.password_confirmation']"></x-forms.error>
                        </div>
                        <x-forms.submit><span x-text="'Change password'"></span></x-forms.submit>

                    </x-form>

                </div>
            </div>
        </div>
    </div>


    {{--    --}}{{--    FORM --}}
    {{--    <x-datatable.modal.modal header="{{$header}}" size="{{$modalSize}}">--}}
    {{--       <x-datatable.relogin header="Re-authentication required."></x-datatable.relogin>--}}
    {{--    </x-datatable.modal.modal>--}}




    {{--    DELETE MODAL--}}
    <x-datatable.modal.delete></x-datatable.modal.delete>

</x-datatable.main>

