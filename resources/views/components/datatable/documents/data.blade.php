<div  class="p-4 bg-gray-50 rounded-lg dark:bg-gray-900/[0.7]" id="documents">
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab">
            <template x-for="(document,index) in documents" :key="index">
                <li
                    x-init="if(!activeStart){ documentID=document.id; requirementTabID = document.id; activeStart=true; }"
                    class="mr-2 mb-3" role="presentation">
                    <button @click.prevent="documentID=document.id; requirementTabID=document.id"
                            class="inline-block p-2 px-3 rounded-lg dark:text-gray-400 hover:text-blue-600  dark:hover:text-blue-500"
                            :class="{'text-blue-600 dark:text-blue-500 border border-blue-600 dark:border-blue-500':documentID===document.id}"
                            :id="document.name+'-tab'" type="button">
                        <span x-text="document.name"></span>
                    </button>
                </li>

            </template>
        </ul>
    </div>
    <template x-for="(document,index) in documents" :key="index">
        <div >
            <div x-show="documentID===document.id" class="  bg-gray-50 rounded-lg dark:bg-transparent">
                <div  class="p-4 w-full grid xxl:grid-cols-5 xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-2 xs:grid-cols-1 gap-4">
                    @if($this->permission('user-document-create'))
                        <div @click.prevent="MyModal('add','document',{'formData':{} }); documentSelected={}; documentSelected.file=''; tempUrl=''; $wire.resetDocument()"
                            class="flex flex-col p-6 w-full min-h-64  justify-center items-center bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 cursor-pointer dark:hover:bg-gray-900/[0.5]"
                            {{--                                :class="{'dark:!bg-red-900/[0.5] hover:dark:!bg-red-900/[0.7] dark:border-red-900':documentFile.rejected===1, 'dark:!bg-green-900/[0.5] hover:dark:!bg-green-900/[0.7] dark:border-green-900':documentFile.accepted===1}"--}}
                        >
                            <x-svg.main
                                type="plus"
                                class="flex self-center relative z-10 h-[30%] w-[30%] text-red-800 dark:text-gray-300/[0.4]  m-1 mb-3">
                            </x-svg.main>
                        </div>
                    @endif
                    <template x-for="(file, index) in document.documents">

                        <div :id="'frame-'+index"
                             @click.prevent.self="(canDocumentUpdate === false) ? ErrorModal = { 'show': true, 'type': 'error', 'title': 'Access Denied!', 'message': 'Cannot update as file decision was finalized' } : '' ;
                              ((file.accepted===0 && file.rejected===0 && file.revision===1) && isUserManager===true ) ? MyModal('update','document',{'formData':file}) : ErrorModal = { 'show': true, 'type': 'error', 'title': 'Revision!', 'message': 'Cannot update as the document is under review' };
                              ((file.accepted===1 && file.rejected===0 && file.revision===0) || (file.accepted===0 && file.rejected===1 && file.revision===0)) ? ErrorModal = { 'show': true, 'type': 'error', 'title': 'Final Decision!', 'message': 'Cannot update as the final decision was made on this document' }: '';
                              documentSelected=file; tempUrl='';"
                             class="flex cursor-pointer flex-col p-6 z-10 relative  @if($this->permission('user-file-update')) pt-2 @else pt-5 @endif px-2 max-w-xm justify-center items-center bg-white rounded-lg border shadow-md "
                             :class="{
                         'dark:!bg-red-900/[0.5] hover:dark:!bg-red-900/[0.7] dark:border-red-900' : (file.accepted===0 && file.rejected===1 && file.revision===0),
                         'dark:!bg-green-900/[0.5] hover:dark:!bg-green-900/[0.7] dark:border-green-900':(file.accepted===1 && file.rejected===0 && file.revision===0),
                         'dark:!bg-yellow-900/[0.5] hover:dark:!bg-yellow-900/[0.7] dark:border-yellow-900':(file.accepted===0 && file.rejected===0 && file.revision===1),
                         'dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-900/[0.5]':(file.accepted===0 && file.rejected===0 && file.revision===0)
                                    }"
                        >

                            <div class="flex flex-row w-full z-50  top-2 right-2 absolute justify-end items-center">
                                <a @click.prevent="$wire.documentChat(file)"
                                   class="flex ">
                                    <x-svg.main
                                        type="chat"
                                        class="flex self-end relative z-50 h-[23px] w-[23px] text-red-800 dark:text-gray-300/[0.4] hover:!text-gray-300/[0.7] m-1 mb-3">
                                    </x-svg.main>
                                </a>

                                <x-svg.main
                                    x-show="(file.applications.length > 0)"
                                    type="link"
                                    class="flex self-end absolute top-1 left-5  z-10 h-[20px] w-[20px] text-red-800 dark:text-gray-300/[0.3] hover:!text-gray-300/[0.7] m-1 mb-3 ml-0">
                                </x-svg.main>

                                @if($this->permission('user-document-delete'))
                                    <a
                                        x-show="((file.accepted===0 && file.rejected===0 &&  file.revision===0) || (file.accepted===0 && file.rejected===0 &&  file.revision===1)) && file.applications.length === 0"
                                        @click.prevent="(file.applications.length === 0) ? MyModal('delete','document',{'formData':file}) : ErrorModal = { 'show': true, 'type': 'error', 'title': 'file Link!', 'message': 'Cannot delete as one or more of the applications are using this document' }; fileSelected=file"
                                        class="flex ">
                                        <x-svg.main
                                            type="delete-open"
                                            class="flex self-end relative z-10 h-[25px] w-[25px] text-red-800 dark:text-gray-300/[0.4] hover:!text-gray-300/[0.7] m-1 mb-3 ml-0">
                                        </x-svg.main>
                                    </a>
                                @endif
                            </div>

                            <div class="flex justify-center items-center mt-8 mb-3">

            <span class="flex relative cursor-pointer sel border-4 border-red-800  dark:border-gray-100 rounded-full w-10 h-10 justify-center items-center m-0 "

            >
                                         <x-svg.main x-show="file.rejected===0 && file.accepted===1 && file.revision===0" type="check-open"
                                                     class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                         <x-svg.main x-show="file.rejected===1 && file.accepted===0 && file.revision===0" type="delete-open"
                                                     class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                         <x-svg.main x-show="file.rejected===0 && file.accepted===0 && file.revision===1" type="refresh"
                                                     class="h-4 w-4 text-yellow-800 dark:text-gray-300 m-1"></x-svg.main>
                                         <x-svg.main x-show="file.rejected===0 && file.accepted===0 && file.revision===0"
                                                     type="question-open"
                                                     class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                <span x-show="(file.active===1)" class="absolute flex border-4 border-red-800 dark:border-gray-100 rounded-full w-10 h-10 justify-center items-center m-0 animate-ping"> </span>
                                     </span>
                            </div>

                            <div class=" flex  cursor-pointer flex-col items-center px-4">
                                <div class="mb-2">
                                    <span x-show="file.rejected===0 && file.accepted===0 && file.revision===0"
                                              class="mb-2 bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300"
                                              x-text="'Under Review'"></span>
                                    <span x-show="file.accepted===1 && file.rejected===0 && file.revision===0"
                                          :id="'accept'-file.id"
                                          class="mb-2 bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded bg-green-500 dark:text-green-900"
                                          x-text="'Accepted'"></span>

                                    <span x-show="file.accepted===0 && file.rejected===0 && file.revision===1"
                                          :id="'revision'-file.id"
                                          class="mb-2 bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded bg-yellow-500 dark:text-yellow-900"
                                          x-text="'Revision'"></span>

                                    <span x-show="file.accepted===0 && file.rejected===1 && file.revision===0"
                                          :id="'reject'-file.id"
                                          class="mb-2 bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded bg-red-500 dark:text-red-900"
                                          x-text="'Rejected'"></span>
                                </div>
                                <p class="flex self-end mb-2 text-[0.7rem] font-normal text-gray-700 dark:text-gray-100/[0.3] leading-tight text-center"
                                   x-text="'Created '+moment(file.created_at).format('MMMM Do YYYY')"
                                ></p>
                            </div>
                            <div class="flex cursor-pointer flex-col grow justify-start items-center">
                                <template x-if="file.file!==undefined">
                                <h5
                                    x-show="file.file.length > 0 "
                                    class="flex mb-2 text-center text-md font-bold tracking-tight text-gray-900 dark:text-white"
                                    x-text="file.name">
                                </h5>
                                </template>

                                <template x-if="!checkFileExist('/storage/images/documents/', file.file)">
                                     <p x-show="(file.accepted!==0 && file.rejected!==0 &&  file.revision!==0) && (file.file.length === 0 || !checkFileExist('/storage/images/documents/'+file.file))"
                                       class="text-xs flex mb-2 px-2 py-1 text-gray-200 font-semibold bg-red-900 rounded-lg "
                                       x-text="'Upload Document'"></p>


                                </template>


                                <template x-if="!checkFileExist('/storage/images/documents/', file.file)">


                                    <p x-show="(file.accepted===0 && file.rejected===0 &&  file.revision===0) && (file.file.length === 0 || !checkFileExist('/storage/images/documents/'+file.file))"
                                       class="text-xs flex mb-2 px-2 py-1 text-gray-200 font-semibold bg-red-900 rounded-lg "
                                       x-text="'Document Missing'"></p>
                                </template>
{{--                                <span x-show="moment(file.expiry_date).isBefore(moment())"--}}
{{--                                      class="my-3 mt-1 dark:!bg-red-900 text-red-800 !text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-200"--}}
{{--                                      x-text="'Expired'"></span>--}}

                                {{--                                        <p class="flex mb-3 text-sm font-normal text-gray-700 dark:text-gray-400"--}}
                                {{--                                           x-text="fileFile.file"></p>--}}
                            </div>
                            <div class="flex flex-row space-x-2 pt-2">
                                @if($this->permission('user-document-download'))
                                    <template x-if="file.file.length > 0 ">
                                    <a
                                        x-show="checkFileExist('/storage/images/documents/',file.file) === true"
                                        @click.prevent=" $wire.photoType='document'; $wire.export(file.file); "
                                        class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <x-svg.main type="download"
                                                    class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                    </a>
                                    </template>
                                @endif
                                @if($this->permission('user-document-view'))
                                    <a x-show="checkImage(file.file)===true" @click.prevent="photoType='file'; $wire.photoView(file.file, 'file');"
                                       class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-purple-700 rounded-md hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                                        <x-svg.main type="view"
                                                    class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                    </a>
                                @endif

                                @if($this->permission('user-document-accept'))
                                    <a x-show="((file.accepted===0 && file.rejected===0 && file.revision===0))"
                                       @click.prevent="if(file.accepted===0) { fileType='file'; comments=''; $wire.acceptDocument(file.id) }"
                                       class="flex items-center justify-center w-8 h-7  text-sm font-medium text-center text-white dark:text-white bg-green-700 rounded-md hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                        <x-svg.main type="check-open"
                                                    class="h-[15px] w-[15px] text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                    </a>
                                @endif
                                @if($this->permission('user-document-reject'))
                                    <a
                                        x-show="((file.accepted===0 && file.rejected===0 && file.revision===0) )"
                                        @click.prevent="if(file.rejected===0){ fileType='file'; comments=''; $wire.rejectDocument(file.id) }"
                                        class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-red-700 rounded-md hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                        <x-svg.main type="delete-open"
                                                    class="h-[15px] w-[15px] text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                    </a>
                                @endif
                                @if($this->permission('user-document-revision'))
                                    <a x-show="((file.accepted===0 && file.rejected===0 && file.revision===0))"
                                       @click.prevent=" fileType='file'; comments='';  $wire.reviseDocument(file.id); "
                                       class="flex items-center justify-center mb-2  w-8 h-7 text-sm font-medium text-center text-white bg-yellow-500 rounded-md hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:focus:ring-red-800">
                                        <x-svg.main type="refresh"
                                                    class="h-[15px] w-[15px] text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                    </a>
                                @endif

                                    <p x-show="(document.accepted===1 && document.rejected===0 && document.revision===0) && !checkFileExist('/storage/images/documents/',file.file)" class="text-xs flex mb-2 px-2 py-1 text-gray-200 font-semibold bg-red-900 rounded-lg " x-text="'Document file unavailable'"> </p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </template>
