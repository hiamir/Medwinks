<div {{ $attributes->merge(['class' => 'flex justify-center items-center w-full']) }} >
    <label :for="fileID"
           class="flex flex-col justify-center items-center w-full h-56 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
        <div class="flex flex-col justify-center items-center pt-5 pb-6">
            <svg x-init="console.log(documentSelectedFile)" x-show="((tempUrl==='' && documentSelectedFile === '') )" aria-hidden="true"
                 class="mb-3 w-10 h-10 text-gray-400" fill="none"
                 stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            <img x-show="tempUrl && checkImage(tempUrl) === true"
                 class="w-20 h-20 rounded-full border-2 border-gray-100 my-2"
                 :src="tempUrl" alt="image description">

            <template x-if="checkImage(filePath+documentSelectedFile) === true ">
            <img x-show="!tempUrl && checkImage(filePath+documentSelectedFile) === true"
                 class="w-20 h-20 rounded-full border-2 border-gray-100 my-2"
                 :src="filePath+documentSelectedFile" alt="image description">
            </template>
            {{--                        CHECK FOR WORD DOCUMENT  TEMP URL               --}}

                <img x-show=" ((fileExtension(tempUrl) === 'doc' || fileExtension(tempUrl) === 'docx' ))"
                     class="w-20 h-20 rounded-full border-2 border-gray-100 my-2"
                     :src="'/storage/images/word-icon.jpg'" alt="Word Document">

                <img  x-show="((fileExtension(tempUrl) === 'pdf' ))"
                     class="w-20 h-20 rounded-full border-2 border-gray-100 my-2"
                     :src="'/storage/images/pdf-icon.jpg'" alt="Pdf Document">


            {{--                        CHECK FOR WORD PDF DOCUMENT                --}}
{{--            <template x-if="documentSelectedFile !== undefined && fileExtension(documentSelectedFile) === 'pdf'">--}}
                <img x-show="(!tempUrl && documentSelectedFile !== undefined && (fileExtension(documentSelectedFile) === 'doc' || fileExtension(documentSelectedFile) === 'docx'))"
                     class="w-20 h-20 rounded-full border-2 border-gray-100 my-2"
                     :src="'/storage/images/word-icon.jpg'" alt="Word Document">

                <img x-show="!tempUrl && documentSelectedFile !== undefined && fileExtension(documentSelectedFile) === 'pdf' "
                     class="w-20 h-20 rounded-full border-2 border-gray-100 my-2"
                     :src="'/storage/images/pdf-icon.jpg'" alt="Pdf Document">
{{--            </template>--}}


            {{--                        SHOW FILE               --}}

            <template x-if="!tempUrl && documentSelectedFile !== undefined && checkImage(documentSelectedFile) === true && checkFileExist(filePath+documentSelectedFile)">
                <img
                    x-show="!tempUrl && documentSelectedFile !== undefined && checkImage(documentSelectedFile) === true"
                    class="w-20 h-20 rounded-full border-2 border-gray-100 my-2"
                    :src="(!tempUrl && documentSelectedFile !== undefined && checkFileExist(filePath+documentSelectedFile)) ? filePath+documentSelectedFile : '/storage/images/not-found.jpg'"
                    :alt="documentSelectedFile">
            </template>

            {{--                        SHOW FILE NAME              --}}
            <template  x-if="!tempUrl && (documentSelectedFile !== undefined && documentSelectedFile.length > 0 )">
                <p x-show="((!tempUrl && documentSelectedFile !== undefined))"
                   class="text-xs flex mb-2 px-2 py-1 text-gray-200 bg-red-900 rounded-lg "
                   x-text="documentSelectedFile"></p>
            </template>

            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span>
                or drag and drop</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF, DOC, DOCX OR PDF (Max file
                size:
                500kb)</p>
            <p x-show="fileValidationError"
               class="!m-0 !mt-1 text-xs text-red-600 dark:text-red-600"
               x-text="fileValidationError"></p>
        </div>
        {{$slot}}

    </label>
</div>
