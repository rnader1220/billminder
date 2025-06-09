{{-- resources/views/forms/textarea.blade.php --}}
@props(['label', 'name', 'value' => '','title'=>'',  'rows' => 4, 'disabled' => false, 'required' => false])

<div class="mb-4">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}@if($required)<span class="text-red-500 ml-1">*</span>@endif
    </label>
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        @if($title != '') title="{{ $title }}" @endif
        @if($disabled) disabled @endif
        @if($required) required @endif
        class="form-element"
    >{{ old($name, $value) }}</textarea>
    @if($helptext != '') 
    <p x-show="showHelp" class="form-help">{{ $helptext }}</p>
    @endif    
</div>