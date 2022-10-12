<x-datatable.modal.add-update x-show="modalDetails.formType==='passport'  ">
    <x-form @submit.prevent="$wire.submitPassport" hasFiles=true class="space-y-6" novalidate autocomplete="off">
        {{--            Passport Number        --}}
        <div class="grid grid-cols-1 space-x-3">
            <div class="mb-1">
                <label for="passport_number"
                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Passport
                    Number</label>
                <input x-bind="bindPassportNumber"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <p x-show="validationErrors['passport.passport_number']"  class= "!m-0 text-xs text-red-600 dark:text-red-600" x-text="validationErrors['passport.passport_number']"> </p>
        </div>
        {{--            Name        --}}
        <div class="grid  xs:grid-cols-1 lg:grid-cols-2">
            <div class="mb-1 xs:mb-8 ">
                <label for="given_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Given
                    name</label>
                <input x-bind="bindPassportGivenName"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                <p x-show="validationErrors['passport.given_name']"  class= "!m-0 !mt-1 text-xs text-red-600 dark:text-red-600" x-text="validationErrors['passport.given_name']"> </p>
            </div>
            <div class="mb-1 xs:mb-8 ">
                <label for="given_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Sur
                    name</label>
                <input x-bind="bindPassportSurName"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <p x-show="validationErrors['passport.sur_name']"  class= "!m-0 !mt-1 text-xs text-red-600 dark:text-red-600" x-text="validationErrors['passport.sur_name']"> </p>
            </div>
        </div>

        {{--            dates        --}}
        <div class="grid  xs:grid-cols-1 lg:grid-cols-3 md:space-x-3 xs:!mt-0">
            <div class="mb-3 xs:mb-8 xs:!ml-0 lg:!ml-0">
                <label for="date_of_birth" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Date
                    of birth</label>
                <input x-bind="bindPassportDateOfBirth" id="dob"
                       {{--                           x-init="$watch('passportSelected',function(value){console.log(value)})"--}}
                       class="bg-gray-50 border cursor-pointer border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <p x-show="validationErrors['passport.date_of_birth']"  class= "!m-0 !mt-1 text-xs text-red-600 dark:text-red-600" x-text="validationErrors['passport.date_of_birth']"> </p>
            </div>
            <div class="mb-3 xs:mb-8 xs:!ml-0 lg:!ml-3">
                <label for="passport_issue_date"
                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Passport issue
                    date</label>
                <input  x-bind="bindPassportIssueDate" id="issue"
                        class="bg-gray-50 border cursor-pointer border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <p x-show="validationErrors['passport.issue_date']"  class= "!m-0 !mt-1 text-xs text-red-600 dark:text-red-600" x-text="validationErrors['passport.issue_date']"> </p>
            </div>
            <div class="mb-3 xs:mb-8 xs:!ml-0 lg:!ml-3">
                <label for="passport_expiry_date"
                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Passport expiry
                    date</label>
                <input x-bind="bindPassportExpiryDate" id="expiry"
                       class="bg-gray-50 border cursor-pointer  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <p x-show="validationErrors['passport.expiry_date']"  class= "!m-0 !mt-1 text-xs text-red-600 dark:text-red-600" x-text="validationErrors['passport.expiry_date']"> </p>
            </div>
        </div>

        {{--            countries and regions        --}}
        <div class="grid grid-cols-2 xs:grid-cols-1 lg:grid-cols-2 lg:space-x-3 xs:!mt-0">
            <div class="mb-3 xs:mb-8">
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Select
                    your country</label>
                <select x-bind="bindPassportCountry"
                        class="bg-gray-50 cursor-pointer border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Please select your country</option>
                    <template x-for="(country, index) in countries" :key="index">
                        <option :value="country.id" x-text="country.name"></option>
                    </template>
                </select>
                <p x-show="validationErrors['passport.country']"  class= "!m-0 !mt-1 text-xs text-red-600 dark:text-red-600" x-text="validationErrors['passport.country']"> </p>
            </div>
            <div class="mb-3 xs:mb-8">
                <label for="regions" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Select
                    your region</label>
                <select x-bind="bindPassportRegion"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Please select your region</option>
                    <template x-for="(region, index) in regions" :key="index">
                        <option :value="index" x-text="region"></option>
                    </template>
                </select>
                <p x-show="validationErrors['passport.region']"  class= "!m-0 !mt-1 text-xs text-red-600 dark:text-red-600" x-text="validationErrors['passport.region']"> </p>
            </div>
        </div>
        {{--            file        --}}
        <div
            x-data="{ filePath:'/storage/images/passports/' }"
            x-init="$watch('passportSelected.file',function(value){documentSelectedFile=value; })"
            class="grid grid-cols-1 space-x-3 xs:!mt-0">

            <x-forms.dropzone documentSelectedFile=passportSelected.file  >
                <input wire:model="passport.file" id="passport-dropzone-file" type="file" class="hidden"/>
            </x-forms.dropzone>
        </div>

{{--        <div class="flex items-center mb-4">--}}
{{--            <input x-bind="bindPassportCurrent" id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">--}}
{{--            <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">This is my current passport</label>--}}
{{--        </div>--}}

        <div class="grid grid-cols-1 space-x-3">
            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>
        </div>



        {{--            <div class="mt-4">--}}
        {{--                <div class="relative">--}}
        {{--                    <x-bundle.select x-data="serviceRequirement">--}}
        {{--                        <select x-bind="bindRequirement">--}}
        {{--                            <x-bundle.select-options></x-bundle.select-options>--}}
        {{--                        </select>--}}
        {{--                    </x-bundle.select>--}}
        {{--                </div>--}}
        {{--            </div>--}}

        {{--            <x-bundle.textarea x-data="notesDate"><textarea x-bind="bindNotes"></textarea></x-bundle.textarea>--}}
        {{--            <div class="grid grid-cols-1">--}}
        {{--                <div x-show="isFileExists===true && tempUrl===null"--}}
        {{--                     class="flex w-full justify-center items-center mb-4">--}}
        {{--                    <img x-bind="imageShow">--}}
        {{--                </div>--}}
        {{--                <x-bundle.file x-data="documentFile"><input wire:model="document.file" x-bind="bindFile" type="file">--}}
        {{--                </x-bundle.file>--}}
        {{--            </div>--}}

        {{--            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>--}}
    </x-form>
</x-datatable.modal.add-update>
