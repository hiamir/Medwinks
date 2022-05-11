@props(['name','href'=>null,'list'=>null,'notification'=>null, 'dropdown'=>false, 'svg_fill','svg_strokeWidth'=>'','svg_viewBox','svg_stroke','svg_path'])
<li>
    <a
        @if(!$dropdown) @if($href)href="{{route($href)}}" @endif @endif
    class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-200 cursor-pointer
                dark:text-white dark:hover:bg-gray-700
@if(!$dropdown && !isset($list)){{ (strcmp(Route::currentRouteName(), $href) == 0) ? 'bg-gray-200 dark:bg-gray-700' : '' }}@endif
    @if(isset($list)){{ (in_array(Route::currentRouteName(), $list)) ? 'bg-gray-200 dark:bg-gray-700' : '' }} @endif
        "
        @if($dropdown)
        aria-expanded={{ (strcmp(Route::currentRouteName(), $href) == 0) ? 'true' : 'false' }}
            aria-controls="dropdown-{{$name}}"
        data-collapse-toggle="dropdown-{{$name}}"
        @endif
        :class="{ 'lg:justify-center': !isSidebarOpen}"
    >

        <svg
            class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
            xmlns="http://www.w3.org/2000/svg"
            fill="{{$svg_fill}}" viewBox="{{$svg_viewBox}}" stroke="{{$svg_stroke}}"
            stroke-width="{{$svg_strokeWidth}}">
            {!! $svg_path !!}

        </svg>

        <span
            class="flex-1 ml-3 text-left whitespace-nowrap capitalize @if(!$dropdown){{ (strcmp(Route::currentRouteName(), $href) == 0) ? 'font-semibold text-blue-500 dark:text-yellow-500' : '' }}@endif"
            sidebar-toggle-item
            :class="{ 'lg:hidden': !isSidebarOpen }">{{$name}}</span>
        @if($dropdown && $notification===null)
            <svg :class="{ 'lg:hidden': !isSidebarOpen }" sidebar-toggle-item class="w-6 h-6" fill="currentColor"
                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd"></path>
            </svg>
        @endif

        @if($notification!=null)
            <span
                class="inline-flex justify-center items-center px-2 ml-3 text-sm font-medium text-gray-800 bg-gray-200 rounded-full group-hover:bg-white dark:bg-gray-700 dark:group-hover:bg-gray-800 dark:text-gray-300 capitalize"
                :class="{ 'lg:hidden': !isSidebarOpen }">{{$notification}}</span>
        @endif
    </a>
    {{$slot}}
</li>
