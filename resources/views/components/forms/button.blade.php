@props(['color'=>'none','rounded'])

@switch($color)
    @case('primary')
    <button type="button"
    {{ $attributes->merge(['class' => 'text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800']) }}">
   {{$slot}}
    </button>
    @break
    @case('alternative')
    <button type="button"
    {{ $attributes->merge(['class' => 'py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700']) }}">
   {{$slot}}
    </button>
    @break
    @case('dark')
    <button type="button"
    {{ $attributes->merge(['class' => 'text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700']) }}">
   {{$slot}}
    </button>
    @break
    @case('light')
    <button type="button"
    {{ $attributes->merge(['class' => 'text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700']) }}">
   {{$slot}}
    </button>
    @break
    @case('green')
    <button type="button"
    {{ $attributes->merge(['class' => 'focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800']) }}">
   {{$slot}}
    </button>
    @break
    @case('red')
    <button type="button"
    {{ $attributes->merge(['class' => 'focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900']) }}">
   {{$slot}}
    </button>
    @break
    @case('yellow')
    <button type="button"
    {{ $attributes->merge(['class' => 'focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:focus:ring-yellow-900']) }}">
   {{$slot}}
    </button>
    @break
    @case('purple')
    <button type="button"
    {{ $attributes->merge(['class' => 'focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900']) }}">
   {{$slot}}
    </button>
    @break

    @case('cancel')
    <button type="button"
    {{ $attributes->merge(['class' => 'px-5 py-2.5 text-center inline-flex items-center uppercase text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-xs font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 tracking-widest']) }}">
    {{$slot}}
    </button>
    @break

    @case('none')
    <button type="button"
    {{ $attributes }}>
    {{$slot}}
    </button>
    @break
@endswitch
