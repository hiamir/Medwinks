{{--<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">--}}
{{--    <div>--}}
{{--        {{ $logo }}--}}
{{--    </div>--}}

{{--    <div class="w-ull sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">--}}
{{--        {{ $slot }}--}}
{{--    </div>--}}
{{--</div>--}}

<div class="relative p-4 xs:w-[90%] sm:w-[80%] md:w-[50%] lg:w-[40%] xl:w-[450px] min-w-md bg-blue-100 rounded-lg border border-gray-200 shadow-md dark:drop-shadow-md2 sm:p-6 lg:p-8

@if($guard == 'admin') bg-red-100 dark:bg-red-900 dark:border-red-700 @else dark:bg-blue-900 dark:border-blue-700 @endif ">

{{--    <div class=" absolute top-3 right-2 w-7 h-7 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">--}}
{{--        <svg class=" absolute w-5 h-5 text-gray-400 -left-1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">--}}
{{--            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />--}}
{{--        </svg>--}}
{{--    </div>--}}
    <div class="absolute top-3 right-2" :class="{'dark': darkMode === true}">
        <div class="dark:text-gray-100">
            <div class="flex items-center justify-center space-x-2">
                <span class="text-sm text-gray-800 dark:text-gray-500">
                     <svg x-cloak x-transition  class="h-[18px] w-[18px]" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
        </svg>
                </span>
                <label for="toggle"
                       class="flex items-center h-5 p-1 duration-300 ease-in-out bg-gray-300 rounded-full cursor-pointer w-9 dark:bg-gray-600">
                    <div
                        class="w-4 h-4 duration-300 ease-in-out transform bg-white rounded-full shadow-md toggle-dot dark:translate-x-3">
                    </div>
                </label>
                <span class="text-sm text-gray-400 dark:text-white">
                    <svg x-cloak  x-transition class="h-[18px] w-[18px]" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
        </svg>
                </span>
                <input id="toggle" type="checkbox" class="hidden" :value="darkMode" @change="darkMode = !darkMode" />
            </div>
        </div>
    </div>


    <div class="flex flex-row justify-start items-center">
        <div class="basis-14 mr-3 "><img src="{{asset('storage/images/logo-circle.svg')}}" alt="" class=""></div>
        <div class="basis-3/4"><h5 class="text-xl font-medium text-gray-900 dark:text-white">{{$header}}</h5></div>
    </div>
    {{ $slot }}
</div>
