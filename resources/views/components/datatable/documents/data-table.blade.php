<div class="flex flex-row mb-2">

    <button @click.prevent="filterDocumentRecord='all'" type="button" class="inline-flex justify-center items-center  text-gray-900 group hover:text-white border border-gray-800 hover:bg-gray-900
    focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center
    mr-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800"
    :class="{ 'bg-blue-900': filterDocumentRecord==='all' }"
    >
        <span class="inline-flex" x-text="'All'"></span>
        <span class="inline-flex text-xs justify-center items-center rounded  border w-6 h-6 ml-2 text-xs font-semibold text-gray-400 border-gray-400 rounded-full dark:group-hover:text-gray-200 dark:group-hover:border-gray-200" x-text="documentsCount.allDocumentCount"></span>
    </button>

    <button  @click.prevent="filterDocumentRecord='review'" type="button" class="inline-flex justify-center items-center text-gray-900 group hover:text-white border border-gray-800 hover:bg-gray-900
    focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center
    mr-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800"
             :class="{ 'bg-blue-900': filterDocumentRecord==='review' }"
    >
        <span class="inline-flex" x-text="'Review'"></span>
        <span class="inline-flex text-xs justify-center items-center rounded  border w-6 h-6 ml-2 text-xs font-semibold text-gray-400 border-gray-400 rounded-full dark:group-hover:text-gray-200 dark:group-hover:border-gray-200" x-text="documentsCount.reviewDocumentsCount"></span>
    </button>

    <button  @click.prevent="filterDocumentRecord='accepted'" type="button" class="inline-flex justify-center items-center text-gray-900 group hover:text-white border border-gray-800 hover:bg-gray-900
    focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center
    mr-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800"
             :class="{ 'bg-blue-900': filterDocumentRecord==='accepted' }"
    >
        <span class="inline-flex" x-text="'Accepted'"></span>
        <span class="inline-flex text-xs justify-center items-center rounded  border w-6 h-6 ml-2 text-xs font-semibold text-gray-400 border-gray-400 rounded-full dark:group-hover:text-gray-200 dark:group-hover:border-gray-200" x-text="documentsCount.acceptedDocumentsCount"></span>
    </button>

    <button  @click.prevent="filterDocumentRecord='rejected'" type="button" class="inline-flex justify-center items-center text-gray-900 group hover:text-white border border-gray-800 hover:bg-gray-900
    focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center
    mr-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800"
             :class="{ 'bg-blue-900': filterDocumentRecord==='rejected' }"
    >
        <span class="inline-flex" x-text="'Rejected'"></span>
        <span class="inline-flex text-xs justify-center items-center rounded  border w-6 h-6 ml-2 text-xs font-semibold text-gray-400 border-gray-400 rounded-full dark:group-hover:text-gray-200 dark:group-hover:border-gray-200" x-text="documentsCount.rejectedDocumentsCount"></span>
    </button>


    <button  @click.prevent="filterDocumentRecord='revision'" type="button" class="inline-flex justify-center items-center text-gray-900 group hover:text-white border border-gray-800 hover:bg-gray-900
    focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center
    mr-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800"
             :class="{ 'bg-blue-900': filterDocumentRecord==='revision' }"
    >
        <span class="inline-flex" x-text="'Revision'"></span>
        <span class="inline-flex text-xs justify-center items-center rounded  border w-6 h-6 ml-2 text-xs font-semibold text-gray-400 border-gray-400 rounded-full dark:group-hover:text-gray-200 dark:group-hover:border-gray-200" x-text="documentsCount.revisionDocumentsCount"></span>
    </button>


</div>
<x-wire_loading></x-wire_loading>
<table wire:loading.remove
{{--    x-init="console.log('d: '+routeName);"--}}
    class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead
        class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
    <tr>
        <th scope="col" class="px-6 py-3" width="5%"  x-text="'#'"></th>
        <th scope="col" class="px-6 py-3 text-center" width="5%" x-text="'Comments'"> </th>
        <th scope="col" class="px-6 py-3 text-center" width="10%" x-text="'User'"></th>
        <th  scope="col" class="px-6 py-3 text-center" width="20%" x-text="'Document Type'"></th>
        <th  scope="col" class="px-6 py-3 text-left" width="40%" x-text="'Document'"></th>
        <th  scope="col" class="px-6 py-3 text-center" width="10%" x-text="'File'"></th>

        <th scope="col" class="px-6 py-3 text-right" width="10%" x-text="'Action'"> </th>
    </tr>
    </thead>
    <template x-for="document in documents" :key="document.id">
        <tbody>
        <tr :id="'tr-1-'+document.id"
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td :id="'td-1-'+document.id" x-text="document.id" scope="row"
                class="px-6 py-3 font-medium text-gray-900 dark:text-white whitespace-nowrap"></td>

            <td :id="'td-2-'+document.id"  scope="row">
                <a @click.prevent="$wire.documentChat(document)"
                   class="flex px-6 py-3 justify-center items-center  font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    <x-svg.main
                        type="chat"
                        class="cursor-pointer flex self-end relative z-10 h-[30px] w-[30px] text-red-800 dark:text-gray-300/[0.4] hover:!text-gray-300/[0.7] ">
                    </x-svg.main>
                </a>
            </td>


            <td  :id="'td-3-'+document.id" scope="row">
                <div class="flex justify-center items-center">
                    <button @click.prevent="$wire.userDetails(document.user.id);" type="button" class="text-blue-700 whitespace-nowrap hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none
                focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white
                dark:hover:bg-blue-600 dark:focus:ring-blue-800" x-text="document.user.name">

                    </button>
                </div>
            </td>


            <td  :id="'td-33-'+document.id" scope="row">
                <div class="flex justify-center items-center">
                  <span x-text="document.service_requirement.name"></span>
                </div>
            </td>


