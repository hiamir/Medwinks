@props(['title'=>'', 'message'=>''])
<div class="flex w-full h-full justify-center items-center">
    <div class="flex w-full max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-red-800 dark:border-gray-700">

        <div class="flex flex-col items-center px-5 py-7 justify-center items-center">
                    <span  class="flex cursor-pointer sel border-4 border-gray-800 dark:border-gray-100 rounded-full w-14 h-14 justify-center items-center m-0 mb-3 ">
                <x-svg.main
                    type="exclamation"
                    class=" h-10 w-10 text-red-800 dark:text-gray-100 m-1"></x-svg.main>
                    </span>
            <h5 class="mb-1 text-xl font-semibold text-gray-900 dark:text-white">{{$title}}</h5>
            <span class="text-sm text-gray-800 dark:text-gray-100 text-center">{{$message}}</span>

        </div>
    </div>
</div>
