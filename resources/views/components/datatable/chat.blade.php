<x-datatable.modal.chatModal>
    <div x-init="
        $watch('ChatModal.show',function(value){
            if(value) this.chats='';
        });
" class="flex flex-col max-h-[500px] overflow-y-auto">

        <div class="flex flex-col">
            <template x-if="chats.length > 0">
                <template x-for="chat in chats">
                    <div
                        class="flex flex-col mb-5 border border-gray-700 rounded bg-gray-900/[0.3] px-2 py-3 x-full">
                        <div class="flex">
                            <div class="flex flex-row">
                <span class="flex bg-gray-100 text-gray-800 text-xs font-medium inline-flex items-center px-1.5 py-0.5
                rounded mr-2 dark:bg-gray-700 dark:text-gray-300">
                  <svg aria-hidden="true" class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20"
                       xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                                clip-rule="evenodd"></path></svg>
                  <span class="flex text-xs" x-text="moment(chat.created_at).fromNow()"></span>
                </span>

                                <span class="flex bg-red-900 text-gray-800 text-xs font-medium inline-flex items-center px-1.5 py-0.5
                rounded mr-2 dark:bg-gray-500 dark:text-gray-300"
                                      :class="{'!bg-red-700' :chat.opened===0, '!bg-green-900' :chat.opened===1 }"
                                >

                  <span x-show="chat.opened===0" class="flex text-xs" x-text="'Not yet Seen'"></span>
                  <span x-show="chat.opened===1" class="flex text-xs" x-text="'Seen'"></span>
                </span>

                            </div>
                        </div>
                        <span class="flex text-gray-300 mt-2 text-xs" x-text="chat.comment"></span>
                    </div>
                </template>
            </template>

            <template x-if="chats.length === 0">
                <div
                    class="flex flex-row justify-start items-center mb-5 border border-gray-700 rounded bg-gray-900/[0.3] px-2 py-3 x-full">
                    <x-svg.main
                        type="exclamation"
                        class="flex h-4 w-4 text-gray-800 dark:text-gray-300 m-1"></x-svg.main>
                    </span>
                    <span class="flex text-xs text-gray-300" x-text="'No chats available!'"></span>
                </div>
            </template>
        </div>
    </div>

</x-datatable.modal.chatModal>
