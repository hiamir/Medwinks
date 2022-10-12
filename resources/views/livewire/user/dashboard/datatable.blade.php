<x-datatable.main
    x-data=" Dashboard( $wire, {
        clientsCount:null,
        acceptedCount:null,
        revisionCount:null,
        rejectedCount:null,
        documentsRevisionCount:null
    })"
    x-init="
        clientsCount={{$clients->clientsCount}}
        applicationCount={{$applications->applicationCount}}
        newApplicationCount={{$newApplicationCount}}
        acceptedCount={{$applications->acceptedCount}}
        revisionCount={{ $applications->revisionCount }}
        rejectedCount= {!! $applications->rejectedCount !!}
        documentsRevisionCount= {{$documentsRevisionCount}}
        documentAction={{$documentAction}}
        latest={{$latest}}
        console.log(documentAction)
"

>
    <x-wire_loading></x-wire_loading>

    <div wire:loading.remove class="grid grid-cols-1 space-y-5">


        {{--            STATS           --}}

        <div class="grid grid-cols-4 xl:grid-cols-4 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-2  xs:grid-cols-1 ">


            <div @click.prevent="$wire.goApplication('review')"
                 class="col-span-1 min-w-[200px] min-h-[120px] p-6 rounded-lg  cursor-pointer  bg-blue-700/[0.5] hover:bg-blue-700/[0.6] shadow-md justify-center items-center m-5">
                <div class="flex flex-row justify-start items-center">
                    <div class="flex relative w-16">
                        <x-svg.main type="document-text"
                                    class="flex self-end relative z-0 h-[40px] w-[40px] text-red-800 dark:text-gray-100/[0.8] hover:!text-gray-300/[0.7]"></x-svg.main>
                        <span x-show="(newApplicationCount > 0)"
                              class="absolute flex border-4 border-red-800 dark:border-gray-100 rounded-full h-[40px] w-[40px] justify-center items-center animate-ping"> </span>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex text-2xl text-yellow-400 font-black"
                             x-text="twoDigitNumber(newApplicationCount)"></div>
                        <div class="flex uppercase text-sm font-semibold text-gray-400 whitespace-wrap">New
                            Applications
                        </div>
                    </div>
                </div>
            </div>
            <div @click.prevent="$wire.goDocument('review')"
                 class="col-span-1 p-6  min-w-[200px] min-h-[120px] rounded-lg cursor-pointer  bg-indigo-700/[0.5] hover:bg-indigo-700/[0.6] shadow-md justify-center items-center  m-5">
                <div class="flex flex-row justify-start items-center">
                    <div class="flex relative w-16">
                        <x-svg.main type="refresh"
                                    class="h-[40px] w-[40px] text-red-800 dark:text-gray-300 "></x-svg.main>
                        <span x-show="(documentsRevisionCount > 0)"
                              class="absolute flex border-4 border-red-800 dark:border-gray-100 rounded-full h-[40px] w-[40px] justify-center items-center m-0 mb-2 animate-ping"> </span>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex text-2xl text-yellow-400 font-black"
                             x-text="twoDigitNumber(documentsRevisionCount)"></div>
                        <div class="flex uppercase text-sm font-semibold text-gray-400">Documents for Revision</div>
                    </div>
                </div>
            </div>
            <div @click.prevent="$wire.goApplication('revision')"
                 class="col-span-1 p-6 rounded-lg   min-w-[200px] min-h-[120px] cursor-pointer  bg-yellow-700/[0.5] hover:bg-yellow-700/[0.6] shadow-md justify-center items-center  m-5">
                <div class="flex flex-row justify-start items-center">
                    <div class="flex relative w-16">
                        <x-svg.main type="refresh"
                                    class="flex self-end relative z-0 h-[40px] w-[40px] text-red-800 dark:text-gray-100/[0.8] hover:!text-gray-300/[0.7]"></x-svg.main>
                        <span x-show="(revisionCount > 0)"
                              class="absolute flex border-4 border-red-800 dark:border-gray-100 rounded-full h-[40px] w-[40px] justify-center items-center animate-ping"> </span>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex text-2xl text-yellow-400 font-black"
                             x-text="twoDigitNumber(revisionCount)"></div>
                        <div class="flex uppercase text-sm font-semibold text-gray-400 whitespace-wrap">Applications for
                            Revision
                        </div>
                    </div>
                </div>
            </div>
            <div @click.prevent="$wire.goApplication('rejected')"
                 class="col-span-1 p-6 rounded-lg  min-w-[200px] min-h-[120px]  cursor-pointer  bg-red-700/[0.5] hover:bg-red-700/[0.6] shadow-md justify-center items-center  m-5">
                <div class="flex flex-row justify-start items-center">
                    <div class="flex relative w-16">
                        <x-svg.main type="x"
                                    class="flex self-end relative z-0 h-[40px] w-[40px] text-red-800 dark:text-gray-100/[0.8] hover:!text-gray-300/[0.7]">
                        </x-svg.main>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex text-2xl text-yellow-400 font-black"
                             x-text="twoDigitNumber(rejectedCount)"></div>
                        <div class="flex uppercase text-sm font-semibold text-gray-400 whitespace-wrap ">Applications
                            Rejected
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--            ATTENTION           --}}
        <div class="flex flex-col m-5 !mb-5   p-6 relative border rounded-lg border-gray-600">
            <h4 class="flex text-xl text-gray-400 font-semibold mb-4"
                x-text="'Attention Required'"></h4>


            <div class="overflow-x-auto relative">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs  text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="rounded-tl-md py-3 px-6" style="width:5%">
                            #
                        </th>
                        <template x-if="isUserManager === true">
                            <th scope="col" class="py-3 px-6" style="width:10%">
                            User
                        </th>
                        </template>
                        <th scope="col" class="py-3 px-6" style="width:20%">
                            Document Type
                        </th>
                        <th scope="col" class="py-3 px-6" style="width:20%">
                            Document
                        </th>
                        <th scope="col" class="py-3 px-6 text-center" style="width:20%">
                            Decision
                        </th>
                        <th scope="col" class="py-3 px-6 text-center" style="width:35%">
                            Comment
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    <template x-for="(doc,index) in documentAction" :key="index">
                        <tr  @click.prevent="$wire.attentionDocument(doc.id)" class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:dark:bg-gray-900/[0.5]">
                            <th>
                                <p x-show="doc.seen===0" class="flex relative top-0 left-0">
                                <span
                                    class="flex absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                <span class="flex absolute  top-[-5px] bottom-0 left-[-5px] right-0 rounded-full h-3 w-3 bg-sky-500"></span>
                                <span
                                    class=" flex absolute  top-[-5px] bottom-0 left-[-5px] right-0 animate-ping h-3 w-3 inline-flex rounded-full bg-sky-400 opacity-75"></span>
                                    </span>
                                </p>
                            </th>
                            <template x-if="isUserManager === true">
                            <th>
                                <div class="flex justify-center items-center">
                                    <button  @click.prevent.self="$wire.userDetails(doc.user.id);" type="button" class="text-blue-700 whitespace-nowrap hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none
                focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center m-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white
                dark:hover:bg-blue-600 dark:focus:ring-blue-800" x-text="doc.user.name">

                                    </button>
                                </div>

                            </th>
                            </template>

                            <th scope="row"
                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <span x-text="doc.service_requirement.name"></span>
                            </th>
                            <td class="py-4 px-6">
                                <span x-text="doc.name"></span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <x-svg.main x-show="doc.rejected===0 && doc.accepted===1 && doc.revision===0"
                                            type="check-open"
                                            class="h-6 w-6 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                <x-svg.main x-show="doc.rejected===1 && doc.accepted===0 && doc.revision===0"
                                            type="delete-open"
                                            class="h-6 w-6 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                <x-svg.main x-show="doc.rejected===0 && doc.accepted===0 && doc.revision===1"
                                            type="refresh"
                                            class="h-6 w-6 text-yellow-800 dark:text-gray-300 m-1"></x-svg.main>
                                <span x-text="'Revision required'"></span>

                            </td>
                            <td class="py-4 px-6 text-center">
                                <span>
                                    <template x-for="(comment, index) in doc.comments" :key="index">
                                        <span x-show="index===0" x-text="comment.comment"></span>
                                    </template>

                                </span>
                                <span x-show="doc.comments.length === 0" x-text="'Not available'"></span>
                            </td>

                        </tr>
                    </template>

                    </tbody>
                </table>
            </div>

        </div>


        {{--            GRAPH           --}}
        <div class="grid grid-cols-10 !mt-0">

            <div
                class="xs:hidden md:flex flex-col m-5  md:col-span-12 lg:col-span-6 md:landscape:hidden lg:landscape:flex p-6 relative border rounded-lg border-gray-600">
                <h4 class="flex text-xl text-gray-400 font-semibold mb-4"
                    x-text="'Applications submitted this year'"></h4>
                <div class="relative">
                    <div class="chart-container" style="position: relative; height:100%; width:100%">
                        <canvas id="myChart" style=" height:550px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="xs:col-span-12 lg:col-span-4 m-5 p-6 border rounded-lg border-gray-600 ">

                <h4 x-show="isUserManager" class="flex text-xl text-gray-400 font-semibold mb-2"
                    x-text="'Latest applications'"></h4>
                <h4 x-show="!isUserManager" class="flex text-xl text-gray-400 font-semibold mb-2"
                    x-text="'My applications'"></h4>
                <div class="flex flex-col space-y-3 ">


                    <template x-if="latest.length===0">
                        <div class="relative flex justify-start items-center rounded-lg border-gray-600 border p-3">
                            <p class="flex inline-flex justify-start items-center ">
                                <span class="flex justify-center items-center">
                                    <x-svg.main type="document-text"
                                                class="flex relative z-0 h-[40px] w-[40px] text-red-800 dark:text-gray-100/[0.8] ">  </x-svg.main>
                                </span>
                            </p>
                            <div class="flex flex-col ml-3">
                                <p class="flex flex-col">
                                    <span class="flex flex-col text-gray-200 font-semibold text-gray-300 "
                                          x-text="'No applications available'"></span>
                                </p>
                            </div>
                        </div>
                    </template>


                    <template x-for="(application, index) in latest" :key="index">
                        <div @click.prevent="$wire.openApplication(application.id)"
                             class="cursor-pointer relative group flex rounded-lg border-gray-600 border p-3 hover:bg-gray-900/[0.5]">
                            <p x-show="application.seen===0 && isUserManager" class="absolute right-2 top-[-5px]">
                                <span class="absolute inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
                                <span
                                    class="animate-ping h-3 w-3 absolute inline-flex rounded-full bg-sky-400 opacity-75"></span>
                            </p>

                            <p class="flex inline-flex justify-start items-center ">
                                <span class="flex justify-center items-center">
                                    <x-svg.main
                                        x-show="application.accepted===0 && application.rejected===0 && application.revision===0"
                                        type="question-open"
                                        class="flex relative z-0 h-[40px] w-[40px] text-red-800 dark:text-gray-100/[0.8] ">  </x-svg.main></span>
                                <x-svg.main
                                    x-show="application.accepted===1 && application.rejected===0 && application.revision===0"
                                    type="check-open"
                                    class="flex relative z-0 h-[40px] w-[40px] text-red-800 dark:text-gray-100/[0.8] "></x-svg.main>
                                </span>
                                <x-svg.main
                                    x-show="application.accepted===0 && application.rejected===1 && application.revision===0"
                                    type="delete-open"
                                    class="flex relative z-0 h-[40px] w-[40px] text-red-800 dark:text-gray-100/[0.8] "></x-svg.main>
                                </span>
                                <x-svg.main
                                    x-show="application.accepted===0 && application.rejected===0 && application.revision===1"
                                    type="refresh"
                                    class="flex  relative z-0 h-[40px] w-[40px] text-red-800 dark:text-gray-100/[0.8] "></x-svg.main>
                                </span>
                            </p>
                            <div class="flex flex-col ml-3">
                                <p class="flex flex-col">
                                <span
                                    class="flex flex-col text-gray-200 font-semibold text-gray-300 group-hover:!text-yellow-400"
                                    x-text="application.service.name"></span>
                                <p class="flex flex-col mb-1">

                                <span
                                    x-show="application.accepted===0 && application.rejected===0 && application.revision===0"
                                    class="block flex-nowrap">
                                    <span
                                        class="text-xs bg-gray-100 text-gray-600 font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-600 dark:text-gray-100"
                                        x-text="'Under Review'"></span>
                                </span>

                                    <span
                                        x-show="application.accepted===1 && application.rejected===0 && application.revision===0"
                                        class="block flex-nowrap">
                                    <span
                                        class="text-xs bg-green-100 text-green-600 font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-600 dark:text-green-100"
                                        x-text="'Accepted'"></span>
                                </span>
                                    <span
                                        x-show="application.accepted===0 && application.rejected===1 && application.revision===0"
                                        class="block flex-nowrap">
                                    <span
                                        class="text-xs bg-red-100 text-red-600 font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-600 dark:text-red-100"
                                        x-text="'Rejected'"></span>
                                </span>
                                    <span
                                        x-show="application.accepted===0 && application.rejected===0 && application.revision===1"
                                        class="block flex-nowrap">
                                    <span
                                        class="text-xs bg-yellow-100 text-yellow-600 font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-600 dark:text-yellow-100"
                                        x-text="'Needs Revision'"></span>
                                </span>
                                </p>
                                <span class="flex text-xs font-semibold text-gray-400"
                                      x-text="application.user.name"></span>
                                </p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</x-datatable.main>

