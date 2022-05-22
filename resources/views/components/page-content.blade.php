@props(['header'])
<div class="content">
    <main class="flex-1 max-h-full p-5 overflow-hidden overflow-y-auto">
        <!-- Main content header -->
        <div
            class="flex flex-col items-start justify-between pb-6 space-y-4 border-b dark:border-gray-700 lg:items-center lg:space-y-0 lg:flex-row">
            <h1 class="text-2xl font-semibold whitespace-nowrap text-blue-500 dark:text-yellow-500">{{$header}}</h1>
            <div class="space-y-6 md:space-x-2 md:space-y-0"></div>
        </div>
        {{$slot}}
    </main>
</div>
