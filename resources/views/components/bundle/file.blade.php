<div {{$attributes}}
     x-on:livewire-upload-start="isUploading = true"
     x-on:livewire-upload-finish="isUploading = false"
     x-on:livewire-upload-error="isUploading = false"
     x-on:livewire-upload-progress="progress = $event.detail.progress"
     class="max-w-full bg-white  rounded-lg border border-gray-200 dark:bg-gray-900/[0.3] dark:border-gray-700">

    <div x-show="tempUrl !== null " class="flex w-full text-center justify-center items-center">
        <div class="flex flex-col justify-center items-center">
            <div class="flex rounded-full  w-[70px] h-[70px] overflow-hidden border-2 border-gray-100 mt-4">
                <img class="flex object-cover hover:bg-blend-darken w-[70px] h-[70px]" :src="tempUrl">
            </div>
            <div class="flex w-full text-xs dark:text-gray-400 pt-2 justify-center items-center">
                <span x-text="tempName"></span>
            </div>
        </div>
    </div>
{{--    <div x-show="isUploading" class="flex w-full h-full justify-center items-center">--}}
{{--        <progress max="100" x-bind:value="progress"></progress>--}}
{{--    </div>--}}
    <div class="flex justify-end p-4" >
        <div class="flex flex-col w-full justify-center">
            <div class="flex  w-[100%]">
                <div class="flex w-full">
                    <div class="relative w-full">
                        <label class="flex cursor-pointer justify-center dark:bg-gray-900/[0.6] dark:hover:bg-gray-900 text-center uppercase border  dark:border-gray-700 dark:text-gray-300
                                                p-2.5 rounded text-xs tracking"><span class="flex" x-text="placeholder"></span>
                            {{$slot}}
                        </label>
                    </div>

                </div>

            </div>

        </div>
        <div x-show="isSubmitButton" class="flex flex-col justify-end ml-3">
            <x-forms.submit class="flex flex-col p-0"><span x-text="'Upload'"></span></x-forms.submit>
        </div>
    </div>



    <x-forms.error x-show="validationErrors[livewireName] != null"
                   x-text="validationErrors[livewireName]"
                   class="!mx-4 !my-0 !mb-3">
    </x-forms.error>
</div>
