<div class="flex grid grid-cols-6 lg:grid-cols-6 dark:bg-gray-900 relative "
     x-data="{isMenuOpen:true,mobile:false,screen_width:0}"
     @resize.window="
     screen_width = window.innerWidth;
     if(window.innerWidth<1200){
        mobile=true; isMenuOpen=true;
         }else{
         mobile=false;
         }
     "
     x-init="
     screen_width = window.innerWidth;
     if(window.innerWidth<1200){
     mobile=true;
     }
"
>
    <div
        class="relative  xs:max-h-screen xs:absolute xs:overflow-auto xs:z-20 xl:relative xs:w-80 xl:w-auto xl:col-span-1 drop-shadow-[0_2.5px_2.5px_rgba(0,0,0,0.75)] dark:drop-shadow-[0_2.5px_2.5px_rgba(0,0,0,1)]">
        <livewire:layouts.sidebar/>
    </div>
    <div class="col-span-5 xs:col-span-6 sm:col-span-6 xl:col-span-5 ">
        <livewire:layouts.header/>
    </div>
    {{--    <div class="col-span-6 xs:col-span-6 sm:col-span-6 xl:col-span-6 h-[65px]">--}}

    {{--    </div>--}}
</div>

