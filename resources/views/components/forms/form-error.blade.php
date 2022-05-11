@props(['field'])
@error($field)
<p class="mt-2 mb-6 text-xs text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
@enderror
