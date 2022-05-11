@props(['name','list'=>null])

<ul id="dropdown-{{$name}}" class="py-2 space-y-1 {{ (!in_array(Route::currentRouteName(), $list)) ? 'hidden' : '' }} ">
    {{$slot}}
</ul>
