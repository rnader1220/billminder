{{-- resources/views/forms/checkbox.blade.php --}}
@props(['label', 'name', 'checked' => false, 'disabled' => false])

<div class="mb-4">
    <div class="flex items-center">
        <input type="checkbox" name="{{ $name }}" id="{{ $name }}" class="form-check" @if(old($name, $checked)) checked
            @endif @if($disabled) disabled @endif>
        <label for="{{ $name }}" class="form-check-label">
            {{ $label }}
        </label>
    </div>
    @if($helptext)
    <p class="form-help hidden">{{ $helptext }}</p>
    @endif
</div>