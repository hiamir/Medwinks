{{--<option wire:loading value="" class="relative"></option>--}}
{{--<option :value="" disabled selected x-text="placeholder"></option>--}}

<option x-show="isRecord===true && recordCount === 0" value="" disabled selected x-text="'No '+name+' available'"></option>
<option x-show="isRecord===false || recordCount === 0" :value="''"  selected x-text="placeholder"></option>
<template  x-show="isRecord===true && recordCount > 0" x-for="[id,value] in Object.entries(options)" :key="id">
    <option  :value="id" x-text="value"></option>
</template>

