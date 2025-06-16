{{-- resources/views/forms/input.blade.php --}}
@props(['label', 'name', 'value' => '', 'disabled' => false, 'required' => false])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}@if($required)<span class="text-red-500 ml-1">*</span>@endif
    </label>
    <input type="date" name="{{ $name }}" id="{{ $name }}"
        value="{{ date_format(new DateTime(old($name, $value)), 'Y-m-d') }}" @if($disabled) disabled @endif
        @if($required) required @endif class="form-element">
    @if($helptext)
    <p class="form-help hidden">{{ $helptext }}</p>
    @endif
</div>