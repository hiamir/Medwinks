@props(['name','type'=>''])
<button name="{{$name}}" type="submit"

@switch($type)
    @case ('add')
        {{ $attributes->merge(['class' => 'bg-blue-700 hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800  focus:ring-blue-300 text-white text-xs uppercase focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center  tracking-widest'])}}
        @break

        @case ('update')
        {{ $attributes->merge(['class' => 'bg-blue-700 hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800  focus:ring-blue-300 text-white text-xs uppercase focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center  tracking-widest'])}}
        @break

        @case ('delete')
        {{ $attributes->merge(['class' => 'text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg inline-flex items-center text-xs uppercase focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center  tracking-widest'])}}
        @break

        @default
        {{ $attributes->merge(['class' => ' px-5 py-2.5 text-center inline-flex items-center uppercase text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-xs font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 tracking-widest'])}}
        @break
    @endswitch

>{{$slot}}</button>
