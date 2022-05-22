@props(['name','href'=>null])
<li {{$attributes}}>
    <a @if($href)href="{{route($href)}}" @endif class="flex items-center p-2   w-full text-base font-normal text-gray-900 rounded-lg transition duration-75
                         hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700"
       :class="{ 'pl-11': isSidebarOpen, 'lg:justify-center': !isSidebarOpen } ">

        <svg @click="toggleSidbarMenu()"
             :class="{ 'hidden': isSidebarOpen }"
             xmlns="http://www.w3.org/2000/svg"
             class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white {{ (strcmp(Route::currentRouteName(), $href) == 0) ? ' font-semibold  text-blue-500 dark:text-yellow-500' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
        </svg>
        <span class="flex flex-nowrap text-left whitespace-nowrap capitalize {{ (strcmp(Route::currentRouteName(), $href) == 0) ? ' font-semibold  text-blue-500 dark:text-yellow-500' : '' }}"
              :class="{ 'lg:hidden': !isSidebarOpen }">{{$name}}</span>
    </a>
</li>
