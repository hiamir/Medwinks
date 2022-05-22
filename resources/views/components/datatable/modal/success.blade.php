<div
{{--    x-show="SuccessModal.show"--}}
    class="z-20 overflow-y-auto overflow-x-hidden hidden fixed top-0 right-0 left-0 w-full md:inset-0 h-modal md:h-full flex justify-center items-center h-screen drop-shadow-md5"
    :class="{'hidden':SuccessModal.show===false, 'flex':SuccessModal.show===true}"

>

    <div class="flex flex-row  justify-center max-w-lg w-[450px] bg-gray-200 rounded-lg border border-gray-200 drop-shadow-md2 dark:bg-green-800 dark:border-green-700 ">

        <div class="relative flex flex-col items-center py-12 px-10">
                 <span
                     class="flex border-4 border-gray-300 dark:border-gray-200 rounded-full w-12 h-12 justify-center items-center m-0 mb-5">
                            <x-svg.main type="check-open"
                                        class="flex h-6 w-6 text-red-800 dark:text-gray-100 mx-2"></x-svg.main>
                </span>
            <span class="absolute flex border-4 border-green-800 dark:border-gray-100 rounded-full w-12 h-12 justify-center items-center m-0 mb-2 animate-ping"> </span>
            <x-form  @submit.prevent="$wire.submit"  class="flex flex-col justify-center items-center mt-5" novalidate autocomplete="off">

            <h5 x-text="SuccessModal.title" class="mb-2 text-lg font-bold text-green-800 dark:text-white capitalize"></h5>
            <span x-html="SuccessModal.message" class="flex text-sm text-gray-800 dark:text-gray-100 text-center"></span>
            <div class="flex mt-7 space-x-5">

               <button @click.prevent="SuccessModal.show=false"  class="cursor-pointer tracking-widest font-semibold uppercase text-xs inline-flex items-center py-2 px-4 text-sm font-medium text-center text-gray-900 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4
               focus:outline-none focus:ring-gray-200 dark:bg-gray-400 dark:text-gray-800 dark:border-gray-500 dark:hover:bg-gray-300 dark:hover:border-gray-600 dark:focus:ring-gray-700">Alright, thanks</button>
            </div>
            </x-form>
        </div>
    </div>
</div>

