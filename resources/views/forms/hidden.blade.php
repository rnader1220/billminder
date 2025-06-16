{{-- resources/views/forms/hidden.blade.php --}}
@props(['name', 'value' => ''])

<input type="hidden" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}">