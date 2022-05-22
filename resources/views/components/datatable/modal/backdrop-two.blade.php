<div
    x-data="{isShow:false}"
    x-init="
            isShow=false;
            $watch('AccessDeniedModal.show',function(value){isShow=value});
            $watch('ErrorModal.show',function(value){isShow=value});
            "
    x-show="isShow"
    class="absolute flex z-30 flex top-0 left-0 min-w-full min-h-screen bg-gray-900 bg-opacity-80"
>
</div>
