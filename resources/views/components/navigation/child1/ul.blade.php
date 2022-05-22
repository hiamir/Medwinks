@props(['name','list'=>null])
<ul id="dropdown-{{$name}}" class="pt-2 space-y-0
{{ (!in_array(Route::currentRouteName(), $list)) ? 'hidden' : '' }}" {{$attributes}}>
    {{$slot}}
</ul>