</div>



























{{--<div  class="p-4 w-full grid xxl:grid-cols-5 xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-2 xs:grid-cols-1 gap-4">--}}
{{--    @if($this->permission('user-document-create'))--}}
{{--        <div--}}
{{--            @click.prevent="MyModal('add','document',{'formData':{} }); documentSelected={}; tempUrl=''; $wire.resetdocument()"--}}
{{--            class="flex flex-col p-6 w-full min-h-64  justify-center items-center bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 cursor-pointer dark:hover:bg-gray-900/[0.5]"--}}
{{--            --}}{{--                                :class="{'dark:!bg-red-900/[0.5] hover:dark:!bg-red-900/[0.7] dark:border-red-900':documentFile.rejected===1, 'dark:!bg-green-900/[0.5] hover:dark:!bg-green-900/[0.7] dark:border-green-900':documentFile.accepted===1}"--}}
{{--        >--}}
{{--            <x-svg.main--}}
{{--                type="plus"--}}
{{--                class="flex self-center relative z-10 h-[30%] w-[30%] text-red-800 dark:text-gray-300/[0.4]  m-1 mb-3">--}}
{{--            </x-svg.main>--}}
{{--        </div>--}}
{{--    @endif--}}
{{--    <template x-init="console.log(documents)" x-for="(document, index) in documents">--}}
{{--        <div :id="'frame-'+index"--}}
{{--             @click.prevent.self="((document.accepted===0 && document.rejected===0 && document.revision===0) || (document.accepted===0 && document.rejected===0 && document.revision===1)) ? MyModal('update','document',{'formData':document}) : ErrorModal = { 'show': true, 'type': 'error', 'title': 'document Decision!', 'message': 'Cannot update as document decision was finalized' };  documentSelected=document; tempUrl='';"--}}
{{--             class="flex cursor-pointer flex-col p-6 z-10 relative  @if($this->permission('user-document-update')) pt-2 @else pt-5 @endif px-2 max-w-xm justify-center items-center bg-white rounded-lg border shadow-md "--}}
{{--             :class="{--}}
{{--                         'dark:!bg-red-900/[0.5] hover:dark:!bg-red-900/[0.7] dark:border-red-900' : (document.accepted===0 && document.rejected===1 && document.revision===0),--}}
{{--                         'dark:!bg-green-900/[0.5] hover:dark:!bg-green-900/[0.7] dark:border-green-900':(document.accepted===1 && document.rejected===0 && document.revision===0),--}}
{{--                         'dark:!bg-yellow-900/[0.5] hover:dark:!bg-yellow-900/[0.7] dark:border-yellow-900':(document.accepted===0 && document.rejected===0 && document.revision===1),--}}
{{--                         'dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-900/[0.5]':(document.accepted===0 && document.rejected===0 && document.revision===0)--}}
{{--                                    }"--}}
{{--        >--}}

{{--            <div class="flex flex-row w-full z-50  top-2 right-2 absolute justify-end items-center">--}}
{{--                <a @click.prevent="$wire.documentChat(document)"--}}
{{--                   class="flex ">--}}
{{--                    <x-svg.main--}}
{{--                        type="chat"--}}
{{--                        class="flex self-end relative z-50 h-[23px] w-[23px] text-red-800 dark:text-gray-300/[0.4] hover:!text-gray-300/[0.7] m-1 mb-3">--}}
{{--                    </x-svg.main>--}}
{{--                </a>--}}

{{--                <x-svg.main--}}
{{--                    x-show="(document.applications.length > 0)"--}}
{{--                    type="link"--}}
{{--                    class="flex self-end absolute top-1 left-5  z-10 h-[20px] w-[20px] text-red-800 dark:text-gray-300/[0.3] hover:!text-gray-300/[0.7] m-1 mb-3 ml-0">--}}
{{--                </x-svg.main>--}}

{{--                @if($this->permission('user-document-delete'))--}}
{{--                    <a--}}
{{--                        x-show="((document.accepted===0 && document.rejected===0 &&  document.revision===0) || (document.accepted===0 && document.rejected===0 &&  document.revision===1)) && document.applications.length === 0"--}}
{{--                        @click.prevent="(document.applications.length === 0) ? MyModal('delete','document',{'formData':document}) : ErrorModal = { 'show': true, 'type': 'error', 'title': 'document Link!', 'message': 'Cannot delete as one or more of the applications are using this document' }; documentSelected=document"--}}
{{--                        class="flex ">--}}
{{--                        <x-svg.main--}}
{{--                            type="delete-open"--}}
{{--                            class="flex self-end relative z-10 h-[25px] w-[25px] text-red-800 dark:text-gray-300/[0.4] hover:!text-gray-300/[0.7] m-1 mb-3 ml-0">--}}
{{--                        </x-svg.main>--}}
{{--                    </a>--}}
{{--                @endif--}}
{{--            </div>--}}

{{--<div class="flex justify-center items-center mt-8 mb-3">--}}

{{--            <span class="flex relative cursor-pointer sel border-4 border-red-800  dark:border-gray-100 rounded-full w-10 h-10 justify-center items-center m-0 "--}}

{{--            >--}}
{{--                                         <x-svg.main x-show="document.rejected===0 && document.accepted===1 && document.revision===0" type="check-open"--}}
{{--                                                     class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>--}}
{{--                                         <x-svg.main x-show="document.rejected===1 && document.accepted===0 && document.revision===0" type="delete-open"--}}
{{--                                                     class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>--}}
{{--                                         <x-svg.main x-show="document.rejected===0 && document.accepted===0 && document.revision===1" type="refresh"--}}
{{--                                                     class="h-4 w-4 text-yellow-800 dark:text-gray-300 m-1"></x-svg.main>--}}
{{--                                         <x-svg.main x-show="document.rejected===0 && document.accepted===0 && document.revision===0"--}}
{{--                                                     type="question-open"--}}
{{--                                                     class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>--}}
{{--                <span x-show="(document.active===1)" class="absolute flex border-4 border-red-800 dark:border-gray-100 rounded-full w-10 h-10 justify-center items-center m-0 animate-ping"> </span>--}}
{{--                                     </span>--}}
{{--</div>--}}

{{--            <div class=" flex  cursor-pointer flex-col items-center px-4">--}}
{{--                <div class="mb-2">--}}
{{--                                        <span x-show="document.rejected===0 && document.accepted===0 && document.revision===0"--}}
{{--                                              class="mb-2 bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300"--}}
{{--                                              x-text="'Pending'"></span>--}}
{{--                    <span x-show="document.accepted===1 && document.rejected===0 && document.revision===0"--}}
{{--                          :id="'accept'-document.id"--}}
{{--                          class="mb-2 bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded bg-green-500 dark:text-green-900"--}}
{{--                          x-text="'Accepted'"></span>--}}

{{--                    <span x-show="document.accepted===0 && document.rejected===0 && document.revision===1"--}}
{{--                          :id="'revision'-document.id"--}}
{{--                          class="mb-2 bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded bg-yellow-500 dark:text-yellow-900"--}}
{{--                          x-text="'Revision'"></span>--}}

{{--                    <span x-show="document.accepted===0 && document.rejected===1 && document.revision===0"--}}
{{--                          :id="'reject'-document.id"--}}
{{--                          class="mb-2 bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded bg-red-500 dark:text-red-900"--}}
{{--                          x-text="'Rejected'"></span>--}}
{{--                </div>--}}
{{--                <p class="flex self-end mb-2 text-[0.7rem] font-normal text-gray-700 dark:text-gray-100/[0.3] leading-tight text-center"--}}
{{--                   x-text="'Created '+document.created_at"--}}
{{--                ></p>--}}
{{--            </div>--}}
{{--            <div class="flex cursor-pointer flex-col grow justify-start items-center">--}}
{{--                <h5 class="flex mb-2 text-center text-md font-bold tracking-tight text-gray-900 dark:text-white"--}}
{{--                    x-text="document.document_number"></h5>--}}
{{--                <span x-show="moment(document.expiry_date).isBefore(moment())"--}}
{{--                      class="my-3 mt-1 dark:!bg-red-900 text-red-800 !text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-200"--}}
{{--                      x-text="'Expired'"></span>--}}

{{--                --}}{{--                                        <p class="flex mb-3 text-sm font-normal text-gray-700 dark:text-gray-400"--}}
{{--                --}}{{--                                           x-text="documentFile.file"></p>--}}
{{--            </div>--}}
{{--            <div class="flex flex-row space-x-2 pt-2">--}}
{{--                @if($this->permission('user-document-download'))--}}
{{--                    <a--}}
{{--                        @click.prevent=" photoType='document'; $wire.export(document.file); "--}}
{{--                        class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">--}}
{{--                        <x-svg.main type="download"--}}
{{--                                    class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>--}}
{{--                    </a>--}}
{{--                @endif--}}
{{--                    <template x-init="$wire.checkPermission('user-document-view')" x-if="permissiondocumentView === true">--}}
{{--                @if($this->permission('user-document-view'))--}}
{{--                    <a @click.prevent="photoType='document'; $wire.photoView(document.file, 'document');"--}}
{{--                       class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-purple-700 rounded-md hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">--}}
{{--                        <x-svg.main type="view"--}}
{{--                                    class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>--}}
{{--                    </a>--}}
{{--                @endif--}}
{{--                    </template>--}}

{{--                @if($this->permission('user-document-accept'))--}}
{{--                    <a x-show="((document.accepted===0 && document.rejected===0 && document.revision===0) || (document.accepted===0 && document.rejected===0 && document.revision===1 ))"--}}
{{--                       @click.prevent="if(document.accepted===0) { documentType='document'; comments=''; $wire.acceptdocument(document.id) }"--}}
{{--                       class="flex items-center justify-center w-8 h-7  text-sm font-medium text-center text-white dark:text-white bg-green-700 rounded-md hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">--}}
{{--                        <x-svg.main type="check-open"--}}
{{--                                    class="h-[15px] w-[15px] text-red-800 dark:text-gray-300 m-1"></x-svg.main>--}}
{{--                    </a>--}}
{{--                @endif--}}
{{--                @if($this->permission('user-document-reject'))--}}
{{--                    <a--}}
{{--                        x-show="((document.accepted===0 && document.rejected===0 && document.revision===0) || (document.accepted===0 && document.rejected===0 && document.revision===1 ))"--}}
{{--                        @click.prevent="if(document.rejected===0){ documentType='document'; comments=''; $wire.rejectdocument(document.id) }"--}}
{{--                        class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-red-700 rounded-md hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">--}}
{{--                        <x-svg.main type="delete-open"--}}
{{--                                    class="h-[15px] w-[15px] text-red-800 dark:text-gray-300 m-1"></x-svg.main>--}}
{{--                    </a>--}}
{{--                @endif--}}
{{--                @if($this->permission('user-document-revision'))--}}
{{--                    <a x-show="((document.accepted===0 && document.rejected===0 && document.revision===0) || (document.accepted===0 && document.rejected===0 && document.revision===1 ))"--}}
{{--                       @click.prevent=" documentType='document'; comments='';  $wire.revisedocument(document.id); "--}}
{{--                       class="flex items-center justify-center mb-2  w-8 h-7 text-sm font-medium text-center text-white bg-yellow-500 rounded-md hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:focus:ring-red-800">--}}
{{--                        <x-svg.main type="refresh"--}}
{{--                                    class="h-[15px] w-[15px] text-red-800 dark:text-gray-300 m-1"></x-svg.main>--}}
{{--                    </a>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </template>--}}
{{--</div>--}}

