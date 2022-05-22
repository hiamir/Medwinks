<x-layout.page.main  subHeader="{{$authSubHeader}}">
    <livewire:layouts.page.loading/>
    <livewire:layouts.page.sidebar/>
    <div class="flex flex-col flex-1 h-full overflow-hidden">
        <livewire:layouts.page.header/>
        <x-layout.page.content header="Menu Items">
            {{--------------------CONTENT STARTS HERE--------------------}}
            <livewire:admin.menu-items.datatable/>
            {{--------------------CONTENT ENDS HERE--------------------}}
        </x-layout.page.content>
        <livewire:layouts.page.footer/>
    </div>
    <livewire:layouts.page.panel/>
</x-layout.page.main>
