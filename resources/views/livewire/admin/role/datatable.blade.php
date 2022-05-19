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
                        <x-datatable.permission-icon wire:click="permissionButton('{{$record->id}}')"></x-datatable.permission-icon>
                        <x-datatable.update-icon wire:click="editButton('{{$record->id}}')"></x-datatable.update-icon>
                        <x-datatable.delete-icon wire:click="deleteButton('{{$record->id}}')"></x-datatable.delete-icon>
                    </td>
                </tr>
            @empty
                <x-datatable.norecords name="Permissions" colspan="5"></x-datatable.norecords>
            @endforelse
            </tbody>
        </table>
    </x-datatable.table>

    {{--    ADD/UPDATE MODAL SIZE MD, Xl, 4XL, 7XL--}}
    <x-datatable.modal.modal header="{{$header}}" size="{{$modalSize}}">
        @switch($modalType)
            @case ('add')
            @case ('update')
            <x-form wire:submit.prevent="submit" class="space-y-6" novalidate autocomplete="off">
                <div class="mt-4">
                    <x-label for="Role name" :value="__('Role name')"/>
                    <div class="relative">
                        <x-input name="name" placeholder="Enter a unique role name" wire:model="role.name"></x-input>
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
            @break

            @case ('permission')
            <div
                x-data="{
                    parentID:$wire.entangle('roleID'),
                    selected:$wire.entangle('rolePermissions'),
                    collection:[]
                }"

                class="flex">
            @forelse($permissions as $permission)
            <x-datatable.toggle-switch
               x-data="{selectedParentChildIDs:$wire.entangle('allRolePermissions')}"

            wire:change="permissionToggle({{$permission->id}})" id="{{$permission->id}}" class="mr-8" size="small">{{$permission->name}}</x-datatable.toggle-switch>

            @empty
            <div class="flex justify-center items-center">
                    <x-svg.heroicons.exclamation class="flex w-5 h-5 text-red-500"></x-svg.heroicons.exclamation> <span class="flex ml-2 text-sm font-semibold text-gray-800 dark:text-gray-300"> No permissions available!</span>
            </div>
            @endforelse

            </div>
            @break

            @endswitch

    </x-datatable.modal.modal>




    {{--    DELETE MODAL--}}
    @isset($record)
        <x-datatable.modal.confirmation name="{{$record->name}}" icon="exclamation"> </x-datatable.modal.confirmation>
    @endisset
</x-datatable.main>

