<div class="flex h-screen overflow-y-hidden bg-white dark:bg-gray-800" x-data="setup()" x-init="$refs.loading.classList.add('hidden')">
    <livewire:layouts.page.loading/>
    <livewire:layouts.page.sidebar/>
    <div class="flex flex-col flex-1 h-full overflow-hidden">
        <livewire:layouts.page.header />
        <x-page-content header="{{$header}}"></x-page-content>
        <livewire:layouts.page.footer/>
    </div>
    <livewire:layouts.page.panel/>
</div>
