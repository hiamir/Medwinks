<x-auth-card header="Verify you email" guard="web">
{{--    <x-form wire:submit.prevent="login" class="space-y-6" novalidate>--}}
        <div class="my-4 text-sm text-gray-600 dark:text-gray-200">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-semibold text-sm text-blue-500 dark:text-yellow-500">
                'A new verification link has been sent to the email address,  {{auth()->user()->email  }}.'
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}" >
                @csrf

                <div>
                    <x-button>
                        {{ __('Resend Verification Email') }}
                    </x-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-forms.auth-submit-button name="{{ __('Log Out') }}" class="!bg-red-600 !text-xs !font-semibold !uppercase">

                </x-forms.auth-submit-button>

                </button>
            </form>
        </div>
{{--    </x-form>--}}

</x-auth-card>
