<div class="flex w-full

justify-center items-center">
    <div class="flex">
        <div class="flex flex-col max-w-lg w-[350px] bg-gray-200 rounded-lg border border-gray-200 drop-shadow-md2 dark:bg-red-800 dark:border-red-700 ">

            <div class="flex flex-col items-center py-12 px-10">
                 <span
                     class="flex border-4 border-red-800 dark:border-gray-100 rounded-full w-12 h-12 justify-center items-center m-0 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-50 w-50 text-red-800 dark:text-gray-100 m-1" viewBox="0 0 20 20"
                             fill="currentColor">
                          <path fill-rule="evenodd"
                                d="M9 3a1 1 0 012 0v5.5a.5.5 0 001 0V4a1 1 0 112 0v4.5a.5.5 0 001 0V6a1 1 0 112 0v5a7 7 0 11-14 0V9a1 1 0 012 0v2.5a.5.5 0 001 0V4a1 1 0 012 0v4.5a.5.5 0 001 0V3z"
                                clip-rule="evenodd"/>
                        </svg>
                 </span>
                <span class="absolute flex border-4 border-red-800 dark:border-gray-100 rounded-full w-12 h-12 justify-center items-center m-0 mb-2 animate-ping"> </span>
                <h5 class="mb-1 mt-3 text-lg font-bold  text-red-800 dark:text-white uppercase">Access Denied!</h5>
                <div
                    class="flex flex-col text-sm text-gray-800 dark:text-gray-100 text-center">
                    <span class="inline">You do not have permissions to access <span class="inline font-bold capitalize">"{{$name}}"</span> page!</span>
                </div>
            </div>
        </div>
    </div>
</div>
