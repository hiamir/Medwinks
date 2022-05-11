<div class="flex h-screen overflow-y-hidden bg-white dark:bg-gray-800" x-data="setup()"
     x-init="$refs.loading.classList.add('hidden')">
    <livewire:layouts.page.loading/>
    <livewire:layouts.page.sidebar/>
    <div class="flex flex-col flex-1 h-full overflow-hidden">
        <livewire:layouts.page.header/>
        <x-page-content header="{{$header}}">
            {{--------------------CONTENT STARTS HERE--------------------}}



            <button class="block px-3 py-2 mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button" data-modal-toggle="role-modal">
                Add Role
            </button>

            <div id="role-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full justify-center items-center">
                <div class="relative p-4 w-full max-w-md h-full md:h-auto">

                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="role-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                        <div class="py-6 px-6 lg:px-8">
                            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Sign in to our platform</h3>
                            <form class="space-y-6" action="#">
                                <div>
                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your email</label>
                                    <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required="">
                                </div>
                                <div>
                                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your password</label>
                                    <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required="">
                                </div>
                                <div class="flex justify-between">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="remember" type="checkbox" value="" class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800" required="">
                                        </div>
                                        <label for="remember" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                                    </div>
                                    <a href="#" class="text-sm text-blue-700 hover:underline dark:text-blue-500">Lost Password?</a>
                                </div>
                                <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login to your account</button>
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                                    Not registered? <a href="#" class="text-blue-700 hover:underline dark:text-blue-500">Create account</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Role name
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Guard name
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Created on
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Updated on
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr class=" @if($loop->last)bg-white dark:bg-gray-800 @else bg-white border-b dark:bg-gray-800 dark:border-gray-700 @endif">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{$role->name}}
                            </th>
                            <td class="px-6 py-4 text-center">
                                {{$role->guard_name}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{$role->created_at}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{$role->updated_at}}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="#"
                                   class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            </td>
                        </tr>

                    @endforeach

                    {{--                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">--}}
                    {{--                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">--}}
                    {{--                            Microsoft Surface Pro--}}
                    {{--                        </th>--}}
                    {{--                        <td class="px-6 py-4">--}}
                    {{--                            White--}}
                    {{--                        </td>--}}
                    {{--                        <td class="px-6 py-4">--}}
                    {{--                            Laptop PC--}}
                    {{--                        </td>--}}
                    {{--                        <td class="px-6 py-4">--}}
                    {{--                            $1999--}}
                    {{--                        </td>--}}
                    {{--                        <td class="px-6 py-4 text-right">--}}
                    {{--                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>--}}
                    {{--                        </td>--}}
                    {{--                    </tr>--}}
                    {{--                    <tr class="bg-white dark:bg-gray-800">--}}
                    {{--                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">--}}
                    {{--                            Magic Mouse 2--}}
                    {{--                        </th>--}}
                    {{--                        <td class="px-6 py-4">--}}
                    {{--                            Black--}}
                    {{--                        </td>--}}
                    {{--                        <td class="px-6 py-4">--}}
                    {{--                            Accessories--}}
                    {{--                        </td>--}}
                    {{--                        <td class="px-6 py-4">--}}
                    {{--                            $99--}}
                    {{--                        </td>--}}
                    {{--                        <td class="px-6 py-4 text-right">--}}
                    {{--                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>--}}
                    {{--                        </td>--}}
                    {{--                    </tr>--}}
                    </tbody>
                </table>
            </div>
            {{--------------------CONTENT ENDS HERE--------------------}}

        </x-page-content>
        <livewire:layouts.page.footer/>
    </div>
    <livewire:layouts.page.panel/>
</div>
