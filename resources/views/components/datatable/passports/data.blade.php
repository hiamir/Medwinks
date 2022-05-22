
<div  class="p-4 w-full grid xxl:grid-cols-5 xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-2 xs:grid-cols-1 gap-4">
    @if($this->permission('user-passport-create'))
        <div
            @click.prevent="MyModal('add','passport',{'formData':{} }); documentSelected={}; documentSelected.file=''; tempUrl=''; $wire.resetPassport()"
            class="flex flex-col p-6 w-full min-h-64  justify-center items-center bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 cursor-pointer dark:hover:bg-gray-900/[0.5]"
            {{--                                :class="{'dark:!bg-red-900/[0.5] hover:dark:!bg-red-900/[0.7] dark:border-red-900':documentpassport.rejected===1, 'dark:!bg-green-900/[0.5] hover:dark:!bg-green-900/[0.7] dark:border-green-900':documentpassport.accepted===1}"--}}
        >
            <x-svg.main
                type="plus"
                class="flex self-center relative z-10 h-[30%] w-[30%] text-red-800 dark:text-gray-300/[0.4]  m-1 mb-3">
            </x-svg.main>
        </div>
    @endif
    <template  x-for="(passport, index) in passports">
        <div :id="'frame-'+index"

             @click.prevent.self="(canPassportUpdate === false) ? ErrorModal = { 'show': true, 'type': 'error', 'title': 'Access Denied!', 'message': 'Cannot update as file decision was finalized' } : '' ;
                              ((passport.accepted===0 && passport.rejected===0 && passport.revision===1) ) ? MyModal('update','passport',{'formData':passport}) : ErrorModal = { 'show': true, 'type': 'error', 'title': 'Revision!', 'message': 'Cannot update as the document is under review' };
                              ((passport.accepted===1 && passport.rejected===0 && passport.revision===0) || (passport.accepted===0 && passport.rejected===1 && passport.revision===0)) ? ErrorModal = { 'show': true, 'type': 'error', 'title': 'Final Decision!', 'message': 'Cannot update as the final decision was made on this passport' }: '';   passportSelected=passport; tempUrl='';"


