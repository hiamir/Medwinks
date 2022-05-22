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
        revisionCount={{$applications->revisionCount}}
        rejectedCount={{$applications->rejectedCount}}
        documentsRevisionCount={{$documentsRevisionCount}}
        latest={{$latest}}
        console.log(newApplicationCount)
"

>
    <div class="grid grid-cols-1 space-y-5">
        {{--            STATS           --}}
        <div
            class="grid grid-cols-4 xl:grid-cols-4 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2  xs:grid-cols-1 space-x-5">


            <div @click.prevent="$wire.goApplication('review')" class="col-span-1 p-6 rounded-lg  cursor-pointer  bg-blue-700/[0.5] hover:bg-blue-700/[0.6] shadow-md justify-center items-center">
                <div class="flex flex-row justify-start items-center">
                    <div class="flex w-16">
                        <x-svg.main type="document-text"
                                    class="flex self-end relative z-10 h-[40px] w-[40px] text-red-800 dark:text-gray-100/[0.8] hover:!text-gray-300/[0.7]"></x-svg.main>
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

            <div @click.prevent="$wire.goApplication('revision')" class="col-span-1 p-6 rounded-lg cursor-pointer  bg-indigo-700/[0.5] hover:bg-indigo-700/[0.6] shadow-md justify-center items-center">
                <div class="flex flex-row justify-start items-center">
                    <div class="flex w-16">
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
            <div @click.prevent="$wire.goApplication('revision')" class="col-span-1 p-6 rounded-lg  cursor-pointer  bg-yellow-700/[0.5] hover:bg-yellow-700/[0.6] shadow-md justify-center items-center">
                <div class="flex flex-row justify-start items-center">
                    <div class="flex w-16">
                        <x-svg.main type="refresh"
                                    class="flex self-end relative z-10 h-[40px] w-[40px] text-red-800 dark:text-gray-100/[0.8] hover:!text-gray-300/[0.7]"></x-svg.main>
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

            <div @click.prevent="$wire.goApplication('rejected')" class="col-span-1 p-6 rounded-lg  cursor-pointer  bg-red-700/[0.5] hover:bg-red-700/[0.6] shadow-md justify-center items-center">
                <div class="flex flex-row justify-start items-center">
                    <div class="flex w-16">
                        <x-svg.main type="x"
                                    class="flex self-end relative z-10 h-[40px] w-[40px] text-red-800 dark:text-gray-100/[0.8] hover:!text-gray-300/[0.7]">
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
        {{--            GRAPH           --}}
        <div class="grid grid-cols-10 space-x-5">

            <div class="col-span-6 p-6 relative border rounded-lg border-gray-600">
                <h4 class="flex text-xl text-gray-400 font-semibold mb-4"
                    x-text="'Applications submitted this year'"></h4>
                <div class="relative">
                    <div class="chart-container" style="position: relative; height:100%; width:100%">
                        <canvas id="myChart" style=" height:550px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-span-4 p-6 border rounded-lg border-gray-600 ">

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
                                                class="flex relative z-10 h-[40px] w-[40px] text-red-800 dark:text-gray-100/[0.8] ">  </x-svg.main>
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
                                        class="flex relative z-10 h-[40px] w-[40px] text-red-800 dark:text-gray-100/[0.8] ">  </x-svg.main></span>
                                <x-svg.main
                                    x-show="application.accepted===1 && application.rejected===0 && application.revision===0"
                                    type="check-open"
                                    class="flex relative z-10 h-[40px] w-[40px] text-red-800 dark:text-gray-100/[0.8] "></x-svg.main>
                                </span>
                                <x-svg.main
                                    x-show="application.accepted===0 && application.rejected===1 && application.revision===0"
                                    type="delete-open"
                                    class="flex relative z-10 h-[40px] w-[40px] text-red-800 dark:text-gray-100/[0.8] "></x-svg.main>
                                </span>
                                <x-svg.main
                                    x-show="application.accepted===0 && application.rejected===0 && application.revision===1"
                                    type="refresh"
                                    class="flex  relative z-10 h-[40px] w-[40px] text-red-800 dark:text-gray-100/[0.8] "></x-svg.main>
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
