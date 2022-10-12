<x-datatable.main
    x-data=" Application($wire,{
{{--        stepID : $persist(1)--}}
        passport:{{$passport}},
        services:{{$services}}
        }) "

>


    {{--    --}}{{--    ADD BUTTON  --}}
    {{--    <x-datatable.insert name="Add" @click.prevent="MyModal('add','user',{'formData':{} });"></x-datatable.insert>--}}

    {{--    DATATABLE FILTER --}}
    {{--    <x-datatable.filter></x-datatable.filter>--}}

    {{--    DATATABLE  --}}
    <x-datatable.table :dataRecord=null>
        <div class="flex h-full justify-center items-start pt-0">

            <div
                class="flex flex-col p-8 w-full justify-center items-center bg-white rounded-lg border shadow-md xs:min-h-[500px]  md:min-w-4xl dark:border-gray-700 dark:bg-gray-800">


                {{--                HEADER              --}}
                <div class="flex w-full border-b border-gray-600 pb-4">
                    <div class="grid grid-cols-12 w-full">
                        <div class="flex col-span-3 xs:col-span-12">
                            <div class="flex flex-col">
                                <div class="flex uppercase text-gray-100 font-semibold text-sm tracking-widest">
                                    <span x-text="'step:'"></span><span
                                        x-text="steps[stepID-1].id + '-' + steps.length"></span></div>
                                <div class="flex capitalize  font-semibold text-xl text-yellow-400"><span
                                        x-text="steps[stepID-1].title"></span></div>
                            </div>
                        </div>
                        <div class="flex col-span-9 xs:col-span-12 xs:mt-2 flex justify-end items-center">
                            <div class="flex w-1/2 xs:w-full">
                                <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                                    <div
                                        class="bg-gradient-to-r from-red-600 to-green-600 text-sm font-medium text-blue-100 text-center p-1 py-2 leading-none rounded-full"
                                        :style="`width:  ${progress}%;`" x-text="Math.trunc(progress)+'%'">
                                        {{--                                        :style="width: (( 100/steps.length ) * steps[stepID-1].id)%" x-text="(( 100/steps.length ) * steps[stepID-1].id)%"> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex grow w-full">
                    {{--                INFORMATION             --}}
                    <div x-show="stepID===steps[0].id" id="information"
                         class="flex w-full justify-center items-center ">
                        <div class="flex flex-col h-full p-4 justify-center items-center leading-normal">

                            <div class="flex flex-col grow justify-center items-center">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Medwinks online application submission</h5>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 text-center">
                                    Please make sure you have uploaded your valid (Active) <a
                                        href="{{route('user.passports')}}"
                                        class="font-semibold underline dark:hover:text-blue-400">Passport</a>
                                    copy
                                    and all the required <a href="{{route('user.documents')}}"
                                                            class="font-semibold underline dark:hover:text-blue-400">Documents</a>
                                    before continuing submitting your application.
                                </p>

                                <template x-if="Object.entries(services).length === 0">
                                <p class="flex flex-row justify-center items-center border text-sm border-red-800 text-white rounded-2xl p-3 py-2 mt-2 bg-red-900">
                                    <x-svg.main type="exclamation-circle"
                                                class="flex h-5 w-5 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                <span  class="flex" x-text="'No services available. Please contact administrator'"></span>
                                </p>
                                </template>
                            </div>

                        </div>
                    </div>

                    {{--                PASSPORT                --}}
                    <div x-show="stepID===steps[1].id" id="information"
                         class="flex  w-full justify-center items-center ">
                        <div class="flex flex-col h-full p-4 py-10 justify-center items-center leading-normal">
                            <template x-if="Object.entries(passport).length > 0">
                                <div class="flex flex-col grow justify-center items-center">
                                    {{--                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"> Passport technology acquisitions 2021 </h5>--}}

                                    @if($passport!==null)
                                        {{--                                ALERT MESSAGE IF PASSPORT EXPIRED           --}}
                                    <p class="text-sm text-gray-300 font-semibold mb-4"  x-text="'Select the active passport inorder to continue'"></p>
                                        <div
                                            @click.prevent="application.passportID=passport.id"
                                            class="cursor-pointer p-6 min-w-sm max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 hover:dark:bg-gray-900/[0.7]"
                                            :class="{'dark:!border-blue-700/[0.7] dark:!bg-gray-900 hover:dark:!bg-gray-900' : application.passportID===passport.id}"
                                        >
                                            <div x-show="moment(passport.expiry_date).isBefore(moment())"
                                                 class="flex flex-col p-4 mb-4 text-sm text-gray-700 bg-red-100 rounded-lg dark:bg-red-800 dark:text-gray-300"
                                                 role="alert">
                                                <span class="flex flex-col font-bold text-md text-gray-100">Passport Expired!</span>
                                                <span class="block">
                                            <span class="inline">Your current passport was expired on <span
                                                    class="flex inline-flex font-medium text-white"
                                                    x-text="'`'+moment(passport.expiry_date).format('MMMM DD, YYYY')+'`'"></span></span>
                                            <span class="inline"> Please update your <a
                                                    href="{{route('user.passports')}}"
                                                    class="font-semibold underline dark:hover:text-white">Passport</a> inorder to continue.</span>
                                        </span>
                                            </div>


                                            <h6 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white border-b border-gray-600 pb-2"
                                                x-text="passport.passport_number"></h6>
                                            <div class="grid gap-y-4 pt-2">
                                                <div class="grid grid-cols-12 gap-4 w-full ">
                                                    <div class="col-span-4 font-semibold text-gray-400"
                                                         x-text="'Full name '"></div>
                                                    <div class="col-span-8  text-gray-400"
                                                         x-text="passport.given_name + ' '+ passport.sur_name "></div>
                                                </div>

                                                <div class="grid grid-cols-12 gap-4 w-full ">
                                                    <div class="col-span-4 font-semibold text-gray-400"
                                                         x-text="'Data of birth '"></div>
                                                    <div class="col-span-8  text-gray-400"
                                                         x-text="moment(passport.date_of_birth).format('MMMM DD, YYYY')"></div>
                                                </div>

                                                <div class="grid grid-cols-12 gap-4 w-full ">
                                                    <div class="col-span-4 font-semibold text-gray-400"
                                                         x-text="'Issue Date '"></div>
                                                    <div class="col-span-8  text-gray-400"
                                                         x-text="moment(passport.issue_date).format('MMMM DD, YYYY')"></div>
                                                </div>

                                                <div class="grid grid-cols-12 gap-4 w-full ">
                                                    <div class="col-span-4 font-semibold text-gray-400"
                                                         x-text="'Expiry Date '"></div>
                                                    <div class="col-span-8 text-gray-400"
                                                         :class="{'text-red-700 font-semibold': moment(passport.expiry_date).isBefore(moment())}"
                                                         x-text="moment(passport.expiry_date).format('MMMM DD, YYYY')">
                                                <span
                                                    class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-600 dark:text-red-900">Expired</span>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-12 gap-4 w-full ">
                                                    <div class="col-span-4 font-semibold text-gray-400"
                                                         x-text="'Country '"></div>
                                                    <div class="col-span-8  text-gray-400"
                                                         x-text="passport.country.name"></div>
                                                </div>

                                                <div class="grid grid-cols-12 gap-4 w-full ">
                                                    <div class="col-span-4 font-semibold text-gray-400"
                                                         x-text="'Region '"></div>
                                                    <div class="col-span-8  text-gray-400"
                                                         x-text="passport.region.name"></div>
                                                </div>

                                            </div>


                                        </div>
                                    @else
                                        {{--                                ALERT MESSAGE IF PASSPORT NO ACTIVE AVAILABLE           --}}
                                        <div
                                            class="flex flex-col justify-center items-center p-8 mb-4 text-sm text-red-700 bg-red-400 rounded-lg dark:bg-red-800 dark:text-gray-100"
                                            role="alert">
                                        <span class="flex font-medium">
                                            <x-svg.main type="exclamation-circle"
                                                        class="h-15 w-15 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                        </span>
                                            <span class="flex">There is no active passport available. </span>
                                            <span class="flex">Please add your &nbsp
                                            <a href="{{route('user.passports')}}"
                                               class="font-semibold underline dark:hover:text-white">Passport</a>&nbsp inorder to continue.
                                        </span>
                                        </div>
                                    @endif


                                </div>
                            </template>
                        </div>
                    </div>


                    {{--                UNIVERSITY                --}}
                    <div x-show="stepID===steps[2].id" id="information"
                         class="flex flex-col grow justify-center items-center ">
                        <div class="flex flex-col w-full h-full py-4 justify-center items-center leading-normal">

                            <div
                                class="block p-6 my-10 max-w-xl bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-900/[0.5]"
                                :class="{'dark:!border-blue-700/[0.7] dark:!bg-gray-900 hover:dark:!bg-gray-900' : (application.universityID !=='' && application.universityID === university) }"
                            >

                                <x-bundle.select x-data="university" class="!text-left  w-[500px]">
                                    <select x-bind="bindUniversity">
                                        <x-bundle.select-options></x-bundle.select-options>
                                    </select>
                                </x-bundle.select>

                            </div>
                        </div>
                    </div>


                    {{--                QUALIFICATION                --}}
                    <div x-show="stepID===steps[3].id" id="qualification"
                         class="flex flex-col grow justify-center items-center ">

                        <div
                            class="block p-6 my-10 max-w-xl bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-900"
                            :class="{'dark:!border-blue-700/[0.7] dark:!bg-gray-900 hover:dark:!bg-gray-900' : (application.degreeID !=='' && application.degreeID === degree) }"
                        >
                            <div class="flex flex-col w-full h-full pt-4 justify-center items-start leading-normal">
                                <x-bundle.select x-data="qualification" class="!text-left w-[500px]">
                                    <select x-bind="bindQualification">
                                        <x-bundle.select-options></x-bundle.select-options>
                                    </select>
                                </x-bundle.select>

                                <div class="flex flex-col w-full pt-8 pb-4 justify-center items-center leading-normal">
                                    <x-bundle.select x-data="degree" class="!text-left  w-[500px]">
                                        <select x-bind="bindDegree">
                                            <x-bundle.select-options></x-bundle.select-options>
                                        </select>
                                    </x-bundle.select>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{--                SERVICE             --}}
                    <div x-show="stepID===steps[4].id" id="information" class="flex w-full ">
                        <div class="flex flex-col h-full p-4 justify-center items-center leading-normal">
                            <h5 class="mb-2 text-md text-left font-bold tracking-tight text-gray-900 dark:text-white">
                                Choose a service you want to enroll
                            </h5>
                            <div class="flex flex-col  justify-start items-start w-full ">
                                <div class="flex flex-1 grow grid grid-cols-12 gap-4 ">
                                    <template x-for="service in services">
                                        <div class="flex flex-1 col-span-4 ">
                                            <a @click.prevent="serviceID=service.id; serviceName=service.name; selectedDocuments=[]"
                                               class="cursor-pointer flex flex-col p-6 w-full bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
                                               :class="{'!bg-yellow-400 !text-gray-900' : serviceID===service.id }"
                                            >
                                                <h5 class="flex grow mb-2 text-md font-bold tracking-tight text-gray-900 dark:text-white"
                                                    x-text="service.name"
                                                    :class="{'!text-gray-900' : serviceID===service.id }"
                                                ></h5>
                                                <p class="flex font-normal text-gray-700 dark:text-gray-400">
                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800"
                                                        x-text="service.abbreviation"
                                                        :class="{'!bg-blue-800 !text-white' : serviceID===service.id }"
                                                    ></span>
                                                </p>
                                            </a>
                                        </div>
                                    </template>
                                </div>
                            </div>

                        </div>
                    </div>


                    {{--                SERVICE REQUIREMENT           --}}
                    <div x-show="stepID===steps[5].id" id="service-requirements"
                         class="flex flex-col grow justify-start items-start w-full ">
                        <div class="flex flex-col w-full h-full py-4 justify-start items-start leading-normal">

                            <div class="flex flex-col w-full justify-start items-left">
                                <h5 class="mb-4 text-md font-bold tracking-tight text-gray-900 dark:text-white"><span
                                        x-text="'Documents required for&nbsp;'"></span> <span class="text-blue-500"
                                                                                              x-text=" '`' + serviceName + '`'"></span>
                                </h5>


                                {{--                                ALERT MESSAGE IF NO REQUIREMENTS           --}}
                                @if($serviceRequirements ===null)
                                    <div class="flex h-full justify-center items-center">
                                        <div
                                            class="flex flex-col justify-center items-center p-8 mb-4 text-sm text-red-700 bg-red-400 rounded-lg dark:bg-red-800 dark:text-gray-100"
                                            role="alert">
                                        <span class="flex font-medium">
                                            <x-svg.main type="exclamation-circle"
                                                        class="!h-15 !w-15 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                        </span>
                                            <span class="flex"
                                                  x-text=" 'There is no requirements for '"> </span>
                                            <span class="font-semibold text-white"
                                                  x-text="'`'+ services.find(x => x.id === serviceID).name+'`'"></span>
                                            {{--                                    <span class="flex">Please add your &nbsp--}}
                                            {{--                                            <a href="{{route('user.passports')}}"--}}
                                            {{--                                               class="font-semibold underline dark:hover:text-white">Passport</a>&nbsp inorder to continue.--}}
                                            {{--                                        </span>--}}
                                        </div>
                                    </div>

                                @else

                                    <div x-show="serviceRequirements.length > 0" class="mb-4 ">
                                        <ul class="flex flex-col -mb-px w-full text-sm font-medium text-left items-start bg-gray-900 rounded-lg py-4 px-2">
                                            <template x-for="requirement in serviceRequirements">
                                                <li @click="serviceRequirementID=requirement.id"
                                                    class="flex flex-col mr-2 p-4 py-2 rounded-xl  p-3 mb-1">
                                                    <button
                                                        class="flex justify-center items-center text-gray-300 font-semibold text-md"
                                                        :class="{ 'text-yellow-400' : serviceRequirementID===requirement.id }"
                                                        type="button">
                                                        <x-svg.main x-show="findRequirement(requirement.id)"
                                                                    type="check"
                                                                    class="flex self-center text-green-800 dark:text-green-600 mr-2"></x-svg.main>
                                                        <x-svg.main x-show="!findRequirement(requirement.id)"
                                                                    type="delete"
                                                                    class="flex self-center text-red-800 dark:text-red-600 mr-2"></x-svg.main>

                                                        <span class="flex" x-text="requirement.name"></span>

                                                    </button>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <div x-show="serviceRequirements.length === 0"
                                         class="flex flex-row p-4 justify-start items-center mb-4 text-sm text-blue-700 bg-yellow-100 rounded-lg dark:bg-yellow-400 dark:text-blue-800"
                                         role="alert">
                                        <x-svg.main type="exclamation-circle"
                                                    class="flex h-6 w-6 text-red-800 dark:text-gray-900 mr-2"></x-svg.main>
                                        <span class="flex text-gray-900 font-semibold">There are no requirements for this service</span>
                                    </div>
                                    <div id="documentContent">

                                        <template x-for="requirement in serviceRequirements" :key="requirement.id">
                                            <div x-show="serviceRequirementID===requirement.id"
                                                 class="p-4 px-0 bg-gray-50 rounded-lg dark:bg-gray-800">

                                                <div x-show="requirement.documents.length === 0"
                                                     class="flex flex-row justify-start items-center p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900 dark:text-gray-200"
                                                     role="alert">
                                                    <x-svg.main type="exclamation-circle"
                                                                class="flex h-6 w-6 text-red-800 dark:text-gray-100 mr-2"></x-svg.main>
                                                    <span class="flex text-gray-100 font-semibold"
                                                          x-text="'No documents available. Please uploaded supporting documents for &nbsp;'"></span>
                                                    <span> <a @click="setDocumentID=requirement.id; "
                                                              href="{{route('user.documents')}}"
                                                              class="font-semibold underline dark:text-yellow-300 dark:hover:text-yellow-200"
                                                              x-text="requirement.name"></a>
                                                    </span>
                                                </div>

                                                <h5 x-show="requirement.documents.length > 0"
                                                    class="text-md font-bold tracking-tight text-gray-900 dark:text-white">
                                                    Available documents
                                                </h5>
                                                <span class="text-sm text-gray-400" x-text="'Please select the document'"></span>
                                                <div
                                                    class="p-4 px-0 grid xxl:grid-cols-5 xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-2 xs:grid-cols-1 gap-4">
                                                    <template x-for="document in requirement.documents"
                                                              :key="document.id">

                                                        <div
                                                            @click.prevent="addDocument(requirement.id, document.id);"
                                                            :id="'frame-'+document.id"
                                                            class="flex cursor-pointer flex-col p-6  dark:bg-gray-800 dark:border-gray-900 dark:hover:bg-gray-900/[0.5] pt-5 px-2 max-w-xm justify-center items-center rounded-lg border shadow-md "
                                                            :class="{
                                                                 'dark:!bg-red-900/[0.5] hover:dark:!bg-red-900/[0.7] dark:border-red-900' : (document.accepted===0 && document.rejected===1),
                                                                 'dark:!bg-green-900/[0.5] hover:dark:!bg-green-900/[0.7] dark:hover:bg-green-900/[0.7] dark:border-green-900':findDocument(requirement.id, document.id),
                                                                 'dark:bg-gray-800 dark !border-gray-900 dark:hover:bg-gray-900/[0.5]':(document.accepted===0 && document.rejected===0)
                                                                }"
                                                        >

                                                                <span
                                                                    class="flex cursor-pointer sel border-4 border-red-800 dark:border-gray-100 rounded-full w-10 h-10 justify-center items-center m-0 mb-3 ">
                                                                     <x-svg.main
                                                                         x-show="findDocument(requirement.id, document.id)"
                                                                         type="check-open"
                                                                         class="h-4 w-4 text-red-800 dark:text-gray-300 m-1">
                                                                     </x-svg.main>


{{--                                                                     <x-svg.main x-show="document.rejected===1"--}}
{{--                                                                                                                                                     type="delete-open"--}}
{{--                                                                                                                                                     class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>--}}
{{--                                                                                                                                         <x-svg.main--}}
{{--                                                                                                                                             x-show="!findDocument(document.id)"--}}
{{--                                                                                                                                             type="question-open"--}}
{{--                                                                                                                                             class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>--}}
                                                                 </span>

                                                            <div
                                                                class=" flex  justify-center cursor-pointer flex-col items-center px-4">
                                                                <div class=" flex  justify-center mb-2">
                                                                    <span
                                                                        x-show="document.rejected===0 && document.accepted===0"
                                                                        class="mb-2 bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300"
                                                                        x-text="'Pending Decision'"></span>
                                                                    <span
                                                                        x-show="document.accepted===1 && document.rejected===0"
                                                                        :id="'accept'-document.id"
                                                                        class="flex mb-2 bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded bg-green-500 dark:text-green-900"
                                                                        x-text="'Accepted'"></span>
                                                                    <span
                                                                        x-show="document.accepted===0 && document.rejected===1"
                                                                        :id="'reject'-document.id"
                                                                        class="flex mb-2 bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded bg-red-500 dark:text-red-900"
                                                                        x-text="'Rejected'"></span>
                                                                </div>
                                                                <p class="flex self-end mb-2 text-[0.7rem] font-normal text-gray-700 dark:text-gray-100/[0.3] leading-tight text-center"
                                                                   x-text="'Created '+moment(document.created_at).format('LL')"></p>
                                                            </div>

                                                            <div
                                                                class="flex cursor-pointer flex-col grow justify-start items-center">
                                                                <h5 class="flex mb-2 text-center text-md font-bold tracking-tight text-gray-900 dark:text-white"
                                                                    x-text="document.name"></h5>

                                                            </div>

                                                            @if($this->permission('user-submit-application-document-download'))
                                                                <div class="flex flex-row space-x-2 pt-2">
                                                                    @if($this->permission('user-submit-application-document-download'))
                                                                        <a
                                                                            @click.prevent=" $wire.export(document.file)"
                                                                            class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                                            <x-svg.main type="download"
                                                                                        class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                                                        </a>
                                                                    @endif
                                                                    @if($this->permission('user-submit-application-document-view'))
                                                                        <a @click.prevent="$wire.photoView(document.file)"
                                                                           class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-purple-700 rounded-md hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                                                                            <x-svg.main type="view"
                                                                                        class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            @endif

                                                        </div>

                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>


                    {{--                FINISH SUMMARY             --}}
                    <div x-show="stepID===steps[6].id" id="finish" class="flex w-full justify-center items-center ">
                        <div class="flex flex-col h-full p-4 leading-normal justify-center items-center ">

                            <div
                                class="block p-6 md:min-w-[400px] max-w-xl bg-white rounded-lg border my-10 border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 ">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Summary</h5>

                                <ul>
                                    <li class="pb-3">
                                        <div
                                            class="flex flex-col border border-gray-700 rounded-2xl p-2 px-4 text-blue-400">
                                            <h5 class="flex font-semibold text-lg" x-text="'Passport'"></h5>
                                            <p class="flex text-gray-200" x-text="passport.passport_number"></p>
                                        </div>
                                    </li>
                                    <li class="pb-3">
                                        <div
                                            class="flex flex-col border border-gray-700 rounded-2xl p-2 px-4 text-blue-400">
                                            <h5 class="flex font-semibold text-lg" x-text="'Service'"></h5>
                                            <p class="flex text-gray-200" x-text="serviceName"></p>
                                        </div>
                                    </li>
                                    <li class="pb-3">
                                        <div
                                            class="flex flex-col border border-gray-700 rounded-2xl p-2 px-4 text-blue-400">
                                            <h5 class="flex font-semibold text-lg mb-2" x-text="'Documents'"></h5>
                                            <template x-for="(requirement, index) in serviceRequirements" :key="index">
                                                <div>
                                                    <p class="flex font-semibold text-green-400"
                                                       x-text="requirement.name"></p>
                                                    <template x-for="(document, index) in requirement.documents"
                                                              :key="index">
                                                        {{--                                                      <p class="flex flex-row justify-start items-center mb-3 text-gray-400">--}}
                                                        {{--                                                          <x-svg.main type="document-text" class="flex mr-1 w-4 h-4 text-gray-400 dark:text-gray-400"></x-svg.main> --}}
                                                        {{--                                                          <span class="flex" x-text="document.name"></span>--}}
                                                        {{--                                                      </p>--}}

                                                        @if($this->permission('user-submit-application-document-view'))
                                                            <a x-init="console.log('RID: '+requirement.id+', '+'DID: '+document.id)"
                                                               x-show="findDocument(requirement.id, document.id)"
                                                               @click.prevent="$wire.photoView(document.file)"
                                                               class="flex flex-row justify-start items-center mb-3 text-gray-400 hover:text-gray-300 cursor-pointer">
                                                                <x-svg.main type="document-text"
                                                                            class="flex mr-1 w-4 h-4 text-gray-400 dark:text-gray-400"></x-svg.main>
                                                                <span class="flex" x-text="document.name"></span>
                                                            </a>
                                                        @endif
                                                    </template>
                                                </div>
                                            </template>
                                            <span>

                                                 <p x-show="serviceRequirementsCount === 0"
                                                    class="flex flex-row justify-start items-center mb-3 text-gray-400 ">
                                                                <x-svg.main type="document-text"
                                                                            class="flex mr-1 w-4 h-4 text-gray-400 dark:text-gray-400"></x-svg.main>
                                                                <span class="flex"
                                                                      x-text="'No documents Required!'"></span>
                                                            </p>
                                            </span>
                                        </div>
                                    </li>
                                </ul>

                            </div>

                        </div>
                    </div>

                </div>

                {{--                FOOTER                  --}}
                <div class="flex  w-full justify-end">
                    <!-- Previous Button -->
                    <a x-show="stepID !== 1" @click.prevent="stepID--"
                       class="inline-flex cursor-pointer items-center py-2 px-4 mr-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg aria-hidden="true" class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Previous
                    </a>
                    <a x-show="stepID !== steps.length" @click.prevent="if(error===false) stepID++ "
                       class="inline-flex cursor-pointer items-center py-2 px-4 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                       :class="{'!cursor-default dark:bg-gray-900 dark:bg-gray-900 dark:border-gray-700 dark:!text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-600': error===true}"
                    >
                        Next
                        <svg aria-hidden="true" class="ml-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <button x-show="stepID === steps.length" @click.prevent="$wire.submit(); isSubmitting=true;"
{{--                            x-bind:disabled="isSubmitting"--}}
                            class="inline-flex cursor-pointer items-center py-2 px-4 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                            :class="{'!cursor-default dark:bg-gray-900 dark:bg-gray-900 dark:border-gray-700 dark:!text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-600': (error===true || isSubmitting)}"
                    >
                        <svg x-show="isSubmitting" aria-hidden="true" role="status"
                             class="inline mr-3 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="#E5E7EB"/>
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentColor"/>
                        </svg>
                        <span x-show="!isSubmitting">Submit</span><span x-show="isSubmitting">Submitting...</span>
                        <svg x-show="!isSubmitting" xmlns="http://www.w3.org/2000/svg" class="ml-2 w-5 h-5"
                             viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>

            </div>

        </div>


    </x-datatable.table>

    {{--                PHOTOVIEW MODAL STARTS HERE      --}}
    <x-datatable.modal.photo-view x-show="AddUpdateModal.formType==='view'">
        <img class="rounded-xl"
             :src=" ($wire.fileView !=='') ? '/storage/images/documents/'+$wire.fileView+'?ver='+Math.floor((Math.random()*100)+1) : '' "
             alt="">
    </x-datatable.modal.photo-view>

</x-datatable.main>

