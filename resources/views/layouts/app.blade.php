<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
       darkMode: true
{{--      darkMode: localStorage.getItem('dark') === 'true'--}}
      } "
      x-init="$watch('darkMode', function(val){
        localStorage.setItem('dark', val);
        dark=true;
        console.log(darkMode);
      })"
      x-bind:class="{ 'dark': darkMode }"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Medwinks') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">


        <!-- Scripts -->

        <script src="{{ asset('js/app.js') }}" defer></script>

        @livewireStyles
        @bukStyles(true)
    </head>
    <body class="font-sans antialiased ">
        <div class="min-h-screen bg-gray-100">

{{--            @include('layouts.navigation')--}}

{{--            <!-- Page Heading -->--}}
{{--            <header class="bg-white shadow">--}}
{{--                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">--}}
{{--                    {{ $header }}--}}
{{--                </div>--}}
{{--            </header>--}}

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
        <script src="https://unpkg.com/flowbite@1.5.1/dist/flowbite.js"></script>
        <script src="https://unpkg.com/flowbite@1.4.4/dist/datepicker.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script >
            const setup = () => {
                function getSidebarStateFromLocalStorage() {
                    if (window.localStorage.getItem('isSidebarOpen')) {
                        return JSON.parse(window.localStorage.getItem('isSidebarOpen'))
                    }

                    // else return the initial state you want
                    return (
                        false
                    )
                }

                function setSidebarStateToLocalStorage(value) {
                    window.localStorage.setItem('isSidebarOpen', value)
                }

                return {
                    loading: true,
                    isSidebarOpen: getSidebarStateFromLocalStorage(),
                    toggleSidbarMenu() {
                        this.isSidebarOpen = !this.isSidebarOpen
                        setSidebarStateToLocalStorage(this.isSidebarOpen)
                    },
                    isSettingsPanelOpen: false,
                    isSearchBoxOpen: false,
                }
            }
        </script>

{{--        @stack('scripts')--}}

        @livewireScripts
        @bukScripts(true)

    </body>
</html>
