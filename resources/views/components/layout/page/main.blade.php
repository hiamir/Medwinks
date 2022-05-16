<div class="flex h-screen overflow-y-hidden bg-white dark:bg-gray-800" x-data="setup()"
     x-init="$refs.loading.classList.add('hidden')">

    {{$slot}}

</div>
