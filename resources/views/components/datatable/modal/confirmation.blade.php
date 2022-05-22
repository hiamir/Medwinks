<div x-data="{ isSubmitting:false }"
    x-init="
    $watch('ConfirmationModal.show',function(value){
           if(value === false)  isSubmitting=false;
    })
"
    class="z-20 overflow-y-auto overflow-x-hidden hidden fixed top-0 right-0 left-0 w-full md:inset-0 h-modal md:h-full flex justify-center items-center h-screen drop-shadow-md5"
    :class="{'hidden':ConfirmationModal.show===false, 'flex':ConfirmationModal.show===true}"

>

    <div class="flex flex-row  justify-center  sm-w-[450px] w-[650px] bg-gray-200 rounded-lg border border-gray-200 drop-shadow-md2 dark:bg-gray-800 dark:border-gray-700 ">

        <div class="relative w-full flex flex-col items-center py-12 px-10">
{{--            <template  x-if="documentType === 'application' ">--}}
                 <span x-show="ConfirmationModal.type !=='' " class="flex border-4 border-gray-300 dark:border-gray-200 rounded-full w-12 h-12 justify-center items-center m-0 mb-5">
                      <x-svg.main x-show="(confirmationType === 'accept' ) && rejectCheckbox === false" type="check-open" class="h-6 w-6 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                       <x-svg.main x-show="(confirmationType === 'reject') && rejectCheckbox === false" type="delete-open" class="h-6 w-6 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                       <x-svg.main x-show="confirmationType==='revision' " type="refresh" class="h-6 w-6 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                </span>
{{--            </template>--}}
            <span class="absolute flex border-4 border-red-800 dark:border-gray-100 rounded-full w-12 h-12 justify-center items-center m-0 mb-2 animate-ping"> </span>


            <x-form  @submit.prevent="$wire.submitConfirmation; isSubmitting=true;"  class="flex flex-col w-full justify-center items-center mt-5" novalidate autocomplete="off">
{{--                <template x-if="documentType === 'application'">--}}
                <h4 x-text="(rejectCheckbox === true) ? 'Reject Application' : ConfirmationModal.title" class="mb-2 text-lg font-bold text-red-800 dark:text-white capitalize"></h4>
                <span x-html="(rejectCheckbox === true) ? 'Are you sure you want to Reject this application?' : ConfirmationModal.message" class="flex text-sm text-gray-800 dark:text-gray-100 text-center"></span>
{{--                </template>--}}
                {{$slot}}
                <div class="flex mt-7 space-x-5">
                    <button  type="submit" class="cursor-pointer tracking-widest font-semibold uppercase inline-flex items-center py-3 px-4 text-xs font-medium text-center text-white bg-red-700
                                rounded-md hover:bg-green-900 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-green-800 dark:hover:bg-green-900 dark:focus:ring-green-800 "
                             :class="{'!cursor-default dark:!bg-gray-700  dark:!border-gray-700 dark:!text-gray-600 dark:focus:!ring-0 dark:hover:!bg-gray-700 dark:!hover:text-gray-700': (isSubmitting)}"
                    >

                        <svg x-show="isSubmitting" aria-hidden="true" role="status"
                             class="inline mr-3 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="#E5E7EB"/>
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentColor"/>
                        </svg>


                        <span x-show="!isSubmitting">Submit</span><span x-show="isSubmitting">Submitting...</span>
                        <svg x-show="!isSubmitting" xmlns="http://www.w3.org/2000/svg" class="ml-2 w-5 h-5"
                             viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>

                    </button>
                    <button @click.prevent="ConfirmationModal.show=false"  class="cursor-pointer tracking-widest font-semibold uppercase text-xs inline-flex items-center py-2 px-4 text-sm font-medium text-center text-gray-900 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4
               focus:outline-none focus:ring-gray-200 dark:bg-gray-400 dark:text-gray-800 dark:border-gray-500 dark:hover:bg-gray-300 dark:hover:border-gray-600 dark:focus:ring-gray-700">No,cancel</button>
                </div>
            </x-form>


        </div>
    </div>
</div>


