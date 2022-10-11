<div class="flex flex-row flex-wrap mb-2">

    <button @click.prevent="filterRecord='all'" type="button" class="inline-flex justify-center items-center  text-gray-900 group hover:text-white border border-gray-800 hover:bg-gray-900
    focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center
    mr-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800"
    :class="{ 'bg-blue-900': filterRecord==='all' }"
    >
        <span class="inline-flex" x-text="'All'"></span>
        <span class="inline-flex text-xs justify-center items-center rounded  border w-6 h-6 ml-2 text-xs font-semibold text-gray-400 border-gray-400 rounded-full dark:group-hover:text-gray-200 dark:group-hover:border-gray-200" x-text="applicationsCount.allApplicationCount"></span>
    </button>

    <button  @click.prevent="filterRecord='review'" type="button" class="inline-flex justify-center items-center text-gray-900 group hover:text-white border border-gray-800 hover:bg-gray-900
    focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center
    mr-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800"
             :class="{ 'bg-blue-900': filterRecord==='review' }"
    >
        <span class="inline-flex" x-text="'Review'"></span>
        <span class="inline-flex text-xs justify-center items-center rounded  border w-6 h-6 ml-2 text-xs font-semibold text-gray-400 border-gray-400 rounded-full dark:group-hover:text-gray-200 dark:group-hover:border-gray-200" x-text="applicationsCount.reviewApplicationsCount"></span>
    </button>

    <button  @click.prevent="filterRecord='accepted'" type="button" class="inline-flex justify-center items-center text-gray-900 group hover:text-white border border-gray-800 hover:bg-gray-900
    focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center
    mr-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800"
             :class="{ 'bg-blue-900': filterRecord==='accepted' }"
    >
        <span class="inline-flex" x-text="'Accepted'"></span>
        <span class="inline-flex text-xs justify-center items-center rounded  border w-6 h-6 ml-2 text-xs font-semibold text-gray-400 border-gray-400 rounded-full dark:group-hover:text-gray-200 dark:group-hover:border-gray-200" x-text="applicationsCount.acceptedApplicationsCount"></span>
    </button>

    <button  @click.prevent="filterRecord='rejected'" type="button" class="inline-flex justify-center items-center text-gray-900 group hover:text-white border border-gray-800 hover:bg-gray-900
    focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center
    mr-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800"
             :class="{ 'bg-blue-900': filterRecord==='rejected' }"
    >
        <span class="inline-flex" x-text="'Rejected'"></span>
        <span class="inline-flex text-xs justify-center items-center rounded  border w-6 h-6 ml-2 text-xs font-semibold text-gray-400 border-gray-400 rounded-full dark:group-hover:text-gray-200 dark:group-hover:border-gray-200" x-text="applicationsCount.rejectedApplicationsCount"></span>
    </button>


    <button  @click.prevent="filterRecord='revision'" type="button" class="inline-flex justify-center items-center text-gray-900 group hover:text-white border border-gray-800 hover:bg-gray-900
    focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center
    mr-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800"
             :class="{ 'bg-blue-900': filterRecord==='revision' }"
    >
        <span class="inline-flex" x-text="'Revision'"></span>
        <span class="inline-flex text-xs justify-center items-center rounded  border w-6 h-6 ml-2 text-xs font-semibold text-gray-400 border-gray-400 rounded-full dark:group-hover:text-gray-200 dark:group-hover:border-gray-200" x-text="applicationsCount.revisionApplicationsCount"></span>
    </button>


</div>
<div  wire:loading >
    <div  class="flex w-full flex-row justify-start items-center">
    <div class="flex">
        <svg class="inline mr-2 w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
    </div>
    <span class="flex text-gray-300" x-text="'Loading...'"></span>
