@props(['name','href'=>null,'list'=>null,'notification'=>null, 'dropdown'=>false, 'svg'=>null])
<li
    {{$attributes}}>
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
        <x-svg.main type="{{$svg}}"></x-svg.main>
        <span
            class="flex-1 ml-3 text-left whitespace-nowrap capitalize @if(!$dropdown){{ (strcmp(Route::currentRouteName(), $href) == 0) ? 'font-semibold text-blue-500 dark:text-yellow-500' : '' }}@endif"
            sidebar-toggle-item
            :class="{ 'lg:hidden': !isSidebarOpen }">{{$name}}</span>
        @if($dropdown && $notification===null)
            {{--             dont know--}}
            <x-svg.main x-show="isSidebarOpen" type="arrow-down"></x-svg.main>

        @endif

        @if($notification!=null)
            <span
                class="inline-flex justify-center items-center px-2 ml-3 text-sm font-medium text-gray-800 bg-gray-200 rounded-full group-hover:bg-white dark:bg-gray-700 dark:group-hover:bg-gray-800 dark:text-gray-300 capitalize"
                :class="{ 'lg:hidden': !isSidebarOpen }">{{$notification}}</span>
        @endif
    </a>
    {{$slot}}
</li>
