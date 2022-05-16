@props(['name','colspan'])
<tr class=" bg-white dark:bg-gray-800 dark:border-gray-700">
<td colspan="{{$colspan}}" class="px-6 py-4 text-center">
    <div class="flex">
        <x-svg.heroicons.exclamation></x-svg.heroicons.exclamation>
        <span class="flex ml-3">No {{$name}} available</span>
    </div>
</td>
</tr>