{{--             @click.prevent.self="((passport.accepted===0 && passport.rejected===0 && passport.revision===0) ) ? MyModal('update','passport',{'formData':passport}) : ErrorModal = { 'show': true, 'type': 'error', 'title': 'Passport Decision!', 'message': 'Cannot update as passport decision was finalized' };  passportSelected=passport; tempUrl='';"--}}
             class="flex !cursor-pointer flex-col p-6 z-10 relative  @if($this->permission('user-passport-update')) pt-2 @else pt-5 @endif px-2 max-w-xm justify-center items-center bg-white rounded-lg border shadow-md "
             :class="{
                         'dark:!bg-red-900/[0.5] hover:dark:!bg-red-900/[0.7] dark:border-red-900' : (passport.accepted===0 && passport.rejected===1 && passport.revision===0),
                         'dark:!bg-green-900/[0.5] hover:dark:!bg-green-900/[0.7] dark:border-green-900':(passport.accepted===1 && passport.rejected===0 && passport.revision===0),
                         'dark:!bg-yellow-900/[0.5] hover:dark:!bg-yellow-900/[0.7] dark:border-yellow-900':(passport.accepted===0 && passport.rejected===0 && passport.revision===1),
                         'dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-900/[0.5]':(passport.accepted===0 && passport.rejected===0 && passport.revision===0)
                     }"
        >

            <div class="flex flex-row w-full z-50  top-2 right-2 absolute justify-end items-center">
                <a @click.prevent="$wire.passportChat(passport)"
                   class="flex ">
                    <x-svg.main
                        type="chat"
                        class="flex self-end relative z-50 h-[23px] w-[23px] text-red-800 dark:text-gray-300/[0.4] hover:!text-gray-300/[0.7] m-1 mb-3">
                    </x-svg.main>
                </a>

                <x-svg.main
                    x-show="(passport.applications.length > 0)"
                    type="link"
                    class="flex self-end absolute top-1 left-5  z-10 h-[20px] w-[20px] text-red-800 dark:text-gray-300/[0.3] hover:!text-gray-300/[0.7] m-1 mb-3 ml-0">
                </x-svg.main>

                @if($this->permission('user-passport-delete'))
                    <a
                        x-show="((passport.accepted===0 && passport.rejected===0 &&  passport.revision===0)) && passport.applications.length === 0"
                        @click.prevent="(passport.applications.length === 0) ? MyModal('delete','passport',{'formData':passport}) : ErrorModal = { 'show': true, 'type': 'error', 'title': 'Passport Link!', 'message': 'Cannot delete as one or more of the applications are using this passport' }; documentSelected=passport"
                        class="flex ">
                        <x-svg.main
                            type="delete-open"
                            class="flex self-end relative z-10 h-[25px] w-[25px] text-red-800 dark:text-gray-300/[0.4] hover:!text-gray-300/[0.7] m-1 mb-3 ml-0">
                        </x-svg.main>
                    </a>
                @endif
            </div>

            <div class="flex justify-center items-center mt-8 mb-3">
                        <span class="flex relative cursor-pointer sel border-4 border-red-800  dark:border-gray-100 rounded-full w-10 h-10 justify-center items-center m-0 ">
                                                     <x-svg.main x-show="passport.rejected===0 && passport.accepted===1 && passport.revision===0" type="check-open"
                                                                 class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                                     <x-svg.main x-show="passport.rejected===1 && passport.accepted===0 && passport.revision===0" type="delete-open"
                                                                 class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                                                     <x-svg.main x-show="passport.rejected===0 && passport.accepted===0 && passport.revision===1" type="refresh"
                                                                 class="h-4 w-4 text-yellow-800 dark:text-gray-300 m-1"></x-svg.main>
                                                     <x-svg.main x-show="passport.rejected===0 && passport.accepted===0 && passport.revision===0"
                                                                 type="question-open"
                                                                 class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                            <span x-show="(passport.active===1)" class="absolute flex border-4 border-red-800 dark:border-gray-100 rounded-full w-10 h-10 justify-center items-center m-0 animate-ping"> </span>
                                                 </span>
            </div>

            <div class=" flex  cursor-pointer flex-col items-center px-4">
                <div class="mb-2">
                                        <span x-show="passport.rejected===0 && passport.accepted===0 && passport.revision===0"
                                              class="mb-2 bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300"
                                              x-text="'Under Review'"></span>
                    <span x-show="passport.accepted===1 && passport.rejected===0 && passport.revision===0"
                          :id="'accept'-passport.id"
                          class="mb-2 bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded bg-green-500 dark:text-green-900"
                          x-text="'Accepted'"></span>

                    <span x-show="passport.accepted===0 && passport.rejected===0 && passport.revision===1"
                          :id="'revision'-passport.id"
                          class="mb-2 bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded bg-yellow-500 dark:text-yellow-900"
                          x-text="'Revision'"></span>

                    <span x-show="passport.accepted===0 && passport.rejected===1 && passport.revision===0"
                          :id="'reject'-passport.id"
                          class="mb-2 bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded bg-red-500 dark:text-red-900"
                          x-text="'Rejected'"></span>
                </div>
                <p class="flex self-end mb-2 text-[0.7rem] font-normal text-gray-700 dark:text-gray-100/[0.3] leading-tight text-center"
                   x-text="'Created '+passport.created_at"
                ></p>
            </div>
            <div class="flex cursor-pointer flex-col grow justify-start items-center">
                <h5 class="flex mb-2 text-center text-md font-bold tracking-tight text-gray-900 dark:text-white"
                    x-text="passport.passport_number"></h5>
                <span x-show="moment(passport.expiry_date).isBefore(moment())"
                      class="my-3 mt-1 dark:!bg-red-900 text-red-800 !text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-200"
                      x-text="'Expired'"></span>


                <template x-if="!checkFileExist('/storage/images/passports/', passport.file)">
                    <p x-show="(passport.accepted!==0 && passport.rejected!==0 &&  passport.revision!==0) && (passport.file.length === 0 || !checkFileExist('/storage/images/passports/'+file.file))"
                       class="text-xs flex mb-2 px-2 py-1 text-gray-200 font-semibold bg-red-900 rounded-lg "
                       x-text="'Upload Passport'"></p>


                </template>


                <template x-if="!checkFileExist('/storage/images/passports/', passport.file)">


                    <p x-show="(passport.accepted===0 && passport.rejected===0 &&  passport.revision===0) || (passport.file.length === 0 || !checkFileExist('/storage/images/passports/'+passport.file))"
                       class="text-xs flex mb-2 px-2 py-1 text-gray-200 font-semibold bg-red-900 rounded-lg "
                       x-text="'Passport Missing'"></p>
                </template>

            </div>
            <button x-show="passport.active !== 1"  @click.prevent="$wire.makePassportActive(passport.id)" type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200
            font-medium rounded-md text-xs px-5 py-1.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600
            dark:focus:ring-gray-700" x-text="'Make current passport'"></button>

            <div class="flex flex-row space-x-2 pt-2">
                @if($this->permission('user-passport-download'))
                    <a  x-show="checkFileExist('/storage/images/passports/',passport.file) === true"
                        @click.prevent=" $wire.photoType='passport'; $wire.export(passport.file); "
                        class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <x-svg.main type="download"
                                    class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                    </a>
                @endif
{{--                    <template x-init="$wire.checkPermission('user-client-details-passport-view')" x-if="permissionPassportView === true">--}}
                @if($this->permission('user-passport-view'))
                    <a
                        x-show="checkImage(passport.file)===true"  @click.prevent="$wire.photoType='passport'; $wire.photoView(passport.file, 'passport');"
                       class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-purple-700 rounded-md hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                        <x-svg.main type="view"
                                    class="h-4 w-4 text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                    </a>
                @endif
{{--                    </template>--}}

                @if($this->permission('user-passport-accept'))
                    <a x-show="((passport.accepted===0 && passport.rejected===0 && passport.revision===0))"
                       @click.prevent="if(passport.accepted===0) { documentType='passport'; comments=''; $wire.acceptPassport(passport.id) }"
                       class="flex items-center justify-center w-8 h-7  text-sm font-medium text-center text-white dark:text-white bg-green-700 rounded-md hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                        <x-svg.main type="check-open"
                                    class="h-[15px] w-[15px] text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                    </a>
                @endif
                @if($this->permission('user-passport-reject'))
                    <a
                        x-show="((passport.accepted===0 && passport.rejected===0 && passport.revision===0) )"
                        @click.prevent="if(passport.rejected===0){ documentType='passport'; comments=''; $wire.rejectPassport(passport.id) }"
                        class="flex items-center justify-center  w-8 h-7 text-sm font-medium text-center text-white bg-red-700 rounded-md hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                        <x-svg.main type="delete-open"
                                    class="h-[15px] w-[15px] text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                    </a>
                @endif
                @if($this->permission('user-passport-revision'))
                    <a x-show="((passport.accepted===0 && passport.rejected===0 && passport.revision===0) )"
                       @click.prevent=" documentType='passport'; comments='';  $wire.revisePassport(passport.id); "
                       class="flex items-center justify-center mb-2  w-8 h-7 text-sm font-medium text-center text-white bg-yellow-500 rounded-md hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:focus:ring-red-800">
                        <x-svg.main type="refresh"
                                    class="h-[15px] w-[15px] text-red-800 dark:text-gray-300 m-1"></x-svg.main>
                    </a>
                @endif


{{--                    <p x-show="((passport.accepted!==1 && passport.rejected===0 && passport.revision===0) || (passport.accepted===0 && passport.rejected!==0 && passport.revision===0)) && !checkFileExist('/storage/images/passports/',passport.file)" class="text-xs flex mb-2 px-2 py-1 text-gray-200 font-semibold bg-red-900 rounded-lg " x-text="'Upload Passport'"> </p>--}}
{{--                    <p x-show="(passport.accepted===1 && passport.rejected===0 && passport.revision===0) && !checkFileExist('/storage/images/passports/',passport.file)" class="text-xs flex mb-2 px-2 py-1 text-gray-200 font-semibold bg-red-900 rounded-lg " x-text="'Passport file unavailable'"> </p>--}}
            </div>
        </div>
    </template>
</div>

