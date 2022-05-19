<x-forms.button name="permission"
                class="font-medium text-gray-300 dark:text-gray-600 group-hover:dark:text-gray-500"
                @click="modalOpen=true"
                data-tooltip-target="tooltip-permission"
    {{$attributes}}
>
    <x-svg.heroicons.shield-check class="w-5 h-5"></x-svg.heroicons.shield-check>
</x-forms.button>
<x-forms.tooltip id="tooltip-permission" text="Permissions"></x-forms.tooltip>
