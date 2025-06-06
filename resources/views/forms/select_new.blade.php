{{-- resources/views/forms/select_new.blade.php --}}
@props(['label', 'name', 'options' => [], 'title'=>'', 'value' => '', 'disabled' => false, 'required' => false, 'helptext' => ''])

<div class="mb-4">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}@if($required)<span class="text-red-500 ml-1">*</span>@endif
    </label>
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        @if($title != '') title="{{ $title }}" @endif
        @if($disabled) disabled @endif
        @if($required) required @endif
        class="form-element"    
        onchange="modal_form.check_new('{{ $name }}');"
        >
        <option value="">-- Select --</option>
        @foreach ($options as $key => $label)
            <option value="{{ $key }}" @if(old($name, $value) == $key) selected @endif>
                {{ $label }}
            </option>
        @endforeach
            <option value="_new">New {{ $label }}</option>
    </select>
    <input type="text" 
        name="new_{{ $name }}"
        id="new_{{ $name }}"
        autocomplete="off"
        class="form-element hidden" 
        >
    @if($helptext != '') 
    <p x-show="showHelp" class="helptext">{{ $helptext }}</p>
    @endif    
</div> 