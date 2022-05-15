<div>
    <nav class="bg-white border-gray-200 dark:border-gray-600 border-b sm:px-4 xl:p-0 dark:bg-gray-800 xs:min-h-full" style="min-height: calc(100vh - 65px);">

        <div class="grid grid-cols-6 gap-4 xs:border-b xs:border-gray-900/[0.3] dark:xs:border-gray-100/[0.3] xs:py-3 xs:px-4">
            <div class="col-start-1 col-end-3 items-stretch xs:flex xl:hidden ">
                <div  x-on:click="isMenuOpen=!isMenuOpen" class="self-center rounded-full border-gray-200 border p-2 ml-0 text-gray-100 bg-sky-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
{{--            <div class="col-start-1 col-end-3 items-stretch xs:hidden xl:flex"  id="mobile-menu-2">--}}
{{--                <ul class="flex flex-col mt-4 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium ">--}}
{{--                    <li class="self-center">--}}
{{--                        <a href="#" class="block py-2 pr-4 pl-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white" aria-current="page">Home</a>--}}
{{--                    </li>--}}
{{--                    <li class="self-center">--}}
{{--                        <a href="#" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</a>--}}
{{--                    </li>--}}
{{--                    <li class="self-center">--}}
{{--                        <a href="#" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Services</a>--}}
{{--                    </li>--}}
{{--                    <li class="self-center">--}}
{{--                        <a href="#" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Pricing</a>--}}
{{--                    </li>--}}
{{--                    <li class="self-center">--}}
{{--                        <a href="#" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contact</a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </div>--}}
            <div class="col-end-7 col-span-3" x-data="{dropdown:false}">
                <div class="flex items-center md:order-2 justify-items-end justify-end" >
                    <button  x-on:click="darkMode=!darkMode" type="button" class="bg-gray-100 dark:bg-gray-700 p-2 rounded-full mr-3 text-gray-400 focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600 ">
                        <span class="sr-only">View notifications</span>
                        <!-- Heroicon name: ou=truetline/bell -->
                        <svg x-cloak x-show="darkMode" class="h-[20px] w-[20px]" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                        </svg>
                        <svg x-show="!darkMode" class="h-[20px] w-[20px]" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                        </svg>
                    </button>

                    <button type="button" class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600"
                    x-on:click="dropdown=!dropdown"
                    >
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="user photo">
                    </button>

                    <div class="z-50 fixed my-4 text-base list-none bg-gray-700 text-gray-800 border-gray-500 dark:border-gray-600 border max-h-screen
                    dark:bg-gray-800 dark:text-gray-200 rounded divide-y divide-gray-100/[0.25] shadow dark:bg-gray-700 dark:divide-gray-600 top-[40px] right-2 pb-2"
                         data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top"
                    x-show="dropdown" @click.away="dropdown = false"
                    >
                        <div class="py-4 px-5">
                            <span class="block text-sm text-gray-100  font-semibold dark:text-white capitalize">{{auth()->user()->name}}</span>
                            <span class="block text-sm font-normal text-gray-400 truncate dark:text-gray-400">{{auth()->user()->email}}</span>
                        </div>
                        <ul class="py-1" aria-labelledby="dropdown">
                            <li>
                                <a href="#" class="block py-2 px-4 text-sm text-gray-200 hover:text-gray-100 hover:bg-gray-400/[0.5] dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
                            </li>
                            <li>
                                <a href="#" class="block py-2 px-4 text-sm text-gray-200 hover:text-gray-100 hover:bg-gray-400/[0.5] dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Settings</a>
                            </li>
                            <li>
                                <a href="#" class="block py-2 px-4 text-sm text-gray-200 hover:text-gray-100 hover:bg-gray-400/[0.5] dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Earnings</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button  class="flex w-full block py-2 px-4 text-sm text-gray-200 hover:text-gray-100 hover:bg-gray-400/[0.5] dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</button>
{{--                                    <x-dropdown-link :href="route('admin-logout')"--}}
{{--                                                     onclick="event.preventDefault();--}}
{{--                                                this.closest('form').submit();">--}}
{{--                                        {{ __('Log Out') }}--}}
{{--                                    </x-dropdown-link>--}}
                                </form>

                            </li>
                        </ul>
                    </div>

                    <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100/[0.5] focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mobile-menu-2" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                        <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
            </div>

        </div>


{{--        <div class="container flex flex-wrap justify-between items-center xs:w-100 xs:mx-0 xl:mx-auto">--}}
{{--            --}}
{{--            --}}



{{--            --}}
{{--        </div>--}}
    </nav>

    <livewire:layouts.footer/>
</div>
