<div
    x-data="{isShow:false}"
    x-init="
            isShow=false;


            $watch('LoginModal.show',function(value){isShow=value});
             $watch('PhotoViewModal.show',function(value){isShow=value});
            $watch('isHeaderMenuOpen',function(value){isShow=value});
            $watch('AddUpdateModal.show',function(value){isShow=value});
            $watch('openDecisionModal.show',function(value){isShow=value});
            $watch('SuccessModal.show',function(value){isShow=value});
            $watch('DeleteModal.show',function(value){isShow=value});
            $watch('ConfirmationModal.show',function(value){isShow=value});
            $watch('ChatModal.show',function(value){isShow=value});
            $watch('RequirementModal.show',function(value){isShow=value});
            $watch('PasswordResetModal.show',function(value){isShow=value});
             $watch('RoleMenuToggle',function(value){isShow=value});
            "
    x-show="isShow"
    class="!absolute flex !z-10 flex top-0 left-0 min-w-full min-h-screen bg-gray-900 bg-opacity-80"
>
</div>
