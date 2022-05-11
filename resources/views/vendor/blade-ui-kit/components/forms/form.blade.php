<form method="{{ $method !== 'GET' ? 'POST' : 'GET' }}" @isset($action) action="{{ $action }}" @endisset {!! $hasFiles ? 'enctype="multipart/form-data"' : '' !!} {{ $attributes }} novalidate>
    @csrf
    @method($method)

    {{ $slot }}
</form>