</div>
</div>
<div wire:loading.remove>
<table
    x-init="console.log('d: '+routeName);"
    class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead
        class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
    <tr>
        <th scope="col" class="px-6 py-3" width="5%">
            #
        </th>
        <th scope="col" class="px-6 py-3 text-center" width="5%">
            Comments
        </th>
        <template x-if="routeName === 'user.application-all-submissions'">
            <th scope="col" class="px-6 py-3 text-center" width="15%" x-text="'User'"></th>
        </template>
        <th scope="col" class="px-6 py-3 text-left" width="15%"
        :class="{'w-[45%]' : routeName !== 'user.client-details'}"
        >
            Service
        </th>
        <th scope="col" class="px-6 py-3 text-center" width="10%">
            Passport
        </th>
        <template x-if="routeName==='user.client-details'">
            <th scope="col" class="px-6 py-3 text-center" width="45%">
                Documents
            </th>
        </template>
        <template x-if="routeName==='user.client-details'">
            <th scope="col" class="px-6 py-3 text-center" width="10%">
                Add Documents
            </th>
        </template>
        <th scope="col" class="px-6 py-3 text-right" width="10%">
            Action
        </th>
    </tr>
    </thead>
    <template x-for="application in applications" :key="application.id">
        <tbody>
        <tr :id="'tr-1-'+application.id"
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td x-text="application.id" scope="row"
                class="px-6 py-3 font-medium text-gray-900 dark:text-white whitespace-nowrap"></td>

            <td scope="row">
                <a @click.prevent="$wire.applicationChat(application)"
                   class="flex px-6 py-3 justify-center items-center  font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    <x-svg.main
                        type="chat"
                        class="cursor-pointer flex self-end relative z-10 h-[30px] w-[30px] text-red-800 dark:text-gray-300/[0.4] hover:!text-gray-300/[0.7] ">
                    </x-svg.main>
                </a>
            </td>

            <template x-if="routeName === 'user.application-all-submissions'">
                <td :id="'td-11-'+application.id" scope="row">
                    <div class="flex justify-center items-center">
                    <button @click.prevent="$wire.userDetails(application.user.id);" type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none
                focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white
                dark:hover:bg-blue-600 dark:focus:ring-blue-800" x-text="application.user.name">

                    </button>
                    </div>
                </td>
            </template>

            <td :id="'td-1-'+application.id" scope="row"
                class="px-6 py-3  text-center  text-gray-900 dark:text-white whitespace-nowrap">
                <p class="flex flex-col">
                                    <span class="flex flex-row font-medium"
                                          x-text="application.service.name+' ('+application.service.abbreviation+' )'"></span>
                    <span class="flex flex-row text-sm font-semibold text-gray-400">
                                        <span class="flex mr-1 " x-text="'Submitted: '"></span>
                                        <span class="flex font-normal" x-text="application.created_at"></span>
                                    </span>
                    <span x-show="application.accepted===1"
                          class="flex flex-row text-sm font-semibold text-gray-400">
                                        <span class="flex mr-1 " x-text="'Accepted: '"></span>
                                        <span class="flex font-normal" x-text="application.updated_at"></span>
                                    </span>
                </p>
            </td>


            <td
                :id="'td-2-'+application.id" scope="row"
                class="px-6 py-3  text-center  text-gray-900 dark:text-white">
                <ul class="flex flex-row w-full justify-center items-center space-x-2">
                                    <span
                                        @click.prevent="photoType='passport'; $wire.photoView(application.passports.file, 'passport');"
                                        class="cursor-pointer flex px-3 py-2  min-w-[150px] bg-blue-900/[0.5] border border-blue-900/[0.8] hover:bg-blue-800/[0.5] rounded-3xl"
                                        :class="{ 'bg-red-900/[0.3] border border-red-900/[0.5] hover:bg-red-800/[0.4]' : moment(application.passports.expiry_date).isBefore(moment())}"
                                    >

                                         <li class="flex border border-gray-00 rounded-full mr-2 "
                                             :class="{
                                        'bg-green-800 border-green-700' : (application.passports.accepted===1 && application.passports.rejected===0),
                                        'bg-red-800 border-red-700' : (application.passports.accepted===0 && application.passports.rejected===1),
                                        'bg-gray-800 border-gray-700' : (application.passports.accepted===0 && application.passports.rejected===0),
                                        }"
                                         >
                                          <x-svg.main x-show="application.passports.accepted===1" type="check-open"
                                                      class="flex h-[10px] w-[10px] text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                         <x-svg.main x-show="application.passports.rejected===1" type="delete-open"
                                                     class="flex h-[10px] w-[10px] text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                         <x-svg.main
                                             x-show="application.passports.rejected===0 && application.passports.accepted===0"
                                             type="question-open"
                                             class="flex h-[10px] w-[10px] text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                    </li>
                                        <span x-text="application.passports.passport_number"></span>
                                    </span>
                </ul>
            </td>

            <template x-if="routeName==='user.client-details'">
                <td :id="'td-3-'+application.id" scope="row"
                    class="px-6 py-3  min-w-[400px] text-center  text-gray-900 dark:text-white">
                    <div x-show="application.selected_documents.length > 0">
                        <ul x-init=" records = application.selected_documents "
                            :id="'ul-3-1-'+application.id"
                            class="flex flex-row w-full justify-start items-center space-x-2 ">
                            <ul class="flex flex-wrap grow-0  flex-row space-x-2 space-y-2">
                                <template x-for="record in application.selected_documents"
                                          :key="record.id">

                                    <li @click.prevent=" photoType='record'; $wire.photoView(record.file);"
                                        class="inline-flex grow-0  justify-start cursor-pointer hover:bg-gray-900 hover:text-gray-100 text-gray-300 border border-gray-600 rounded-md p-2">
                                               <span class="flex justify-center items-center">
                                               <span :id="'wrapper-'+record.id"
                                                     class="flex justify-center items-center border border-gray-400 min-w-[20px] min-h-[20px] rounded-full mr-2"
                                                     :class="{
                                                                                      'bg-green-900 hover:bg-green-800 border-green-700' : ( record.rejected===0 && record.accepted===1 && record.revision===0 ),
                                                                                      'bg-red-900 hover:bg-red-800 border-red-700' : ( record.rejected===1 && record.accepted===0 && record.revision===0 ),
                                                                                      'bg-yellow-900 hover:bg-yellow-800 border-yellow-700' : ( record.rejected===0 && record.accepted===0 && record.revision===1),
                                                                                      'bg-gray-800 hover:bg-gray-700 border-gray-600' : ( record.rejected===0 && record.accepted===0 && record.revision===0 )
                                                                                  }"
                                               >
                                                                                  <x-svg.main
                                                                                      x-show="record.rejected===0 && record.accepted===1 && record.revision===0"
                                                                                      type="check-open"
                                                                                      ::id="'accepted-'+record.id"
                                                                                      class="flex h-[10px] w-[10px] text-red-800 dark:text-gray-300 m-1"
                                                                                  ></x-svg.main>
                                                                                 <x-svg.main
                                                                                     x-show="record.rejected===1 && record.accepted===0 && record.revision===0"
                                                                                     type="delete-open"
                                                                                     ::id="'rejected-'+record.id"
                                                                                     class="flex h-[10px] w-[10px] text-red-800 dark:text-gray-300 m-1"></x-svg.main>

                                         <x-svg.main
                                             x-show="record.rejected===0 && record.accepted===0 && record.revision===1"
                                             type="refresh"
                                             ::id="'revision-'+record.id"
                                             class="flex h-[10px] w-[10px] text-yellow-800 dark:text-gray-300 m-1"></x-svg.main>
                                                                                 <x-svg.main
                                                                                     x-show="record.rejected===0 && record.accepted===0 && record.revision===0"
                                                                                     type="question-open"
                                                                                     ::id="'none-'+record.id"
                                                                                     class="flex h-[10px] w-[10px]  text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                                                            </span>
                                                   </span>
                                        <span class="flex  justify-start items-start">
                                                   <span class="flex w-auto grow-0 self-start text-left"
                                                         x-text="record.service_requirement.name"></span>
                                               </span>
                                    </li>
                                </template>
                            </ul>

                            {{--                                    <x-datatable.document-show></x-datatable.document-show>--}}
                        </ul>


                        <div
                            {{--                                        x-init="console.log(compareArrays(application.selected_documents.map(s=>s.service_requirement).map(r=>r.id),application.additional_requirements.map(s=>s.id)))"--}}
                            x-show="compareArrays(application.selected_documents.map(s=>s.service_requirement).map(r=>r.id),application.additional_requirements.map(s=>s.id))"
                            {{--                                        x-show="((application.selected_documents[0].applications[0].additional_requirements.length > 0) || (application.selected_documents[0].applications[0].service.requirements.length > 0))"--}}
                            class="flex flex-col ml-2 ">
                            <p class="flex font-semibold text-yellow-400 mt-3"
                               x-text="'Documents required'"></p>
                            <div class="flex flex-wrap mt-2">
                                <template
                                    x-for="(additionalRequirement,index) in application.additional_requirements
