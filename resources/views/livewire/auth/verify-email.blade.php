<div x-data="Verification(
    {
    'verificationCode':$wire.entangle('verificationCode'),
    'verificationCodeLength':6,
    'isCodeExpired':$wire.entangle('isCodeExpired'),
    'isCodeMatched':$wire.entangle('isCodeMatched'),
    'expiringAt':$wire.entangle('expiringAt'),
    'msg': $wire.entangle('msg'),
    })"

     x-init="
{{--         console.log(msg);--}}
         $watch('msg',function(value){
{{--         this.msg=value;--}}
         console.log(value);
      })
"
>
    <x-auth-card type="two_factor" header="Two Factor Authentication" guard="web" class="">
        <div class="mt-2 mb-1 text-sm text-gray-600 dark:text-gray-200 text-center">
            {{ __('Verify your two-factor code sent to your email: ') }} <strong>{{auth()->user()->email}}</strong>
        </div>

        <div x-data="Timer({'expiringAt':$wire.entangle('expiringAt'),'isCodeExpired':$wire.entangle('isCodeExpired'),'isCodeMatched':$wire.entangle('isCodeMatched')})"
             x-init=" init(expiringAt); $refs.one.focus();" class="flex flex-col">

            <div id="countdown" class="flex flex-row w-100 justify-center mt-3 mb-3"
                 :class="{'hidden':isCodeExpired, 'flex':isCodeExpired===false}"
            >
                <div
                    class="flex flex-col bg-gray-100 text-gray-800 text-xs w-auto font-light  items-center px-2.5 py-1.5 rounded mr-2
                    dark:bg-gray-900/[0.7] dark:text-white"
                    {{--                    :class="{'hidden':isCodeExpired, 'flex':isCodeExpired===false}"--}}
                >
                    <div class="flex ">
                        <svg class="mr-1 w-4 h-4"
                             :class="{'hidden':isCodeExpired, 'flex':isCodeExpired===false}"
                             fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="flex">
                            <div class="flex  text-xs uppercase font-normal tracking-wide" x-text="time().remainingTime"></div>
                            <div class="flex  text-xs uppercase font-normal tracking-wide" x-text="time().minutes"></div>
                            <div class="flex  text-xs uppercase font-normal tracking-wide" x-text="':'"></div>
                            <div class="flex  text-xs uppercase font-normal tracking-wide" x-text="time().seconds"></div>
                            <div class="flex pl-1 text-xs  uppercase font-normal tracking-wide" x-text="' remaining'"></div>
                        </div>
                        <div>

                        </div>
                    </div>

                </div>


            </div>

            <div
                x-init="
                         $watch('msg',function(value){
                         if(value.action !== 'expired'){
                          resetVerificationCode();
                                          $refs.one.focus();
                                             setTimeout(() => msgReset(), 5000);
                                              }
                                          });
                                 "
                class="justify-center  mb-4"
                :class="{'flex':!(msg.action === ''), 'hidden':(msg.action === ''), 'my-3':isCodeExpired}"
            >
                <div
                    class="flex border dark:border-red-800 rounded-lg p-2 text-sm text-white dark:text-white dark:bg-red-700  py-1 px-2 justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                              clip-rule="evenodd"/>
                    </svg>
                    <span class="flex text-xs ml-1 font-semibold"
                          x-text="msg.message"></span>
                </div>
            </div>


