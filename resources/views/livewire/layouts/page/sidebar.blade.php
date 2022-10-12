{{--<div--}}
{{--    x-show.in.out.opacity="isSidebarOpen"--}}
{{--    class="fixed inset-0 z-10 bg-black bg-opacity-20 lg:hidden"--}}
{{--    style="backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px)">--}}
{{--</div>--}}
@inject('Authorize', 'App\Http\Livewire\Layouts\Page\Sidebar')
@inject('Data', 'App\Http\Livewire\Layouts\Page\Sidebar')
<aside
    x-data="{
        userRoles:$wire.entangle('userRoles'),
        activeRoleName:$wire.entangle('activeRoleName'),
        userName:'{{auth()->user()->name}}',
        roleActive:$wire.entangle('roleActive'),
        roleActiveName:$wire.entangle('roleActiveName')
    }"
    x-init="
    console.log(userRoles);
    $watch('roleActive',function(value){console.log(value)});
        "
    x-cloak
    x-transition:enter="transition transform duration-300"
    x-transition:enter-start="-translate-x-full opacity-30  ease-in"
    x-transition:enter-end="translate-x-0 opacity-100 ease-out"
    x-transition:leave="transition transform duration-300"
    x-transition:leave-start="translate-x-0 opacity-100 ease-out"
    x-transition:leave-end="-translate-x-full opacity-0 ease-in"
    class="fixed transition-all inset-y-0 z-10 flex flex-col flex-shrink-0 w-64 max-h-screen overflow-hidden  bg-white dark:bg-gray-800 border-r  dark:border-gray-700 shadow-lg lg:z-auto lg:static lg:shadow-none"
    :class="{'-translate-x-full lg:translate-x-0 lg:w-20': !isSidebarOpen}"
>
    <!-- sidebar header -->
    <div
        class=" bg-white dark:bg-gray-800 flex items-center justify-center border-b border-gray-200 dark:border-gray-700 flex-shrink-0 "
        :class="{'lg:justify-center': !isSidebarOpen}">
          <span
              class="flex h-[72px] text-md dark:text-gray-300 font-bold leading-8 uppercase whitespace-nowrap items-center place-items-center">
              <span class="flex justify-center">
                  <img class="flex w-40 h-15 place-items-center" :class="{'lg:hidden': !isSidebarOpen}" src="{{asset('storage/images/logo.svg')}}"
                       alt=""> </span>
               <img class="flex w-30 h-10 place-items-center"  :class="{ 'lg:hidden xs:hidden': isSidebarOpen}" src="{{asset('storage/images/logo-letter.svg')}}"
                    alt=""> </span>
{{--            <span class="ml-3" :class="{'lg:hidden': !isSidebarOpen}">ED-Manager</span>--}}
          </span>
        <button @click="toggleSidbarMenu()" class="p-2 rounded-md lg:hidden ml-6">
            <svg
                class="w-6 h-6 text-gray-600 dark:text-gray-300"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    @if ($this->permission('user-submit-application-create'))
    <a href="{{route('user.submit-application')}}" class="flex items-center p-2 cursor-pointer h-[74px] max-h-[74px] text-base font-normal text-gray-900 transition duration-75
              hover:bg-gray-200 dark:text-white inline-flex relative justify-start items-start relative font-semibold text-center text-white bg-red-700
              md:mb-0 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-900 dark:hover:bg-red-800 "
       :class="{ 'pl-11': isSidebarOpen, 'lg:justify-center': !isSidebarOpen } ">

        <x-svg.main type="document-text"
                    class="h-[30px] w-[30px] text-red-800 dark:text-gray-300 m-1"></x-svg.main>
        <span class="flex flex-nowrap text-left whitespace-nowrap capitalize"
              :class="{ 'lg:hidden': !isSidebarOpen }"  x-text="'New Application'"></span>
    </a>

        @else
        <div class="flex  h-[74px]"></div>
@endif