"
                                    :key="index">
                                    <p x-show="!(application.selected_documents).map(s=>s.service_requirement).map(r=>r.id).includes(additionalRequirement.id)"
                                       {{--                                                    x-init="--}}

                                       {{--                                                    console.log((application.selected_documents).map(s=>s.service_requirement).map(r=>r.id))"--}}
                                       class="flex border bg-blue-900/[0.3] border-blue-900/[0.5] rounded-md px-2 py-1 mr-2 mb-2">
                                                    <span class="flex self-start mr-2"
                                                          x-text="additionalRequirement.name">  </span>
                                    </p>
                                </template>
                                {{--                                            <template--}}
                                {{--                                                x-for="(requirement,index) in application.selected_documents[0].applications[0].additional_requirements"--}}
                                {{--                                                :key="index">--}}
                                {{--                                                <p--}}
                                {{--                                                    x-init=" "--}}
                                {{--                                                    class="flex border bg-red-900/[0.3] border-red-900/[0.5] rounded-md px-2 py-1 mr-2">--}}
                                {{--                                                    <span class="flex self-start mr-2"--}}
                                {{--                                                          x-text="requirement.name">  </span>--}}
                                {{--                                                    <x-svg.main--}}
                                {{--                                                        @click.prevent="$wire.removeAdditionalRequirements(application.id,requirement.id)"--}}
                                {{--                                                        type="delete"--}}
                                {{--                                                        class="flex self-center relative z-10 h-[20px] w-[20px] text-red-800 dark:text-gray-300/[0.4]  m-0"></x-svg.main>--}}
                                {{--                                                </p>--}}
                                {{--                                            </template>--}}
                            </div>
                        </div>
                    </div>
                    <template x-if="application.selected_documents.length === 0">
                        <ul class="flex flex-wrap grow-0  flex-row space-x-2 space-y-2">
                            <li class="inline-flex grow-0 ml-2 bg-red-900/[0.5] self-start  text-gray-300 border border-gray-600 rounded-md p-2"
                                x-text="'No documents available'"></li>
                        </ul>
                    </template>
                </td>
            </template>
            <template x-if="routeName==='user.client-details'">
                <td :id="'td-4-'+application.id" scope="row"
                    class="px-6 py-3  text-center  text-gray-900 dark:text-white">

                    <button
                        @click.prevent="((application.accepted === 0 && application.rejected ===0 && application.revision ===1) || (application.accepted === 0 && application.rejected ===0 && application.revision ===0)) ? $wire.getAdditionalRequirements(application.id) : ''; selectedRequirements=[]; "
                        :id="'requirementButton-'+application.id"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        :class="{ 'dark:!bg-gray-600 cursor-default dark:!text-gray-500' : !((application.accepted === 0 && application.rejected ===0 && application.revision ===1) || (application.accepted === 0 && application.rejected ===0 && application.revision ===0))}"
                        type="button">
                                                <span class="flex flex-row">
                                                    <x-svg.main
                                                        type="plus"
                                                        class="flex self-center relative z-10 h-[10px] w-[10px] text-red-800 dark:text-gray-100 mr-1"
                                                        ::class="{ 'dark:!bg-gray-600 cursor-default dark:!text-gray-500' : !((application.accepted === 0 && application.rejected ===0 && application.revision ===1) || (application.accepted === 0 && application.rejected ===0 && application.revision ===0))}"
                                                    >
                                                     </x-svg.main>
                                                    <span class="flex" x-text="'Requirements'"></span>
                                                </span>
                    </button>


                </td>
            </template>

            <td id="'td-5-'+application.id"
                class="px-2 py-3 text-right space-x-2 overflow-hidden">
                <div class="flex flex-row justify-end items-end">

                    <button
                        @click.prevent="(routeName==='user.client-details') ? $wire.applicationDecision(application.id) : $wire.applicationDetails(application.id); "
                        type="button" class="mb-0 "
                        :class="{
                                    'py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700' :
                                    (application.accepted===0 && application.rejected===0 && application.revision===0),

                                    'text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800' :
                                    (application.accepted===1 && application.rejected===0 && application.revision===0),

                                    'text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:focus:ring-yellow-900' :
                                    (application.accepted===0 && application.rejected===0 && application.revision===1),

                                    'text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900' :
                                    (application.accepted===0 && application.rejected===1 && application.revision===0)
                                    }">
                                        <span
                                            x-show="(application.accepted===0 && application.rejected===0 && application.revision===0)"
                                            x-text="'Pending'"></span>
                        <span
                            x-show="(application.accepted===1 && application.rejected===0 && application.revision===0)"
                            x-text="'Accepted'"></span>
                        <span
                            x-show="(application.accepted===0 && application.rejected===0 && application.revision===1)"
                            x-text="'Revision'"></span>
                        <span
                            x-show="(application.accepted===0 && application.rejected===1 && application.revision===0)"
                            x-text="'Rejected'"></span>
                    </button>

                </div>
            </td>
        </tr>

        </tbody>
    </template>
    <tbody x-show="applications.length === 0 ">
    <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
        <td colspan="7"
            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
            No
            records available!
        </td>
    </tr>
    </tbody>
</table>
</div>

