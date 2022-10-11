<div
    class="z-20 overflow-y-auto hidden overflow-x-hidden fixed top-0 right-0 left-0 w-full md:inset-0 h-modal md:h-full flex justify-center items-center h-screen drop-shadow-md5"
    :class="{'hidden':AddUpdateModal.show===false, 'flex':AddUpdateModal.show===true}" {{$attributes}}
>
    <div
        class="flex flex-row  overflow-y-auto justify-center max-w-lg max-h-[80%] w-full bg-gray-200 rounded-lg border border-gray-200 drop-shadow-md2 dark:bg-gray-800 dark:border-gray-700"
        :class=
        "{
            'relative p-4 w-full max-w-md h-full md:h-auto max-w-[90%]':AddUpdateModal.size=='small',
            'relative p-4 w-full max-w-xl h-full md:h-auto max-w-[90%]' : AddUpdateModal.size=='medium',
            'relative p-4 w-full max-w-4xl h-full md:h-auto max-w-[90%]' : AddUpdateModal.size=='large',
            'relative p-4 w-full max-w-7xl h-full md:h-auto max-w-[90%]' :AddUpdateModal.size=='xlarge'
        }"
    >
        <div class="flex ">
            <button @click="AddUpdateModal.show=false" type="button"
                    class="absolute z-30 top-3 right-3 text-gray-400 border border-gray-400 dark:border-gray-600
                    bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
                     items-center dark:hover:bg-gray-800 dark:hover:text-white">
                <x-svg.heroicons.x class="flex inline-flex h-5 w-5 "></x-svg.heroicons.x>
            </button>
        </div>
        <div class="relative flex flex-col w-full items-start py-5 px-3">

            <h3 class="flex inline-flex  w-full border-b border-gray-600 dark:border-gray-600  pb-2 mb-3 justify-start items-center mb-0 text-xl font-medium text-gray-800 dark:text-gray-200 cal">
                <x-svg.heroicons.plus x-show="AddUpdateModal.type==='add'" class="flex inline-flex h-6 w-6 "></x-svg.heroicons.plus>
                <x-svg.heroicons.pencil x-show="AddUpdateModal.type=='update'" class="flex inline-flex h-6 w-6 "></x-svg.heroicons.pencil>
                <x-svg.heroicons.trash x-show="AddUpdateModal.type==='delete'" class="flex inline-flex h-6 w-6 "></x-svg.heroicons.trash>
                <span x-text='AddUpdateModal.title' class="flex ml-2"></span>
            </h3>
            <div class="flex flex-col w-full">
                {{$slot}}
            </div>
        </div>
    </div>
</div>



