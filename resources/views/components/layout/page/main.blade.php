{{--@props(['subHeader','modalType'])--}}

<div
{{--    x-data="Modal($wire)"--}}
x-data=" Main($wire,{
        setDocumentID : $persist(0),
        isUserManager:false
    }) "

     x-init="
     isUserManager= $wire.isUserManager;
     eventToListen()"
     class="flex h-screen overflow-y-hidden bg-white dark:bg-gray-800"
>
    <div x-data="setup()"
         x-init="

         $refs.loading.classList.add('hidden');
         $refs.access.classList.add('hidden')"
         class="flex w-full h-full"
    >
        {{$slot}}


        <x-datatable.modal.access-denied></x-datatable.modal.access-denied>
        <x-datatable.modal.error></x-datatable.modal.error>
        <x-datatable.modal.success></x-datatable.modal.success>
        <x-datatable.modal.login></x-datatable.modal.login>
        <x-datatable.toast></x-datatable.toast>


        {{--    <x-datatable.modal.auth-modal header="Authentication Required"  subHeader="{{$subHeader}}" modalSize="small">--}}

{{--                <div--}}
{{--                    x-data="{authError:$wire.entangle('authError')}"--}}
{{--                    x-init=--}}
{{--                    "$watch('authError',function(value){--}}
{{--                        setTimeout(() => authError = false, 3000)--}}
{{--                    })"--}}
{{--                    x-show="authError" x-transition.opacity--}}
{{--                    class="flex p-2 my-4 text-xs text-red-100 bg-red-700 rounded-lg dark:bg-red-900 dark:text-red-100" role="alert">--}}
{{--                    <svg class="inline flex-shrink-0 mr-3 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>--}}

{{--                    <div>--}}
{{--                        <span class="font-medium">Invalid credentials. Please try again.</span>--}}
{{--                    </div>--}}
{{--                </div>--}}

        {{--        <x-datatable.relogin header="Re-authentication required."></x-datatable.relogin>--}}
        {{--    </x-datatable.modal.auth-modal>--}}


        <x-datatable.modal.backdrop></x-datatable.modal.backdrop>
        <x-datatable.modal.backdrop-two></x-datatable.modal.backdrop-two>
    </div>
</div>

