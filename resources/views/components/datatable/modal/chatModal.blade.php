<div
    class="z-50 overflow-y-auto overflow-x-hidden hidden fixed top-0 right-0 left-0 w-full md:inset-0 h-modal md:h-full flex justify-center items-center h-screen drop-shadow-md5"
    :class="{'hidden':ChatModal.show===false, 'flex':ChatModal.show===true}"
>
    <div  @click.prevent.away="ChatModal.show=false" class="flex flex-col  py-5 px-5 justify-center max-w-sm w-[450px] max-w-lg w-[550px] bg-gray-200 rounded-lg
    border border-gray-200 drop-shadow-md2 dark:bg-gray-800 dark:border-gray-700 ">
                <h4 x-text="ChatModal.title" class="flex w-full mb-2 text-lg font-bold text-red-800 dark:text-white capitalize"></h4>
        {{$slot}}
    </div>
</div>


