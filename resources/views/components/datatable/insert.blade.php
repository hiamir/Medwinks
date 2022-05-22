@props(['name'])

<x-forms.button
    type="button"

{{ $attributes->merge(['class' => 'w-[100px] min-w-[100px] rounded-full flex justify-center items-center mt-5']) }}
{{--    {{ $attribute->merge(['class'=>'w-[100px] min-w-[100px] rounded-full flex justify-center items-center mt-5']) }}--}}
    color="primary"

>
    <svg class="flex w-4 h-4" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
         stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
    </svg>
    <span x-ref="modalHeader" class="flex pl-1">Add</span>

</x-forms.button>
