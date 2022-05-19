{{--<div--}}
{{--    x-show.in.out.opacity="isSidebarOpen"--}}
{{--    class="fixed inset-0 z-10 bg-black bg-opacity-20 lg:hidden"--}}
{{--    style="backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px)">--}}
{{--</div>--}}
<aside
    x-cloak
    x-transition:enter="transition transform duration-300"
    x-transition:enter-start="-translate-x-full opacity-30  ease-in"
    x-transition:enter-end="translate-x-0 opacity-100 ease-out"
    x-transition:leave="transition transform duration-300"
    x-transition:leave-start="translate-x-0 opacity-100 ease-out"
    x-transition:leave-end="-translate-x-full opacity-0 ease-in"
    class="fixed inset-y-0 z-10 flex flex-col flex-shrink-0 w-64 max-h-screen overflow-hidden transition-all transform bg-white dark:bg-gray-800 border-r  dark:border-gray-700 shadow-lg lg:z-auto lg:static lg:shadow-none"
    :class="{'-translate-x-full lg:translate-x-0 lg:w-20': !isSidebarOpen}"
>

<!-- sidebar header -->
    <div class=" bg-white dark:bg-gray-800 flex items-center justify-center border-b border-gray-200 dark:border-gray-700 flex-shrink-0 "
         :class="{'lg:justify-center': !isSidebarOpen}">
          <span
              class="flex h-[72px] text-md dark:text-gray-300 font-bold leading-8 uppercase whitespace-nowrap items-center place-items-center">
              <span class="flex justify-center"> <img class="flex w-10 h-10 place-items-center"
                                                      src="{{asset('storage/images/logo-circle.svg')}}" alt=""> </span>
            <span class="ml-3" :class="{'lg:hidden': !isSidebarOpen}">ED-Manager</span>
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
    <!-- Sidebar links -->
    <x-navigation.main>
        <x-navigation.parent.ul  >

            <x-navigation.parent.li
                name="Dashboard"
                href="admin.dashboard"
                svg_fill="none"
                svg_viewBox="0 0 24 24"
                svg_stroke="currentColor"
                svg_path='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"'
            >
            </x-navigation.parent.li>

            <x-navigation.parent.li
                :list="['admin.admins','admin.users','admin.roles','admin.permissions']"
                name="security"
                href="admin.roles"
                dropdown="true"
                svg_fill="none"
                svg_viewBox="0 0 24 24"
                svg_stroke="currentColor"
                svg_strokeWidth="2"
                svg_path='<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"</path>'
            >
                <x-navigation.child1.ul name="security" :list="['admin.admins','admin.users','admin.roles','admin.permissions']">
                    <x-navigation.child1.li name="administrators" href="admin.admins"></x-navigation.child1.li>
                    <x-navigation.child1.li name="users" href="admin.users"></x-navigation.child1.li>
                    <x-navigation.child1.li name="roles" href="admin.roles"></x-navigation.child1.li>
                    <x-navigation.child1.li name="permissions" href="admin.permissions"></x-navigation.child1.li>
                </x-navigation.child1.ul>
            </x-navigation.parent.li>



            <x-navigation.parent.li
                name="Kaban"
                notification="new"
                svg_fill="none"
                svg_viewBox="0 0 20 20"
                svg_stroke="currentColor"
                svg_path='<path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"</path>'
            >
            </x-navigation.parent.li>


            </x-navigation.parent.ul>
    </x-navigation.main>
    <!-- Sidebar footer -->
    <div class="flex-shrink-0 p-2 border-t dark:border-gray-700 max-h-[60px] h-[60px]">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button
                class="flex bg-red-500 dark:bg-red-500 border-red-500/[0.6] text-white hover:bg-red-600/[1] hover:border-red-500/[0.6] items-center justify-center w-full px-4 py-2 space-x-1 font-medium uppercase bg-gray-100 border rounded-md focus:outline-none focus:ring"
            >
            <span>
              <svg
                  class="w-6 h-6"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
              >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                />
              </svg>
            </span>
                <span :class="{'lg:hidden': !isSidebarOpen}"> Logout </span>
            </button>
        </form>
    </div>
</aside>
{{--</div>--}}
