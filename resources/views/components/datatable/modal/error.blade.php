<div
x-init="$watch('ErrorModal',function(value){console.log(value)})"
    class="z-40 hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full flex justify-center items-center h-screen drop-shadow-md5"
    :class="{'hidden':ErrorModal.show===false, 'flex':ErrorModal.show===true}"
>
    <div
        class="flex flex-row  justify-center xs:w-[85%]  lg:w-[350px]  bg-gray-200 rounded-lg border border-gray-200 drop-shadow-md2 dark:bg-red-800 dark:border-red-700 ">

        <div class="relative flex flex-col items-center py-12 px-10">
            <div x-show="ErrorModal.type==='security' || ErrorModal.type==='error'" class="flex">
                     <span  class="flex border-4 border-red-800 dark:border-gray-100 rounded-full w-10 h-10 justify-center items-center m-0 mb-5 ">
                         {{--                   security svg                        --}}
                            <svg x-show="ErrorModal.type==='security'" xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 text-red-800 dark:text-gray-100 m-1"
                                 viewBox="0 0 20 20"
                                 fill="currentColor">
                              <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd"/>
                            </svg>
                          {{--                   error svg                        --}}
                         <svg x-show="ErrorModal.type==='error'"xmlns="http://www.w3.org/2000/svg"
                              class="h-5 w-5 text-red-800 dark:text-gray-100 m-1"
                              viewBox="0 0 20 20"
                              fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                     </span>
                <span class="absolute flex border-4 border-red-800 dark:border-gray-100 rounded-full w-10 h-10 justify-center items-center m-0 mb-2 animate-ping"> </span>
            </div>

            <h5  x-text="ErrorModal.title" class="mb-2 text-xl font-bold  text-red-800 dark:text-white capitalize"></h5>
            <span x-html="ErrorModal.message"
                  class="flex text-sm text-gray-800 dark:text-gray-100 text-center"></span>
            <div class="flex mt-7">
                <a @click.prevent="ErrorModal.show=false; CloseOtherModals()" class="cursor-pointer inline-flex items-center py-3 px-4 text-xs font-medium text-center text-white bg-blue-700
                                rounded-md hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-800 dark:hover:bg-gray-900 dark:focus:ring-gray-800 uppercase">Yes,
                    I understand</a>
            </div>
        </div>
    </div>
</div>

