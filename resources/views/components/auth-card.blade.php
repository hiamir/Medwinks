<div class="

@if($type==="two_factor")
    relative p-4 xs:w-[90%] sm:w-[80%] md:w-[60%] lg:w-[50%] xl:w-[550px] min-w-md bg-blue-100 rounded-lg border border-gray-200 shadow-md dark:drop-shadow-md2  sm:p-6 lg:p-8
    @else
    relative p-4 xs:w-[90%] sm:w-[80%] md:w-[50%] lg:w-[40%] xl:w-[450px] min-w-md bg-blue-100 rounded-lg border border-gray-200 shadow-md dark:drop-shadow-md2 xs:p-10 sm:p-6 lg:p-8
    @endif


@if($guard == 'admin') bg-red-100 dark:bg-red-900 dark:border-red-700 @else dark:bg-blue-900 dark:border-blue-700 @endif

    {{$attributes}}
    ">

{{--    <div class=" absolute top-3 right-2 w-7 h-7 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">--}}
{{--        <svg class=" absolute w-5 h-5 text-gray-400 -left-1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">--}}
{{--            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />--}}
{{--        </svg>--}}
{{--    </div>--}}
    <div class="absolute top-3 right-2.5" :class="{'dark': darkMode === true}">
        @if($type==="two_factor")
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <svg data-tooltip-target="tooltip-logout" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 cursor-pointer dark:text-gray-300 dark:hover:text-gray-100" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                    </svg>
                </button>

            </form>
            <div id="tooltip-logout" role="tooltip" class="inline-block absolute invisible z-10 py-1 px-2 text-xs font-medium text-white bg-red-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-red-700">
               Logout
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            @else
{{--        <div class="dark:text-gray-100">--}}
{{--            <div class="flex items-center justify-center space-x-2">--}}
{{--                <span class="text-sm text-gray-800 dark:text-gray-500">--}}
{{--                     <svg x-cloak x-transition  class="h-[18px] w-[18px]" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">--}}
{{--            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />--}}
{{--        </svg>--}}
{{--                </span>--}}
{{--                <label for="toggle"--}}
{{--                       class="flex items-center h-5 p-1 duration-300 ease-in-out bg-gray-300 rounded-full cursor-pointer w-9 dark:bg-gray-600">--}}
{{--                    <div--}}
{{--                        class="w-4 h-4 duration-300 ease-in-out transform bg-white rounded-full shadow-md toggle-dot dark:translate-x-3">--}}
{{--                    </div>--}}
{{--                </label>--}}
{{--                <span class="text-sm text-gray-400 dark:text-white">--}}
{{--                    <svg x-cloak  x-transition class="h-[18px] w-[18px]" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">--}}
{{--            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />--}}
{{--        </svg>--}}
{{--                </span>--}}
{{--                <input id="toggle" type="checkbox" class="hidden" :value="darkMode" @change="darkMode = !darkMode" />--}}
{{--            </div>--}}
{{--        </div>--}}
        @endif
    </div>

    @if($type==="two_factor")
    <div class="flex flex-col justify-start items-center">
        <div  class="flex rounded-full  w-[70px] h-[70px] overflow-hidden border-2 border-gray-100 my-4">
            <img class="flex object-cover hover:bg-blend-darken w-[70px] h-[70px]"
                 src="{{asset('storage/images/icons/two-factor.png')}}">
        </div>

        <div class="flex"><h5 class="text-xl font-medium text-gray-900 dark:text-white">{{$header}}</h5></div>
    </div>
    @else
        <div class="flex flex-row justify-start items-center">
            <div class="basis-14 mr-3 "><img src="{{asset('storage/images/logo-letter.svg')}}" alt="" class=""></div>
            <div class="basis-3/4"><h5 class="text-xl font-medium text-gray-900 dark:text-white">{{$header}}</h5></div>
        </div>
    @endif
    {{ $slot }}
</div>
