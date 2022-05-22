<x-datatable.main
    x-data="{
        countries: null,
        regionShow:null,
        countryRecord:$wire.entangle('country'),
        regionRecord:$wire.entangle('region')
    }"
    x-init="
        errorCount= {{ count($errors) }}
        countries={{$records->getCollection()}};
    "
>
    {{--    ADD BUTTON  --}}
    <x-datatable.insert name="Add" @click.prevent="MyModal('add','country',{'formData':{} });"></x-datatable.insert>

    {{--    DATATABLE FILTER --}}
    <x-datatable.filter></x-datatable.filter>

    {{--    DATATABLE  --}}
    <x-datatable.table :dataRecord="$records">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Country name
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Continent
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Currency Name (code)
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Phone prefix
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Regions
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Created on
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Updated on
                </th>
                <th scope="col" class="px-6 py-3 text-right pr-8">
                    Action
                </th>
            </tr>
            </thead>

            <template x-for="country in countries">
                <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td x-text="country.name" scope="row"
                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"></td>
                    <td x-text="country.continent" scope="row" class="px-6 py-4 text-center"></td>
                    <td scope="row" class="px-6 py-4 text-center"><span x-text="country.currency_name"></span>(<span
                            x-text="country.currency_code"></span>)
                    </td>
                    <td x-text="country.phone_prefix" scope="row" class="px-6 py-4 text-center"></td>
                    <td class="px-6 py-4 text-center ">
                        <x-svg.main x-show="regionShow != country.id"
                                    @click.prevent="regionShow = regionShow === country.id ? null :  regionShow = country.id"
                                    type="arrow-circle-down"></x-svg.main>
                        <x-svg.main x-show="regionShow === country.id"
                                    @click.prevent="regionShow = regionShow === country.id ? null :  regionShow = country.id "
                                    type="arrow-circle-up"></x-svg.main>
                    </td>
                    <td class="px-6 py-4 text-center"><span x-text="country.created_at"></span></td>
                    <td class="px-6 py-4 text-center"><span x-text="country.updated_at"></span></td>
                    <td class="px-8 py-4 text-right space-x-2 overflow-hidden text-right ">
                        <div class="flex flex-row justify-end">
                            <x-datatable.update-icon class="mx-1"
                                                     @click.prevent="MyModal('update','country',{'formData':country});"></x-datatable.update-icon>
                            <x-datatable.delete-icon class="ml-1"
                                                     @click.prevent="MyModal('delete','country',{'formData':country});"></x-datatable.delete-icon>
                        </div>
                    </td>
                </tr>
                <tr
                    {{--                    x-show="regionShow === country.id" --}}
                    :class="{'table-row':regionShow === country.id,  'hidden':regionShow != country.id }"
                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                    <td colspan="9" class="px-6 py-4 text-center">
                        <span
                            @click.prevent="MyModal('add','region',{'formData':{},'country':country})"
                            x-text="'Add Region'"
                            class="cursor-pointer border rounded-2xl border-blue-800 text-gray-200  text-xs px-4 py-2 hover:text-gray-200 bg-blue-800 hover:bg-blue-900"></span>
                        <template x-for="region in country.regions">
                            <div class="flex inline-flex">

                                <x-datatable.sub-delete-icon>

                                                        <span
                                                            @click.prevent="MyModal('update','region',{'formData':region}); "
                                                            class="flex ml-1 relative z-0  py-1.5 ">
                                                            <span x-text="region.name"></span></span>
                                    <x-svg.main type="delete"
                                                @click.prevent="MyModal('delete','region',{'formData':region});"
                                                class="flex relative z-50 ml-2 dark:hover:text-gray-200"
                                    ></x-svg.main>

                                </x-datatable.sub-delete-icon>
                            </div>
                        </template>
                    </td>
                </tr>
                </tbody>
            </template>
        </table>
    </x-datatable.table>

    {{--                ADD/EDIT MODAL STARTS HERE      --}}
    <x-datatable.modal.add-update>
        {{--                FORM FOR COUNTRY      --}}
        <x-form wire:submit.prevent="submit"
                x-show="modalDetails.formType==='country'" class="space-y-0" novalidate autocomplete="off">
            <div class="grid xl:grid-cols-2 xl:gap-6">
                <div class="relative z-0 w-full mb-2 group">
                    <div class="mt-4">
                        <x-label for="Country name" :value="__('Country name')"></x-label>
                        <div class="relative">
                            <x-input wire:model.defer="country.name" x-bind:value="(errorCount === 0) ? dataRecord.name : $wire.country.name" name="name"
                                     placeholder="Enter a unique country name"
                            ></x-input>
                        </div>
                        <x-forms.form-error field="country.name"></x-forms.form-error>
                    </div>
                </div>
                <div class="relative z-0 w-full mb-2 group">
                    <div class="mt-4">
                        <x-label for="Continent" :value="__('Continent')"></x-label>
                        <div class="relative">
                            <x-input wire:model.defer="country.continent" x-bind:value="(errorCount === 0) ? dataRecord.continent : $wire.country.continent"
                                     name="continent"
                                     placeholder="Enter a continent"
                            ></x-input>
                        </div>
                        <x-forms.form-error field="country.continent"></x-forms.form-error>
                    </div>
                </div>
            </div>
            <div class="grid xl:grid-cols-3 xl:gap-6">
                <div class="relative z-0 w-full mb-2 group">
                    <div class="mt-4">
                        <x-label for="Currency code" :value="__('Currency code')"></x-label>
                        <div class="relative">
                            <x-input x-bind:value="(errorCount === 0) ? dataRecord.currency_code : $wire.country.currency_code"
                                     name="currency_code"
                                     placeholder="Enter a currency code"
                                     wire:model.defer="country.currency_code"></x-input>
                        </div>
                        <x-forms.form-error field="country.currency_code"></x-forms.form-error>
                    </div>
                </div>
                <div class="relative z-0 w-full mb-2 group">
                    <div class="mt-4">
                        <x-label for="Currency name" :value="__('Currency name')"></x-label>
                        <div class="relative">
                            <x-input x-bind:value="(errorCount === 0) ? dataRecord.currency_name : $wire.country.currency_name"
                                     name="Currency code"
                                     placeholder="Enter a currency name"
                                     wire:model.defer="country.currency_name"></x-input>
                        </div>
                        <x-forms.form-error field="country.currency_name"></x-forms.form-error>
                    </div>
                </div>
                <div class="relative z-0 w-full mb-2 group">
                    <div class="mt-4">
                        <x-label for="Phone prefix" :value="__('Phone prefix')"></x-label>
                        <div class="relative">
                            <x-input x-bind:value="(errorCount === 0) ? dataRecord.phone_prefix : $wire.country.phone_prefix"
                                     name="Phone prefix"
                                     placeholder="Enter a phone prefix"
                                     wire:model.defer="country.phone_prefix"></x-input>
                        </div>
                        <x-forms.form-error field="country.phone_prefix"></x-forms.form-error>
                    </div>
                </div>
            </div>
            <div class="grid xl:grid-cols-3 xl:gap-6">
                <div class="relative z-0 w-full mb-2 group">
                    <div class="mt-4">
                        <x-label for="Postal code" :value="__('Postal code')"></x-label>
                        <div class="relative">
                            <x-input x-bind:value="(errorCount === 0) ? dataRecord.postal_code : $wire.country.postal_code"
                                     name="Postal code"
                                     placeholder="Enter a postal code"
                                     wire:model.defer="country.postal_code"></x-input>
                        </div>
                        <x-forms.form-error field="country.phone_prefix"></x-forms.form-error>
                    </div>
                </div>
                <div class="relative z-0 w-full mb-2 group">
                    <div class="mt-4">
                        <x-label for="Languages" :value="__('Languages')"></x-label>
                        <div class="relative">
                            <x-input x-bind:value="(errorCount === 0) ? dataRecord.languages : $wire.country.languages"
                                     name="languages" placeholder="Enter languages"
                                     wire:model.defer="country.languages"></x-input>
                        </div>
                        <x-forms.form-error field="country.languages"></x-forms.form-error>
                    </div>
                </div>
                <div class="relative z-0 w-full mb-2 group">
                    <div class="mt-4">
                        <x-label for="ISO" :value="__('ISO')"></x-label>
                        <div class="relative">
                            <x-input x-bind:value="(errorCount === 0) ? dataRecord.iso : $wire.country.iso"
                                     name="iso" placeholder="Enter iso"
                                     wire:model.defer="country.iso"></x-input>
                        </div>
                        <x-forms.form-error field="country.iso"></x-forms.form-error>
                    </div>
                </div>
            </div>
            <div class="grid xl:grid-cols-3 pb-4 xl:gap-6">
                <div class="relative z-0 w-full mb-2 group">
                    <div class="mt-4">
                        <x-label for="ISO3" :value="__('ISO')"></x-label>
                        <div class="relative">
                            <x-input x-bind:value="(errorCount === 0) ? dataRecord.iso3 : $wire.country.iso3"
                                     name="iso3" placeholder="Enter iso3"
                                     wire:model.defer="country.iso3"></x-input>
                        </div>
                        <x-forms.form-error field="country.iso3"></x-forms.form-error>
                    </div>
                </div>
                <div class="relative z-0 w-full mb-2 group">
                    <div class="mt-4">
                        <x-label for="FIPS" :value="__('FIPS')"></x-label>
                        <div class="relative">
                            <x-input x-bind:value="(errorCount === 0) ? dataRecord.fips : $wire.country.fips"
                                     name="fips" placeholder="Enter FIPS"
                                     wire:model.defer="country.fips"></x-input>
                        </div>
                        <x-forms.form-error field="country.fips"></x-forms.form-error>
                    </div>
                </div>
                <div class="relative z-0 w-full mb-2 group">
                    <div class="mt-4">
                        <x-label for="Geonameid" :value="__('Geonameid')"></x-label>
                        <div class="relative">
                            <x-input
                                x-bind:value="(errorCount === 0) ? dataRecord.geonameid : $wire.country.geonameid"
                                name="geonameid" placeholder="Enter Geonameid"
                                     wire:model.defer="country.geonameid"></x-input>
                        </div>
                        <x-forms.form-error field="country.geonameid"></x-forms.form-error>
                    </div>
                </div>
            </div>
            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>

        </x-form>

        {{--                FORM FOR REGION      --}}
        <x-form  x-show="modalDetails.formType==='region'" wire:submit.prevent="submit" class="space-y-6" novalidate
                autocomplete="off">
            <div class="mt-4">
                <x-label for="Region name" :value="__('Region name')"></x-label>
                <div class="relative">
                    <x-input wire:model.defer="region.name"
                             x-bind:value="(errorCount === 0) ? dataRecord.name : $wire.region.name"
                             name="regionName" placeholder="Enter a region name"
                    ></x-input>
                </div>
                <x-forms.form-error field="region.name"></x-forms.form-error>
            </div>

            <div class="mt-4">
                <x-label for="timezone" :value="__('Timezone')"></x-label>
                <div class="relative">
                    <x-forms.select   x-bind:value="(errorCount === 0) ? dataRecord.timezone_id : $wire.region.timezone_id"
                                    wire:model.defer="region.timezone_id" name="region.timezone"
                                    :values="$timezone"
                                    placeholder="Choose a timezone">

                    </x-forms.select>
                </div>
                <x-forms.form-error field="region.timezone_id" class="mb-0"></x-forms.form-error>
            </div>

            <x-forms.submit><span x-text="AddUpdateModal.submit"></span></x-forms.submit>

        </x-form>
    </x-datatable.modal.add-update>
    {{--                ADD/EDIT MODAL STARTS HERE      --}}

    {{--                DELETE MODAL STARTS HERE      --}}
    <x-datatable.modal.delete></x-datatable.modal.delete>
</x-datatable.main>




