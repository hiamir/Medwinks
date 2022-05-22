<x-input
    type="{{$type}}"
    name="{{$name}}"
    id="{{$name}}"
    :value="old('{{$name}}')"
{{ $attributes->merge(['class'=>'pl-10
dark:bg-gray-500/[0.2] dark:border-blue-500/[0.3] dark:!bg-gray-900/[0.2] dark:border-blue-500/[0.3]
bg-gray-100 border border-gray-300
text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500
block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600
dark:placeholder-gray-400 dark:!text-gray-500 dark:focus:ring-blue-500 dark:focus:border-blue-500
'])}}
 placeholder="{{$placeholder}}"
    autofocus autocomplete="off" disabled/>
