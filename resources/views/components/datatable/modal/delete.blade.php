<div
{{--    x-show="DeleteModal.show"--}}
    class="z-20 overflow-y-auto overflow-x-hidden hidden fixed top-0 right-0 left-0 w-full md:inset-0 h-modal md:h-full flex justify-center items-center h-screen drop-shadow-md5"
    :class="{'hidden':DeleteModal.show===false, 'flex':DeleteModal.show===true}"

>

    <div class="flex flex-row  justify-center max-w-lg w-[450px] bg-gray-200 rounded-lg border border-gray-200 drop-shadow-md2 dark:bg-gray-800 dark:border-gray-700 ">

        <div class="relative flex flex-col items-center py-12 px-10">
                 <span class="flex border-4 border-gray-300 dark:border-gray-200 rounded-full w-12 h-12 justify-center items-center m-0 mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="flex h-6 w-6 border-gray-300 dark:text-gray-200"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                </span>
            <span class="absolute flex border-4 border-red-800 dark:border-gray-100 rounded-full w-12 h-12 justify-center items-center m-0 mb-2 animate-ping"> </span>
            <x-form  @submit.prevent="$wire.submit"  class="flex flex-col justify-center items-center mt-5" novalidate autocomplete="off">

            <h5 x-text="DeleteModal.title" class="mb-2 text-lg font-bold text-red-800 dark:text-white capitalize"></h5>
            <span x-html="DeleteModal.message" class="flex text-sm text-gray-800 dark:text-gray-100 text-center"></span>
            <div class="flex mt-7 space-x-5">
                <button  type="submit" class="cursor-pointer tracking-widest font-semibold uppercase inline-flex items-center py-3 px-4 text-xs font-medium text-center text-white bg-red-700
                                rounded-md hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-red-800 dark:hover:bg-red-900 dark:focus:ring-red-800 ">Yes,
                    I'm sure</button>
               <button @click.prevent="DeleteModal.show=false"  class="cursor-pointer tracking-widest font-semibold uppercase text-xs inline-flex items-center py-2 px-4 text-sm font-medium text-center text-gray-900 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4
               focus:outline-none focus:ring-gray-200 dark:bg-gray-400 dark:text-gray-800 dark:border-gray-500 dark:hover:bg-gray-300 dark:hover:border-gray-600 dark:focus:ring-gray-700">No,cancel</button>
            </div>
            </x-form>
        </div>
    </div>
</div>

