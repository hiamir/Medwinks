<x-forms.button name="delete"
                {{$attributes->merge(['class'=>'font-medium text-gray-300 dark:text-gray-600 group-hover:dark:text-gray-500'])}}
{{--                data-tooltip-target="tooltip-delete"--}}
>
    <x-svg.feathericons.trash class="w-5 h-5"></x-svg.feathericons.trash>
</x-forms.button>
{{--<x-forms.tooltip id="tooltip-delete" text="Delete"></x-forms.tooltip>--}}
