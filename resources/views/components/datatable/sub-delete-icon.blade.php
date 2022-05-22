@props(['name'=>null])
<button
    name="delete"
{{$attributes->merge(['class'=>'flex relative z-0  text-xs font-medium my-1.5  mx-1 pl-2.5 pr-1
                            text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200
                            hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200
                            dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600
                            dark:hover:text-white dark:hover:bg-gray-700'])}}
>
<div class="flex justify-center items-center">
    {{$slot}}

</div>
</button>
