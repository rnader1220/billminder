{{-- resources/views/forms/input.blade.php --}}
@props(['label', 'name', 'title' => '', 'value' => '', 'disabled' => false, 'required' => false, 'helptext' => ''])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}@if($required)<span class="text-red-500 ml-1">*</span>@endif
    </label>
    <input
        type="text"
        name="{{ $name }}"
        id="{{ $name }}"
        @if($title != '') title="{{ $title }}" @endif
        value="{{ old($name, $value) }}"
        @if($disabled) disabled @endif
        @if($required) required @endif

        class="form-element"            
    >
    @if($helptext != '') 
    <p x-show="showHelp" class="form-help">{{ $helptext }}</p>
    @endif
</div>