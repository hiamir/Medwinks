<x-layout.page.main  subHeader="{{$authSubHeader}}">
    <livewire:layouts.page.loading/>
    <livewire:layouts.page.sidebar/>
    <div class="flex flex-col flex-1 h-full overflow-hidden">
        <livewire:layouts.page.header/>
        <x-layout.page.content header="Client Details">
            {{--------------------CONTENT STARTS HERE--------------------}}
            <livewire:user.client-details.datatable :userID="$user"/>
            {{--------------------CONTENT ENDS HERE--------------------}}
        </x-layout.page.content>
        <livewire:layouts.page.footer/>
    </div>
    <livewire:layouts.page.panel/>
</x-layout.page.main>
