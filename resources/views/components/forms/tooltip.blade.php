@props(['id','text'])
<div id="{{$id}}" role="tooltip" class="block top-0 absolute invisible z-10 py-2 px-3 text-xs font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700 drop-shadow-md2">
   {{$text}}
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
