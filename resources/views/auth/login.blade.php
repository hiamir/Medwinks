<x-guest-layout>
    <x-auth-card header="Sign in to our platform">
        <x-form action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Your email')"/>
                <div class="relative mb-6">
                    <x-forms.auth-input-svg>
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </x-forms.auth-input-svg>
                    <x-forms.auth-input type="text" name="email" placeholder="name@omjmanager.com"></x-forms.auth-input>
                </div>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Your password')"/>
                <div class="relative mb-6">
                    <x-forms.auth-input-svg>
                        <path fill-rule="evenodd"
                              d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z"
                              clip-rule="evenodd">
                        </path>
                    </x-forms.auth-input-svg>
                    <x-forms.auth-input type="password" name="password"
                                        placeholder="••••••••••••••••••"></x-forms.auth-input>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-start">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <x-checkbox name="remember"/>
                    </div>
                    <x-label for="Remember me" class="pl-2"/>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="ml-auto text-sm text-blue-700 hover:underline dark:text-blue-400 font-medium">{{ __('Lost Password?') }}</a>
                @endif
            </div>

            <x-forms.auth-submit-button name="Login to your account"></x-forms.auth-submit-button>


            <div class="text-sm font-medium text-gray-500 dark:text-gray-300"> Not registered? <a
                    href="{{route('register')}}" class="text-blue-700 hover:underline dark:text-yellow-400">Create
                    account</a>
            </div>
        </x-form>
    </x-auth-card>


    {{--    <x-auth-card>--}}
    {{--        <x-slot name="logo">--}}
    {{--            <a href="/">--}}
    {{--                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />--}}
    {{--            </a>--}}
    {{--        </x-slot>--}}

    {{--        <!-- Session Status -->--}}
    {{--        <x-auth-session-status class="mb-4" :status="session('status')" />--}}

    {{--        <!-- Validation Errors -->--}}
    {{--        <x-auth-validation-errors class="mb-4" :errors="$errors" />--}}

    {{--        <x-form action="{{ route('login') }}">--}}
    {{--            @csrf--}}

    {{--            <!-- Email Address -->--}}
    {{--            <div>--}}
    {{--                <x-label for="email" :value="__('Email')" />--}}

    {{--                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />--}}
    {{--            </div>--}}

    {{--            <!-- Password -->--}}
    {{--            <div class="mt-4">--}}
    {{--                <x-label for="password" :value="__('Password')" />--}}

    {{--                <x-input id="password" class="block mt-1 w-full"--}}
    {{--                                type="password"--}}
    {{--                                name="password"--}}
    {{--                                required autocomplete="current-password" />--}}
    {{--            </div>--}}

    {{--            <!-- Remember Me -->--}}
    {{--            <div class="block mt-4">--}}
    {{--                <label for="remember_me" class="inline-flex items-center">--}}
    {{--                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">--}}
    {{--                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>--}}
    {{--                </label>--}}
    {{--            </div>--}}

    {{--            <div class="flex items-center justify-end mt-4">--}}
    {{--                @if (Route::has('password.request'))--}}
    {{--                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">--}}
    {{--                        {{ __('Forgot your password?') }}--}}
    {{--                    </a>--}}
    {{--                @endif--}}

    {{--                <x-button class="ml-3">--}}
    {{--                    {{ __('Log in') }}--}}
    {{--                </x-button>--}}
    {{--            </div>--}}
    {{--        </x-form>--}}
    {{--    </x-auth-card>--}}
</x-guest-layout>
