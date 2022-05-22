<x-datatable.main
    x-data="{
    application:{},
    documents:{},
    userDocuments:$wire.entangle('userDocuments'),
    selectedDocuments:$wire.entangle('selectedDocuments'),
    additional_requirements:$wire.entangle('additionalRequirements'),
    isSubmitting:false,
    submitClick:false,
}"
    x-init="
        application={{$application}}
        requirements=application.selected_documents;
        documents=application.selected_documents
        "
>
    @if($application !== null)
        <div x-show="application !== null" class="flex justify-center items-start mb-7">
            <div
                class="w-full pt-8 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">

                <div class="flex flex-col items-center pb-10">

             <span
                 class="flex cursor-pointer sel border-4 border-gray-800 dark:border-gray-100 rounded-full w-20 h-20 justify-center items-center m-0 mb-3 "
                 :class="{
                 'bg-green-900' : application.rejected===0 && application.accepted===1 && application.revision===0,
                 'bg-red-900' : application.rejected===1 && application.accepted===0 && application.revision===0,
                 'bg-yellow-900' : application.rejected===0 && application.accepted===0 && application.revision===1
                 }"
             >
                                         <x-svg.main
                                             x-show="application.rejected===0 && application.accepted===1 && application.revision===0"
                                             type="check-open"
                                             class=" h-10 w-10 text-red-800 dark:text-gray-100 m-1"></x-svg.main>
                                         <x-svg.main
                                             x-show="application.rejected===1 && application.accepted===0 && application.revision===0"
                                             type="delete-open"
                                             class=" h-10 w-10 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                         <x-svg.main
                                             x-show="application.rejected===0 && application.accepted===0 && application.revision===1"
                                             type="refresh"
                                             class="h-10 w-10 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                         <x-svg.main
                                             x-show="application.rejected===0 && application.accepted===0 && application.revision===0"
                                             type="question-open"
                                             class="h-10 w-10 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                     </span>

                    <span
                        class="bg-blue-100 mb-5 uppercase text-blue-800 text-xs font-normal tracking-wide px-2.5 py-1 border border-gray-600 rounded-2xl dark:bg-transparent dark:text-gray-400">
                    <span class="flex text-md px-2 py-1 font-semibold text-gray-200 tracking-wider"
                          x-show="application.accepted===1 && application.rejected===0 && application.revision===0"
                          x-text="'Accepted'"></span>
                    <span class="flex text-md px-2 py-1 font-semibold text-gray-200 tracking-wider"
                          x-show="application.accepted===0 && application.rejected===1 && application.revision===0"
                          x-text="'Rejected'"></span>
                    <span class="flex text-md px-2 py-1 font-semibold text-gray-200 tracking-wider"
                          x-show="application.accepted===0 && application.rejected===0 && application.revision===1"
                          x-text="'Revision'"></span>
                    <span class="flex text-md px-2 py-1 font-semibold text-gray-200 tracking-wider"
                          x-show="application.accepted===0 && application.rejected===0 && application.revision===0"
                          x-text="'Pending Decision'"></span>

                </span>

                    <h5 class="mb-1 px-3 pb-1 justify-center flex text-lg text-center leading-6 text-yellow-400 font-semibold "
                        x-text="application.service.name"></h5>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                    <span class="text-sm"
                          x-show="application.rejected===0 && application.accepted===1 && application.revision===0"
                          x-text="'Accepted '+application.updated_at"></span>
                </span>
                    {{--                    <div class="flex mt-4 space-x-3 md:mt-6">--}}
                    {{--                        <a href="#"--}}
                    {{--                           class="inline-flex items-center py-2 px-4 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add--}}
                    {{--                            friend</a>--}}
                    {{--                        <a href="#"--}}
                    {{--                           class="inline-flex items-center py-2 px-4 text-sm font-medium text-center text-gray-900 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">Message</a>--}}
                    {{--                    </div>--}}
                </div>
            </div>

        </div>

        {{--   CONTENT          --}}

        <div x-init="console.log(documents)" class="flex flex-col w-full mt-4">
            <p class="flex text-gray-100 font-semibold ml-4 self-center" x-text="'Documents'"></p>



            <div class="flex p-4 w-full
{{--            xxl:grid-cols-5 xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-2 xs:grid-cols-1 gap-4--}}


">
<div class="flex w-full flex-wrap space-x-5 justify-center">
                {{--                PASSPORT        --}}
                <div class="flex justify-start w-[300px] my-2.5 items-center flex-col p-6 pt-6 px-6 max-w-xm justify-start items-center dark:bg-blue-900 dark:border-blue-800  rounded-lg border shadow-md">

                <span class="flex flex-col  cursor-pointer sel border-4 border-gray-800  bg-green-700 dark:border-gray-100 rounded-full w-14 h-14 justify-center items-center m-0 mb-3 "
                    :class="{
                                'bg-gray-700' : (application.passports.rejected===0 && application.passports.accepted===0 && application.passports.revision===0),
                                'bg-red-600' : (application.passports.rejected===1 && application.passports.accepted===0 && application.passports.revision===0),
                                'bg-green-600' : (application.passports.rejected===0 && application.passports.accepted===1 && application.passports.revision===0),
                                'bg-yellow-600' : (application.passports.rejected===0 && application.passports.accepted===1 && application.passports.revision===1)
                           }"
                >
                                         <x-svg.main
                                             x-show="application.passports.rejected===0 && application.passports.accepted===1 && application.passports.revision===0"
                                             type="check-open"
                                             class=" h-8 w-8 text-red-800 dark:text-gray-100 m-1"></x-svg.main>
                                         <x-svg.main
                                             x-show="application.passports.rejected===1 && application.passports.accepted===0 && application.passports.revision===0"
                                             type="delete-open"
                                             class=" h-10 w-10 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                                             <x-svg.main
                                                                 x-show="application.passports.rejected===0 && application.passports.accepted===0 && application.passports.revision===1"
                                                                 type="refresh"
                                                                 class="h-10 w-10 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                                             <x-svg.main
                                                                 x-show="application.passports.rejected===0 && application.passports.accepted===0 && application.passports.revision===0"
                                                                 type="question-open"
                                                                 class="h-10 w-10  dark:text-gray-300 m-1"></x-svg.main>


                 </span>
                    <span
                        class="bg-blue-100 uppercase text-blue-800 !text-xs font-normal tracking-wide px-2.5 py-1 border border-blue-400 rounded-2xl dark:bg-transparent dark:text-blue-200">Passport</span>
                    <div class="flex flex-col flex-grow">
                        <div class="flex justify-center">
                            <h5 class="mb-1 mt-4 px-3 pb-0 justify-center flex text-lg text-center leading-6 text-yellow-400 font-semibold "

                                x-text="application.passports.passport_number"></h5>
                        </div>
                        <span x-show="moment(application.passports.expiry_date).isAfter(moment())"
                              class="text-xs text-gray-300 text-center"
                              x-text="'Expires on: ' + moment(application.passports.expiry_date).format('LL')"></span>
                        <span x-show="moment(application.passports.expiry_date).isBefore(moment())"
                              class="text-xs font-semibold text-red-600"
                              x-text="'Expired on: ' + moment(application.passports.expiry_date).format('LL')"></span>

                        <div class="flex flex-row space-x-2 pt-2 flex-grow items-end justify-center">
                            @if($this->permission('user-passport-download'))
                                <a  x-show="checkFileExist('/storage/images/passports/',application.passports.file) === true"
                                    @click.prevent=" $wire.photoType='passport'; $wire.export(application.passports.file); "
                                    class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <x-svg.main type="download"
                                                class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                </a>
                            @endif
                                @if($this->permission('user-passport-view'))
                                    <a x-show="checkImage(application.passports.file)===true"  @click.prevent="$wire.photoType='passport'; $wire.photoView(application.passports.file, 'passport');"
                                       class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-purple-700 rounded-md hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                                        <x-svg.main type="view"
                                                    class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                    </a>
                            @endif
{{--                            <a @click.prevent=" $wire.photoType='passport'; $wire.photoView(application.passports.file, 'passport'); "--}}
{{--                               class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-purple-700 rounded-md hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">--}}
{{--                                <x-svg.main type="view"--}}
{{--                                            class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>--}}
{{--                            </a>--}}
                        </div>
                    </div>

                    <div class="flex justify-center w-full px-2 py-3 bg-gray-800  rounded-2xl border-gray-800 mt-4 "
                         :class="{'!bg-green-900' :application.passports.accepted === 1 && application.passports.rejected===0, '!bg-red-900' :application.passports.accepted === 0 && application.passports.rejected===1 }"
                    >
                    <span x-show="application.passports.accepted === 1 && application.passports.rejected===0"
                          class="text-xs font-semibold text-white text-center"
                          x-text="'Accepted on ' + moment(application.passports.updated_at,'DD MM YYYY hh:mm:ss').format('LL') "></span>


                    <span x-show="application.passports.accepted === 0 && application.passports.rejected===0"
                              class="text-xs font-semibold text-white" x-text="'Pending Decision'"></span>
                    </div>
                </div>

                {{--                DOCUMENTS        --}}


                <template x-for="document in documents">

                    <div x-init="console.log(document)"
                         class="flex justify-start  w-[300px] my-2.5  items-center flex-col p-6 pt-6 px-6 max-w-xm justify-start items-center dark:bg-gray-700 dark:border-gray-800  rounded-lg border shadow-md">
                         <span
                             class="flex flex-col  cursor-pointer sel border-4 border-gray-800  bg-gray-700 dark:border-gray-100 rounded-full w-14 h-14 justify-center items-center m-0 mb-3 "
                             :class="{
                                'bg-gray-700' : (document.rejected===0 && document.accepted===0),
                                'bg-red-600' : (document.rejected===1 && document.accepted===0),
                                'bg-green-600' : (document.rejected===0 && document.accepted===1)
                                }"
                         >
                                         <x-svg.main
                                             x-show="document.rejected===0 && document.accepted===1 "
                                             type="check-open"
                                             class=" h-8 w-8 text-red-800 dark:text-gray-100 m-1"></x-svg.main>
                                         <x-svg.main
                                             x-show="document.rejected===1 && document.accepted===0 "
                                             type="delete-open"
                                             class=" h-8 w-8 text-red-800 dark:text-gray-100 m-1"></x-svg.main>
{{--                                         <x-svg.main--}}
                             {{--                                             x-show="document.rejected===0 && document.accepted===0 && document.revision===1"--}}
                             {{--                                             type="refresh"--}}
                             {{--                                             class="h-8 w-8 text-red-800 dark:text-gray-300 m-1"></x-svg.main>--}}
                                         <x-svg.main
                                             x-show="document.rejected===0 && document.accepted===0 "
                                             type="question-open"
                                             class="h-8 w-8 text-red-800 dark:text-gray-300 m-1"></x-svg.main>


                 </span>

                        <div class="flex flex-col flex-grow">
                            <div class="flex justify-center">
                            <span class="flex bg-blue-100 uppercase text-gray-800 text-xs font-normal tracking-wide px-2.5 py-1 border border-gray-400 rounded-2xl dark:bg-transparent dark:text-gray-200">Document</span>
                            </div>
                            <h5 class="flex mb-1 leading-4 mt-4 px-3 pb-0 justify-center flex !text-sm text-center leading-6 text-gray-300 font-semibold "
                                x-text="document.service_requirement.name"></h5>
                            <div class="flex flex-row flex-grow space-x-2 pt-2 justify-center items-end">

                                @if($this->permission('user-document-download'))
                                    <template x-if="document.file.length > 0 ">
                                        <a  x-show="checkFileExist('/storage/images/documents/',document.file) === true"
                                            @click.prevent=" $wire.photoType='document'; $wire.export(document.file); "
                                            class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <x-svg.main type="download"
                                                        class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                        </a>
                                    </template>
                                @endif
                                @if($this->permission('user-document-view'))
                                    <a x-show="checkImage(document.file)===true" @click.prevent="photoType='document'; $wire.photoView(document.file, 'document');"
                                       class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-purple-700 rounded-md hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                                        <x-svg.main type="view"
                                                    class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                    </a>
                                @endif

{{--                                <a--}}
{{--                                    @click.prevent=" $wire.photoType='document'; $wire.export(document.file); "--}}
{{--                                    class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">--}}
{{--                                    <x-svg.main type="download"--}}
{{--                                                class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>--}}
{{--                                </a>--}}
{{--                                <a @click.prevent=" $wire.photoType='document'; $wire.photoView(document.file);"--}}
{{--                                   class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-purple-700 rounded-md hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">--}}
{{--                                    <x-svg.main type="view"--}}
{{--                                                class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>--}}
{{--                                </a>--}}
                            </div>


                        </div>
                        <div
                            class="flex justify-center w-full px-2 py-3 bg-gray-800  rounded-2xl border-green-800 mt-4 "
                            :class="{'!bg-green-900' :document.rejected===0 && document.accepted===1, '!bg-red-900' :document.rejected===1 && document.accepted===0 }"
                        >
                        <span x-init="console.log(document)" x-show="document.rejected===0 && document.accepted===1"
                              class="text-xs font-semibold text-white text-center"
                              x-text="'Accepted on ' + moment(momentDate(document.updated_at)).format('LL')"></span>
                            <span x-show="document.rejected===1 && document.accepted===0"
                                  class="text-xs font-semibold text-white"
                                  x-text="'Rejected on ' + moment(momentDate(document.updated_at)).format('LL') "></span>
                            <span x-show="document.rejected===0 && document.accepted===0"
                                  class="text-xs font-semibold text-white" x-text="'Pending Decision'"></span>
                        </div>
                    </div>
                </template>

</div>
            </div>

            {{--            ADDITIONAL DOCUMENTS        --}}
            <p x-show="additional_requirements.length > 0" class="flex text-gray-100 p-4 font-semibold mt-4 ml-4 self-center" x-text="'Documents required'"></p>

            <div class="flex">
            <div x-show="additional_requirements.length > 0" class="flex w-full flex-wrap  justify-center sm:space-x-5 xs:space-x-0">

                <template x-for="requirement in additional_requirements">
{{--                    <tempalate x-if="requirement.documents.length === 0 ">--}}
                    <div  class="flex w-[300px] my-2.5 items-center flex-col p-6 pt-6 px-6 max-w-xm justify-center items-center dark:bg-red-900/[0.5] dark:border-red-800/[0.5]  rounded-lg border shadow-md">

                        <div class="flex flex-col flex-grow">
                            <div class="flex justify-center">
                            <span
                                class="flex bg-blue-100 uppercase text-gray-800 text-xs font-normal tracking-wide px-2.5 py-1 border border-gray-400 rounded-2xl dark:bg-transparent dark:text-gray-200">Document</span>
                            </div>
                            <h5 class="flex mb-1 leading-4 mt-4 px-3 pb-0 justify-center flex !text-sm text-center leading-6 text-gray-300 font-semibold "
                                x-text="requirement.name"></h5>

                            <div class="flex flex-row flex-grow space-x-2 pt-2 justify-center items-end">
                                <button
                                    @click.prevent="selectedDocuments=[]; $wire.addAdditionalRequirements(application.id,requirement.id )"
                                    type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300
                                font-medium rounded-md text-xs px-5 py-2 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none
                                dark:focus:ring-blue-800" x-text="'Select Document'">
                                </button>
                            </div>
                        </div>
                    </div>
{{--                    </tempalate>--}}
                </template>


            </div>
            </div>
        </div>

    @else
        <x-datatable.modal.record-not-found-modal title="Application Not Found!"
                                                  message="The application you are trying to access is either unavailable or you do not have permissions to access the content."></x-datatable.modal.record-not-found-modal>
    @endif

        {{--                PHOTOVIEW MODAL STARTS HERE      --}}
        <x-datatable.photo-view></x-datatable.photo-view>


    {{--                REQUIREMENT MODAL STARTS HERE      --}}
    <x-datatable.modal.requirementModal>
        <div class="flex w-full rounded-lg border border-gray-600 bg-gray-900 p-2 !mt-2">
            <template x-if="userDocuments.length > 0">
                <template x-for="(document,index) in userDocuments" :key="index">

                    <div x-init="
                    isSubmitDisabled=true;
                    $watch('selectedDocuments',function(value){
                        (value.length > 0) ? isSubmitting=true : isSubmitting=false;
                    });
                    "

                         class="flex">
                        <div class="flex items-center mr-4">
                            <input x-model="selectedDocuments" :id="'document-checkbox'+index" type="checkbox"
                                   :value="document.id"
                                   class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label :id="'document-label-checkbox'+index" :for="'document-checkbox'+index"
                                   class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                   x-text="document.name"></label>
                        </div>
                    </div>
                </template>
            </template>
            <template x-if="userDocuments.length === 0">
                <span x-init="isSubmitDisabled=true" class="flex font-medium text-xs text-gray-200 p-2"
                      x-text="'No documents available. Please add your document first'"></span>
            </template>
        </div>
    </x-datatable.modal.requirementModal>


</x-datatable.main>


