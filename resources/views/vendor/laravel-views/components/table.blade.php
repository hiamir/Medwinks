{{-- components.table

Renders a data table
You can customize all the html and css classes but YOU MUST KEEP THE BLADE AND LIVEWIRE DIRECTIVES,

props:
  - headers
  - itmes
  - actionsByRow --}}
<div class="relative overflow-x-auto drop-shadow-md1.5 sm:rounded-lg mt-3">
<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
  <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
    <tr>
      @if ($this->hasBulkActions)
        <th scope="col" class="px-6 py-3">
          <span class="flex items-center justify-center">
            <x-lv-checkbox wire:model="allSelected" />
          </span>
        </th>
      @endif
      {{-- Renders all the headers --}}
      @foreach ($headers as $header)
        <th class="px-3 py-3" {{ is_object($header) && ! empty($header->width) ? 'width=' . $header->width . '' : '' }}>
          @if (is_string($header))
            {{ $header }}
          @else
            @if ($header->isSortable())
              <div class="flex">
                <a href="#!" wire:click.prevent="sort('{{ $header->sortBy }}')" class="flex-1">
                  {{ $header->title }}
                </a>
                <a href="#!" wire:click.prevent="sort('{{ $header->sortBy }}')" class="flex">
                  <i data-feather="chevron-up" class="{{ $sortBy === $header->sortBy && $sortOrder === 'asc' ? 'text-gray-900' : 'text-gray-400'}} h-4 w-4"></i>
                  <i data-feather="chevron-down" class="{{ $sortBy === $header->sortBy && $sortOrder === 'desc' ? 'text-gray-900' : 'text-gray-400'}} h-4 w-4"></i>
                </a>
              </div>
            @else
              {{ $header->title }}
            @endif
          @endif
        </th>
      @endforeach

      {{-- This is a empty cell just in case there are action rows --}}
      @if (count($actionsByRow) > 0)
        <th></th>
      @endif
    </tr>
  </thead>

  <tbody>
    @foreach ($items as $item)
      <tr class="@if($loop->last)bg-white dark:bg-gray-800 @else bg-white border-b dark:bg-gray-800 dark:border-gray-700 @endif" wire:key="{{ $item->getKey() }}">
        @if ($this->hasBulkActions)
              <th scope="row"
                  class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                  {{$role->name}}
              </th>
          <td class="pl-3">
            <span class="flex items-center justify-center">
              <x-lv-checkbox value="{{ $item->getKey() }}" wire:model="selected" />
            </span>
          </td>
        @endif
        {{-- Renders all the content cells --}}
        @foreach ($view->row($item) as $column)
          <td class="px-3 py-2 whitespace-no-wrap">
            {!! $column !!}
          </td>
        @endforeach

        {{-- Renders all the actions row --}}
        @if (count($actionsByRow) > 0)
          <td>
            <div class="px-3 py-2 flex justify-end">
              <x-lv-actions :actions="$actionsByRow" :model="$item" />
            </div>
          </td>
        @endif
      </tr>
    @endforeach
  </tbody>
</table>
</div>
