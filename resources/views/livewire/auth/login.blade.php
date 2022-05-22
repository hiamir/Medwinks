<x-auth-card header="Sign in to our platform" guard="web">
    <x-form wire:submit.prevent="login" class="space-y-6" novalidate>
    @csrf

    <!-- Email Address -->
        <div>
            <x-label for="email" :value="__('Your email')"/>
            <div class="relative">
                <x-forms.auth-input-svg>
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                </x-forms.auth-input-svg>
                <x-forms.auth-input wire:model.defer="email" type="text" name="email" class="text-xs"
                                    placeholder="name@omjmanager.com"></x-forms.auth-input>
            </div>
            <x-forms.form-error field="email"></x-forms.form-error>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-label for="password" :value="__('Your password')"/>
            <div class="relative">
                <x-forms.auth-input-svg>
                    <path fill-rule="evenodd"
                          d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z"
                          clip-rule="evenodd">
                    </path>
                </x-forms.auth-input-svg>
                <x-forms.auth-input wire:model.defer="password" type="password" name="password"
                                    placeholder="••••••••••••••••••"></x-forms.auth-input>
            </div>
            <x-forms.form-error field="password"></x-forms.form-error>
        </div>

        <!-- Remember Me -->
        <div class="flex items-start">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <x-checkbox wire:model="remember" name="remember"/>
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