{{--            <td :id="'td-3-'+document.id"  scope="row" >--}}
{{--                <div class="flex justify-center items-center">--}}
{{--                    <button @click.prevent="$wire.userDetails(application.user.id);" type="button" class="flex text-gray-900 whitespace-nowrap hover:text-white border border-gray-800--}}
{{--                hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5--}}
{{--                text-center mr-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800" x-text="document.user.name"></button>--}}
{{--                </div>--}}
{{--            </td>--}}


            <td :id="'td-4-'+document.id"  scope="row">

                <p class="flex flex-col py-2">
                                    <span class="flex flex-row font-semibold text-gray-100"
                                          x-text="document.name"></span>
                    <span class="flex flex-row text-sm font-semibold text-gray-400">
                                        <span class="flex mr-1 " x-text="'Submitted: '"></span>
                                        <span class="flex font-normal" x-text="moment(document.created_at).format('MMMM Do YYYY')"></span>
                                    </span>
                    <span x-show="document.accepted===1"
                          class="flex flex-row text-sm font-semibold text-gray-400">
                                        <span class="flex mr-1 " x-text="'Accepted: '"></span>
                                        <span class="flex font-normal" x-text="moment(document.updated_at).format('MMMM Do YYYY')"></span>
                                    </span>
                </p>

            </td>

            <td :id="'td-5-'+document.id"  scope="row">
                <div class="flex flex-row space-x-2 justify-center items-center">
                <template x-if="document.file.length > 0 ">
                    <a  x-show="checkFileExist('/storage/images/documents/',document.file) === true"
                        @click.prevent=" $wire.photoType='document'; $wire.export(document.file); "
                        class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <x-svg.main type="download"
                                    class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                    </a>
                </template>

                <a x-show="checkImage(document.file)===true" @click.prevent="photoType='file'; $wire.photoView(document.file, 'file');"
                   class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-purple-700 rounded-md hover:bg-purple-800 focus:ring-4
                   focus:outline-none focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                    <x-svg.main type="view"
                                class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                </a>
                </div>
            </td>

            <td id="'td-6-'+document.id"
                class="px-2 py-3 text-right space-x-2 overflow-hidden">
                <div class="flex flex-row justify-end items-end">

                    <button
                        @click.prevent="$wire.attentionDocument(document.id)"
                        type="button" class="mb-0 "
                        :class="{
                                    'py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700' :
                                    (document.accepted===0 && document.rejected===0 && document.revision===0),

                                    'text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800' :
                                    (document.accepted===1 && document.rejected===0 && document.revision===0),

                                    'text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:focus:ring-yellow-900' :
                                    (document.accepted===0 && document.rejected===0 && document.revision===1),

                                    'text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900' :
                                    (document.accepted===0 && document.rejected===1 && document.revision===0)
                                    }">
                                        <span
                                            x-show="(document.accepted===0 && document.rejected===0 && document.revision===0)"
                                            x-text="'Pending'"></span>
                        <span
                            x-show="(document.accepted===1 && document.rejected===0 && document.revision===0)"
                            x-text="'Accepted'"></span>
                        <span
                            x-show="(document.accepted===0 && document.rejected===0 && document.revision===1)"
                            x-text="'Revision'"></span>
                        <span
                            x-show="(document.accepted===0 && document.rejected===1 && document.revision===0)"
                            x-text="'Rejected'"></span>
                    </button>

                </div>
            </td>
        </tr>

        </tbody>
    </template>
    <tbody x-show="documents.length === 0 ">
    <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
        <td colspan="7"
            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
            No
            records available!
        </td>
    </tr>
    </tbody>
</table>


