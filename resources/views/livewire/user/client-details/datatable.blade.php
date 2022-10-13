<div class="flex w-full" x-data=" Client($wire,{
 clientTab:$persist($wire.entangle('clientTab')),
 cTab:$wire.entangle('clientTab')
}) ">
    <div class="flex w-full" x-data=" Passport($wire,{ 'passports': {}}) ">

        <x-datatable.main
            x-data="
        Document($wire,{
        'requirements': {},
        routeName:'',
        applications:[],
        documentID:$persist(0),
        selectedRequirements:$wire.entangle('selectedRequirements'),
        did : $wire.entangle('documentID')
        })
"

            x-init="
                applicationsCount={{$applicationsCount}};
                user={{$profile}}
                applications={{$applications->getCollection()}}
                documents={{$documents->getCollection()}}
                passports={{$passports}}
                countries={{$countries}}
                routeName='user.client-details'
                 if(cTab !== null ) clientTab = cTab;
                 if(did !== null ) documentID = did;
                "
        >
            <style>
                input::-webkit-calendar-picker-indicator {
                    display: none;
                }

                input[type="date"]::-webkit-input-placeholder {
                    visibility: hidden !important;
                }
            </style>
            <div class="block mx-auto w-100 justify-center px-3 py-8">
                <div
                    class="min-w-[300px] pt-8 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">

                    <div class="flex flex-col items-center pb-10">

                        <template x-if="user.default_profile_photo_id !== null">
                            <img class="mb-3 w-24 h-24 rounded-full shadow-lg" :src="'{{asset('storage/images/profile')}}'+'/'+user.profile_photo.file+'?ver='+Math.floor((Math.random()*100)+1)" :alt="user.name+' image'">
                        </template>

                        <template x-if="user.default_profile_photo_id === null">
                            <img class="mb-3 w-24 h-24 rounded-full shadow-lg" :src="'{{asset('storage/images/profile/default.jpg')}}'" :alt="user.name+' image'">
                        </template>


                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-yellow-400" x-text="user.name"></h5>
                        <h5 x-show="universityName !== ''"
                            class="mb-1 text-normal font-medium text-gray-900 dark:text-white"
                            x-text="universityName"></h5>
                        <p x-show="degreeName !== ''" class="mb-1 text-sm text-gray-700 dark:text-gray-300"
                           x-text=" '(' + degreeName + ')'"></p>
                        <span class="text-sm text-gray-500 dark:text-gray-400" x-text="user.email"></span>

                    </div>
                </div>
            </div>

            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                    data-tabs-toggle="#myTabContent"
                    role="tablist">
                    <li class="mr-2" role="presentation">
                        <button @click.prevent="clientTab='application'; isApplicationZone=true"
                                class="inline-flex p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 font-semibold dark:text-gray-500 dark:hover:text-gray-300 group"
                                :class="{'border-b-2 border-blue-500 text-blue-600 dark:text-blue-500': clientTab==='application'}"
                                id="application-tab" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="mr-2 w-5 h-5 text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Applications
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button @click.prevent="clientTab='passport'; $wire.documentType='passport'; isApplicationZone=false"
                                class="inline-flex p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 font-semibold dark:text-gray-500 dark:hover:text-gray-300 group"
                                :class="{'border-b-2 border-blue-500 text-blue-600 dark:text-blue-500': clientTab==='passport'}"
                                id="passport-tab" data-tabs-target="#passport" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="mr-2 w-5 h-5 text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                            Passport
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button @click.prevent="clientTab='document'; $wire.documentType='document'; isApplicationZone=false"
                                class="inline-flex p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 font-semibold dark:text-gray-500 dark:hover:text-gray-300 group"
                                :class="{'border-b-2 border-blue-500 text-blue-600 dark:text-blue-500': clientTab==='document'}"
                                id="settings-tab" data-tabs-target="#documents" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="mr-2 w-5 h-5 text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                            </svg>
                            Documents
                        </button>
                    </li>
{{--                    <li role="presentation">--}}
{{--                        <button @click.prevent="clientTab='contact'"--}}
{{--                                class="inline-flex p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 font-semibold dark:text-gray-500 dark:hover:text-gray-300 group"--}}
{{--                                :class="{'border-b-2 border-blue-500 text-blue-600 dark:text-blue-500': clientTab==='contact'}"--}}
{{--                                id="contacts-tab" type="button">--}}
{{--                            <svg aria-hidden="true"--}}
{{--                                 class="mr-2 w-5 h-5 text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300"--}}
{{--                                 fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>--}}
{{--                                <path fill-rule="evenodd"--}}
{{--                                      d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"--}}
{{--                                      clip-rule="evenodd"></path>--}}
{{--                            </svg>--}}
{{--                            Contacts--}}
{{--                        </button>--}}
{{--                    </li>--}}
                </ul>
            </div>
            <div id="myTabContent">


                {{--        APPLICATION CONTENT       --}}
                <div x-show="clientTab==='application'" class="p-4 bg-gray-50 rounded-lg dark:bg-gray-900/[0.7]"
                     id="application">


                    <x-datatable.table :dataRecord="$applications">
                        <x-datatable.applications.data></x-datatable.applications.data>
                    </x-datatable.table>


                </div>


                {{--        PASSPORT CONTENT       --}}
                <div x-show="clientTab==='passport'" class="p-4 bg-gray-50 rounded-lg dark:bg-gray-900/[0.7]"
                     id="passport">

                    <x-datatable.passports.data></x-datatable.passports.data>


                </div>


                {{--        DOCUMENTS CONTENT       --}}
                <div x-show="clientTab==='document'" class="p-4 bg-gray-50 rounded-lg dark:bg-gray-900/[0.7]"
                     id="documents">


                    <x-datatable.documents.data></x-datatable.documents.data>
                </div>


                <div x-show="clientTab==='contact'" class=" p-4 bg-gray-50 rounded-lg dark:bg-gray-800" id="contacts"
                     role="tabpanel"
                     aria-labelledby="contacts-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong
                            class="font-medium text-gray-800 dark:text-white">Contacts tab's associated content</strong>.
                        Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript
                        swaps
                        classes to control the content visibility and styling.</p>
                </div>

            </div>

            {{--                PASSPORT ADDUPDATE MODAL STARTS HERE      --}}
            <x-datatable.passports.create-update></x-datatable.passports.create-update>

            {{--                DOCUMENT ADDUPDATE MODAL STARTS HERE      --}}
            <x-datatable.documents.create-update></x-datatable.documents.create-update>


            {{--                PHOTOVIEW MODAL STARTS HERE      --}}
            <x-datatable.photo-view></x-datatable.photo-view>
            {{--    <x-datatable.modal.photo-view x-show="AddUpdateModal.formType==='view'">--}}
            {{--        <img x-show="$wire.fileView !=='' &&  photoType === 'passport'" class="rounded-xl"--}}
            {{--             :src="--}}
            {{--             ($wire.fileView !=='' &&  photoType === 'passport' ) ? '/storage/images/passports/'+$wire.fileView+'?ver='+Math.floor((Math.random()*100)+1) : '' ;--}}
            {{--                   "--}}
            {{--             alt="">--}}

            {{--        <img x-show="$wire.fileView !=='' &&  photoType === 'document'" class="rounded-xl"--}}
            {{--             :src="--}}
            {{--             ($wire.fileView !=='' &&  photoType === 'document' ) ? '/storage/images/documents/'+$wire.fileView+'?ver='+Math.floor((Math.random()*100)+1) : '' ;--}}
            {{--                   "--}}
            {{--             alt="">--}}
            {{--    </x-datatable.modal.photo-view>--}}

            {{--                CONFIRMATION MODAL STARTS HERE      --}}
            <x-datatable.modal.confirmation>
                                <template  x-if="documentType === 'application' ">
                <span x-show="((isApplicationZone===true && rejectCheckbox===true) || confirmationType === 'accept' || confirmationType === 'reject') || (isApplicationZone===false && (confirmationType === 'accept' || confirmationType === 'reject'))"
                      class="flex justify-center items-center border border-red-500 bg-red-600 rounded-lg px-4 py-2 my-3 mt-4">
            <p class="flex font-bold text-white text-xs w-full text-center"
               x-text="'NOTE: This will be the final decision on this application. Once committed, the process cannot be reversed'"></p>
                </span>
                                </template>
                <div class="flex lg:w-2xl flex-col p-3 mt-4 w-full border border-gray-700 rounded-2xl">
                    <x-bundle.textarea x-data="commentsData" class="flex  flex-col w-full"><textarea
                            class="flex min-w-2xl"
                            x-bind="bindComments"></textarea>
                    </x-bundle.textarea>
                </div>
                                <template x-if="documentType === 'application'">
                <div x-show="isApplicationZone === true"
                    class="flex w-full items-center p-4 mt-4 rounded-2xl border border-gray-200 dark:border-gray-700"
                    :class="{ 'bg-red-600 dark:bg-gray-900 border-gray-200 dark:border-gray-700' : rejectCheckbox===true, 'bg-gray-600 dark:bg-gray-800/[0.5] border-gray-500 dark:border-gray-700' : rejectCheckbox===false}"
                >
                    <input @change="$wire.rejectCheckbox" id="link-checkbox" x-model="rejectCheckbox"
                           type="checkbox"
                           value=""
                           class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="link-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">No,
                        I would
                        like to<span class="py-4 mx-1 w-full text-sm font-bold text-red-900 dark:text-red-500"
                                     :class="{ 'text-yellow-400' : rejectCheckbox === true }"
                        >Reject</span>this application completely.</label>
                </div>


                                </template>
            </x-datatable.modal.confirmation>

            {{--                CHAT MODAL STARTS HERE      --}}
            <x-datatable.chat></x-datatable.chat>

            {{--                REQUIREMENT MODAL STARTS HERE      --}}
            <x-datatable.modal.requirementModal>
                <div
                    class="flex flex-wrap space-x-3 items-center  w-full rounded-lg border border-gray-600 bg-gray-900 p-2 !mt-2">
                    <template x-for="(requirement,index) in additionalRequirements" :key="index">

                        <div
                            x-init="
                    isSubmitDisabled=true;
                    $watch('selectedRequirements',function(value){
                        (value.length > 0) ? isSubmitting=true : isSubmitting=false;
                    });
                    "
                            class="flex space-y-3">
                            <div class="flex my-2  justify-center items-center">
                                <input x-model="selectedRequirements" :id="'requirement-checkbox'+index" type="checkbox"
                                       :value="requirement.id"
                                       class="flex w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label :id="'requirement-label-checkbox'+index" :for="'requirement-checkbox'+index"
                                       class="flex ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                       x-text="requirement.name"></label>
                            </div>

                        </div>

                    </template>

                </div>
            </x-datatable.modal.requirementModal>

            {{--                DELETE MODAL STARTS HERE      --}}
            <x-datatable.modal.delete></x-datatable.modal.delete>

        </x-datatable.main>

    </div>
</div>
