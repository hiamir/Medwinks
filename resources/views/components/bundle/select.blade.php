<div {{$attributes}}>
    <label for="name" class="flex mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" x-text="label"></label>
    <div class="flex relative">
        {{$slot}}
    </div>
    <p  x-show="validationErrors[livewireName]"  class= "mt-2 mb-0 text-xs text-red-600 dark:text-red-600" x-text="validationErrors[livewireName]"> </p>
</div>
