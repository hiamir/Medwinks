@props(['header'=>''])

    <main class="flex-1 max-h-full p-0 overflow-hidden overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-300 h-32 overflow-y-scroll
    dark:scrollbar-thumb-gray-500 dark:scrollbar-track-gray-700">
        <!-- Main content header -->
        <div class="flex flex-col justify-center xs:items-center  justify-between py-4 space-y-4 border-b dark:border-gray-700 lg:items-center lg:space-y-0 sm:flex-row">
            <h1 class="flex text-2xl font-semibold whitespace-nowrap text-blue-500 dark:text-yellow-500 h-full px-5">{{$header}}</h1>
            @if(!request()->is('dashboard') )
            <a href="{{ url()->previous() }}" type="button" class="py-2.5 px-5 mr-5 mb-2 text-sm sm:!mt-0 font-medium text-gray-900 focus:outline-none bg-white rounded-full
            border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700
            dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" x-text="'Back'"></a>
                @endif
        </div>

        <!-- Start Content -->
        <div class="flex min-h-[calc(100%_-_69px)]  p-5 mb-0">
            {{$slot}}
        </div>

    </main>

