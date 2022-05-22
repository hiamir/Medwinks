<x-forms.button name="reset_password"
                {{$attributes->merge(['class'=>'font-medium text-gray-300 dark:text-gray-600 group-hover:dark:text-gray-500'])}}
                @click.prevent="openConfirmationModal=true"
                data-tooltip-target="tooltip-reset-password">
    <x-svg.heroicons.key class="w-5 h-5"></x-svg.heroicons.key>
</x-forms.button>
<x-forms.tooltip id="tooltip-reset-password" text="Reset Password"></x-forms.tooltip>
