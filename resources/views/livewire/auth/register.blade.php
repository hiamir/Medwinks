<x-auth-card header="Sign in to our platform" guard="web">

    <x-form wire:submit.prevent="register" class="space-y-6" novalidate>
    @csrf

    <!-- Full name -->
        <div>
            <x-label for="name" :value="__('Your name')"/>
            <div class="relative">
                <x-forms.auth-input-svg>
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </x-forms.auth-input-svg>
                <x-forms.auth-input wire:model="name" type="text" name="name"
                                    placeholder="Your full name"></x-forms.auth-input>
            </div>
            <x-forms.form-error field="name"></x-forms.form-error>
        </div>




        <!-- Email -->

        <div>
            <x-label for="email" :value="__('Your email')"/>
            <div class="relative">
                <x-forms.auth-input-svg>
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                </x-forms.auth-input-svg>
                <x-forms.auth-input wire:model="email" type="text" name="email"
                                    placeholder="name@omjmanager.com"></x-forms.auth-input>
            </div>
            <x-forms.form-error field="email"></x-forms.form-error>
        </div>


        <!-- Password -->
        <div>
            <x-label for="password" :value="__('New password')"/>
            <div class="relative">
                <x-forms.auth-input-svg>
                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd" />
                </x-forms.auth-input-svg>
                <x-forms.auth-input wire:model="password" type="password" name="password"
                                    placeholder="••••••••••••••••••"></x-forms.auth-input>
            </div>
            <x-forms.form-error field="password"></x-forms.form-error>
        </div>

        <div>
            <x-label for="confirm_password" :value="__('Confirm password')"/>
            <div class="relative">
                <x-forms.auth-input-svg>
                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd" />
                </x-forms.auth-input-svg>
                <x-forms.auth-input wire:model="password_confirmation" type="password" name="confirm_password"
                                    placeholder="••••••••••••••••••"></x-forms.auth-input>
            </div>
            <x-forms.form-error field="confirm_password"></x-forms.form-error>
        </div>




        <x-forms.auth-submit-button name="Register"></x-forms.auth-submit-button>

        <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
            Already registered? <a href="{{route('login')}}" class="text-blue-700 hover:underline dark:text-yellow-400">Login to my account</a>
        </div>
    </x-form>

</x-auth-card>
