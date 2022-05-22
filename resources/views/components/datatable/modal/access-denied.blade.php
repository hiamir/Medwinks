<div
    x-ref="access"
    class="z-40 hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full flex justify-center items-center h-screen drop-shadow-md5"
    :class="{'hidden':AccessDeniedModal.show===false, 'flex':AccessDeniedModal.show===true}"
>
    <div
        class="flex flex-row  justify-center max-w-lg w-[400px] bg-gray-200 rounded-lg border border-gray-200 drop-shadow-md2 dark:bg-red-800 dark:border-red-700 ">

        <div class="relative flex flex-col items-center py-12 px-10">
                 <span
                     class="flex border-4 border-red-800 dark:border-gray-100 rounded-full w-12 h-12 justify-center items-center m-0 mb-5 ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-50 w-50 text-red-800 dark:text-gray-100 m-1"
                             viewBox="0 0 20 20"
                             fill="currentColor">
                          <path fill-rule="evenodd"
                                d="M9 3a1 1 0 012 0v5.5a.5.5 0 001 0V4a1 1 0 112 0v4.5a.5.5 0 001 0V6a1 1 0 112 0v5a7 7 0 11-14 0V9a1 1 0 012 0v2.5a.5.5 0 001 0V4a1 1 0 012 0v4.5a.5.5 0 001 0V3z"
                                clip-rule="evenodd"/>
                        </svg>
                 </span>
            <span
                class="absolute flex border-4 border-red-800 dark:border-gray-100 rounded-full w-12 h-12 justify-center items-center m-0 mb-2 animate-ping"> </span>
            <h5 class="mb-2 text-xl font-bold  text-red-800 dark:text-white uppercase">Access Denied!</h5>
            <span x-html="AccessDeniedModal.message"
                  class="flex text-sm text-gray-800 dark:text-gray-100 text-center"></span>
            <div class="flex mt-7">
                <a @click.prevent="AccessDeniedModal.show=false" class="cursor-pointer inline-flex items-center py-3 px-4 text-xs font-medium text-center text-white bg-blue-700
                                rounded-md hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-800 dark:hover:bg-gray-900 dark:focus:ring-gray-800 uppercase">Yes,
                    I understand</a>
            </div>
        </div>
    </div>
</div>

