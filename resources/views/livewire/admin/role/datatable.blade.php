<x-datatable.main>

    {{--    TOAST  --}}
    <x-datatable.toast></x-datatable.toast>

    {{--    ADD BUTTON  --}}
    <x-datatable.insert name="Add"></x-datatable.insert>

    {{--    DATATABLE FILTER --}}
    <x-datatable.filter></x-datatable.filter>

    {{--    DATATABLE  --}}
    <x-datatable.table :dataRecord="$records">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Role name
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Guard name
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Created on
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Updated on
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only" type="button">Edit</span>
                </th>
            </tr>
            </thead>
            <tbody>


            @forelse ($records as $record)
                <tr class=" @if($loop->last)bg-white dark:bg-gray-800 @else bg-white border-b dark:bg-gray-800 dark:border-gray-700 @endif">
                    <th scope="row"
                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                        {{$record->name}}
                    </th>
                    <td class="px-6 py-4 text-center">
                        {{$record->guard_name}}
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{$record->created_at->diffForHumans()}}
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{$record->updated_at->diffForHumans()}}
                    </td>

                    <td class="px-8 py-4 text-right space-x-2 overflow-hidden">
                        <x-forms.button name="update"
                                        class="font-medium text-gray-300 dark:text-gray-600 group-hover:dark:text-gray-500"
                                        @click="modalOpen=true, openModal=true"
                                        wire:click="editButton('{{$record->id}}')"
                                        data-tooltip-target="tooltip-update">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5 feather feather-edit-3 hover:text-gray-400 dark:hover:text-gray-700"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2"
                                 stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                        </x-forms.button>

                        <x-forms.tooltip id="tooltip-update" text="Update"></x-forms.tooltip>

                        <x-forms.button name="update"
                                        class="font-medium text-gray-300 dark:text-gray-600 group-hover:dark:text-gray-500"
                                        @click="confirmModal=true" wire:click="deleteButton('{{$record->id}}')"
                                        data-tooltip-target="tooltip-delete">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5  feather feather-trash hover:text-gray-400 dark:hover:text-gray-700"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2"
                                 stroke-linecap="round"
                                 stroke-linejoin="round"
                            >
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path
                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>


                        </x-forms.button>
                        <x-forms.tooltip id="tooltip-delete" text="Delete"></x-forms.tooltip>
                    </td>
                </tr>
            @empty
                <x-datatable.norecords name="Permissions" colspan="5"></x-datatable.norecords>
            @endforelse
            </tbody>
        </table>
    </x-datatable.table>

    {{--    ADD/UPDATE MODAL--}}
    <x-datatable.modal.modal modalType="{{$modalType}}">
        <x-form wire:submit.prevent="submit" class="space-y-6" novalidate autocomplete="off">
            <div class="mt-4">
                <x-label for="Role name" :value="__('Role name')"/>
                <div class="relative">
                    <x-input name="name" placeholder="Enter a unique role name"
                             wire:model="role.name"></x-input>
                </div>
                <x-forms.form-error field="role.name"></x-forms.form-error>
            </div>

            <div class="mt-4">
                <x-label for="guard_name" :value="__('Role name')"/>
                <div class="relative">
                    <x-forms.select wire:model="role.guard_name" name="role.guard_name"
                                    :values="['admin'=>'Admin','web'=>'Web']"
                                    placeholder="Choose a guard"></x-forms.select>
                </div>
                <x-forms.form-error field="role.guard_name" class="mb-0"></x-forms.form-error>
            </div>

            <x-forms.submit name="update" type="update">{{$modalType}}</x-forms.submit>

        </x-form>
    </x-datatable.modal.modal>

    {{--    DELETE MODAL--}}

    <x-datatable.modal.confirmation name="" icon="exclamation"> </x-datatable.modal.confirmation>

</x-datatable.main>

