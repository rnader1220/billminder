{{-- resources/views/forms/toggle.blade.php --}}
@props([
    'label',
    'name',
    'checked' => false,
    'disabled' => false,
    'title' => '',
    'helptext' => ''
])

<div class="mb-4">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>

    <label class="inline-flex relative items-center cursor-pointer" @if($title) title="{{ $title }}" @endif>
        <input
            type="checkbox"
            name="{{ $name }}"
            id="{{ $name }}"
            value="1"
            class="sr-only peer"
            @if(old($name, $checked)) checked @endif
            @if($disabled) disabled @endif
        >
        <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
        <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition peer-checked:translate-x-full"></div>
    </label>

    @if($helptext)
        <p x-show="showHelp" class="helptext">{{ $helptext }}</p>
    @endif
</div>

<style>
    /* This styles the toggle slider dot */
    .dot {
        transition: transform 0.2s ease-in-out;
    }
</style>