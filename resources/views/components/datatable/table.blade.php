<div class="block !w-full h-full">
    <div class="relative overflow-x-auto h-auto mb-3 drop-shadow-md2c sm:rounded-lg mt-3
overflow-hidden overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-300  overflow-y-scroll
    dark:scrollbar-thumb-gray-500 dark:scrollbar-track-gray-700

">
        {{$slot}}
    </div>

    @if($dataRecord!==null)
        {!! $dataRecord->render() !!}
{{--        {{ $dataRecord->links() }}--}}
    @endif
</div>

