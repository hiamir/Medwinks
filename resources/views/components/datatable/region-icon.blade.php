<x-forms.button name="update"
                class="font-medium text-gray-300 dark:text-yellow-500 group-hover:dark:text-yellow-500"
                @click.prevent="openModal=true"
                data-tooltip-target="tooltip-update"
{{$attributes}}
>
    <x-svg.heroicons.dot-circle class="w-5 h-5"></x-svg.heroicons.dot-circle>

</x-forms.button>

<x-forms.tooltip id="tooltip-update" text="Regions"></x-forms.tooltip>
