<x-input
    type="{{$type}}"
    name="{{$name}}"
    id="{{$name}}"
    :value="old('{{$name}}')"
{{ $attributes->merge(['class'=>'pl-10  dark:bg-gray-500/[0.2] dark:border-blue-500/[0.3] dark:bg-gray-500/[0.2] dark:border-blue-500/[0.3]'])}}
 placeholder="{{$placeholder}}"
    autofocus autocomplete="off"/>
