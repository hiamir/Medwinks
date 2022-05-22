<div
    x-ref="access"
    class="z-40 hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full flex justify-center items-center h-screen drop-shadow-md5"
    :class="{'hidden':PhotoViewModal.show===false, 'flex':PhotoViewModal.show===true}"

>
    <div @click.away="PhotoViewModal.show=false"
         class="flex flex-row   justify-center max-w-lg min-w-[200px] w-auto h-auto bg-gray-200 rounded-xl border border-gray-200 drop-shadow-md2 dark:bg-white dark:border-white border-6 ">
        {{$slot}}
    </div>
</div>

