<template x-for="(record, index) in records"
          :key="record.id">
<li :id="'li-3-'+application.id+'-'+record.id"
    @click.prevent=" photoType='document'; $wire.photoView(record.file);"


    class="flex items-center  min-w-[250px] px-2 py-2  pr-3 cursor-pointer hover:bg-gray-900 border border-gray-600 rounded-3xl">
                                    <span :id="'wrapper-'+record.id"
                                          class="flex border border-gray-400 rounded-full mr-2"
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
                                                                                      class="flex h-3 w-3 text-red-800 dark:text-gray-300 m-1"
                                                                                  ></x-svg.main>
                                                                                 <x-svg.main
                                                                                     x-show="record.rejected===1 && record.accepted===0 && record.revision===0"
                                                                                     type="delete-open"
                                                                                     ::id="'rejected-'+record.id"
                                                                                     class="flex h-3 w-3 text-red-800 dark:text-gray-300 m-1"></x-svg.main>

                                         <x-svg.main
                                             x-show="record.rejected===0 && record.accepted===0 && record.revision===1"
                                             type="refresh"
                                             ::id="'revision-'+record.id"
                                             class="flex h-3 w-3 text-yellow-800 dark:text-gray-300 m-1"></x-svg.main>
                                                                                 <x-svg.main
                                                                                     x-show="record.rejected===0 && record.accepted===0 && record.revision===0"
                                                                                     type="question-open"
                                                                                     ::id="'none-'+record.id"
                                                                                     class="flex h-3 w-3  text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                                                            </span>
    <span :id="'span-3-'+application.id-record.id"
          class="text-gray-200 text-sm"
          x-text="record.service_requirement.name"></span>
</li>
</template>