{{--    <button--}}
{{--                @click.prevent="RoleMenuToggle = !RoleMenuToggle" @click.away="RoleMenuToggle=false"--}}
{{--        id="userRolesButton" class="inline-flex relative justify-start items-start relative--}}
{{--     px-3 mx-6 h-8 py-2 !my-4 text-sm font-medium text-center text-white bg-red-700 rounded-md md:mb-0focus:ring-4 focus:outline-none--}}
{{--    focus:ring-red-300 dark:bg-red-900 dark:hover:bg-red-800"--}}
{{--        :class="{'xs:px-0 pt-0 h-8': !isSidebarOpen}"--}}
{{--        type="button">--}}
{{--        <div class="flex justify-center items-center">--}}
{{--            <x-svg.main type="document-text"--}}
{{--                        class="h-[20px] w-[20px] text-red-800 dark:text-gray-300 m-1"></x-svg.main>--}}

{{--            <span class="text-sm ml-1" :class="{'lg:hidden': !isSidebarOpen}" x-text="'New Application'"></span>--}}
{{--        </div>--}}
{{--                <svg class="ml-2 w-3 h-3" aria-hidden="true" fill="none" stroke="currentColor"--}}
{{--                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">--}}
{{--                    <path stroke-linecap="round"--}}
{{--                          stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>--}}
{{--                </svg>--}}
{{--    </button>--}}

    <!-- Dropdown menu -->
{{--    <div  x-show="RoleMenuToggle" class="flex flex-col relative !z-40 bg-white dark:bg-gray-800 dark:border-gray-700 rounded-md shadow-md border-gray-200">--}}
{{--        <div--}}
{{--             class="flex hidden z-40 w-44 bg-white dark:bg-gray-800 dark:border-gray-700 rounded-md shadow-md border-gray-200 border "--}}
{{--             :class="{'relative !w-20':isSidebarOpen===false,'flex absolute z-40 mt-1 transform translate-x-10 ':isSidebarOpen===true,'flex':RoleMenuToggle===true,'hidden':RoleMenuToggle===false}"--}}
{{--        >--}}

{{--            <ul class="py-1  w-full text-sm text-gray-700 dark:text-gray-200" aria-labelledby="userRolesButton">--}}
{{--                <template x-for="(role,index) in userRoles" :key="index">--}}

{{--                    <li x-init="console.log(role.role)">--}}
{{--                        <a @click.prevent="roleActive=role.role" class="cursor-pointer block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">--}}
{{--                            <span class="text-xs capitalize"--}}
{{--                                  :class="{'text-red-600':roleActive===role.role}"--}}
{{--                                  x-text="role.name"></span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </template>--}}
{{--            </ul>--}}

{{--        </div>--}}
{{--    </div>--}}


<!-- Sidebar links -->
    <x-navigation.main class="border-t border-gray-700">
        <x-navigation.parent.ul>
            @foreach($navigation as $menu)

                @if($menu->menuItems->first() != null && $menu->menuItems->first()->permissions !==null && count($menu->menuItems)==1)
                    @if ($this->permission($menu->menuItems->first()->permissions->name))
                    <x-navigation.parent.li
                        name="{{$menu->menuItems->first()->name}}"
                        href="{{$menu->menuItems->first()->route}}"
                        svg="{{$menu->svg}}"
                    >
                        @endif
                    </x-navigation.parent.li>
                @else

                    @if($menu->menuItems->first() != null)
                        @if($this->countItems($menu->menuItems))
                            <x-navigation.parent.li
                                :list="(json_decode($menu->menuItems->pluck('route')))"
                                name="{{$menu->name}}"
                                href=""
                                dropdown="true"
                                svg="{{$menu->svg}}"
                            >
                                <x-navigation.child1.ul name="{{$menu->name}}"
                                                        :list="json_decode($menu->menuItems->pluck('route'))">
                                    @foreach($menu->menuItems as $item)
                                        @if ($this->permission($item->permissions->name))

                                            <x-navigation.child1.li name="{{$item->name}}"
                                                                    href="{{$item->route}}"></x-navigation.child1.li>
                                        @endif
                                    @endforeach
                                </x-navigation.child1.ul>
                            </x-navigation.parent.li>
                        @endif
                    @endif
                @endif
            @endforeach
        </x-navigation.parent.ul>
    </x-navigation.main>
    <!-- Sidebar footer -->
    <div class="flex-shrink-0 p-2 border-t dark:border-gray-700 max-h-[60px] h-[60px]">
{{--        <form method="POST" action="{{ route('admin.logout') }}">--}}
{{--            @csrf--}}
{{--            <button--}}
{{--                class="flex bg-red-500 dark:bg-red-500 border-red-500/[0.6] text-white hover:bg-red-600/[1] hover:border-red-500/[0.6] items-center justify-center w-full px-4 py-2 space-x-1 font-medium uppercase bg-gray-100 border rounded-md focus:outline-none focus:ring"--}}
{{--            >--}}
{{--        <span>--}}
{{--          <svg--}}
{{--              class="w-6 h-6"--}}
{{--              xmlns="http://www.w3.org/2000/svg"--}}
{{--              fill="none"--}}
{{--              viewBox="0 0 24 24"--}}
{{--              stroke="currentColor"--}}
{{--          >--}}
{{--            <path--}}
{{--                stroke-linecap="round"--}}
{{--                stroke-linejoin="round"--}}
{{--                stroke-width="2"--}}
{{--                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"--}}
{{--            />--}}
{{--          </svg>--}}
{{--        </span>--}}
{{--                <span :class="{'lg:hidden': !isSidebarOpen}"> Logout </span>--}}
{{--            </button>--}}
{{--        </form>--}}
    </div>
</aside>
{{--</div>--}}