{{--            <div x-show=" msg.type !=='' "--}}
{{--                 x-init="--}}
{{--                         $watch('msg',function(value){--}}
{{--                         if(value.action==='match1'){--}}
{{--                          resetVerificationCode();--}}
{{--                                          $refs.one.focus();--}}
{{--                                             setTimeout(() => msgReset(), 3000);--}}
{{--                                              }--}}
{{--                                          });--}}

{{--                                 "--}}
{{--                 class="flex flex-col justify-center mt-2">--}}
{{--                <div--}}
{{--                    class="flex border  rounded-xl p-2 text-sm text-white dark:text-white py-1 px-3 justify-center items-center"--}}
{{--                    :class="{'dark:border-red-800 dark:bg-red-600':msg.type==='error', 'dark:border-green-800 dark:bg-green-600':msg.type==='success'}"--}}
{{--                    role="alert">--}}
{{--                    <svg class="flex flex-shrink-0 mr-1.5 w-4 h-4" xmlns="http://www.w3.org/2000/svg"--}}
{{--                         class="h-5 w-5"--}}
{{--                         viewBox="0 0 20 20" fill="currentColor">--}}
{{--                        <path fill-rule="evenodd"--}}
{{--                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"--}}
{{--                              clip-rule="evenodd"/>--}}
{{--                    </svg>--}}
{{--                    <div>--}}
{{--                        <span class="flex font-medium text-xs" x-text="msg.message"></span>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}


            <div id="otp" class="flex flex-row justify-center text-center px-2 mt-0 mb-0">

                <input :disabled="isCodeExpired" x-mask="9" x-ref="one" autocomplete="off"
                       @keydown="verificationCode[0]=''"
                       @keyup.prevent="if(validateKeys.includes(verificationCode[0])){ $wire.verifyCode(); $refs.two.focus();}"
                       x-model="verificationCode[0]"
                       class="m-2 border h-[50px] w-[50px] font-bold text-xl text-center form-control rounded"
                       :class="{'dark:bg-gray-900/[0.3] dark:border-gray-900/[0.7]':isCodeExpired}" type="text"
                       id="first" maxlength="1"/>

                <input :disabled="isCodeExpired || !validateKeys.includes(verificationCode[0])" x-mask="9" x-ref="two" autocomplete="off"
                       @keydown="verificationCode[1]=''"
                       @keyup.prevent="if(validateKeys.includes(verificationCode[1])) $wire.verifyCode(); if(verificationCode[1] !== null ) $refs.three.focus();"
                       x-model="verificationCode[1]"
                       class="m-2 border h-[50px] w-[50px] font-bold text-xl text-center form-control rounded"
                       :class="{'dark:bg-gray-900/[0.3] dark:border-gray-900/[0.7]':(isCodeExpired || !validateKeys.includes(verificationCode[0]) )}" type="text"
                       id="second" maxlength="1"/>

                <input :disabled="isCodeExpired || !validateKeys.includes(verificationCode[1])" x-mask="9" x-ref="three" autocomplete="off"
                       @keydown="verificationCode[2]=''"
                       @keyup.prevent="if(validateKeys.includes(verificationCode[2])) $wire.verifyCode(); if(verificationCode[2] !== null ) $refs.four.focus();"
                       x-model="verificationCode[2]"
                       class="m-2 border h-[50px] w-[50px] font-bold text-xl text-center form-control rounded"
                       :class="{'dark:bg-gray-900/[0.3] dark:border-gray-900/[0.7]':(isCodeExpired || !validateKeys.includes(verificationCode[1]) )}" type="text"
                       id="second" maxlength="1"/>

                <input :disabled="isCodeExpired || !validateKeys.includes(verificationCode[2])" x-mask="9" x-ref="four" autocomplete="off"
                       @keydown="verificationCode[3]=''"
                       @keyup.prevent="if(validateKeys.includes(verificationCode[3])) $wire.verifyCode(); if(verificationCode[3] !== null ) $refs.five.focus();"
                       x-model="verificationCode[3]"
                       class="m-2 border h-[50px] w-[50px] font-bold text-xl text-center form-control rounded"
                       :class="{'dark:bg-gray-900/[0.3] dark:border-gray-900/[0.7]':(isCodeExpired || !validateKeys.includes(verificationCode[2]) )}" type="text"
                       id="second" maxlength="1"/>


                <input :disabled="isCodeExpired || !validateKeys.includes(verificationCode[3])" x-mask="9" x-ref="five" autocomplete="off"
                       @keydown="verificationCode[4]=''"
                       @keyup.prevent="if(validateKeys.includes(verificationCode[4])) $wire.verifyCode(); if(verificationCode[4] !== null ) $refs.six.focus();"
                       x-model="verificationCode[4]"
                       class="m-2 border h-[50px] w-[50px] font-bold text-xl text-center form-control rounded"
                       :class="{'dark:bg-gray-900/[0.3] dark:border-gray-900/[0.7]':(isCodeExpired || !validateKeys.includes(verificationCode[3]) )}" type="text"
                       id="second" maxlength="1"/>

                <input :disabled="isCodeExpired || !validateKeys.includes(verificationCode[4])" x-mask="9" x-ref="six" autocomplete="off"
                       @keydown="verificationCode[5]=''"
                       @keyup.prevent="if(validateKeys.includes(verificationCode[5])) $wire.verifyCode();"
                       x-model="verificationCode[5]"
                       class="m-2 border h-[50px] w-[50px] font-bold text-xl text-center form-control rounded"
                       :class="{'dark:bg-gray-900/[0.3] dark:border-gray-900/[0.7]':(isCodeExpired || !validateKeys.includes(verificationCode[4]) )}" type="text"
                       id="second" maxlength="1"/>
            </div>


            <div class="flex  text-gray-100 text-sm justify-center mt-2">
                <span class="flex" x-text="'Didnt receive the code?'"> </span>
                <span class="cursor-pointer ml-1 flex font-semibold underline hover:text-yellow-300"
                      @click.prevent="$wire.resendCode;" x-text="'Resend'"></span>
                <div wire:loading.inline wire:loading.attr="disabled"  wire:target="resendCode"  class="px-5 py-2.5 absolute top-0 left-0">
                    <svg role="status" class="inline w-4 h-4 mr-2 text-gray-900 animate-spin dark:text-gray-100" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                    </svg>
                </div>
            </div>
            {{--            @if($message != '')--}}
            {{--                <div class="flex justify-center">--}}
            {{--                    <div--}}
            {{--                        class="flex grow-0 py-2 px-4 mb-4 text-sm text-red-700 bg-red-600 rounded-lg dark:bg-red-700 dark:text-red-200 justify-center items-center"--}}
            {{--                        role="alert">--}}
            {{--                        <svg class="flex flex-shrink-0 mr-1.5 w-6 h-6" xmlns="http://www.w3.org/2000/svg"--}}
            {{--                             class="h-5 w-5"--}}
            {{--                             viewBox="0 0 20 20" fill="currentColor">--}}
            {{--                            <path fill-rule="evenodd"--}}
            {{--                                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"--}}
            {{--                                  clip-rule="evenodd"/>--}}
            {{--                        </svg>--}}
            {{--                        <div>--}}
            {{--                            <span class="font-medium text-sm">{{$message}}</span><a @click.prevent="$wire.resendCode"--}}
            {{--                                                                                    class="cursor-pointer font-bold text-sm underline hover:text-white">Resend</a>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--        @endif--}}

            {{--    @if (session('status') == 'verification-link-sent')--}}
            {{--        <div class="mb-4 font-semibold text-sm text-blue-500 dark:text-yellow-500">--}}
            {{--            'A new verification link has been sent to the email address, {{auth()->user()->email  }}.'--}}
            {{--        </div>--}}
            {{--    @endif--}}

            {{--    <div class="mt-4 flex items-center justify-between">--}}
            {{--        <form method="POST" action="{{ route('verification.send') }}">--}}
            {{--            @csrf--}}

            {{--            <div>--}}
            {{--                <x-button>--}}
            {{--                    {{ __('Resend Verification Email') }}--}}
            {{--                </x-button>--}}
            {{--            </div>--}}
            {{--        </form>--}}

            {{--        <form method="POST" action="{{ route('logout') }}">--}}
            {{--            @csrf--}}
            {{--            <x-forms.auth-submit-button name="{{ __('Log Out') }}"--}}
            {{--                                        class="!bg-red-600 !text-xs !font-semibold !uppercase">--}}

            {{--            </x-forms.auth-submit-button>--}}

            {{--            </button>--}}
            {{--        </form>--}}
            {{--    </div>--}}
            {{--    </x-form>--}}
        </div>
    </x-auth-card>

</div>