{{--@push('scripts')--}}
{{--    <script>--}}
{{--        --}}{{--const cData = JSON.parse('<?php echo $this->data ?>');--}}
{{--        const ctx = document.getElementById('myChart');--}}


{{--        const labels = moment.months({count: 7});--}}
{{--        const data = {--}}
{{--            labels: labels,--}}
{{--            datasets: [{--}}
{{--                label: 'My First Dataset',--}}
{{--                data: [65, 59, 80, 81, 56, 55, 40],--}}
{{--                backgroundColor: [--}}
{{--                    'rgba(255, 99, 132, 0.2)',--}}
{{--                    'rgba(255, 159, 64, 0.2)',--}}
{{--                    'rgba(255, 205, 86, 0.2)',--}}
{{--                    'rgba(75, 192, 192, 0.2)',--}}
{{--                    'rgba(54, 162, 235, 0.2)',--}}
{{--                    'rgba(153, 102, 255, 0.2)',--}}
{{--                    'rgba(201, 203, 207, 0.2)'--}}
{{--                ],--}}
{{--                borderColor: [--}}
{{--                    'rgb(255, 99, 132)',--}}
{{--                    'rgb(255, 159, 64)',--}}
{{--                    'rgb(255, 205, 86)',--}}
{{--                    'rgb(75, 192, 192)',--}}
{{--                    'rgb(54, 162, 235)',--}}
{{--                    'rgb(153, 102, 255)',--}}
{{--                    'rgb(201, 203, 207)'--}}
{{--                ],--}}
{{--                borderWidth: 1--}}
{{--            }]--}}
{{--        };--}}

{{--        const config = {--}}
{{--            type: 'line',--}}
{{--            data: data,--}}
{{--            options: {--}}
{{--                responsive: true,--}}
{{--                aspectRatio: 1,--}}
{{--                maintainAspectRatio: false,--}}
{{--                scales: {--}}
{{--                    y: {--}}
{{--                        beginAtZero: true--}}
{{--                    }--}}
{{--                }--}}
{{--            },--}}
{{--        };--}}
{{--        const myChart = new Chart(ctx, config);--}}

{{--    </script>--}}
{{--    @endpush--}}
