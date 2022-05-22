@props(['header','subHeader'=>null,'modalSize'])
<div
    x-data=""
    x-show="openAuthModal"
        x-on:openLogin.window="openModal=true"
    x-cloak tabindex="-1" aria-hidden="true"
    class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full flex justify-center items-center h-screen drop-shadow-md5"
{{$attributes}}
>

    <div
        @switch($modalSize)
        @case ('small')
        class="relative p-4 w-full max-w-md h-full md:h-auto">
        @break

        @case ('medium')
        class="relative p-4 w-full max-w-xl h-full md:h-auto">
        @break

        @case ('large')
        class="relative p-4 w-full max-w-4xl h-full md:h-auto">
        @break

        @case ('xlarge')
        class="relative p-4 w-full max-w-7xl h-full md:h-auto">
        @break
        @endswitch

        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

            <div class="py-6 px-6 lg:px-8">
                <div class="flex flex-col items-left justify-between">

                    <h3 class="flex inline-flex justify-center items-center mb-0 text-xl font-medium text-gray-800 dark:text-gray-200 cal">
                        <x-svg.heroicons.user-circle class="flex inline-flex h-6 w-6 "></x-svg.heroicons.user-circle>
                        <span class="flex ml-2">{{$header}}</span>
                    </h3>
                 @if($subHeader !=null)  <span class="text-center text-xs  mt-2 dark:text-gray-300">{{$subHeader}}</span>@endif
                    <div class="flex ">
                        <button @click="openAuthModal=false" type="button"
                                class="absolute  top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </button>

                    </div>
                </div>
                {{$slot}}
            </div>
        </div>

    </div>
</div>

