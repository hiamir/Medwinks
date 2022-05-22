<x-forms.button name="update"
                class="font-medium text-gray-300 dark:text-gray-600 group-hover:dark:text-gray-500"
                @click.prevent="openModal=true"
                data-tooltip-target="tooltip-sub-add"
{{$attributes}}
>
    <x-svg.main type="plus-circle"  class="dark:text-gray-300 h-[30px] w-[30px]" ></x-svg.main>
</x-forms.button>

<x-forms.tooltip id="tooltip-sub-add" text="Add"></x-forms.tooltip>
