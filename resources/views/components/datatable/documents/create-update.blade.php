<x-datatable.modal.add-update
    x-data="{modalType:''}"
    x-init="
     AddUpdateModal.size='medium';
    $watch('modalDetails',function(value){ modalType=(value.modalType) })"

    x-show="modalDetails.formType==='document'">
    <x-form @submit.prevent="$wire.submitDocument" hasFiles=true class="space-y-6" novalidate autocomplete="off">
        {{--            Name        --}}
        <div class="grid grid-cols-1 space-x-3">
            <div class="mb-1">
                <label for="name"
                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Document Name</label>
                <input x-bind="bindDocumentName"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <p x-show="validationErrors['document.name']" class="!m-0 text-xs text-red-600 dark:text-red-600"
               x-text="validationErrors['document.name']"></p>
        </div>
        {{--            Notes        --}}
        <div class="grid grid-cols-1 space-x-3">
            <div class="mb-1">
                <label for=notes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Notes</label>
                <textarea x-bind="bindDocumentNotes" id="message" rows="4"
                          class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                          placeholder="Your notes..."></textarea>

                <p x-show="validationErrors['document.notes']" class="!m-0 !mt-1 text-xs text-red-600 dark:text-red-600"
                   x-text="validationErrors['document.notes']"></p>
            </div>
        </div>

        <template x-if="isUserManager===true && modalType==='update'">
            <div class="grid grid-cols-1 space-x-3">
                <div class="mb-1">
                    <label for="regions" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Select
                        your requirement</label>
                    <select x-bind="bindDocumentRequirement"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Please select your requirement</option>
                        <template x-for="(requirement, index) in requirements" :key="index">
                            <option :value="index" x-text="requirement"></option>
                        </template>
                    </select>
                    <p x-show="validationErrors['document.requirement']"
                       class="!m-0 !mt-1 text-xs text-red-600 dark:text-red-600"
                       x-text="validationErrors['document.requirement']"></p>
                </div>
            </div>
        </template>
        {{--            File        --}}
        <div x-data="{ filePath:'/storage/images/documents/' }"
             x-init="$watch('documentSelected.file',function(value){documentSelectedFile=value})"
             class="grid grid-cols-1 space-x-3">


            <x-forms.dropzone documentSelectedFile=documentSelected.file>
                <input wire:model="document.file" id="document-dropzone-file" type="file" class="hidden"/>
            </x-forms.dropzone>
        </div>
        <div class="grid grid-cols-1 space-x-3">
            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>
        </div>
    </x-form>
</x-datatable.modal.add-update>
