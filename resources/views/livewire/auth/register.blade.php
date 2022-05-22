<x-auth-card header="Sign in to our platform" guard="web">

    <x-form
        x-data="{
            user:$wire.entangle('user.name').defer,
            email:$wire.entangle('user.email').defer,
            password:$wire.entangle('user.password').defer,
            password_confirmation:$wire.entangle('user.password_confirmation').defer,
            country:$wire.entangle('user.country'),
            region:$wire.entangle('user.region'),
            genderID:$wire.entangle('user.genderID'),
            gender:{},
            countries:[],
            name:$wire.entangle('user.name').defer,
            regions: $wire.entangle('regions')
        }"
        x-init="
        gender={{$gender}};
        countries={{$countries}};

        "
        wire:submit.prevent="register" class="space-y-6" novalidate autocomplete="off">
    @csrf

    <!-- Full name -->
        <div>
            <x-label for="name" :value="__('Your name')"/>
            <div class="relative">
                <x-forms.auth-input-svg>
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                          clip-rule="evenodd"/>
                </x-forms.auth-input-svg>
                <x-forms.auth-input x-model="name" type="text" name="name"
                                    placeholder="Your full name"></x-forms.auth-input>
            </div>
            <x-forms.form-error field="user.name"></x-forms.form-error>
        </div>

        <!-- Email -->
        <div>
            <x-label for="email" :value="__('Your email')"/>
            <div class="relative">
                <x-forms.auth-input-svg>
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                </x-forms.auth-input-svg>
                <x-forms.auth-input  x-model="email" type="text" name="email"
                                    placeholder="name@omjmanager.com"></x-forms.auth-input>
            </div>
            <x-forms.form-error field="user.email"></x-forms.form-error>
        </div>



        <!-- Password -->
        <div>
            <x-label for="password" :value="__('New password')"/>
            <div class="relative">
                <x-forms.auth-input-svg>
                    <path fill-rule="evenodd"
                          d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z"
                          clip-rule="evenodd"/>
                </x-forms.auth-input-svg>
                <x-forms.auth-input x-model="password" type="password" name="password"
                                    placeholder="••••••••••••••••••"></x-forms.auth-input>
            </div>
            <x-forms.form-error field="user.password"></x-forms.form-error>
        </div>

        <div>
            <x-label for="confirm_password" :value="__('Confirm password')"/>
            <div class="relative">
                <x-forms.auth-input-svg>
                    <path fill-rule="evenodd"
                          d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z"
                          clip-rule="evenodd"/>
                </x-forms.auth-input-svg>
                <x-forms.auth-input  x-model="password_confirmation" type="password" name="confirm_password"
                                    placeholder="••••••••••••••••••"></x-forms.auth-input>
            </div>
            <x-forms.form-error field="user.confirm_password"></x-forms.form-error>
        </div>


        <div class="mb-3">
            <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Select
                your country</label>
            <select x-model="country" name=country"
                    class="bg-gray-50 cursor-pointer border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500  dark:bg-gray-500/[0.2] dark:border-blue-500/[0.3] dark:bg-gray-500/[0.2] dark:border-blue-500/[0.3]">
                <option value="">Please select your country</option>
                <template x-for="(country, index) in countries" :key="index">
                    <option :value="country.id" x-text="country.name"></option>
                </template>
            </select>
            <x-forms.form-error field="user.country"></x-forms.form-error>
        </div>

        <div class="mb-3">
            <label for="regions" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Select
                your region</label>
            <select x-model="region"  name="region"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500  dark:bg-gray-500/[0.2] dark:border-blue-500/[0.3] dark:bg-gray-500/[0.2] dark:border-blue-500/[0.3]">
                <option value="">Please select your region</option>
                <template x-for="(region, index) in regions" :key="index">
                    <option :value="index" x-text="region"></option>
                </template>
            </select>
            <x-forms.form-error field="user.regions_id"></x-forms.form-error>
        </div>

        <!-- Gender -->
        <div class="mb-4">
            <x-label for="gender" :value="__('Your Gender')"/>
            <div class="relative">
                <div class="flex">
                    <template x-for="sex in gender" :key="sex.id">
                        <div class="flex items-center mr-4">
                            <input @change="genderID=sex.id; console.log(genderID)" x-model="genderID" :value="sex.id"  :id="'gender-'+sex.id" type="radio"  :name="sex.name"
                                   class="cursor-pointer w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600
                                   dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="inline-radio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"><span
                                    x-text="sex.name"></span></label>
                        </div>
                    </template>

                </div>
                <x-forms.form-error field="user.genderID"></x-forms.form-error>
            </div>
        </div>


        <x-forms.auth-submit-button name="Register"></x-forms.auth-submit-button>

        <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
            Already registered? <a href="{{route('login')}}" class="text-blue-700 hover:underline dark:text-yellow-400">Login
                to my account</a>
        </div>
    </x-form>

</x-auth-card>
