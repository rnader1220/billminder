{{-- resources/views/forms/input.blade.php --}}
@props(['label', 'name', 'title' => '', 'value' => '', 'disabled' => false, 'required' => false, 'helptext' => ''])

<div class="mb-4">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}@if($required)<span class="text-red-500 ml-1">*</span>@endif
    </label>
    <input
        inputmode="integer"
        type="text"
        name="{{ $name }}"
        id="{{ $name }}"
        @if($title != '') title="{{ $title }}" @endif
        value="{{ old($name, $value) }}"
        @if($disabled) disabled @endif
        @if($required) required @endif
        class="form-element text-right"            
    >
    @if($helptext != '') 
    <p x-show="showHelp" class="form-help">{{ $helptext }}</p>
    @endif    
</div>