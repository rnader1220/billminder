{{-- resources/views/forms/input.blade.php --}}
@props(['label', 'name', 'title' => '', 'value' => '', 'disabled' => false, 'required' => false, 'helptext' => ''])

<div class="mb-4">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}@if($required)<span class="text-red-500 ml-1">*</span>@endif
    </label>
    <input inputmode="decimal" type="text" name="{{ $name }}" id="{{ $name }}" @if($title !='' ) title="{{ $title }}"
        @endif value="{{ old($name, $value) }}" @if($disabled) disabled @endif @if($required) required @endif
        class="form-element">
    @if($helptext != '')
    <p class="form-help hidden">{{ $helptext }}</p>
    @endif
</div>

<!-- class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm  text-right" -->