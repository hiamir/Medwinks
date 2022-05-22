<div
    x-data="{
        login:$wire.entangle('login'),
        authError:$wire.entangle('authError')
    }"
    x-ref="access"
    x-init="

        $watch('authError',function(value){
        if(value===true)  setTimeout(() => authError = false, 3000)
        });

"
    class="z-40 hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full flex justify-center items-center h-screen drop-shadow-md5"
    :class="{'hidden':LoginModal.show===false, 'flex':LoginModal.show===true}"
>
    <div class="flex flex-col justify-center xs:w-[85%]  lg:w-[350px]  bg-gray-200 rounded-lg border border-gray-200 drop-shadow-md2 dark:bg-blue-800 dark:border-blue-700">
        <div class="relative flex-col  flex items-start py-8 xs:px-6 lg:px-10">
            <div class="flex justify-center  items-center">
                <div class="flex">
                     <span  class="flex border-4 border-red-800 dark:border-gray-100 rounded-full w-10 h-10 justify-center items-center m-0 mb-5 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-800 dark:text-gray-100 m-1"
                                 viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd"/>
                            </svg>
                     </span>
                    <span class="absolute flex border-4 border-red-800 dark:border-gray-100 rounded-full w-10 h-10 justify-center items-center m-0 mb-2 animate-ping"> </span>
                </div>
                <h5 x-text="LoginModal.title" class="text-base text-center font-bold xs:ml-2 lg:ml-3 text-red-800 dark:text-white  mt-[-20px]"></h5>
            </div>

                        <span x-text="LoginModal.message" class="flex text-sm text-gray-800 dark:text-gray-100 text-center"></span>

            <div x-show="authError" class="flex w-full justify-center p-2 mb-4 bg-red-800 rounded-2xl"> <span class="text-xs text-white">Invalid login credentials</span></div>

            <x-form x-on:submit.prevent="$wire.LoginSubmit" class="space-y-6 w-full flex flex-col" novalidate autocomplete="off">
                <div class="!mt-0">
                    <x-label class="font-semibold" for="email" :value="__('Your email')"/>
                    <div class="relative">
                        <x-forms.auth-input-svg>
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </x-forms.auth-input-svg>
                        <x-forms.auth-input-disabled x-model="login.email" wire:model="login.email" type="text" name="login.email"
                                            placeholder="name@omjmanager.com"></x-forms.auth-input-disabled>
                    </div>
                    <x-forms.form-error class="text-gray-800 dark:text-gray-200 mb-0" field="login.email"></x-forms.form-error>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-label class="font-semibold" for="password" :value="__('Your password')"/>
                    <div class="relative">
                        <x-forms.auth-input-svg>
                            <path fill-rule="evenodd"
                                  d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z"
                                  clip-rule="evenodd">
                            </path>
                        </x-forms.auth-input-svg>
                        <x-forms.auth-input wire:model="login.password" type="password" name="login.password"
                                            placeholder="••••••••••••••••••"></x-forms.auth-input>
                    </div>
                    <x-forms.form-error class="text-gray-800 dark:text-gray-200 mb-0" field="login.password"></x-forms.form-error>
                </div>


                <div class="flex mt-7">
                    <div class="flex justify-between w-full">
                        <button type="submit" class="cursor-pointer flex tracking-widest font-semibold uppercase inline-flex items-center py-2 px-4 !text-xs text-center
                                rounded-md hover:bg-gray-900 focus:ring-4 focus:outline-none text-gray-800 dark:text-gray-100 focus:ring-gray-300 dark:bg-gray-800 dark:hover:bg-gray-900 dark:focus:ring-gray-800 uppercase">
                            Yes, Login
                        </button>
                        <button @click.prevent="LoginModal.show=false" class="flex cursor-pointer tracking-widest font-semibold uppercase !text-xs inline-flex items-center py-2 px-4  text-center text-gray-900 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4
               focus:outline-none focus:ring-gray-200 dark:bg-gray-400 dark:text-gray-800 dark:border-gray-500 dark:hover:bg-gray-300 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            No,cancel
                        </button>
                    </div>
                </div>
            </x-form>
        </div>
    </div>
</div>




