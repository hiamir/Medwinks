<x-forms.button name="update"
                class="font-medium text-gray-300 dark:text-gray-600 group-hover:dark:text-gray-500"
                @click="modalOpen=true, openModal=true"
                data-tooltip-target="tooltip-update"
{{$attributes}}
>
    <x-svg.feather-icons.edit-3 class="w-5 h-5"></x-svg.feather-icons.edit-3>

</x-forms.button>

<x-forms.tooltip id="tooltip-update" text="Update"></x-forms.tooltip>
