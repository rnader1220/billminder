{{-- resources/views/forms/select_new.blade.php --}}
@props(['label', 'name', 'options' => [], 'title'=>'', 'value' => '', 'disabled' => false, 'required' => false,
'helptext' => ''])


<div class="mb-4">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}@if($required)<span class="text-red-500 ml-1">*</span>@endif
    </label>
    <select name="{{ $name }}" id="{{ $name }}" @if($title !='' ) title="{{ $title }}" @endif @if($disabled) disabled
        @endif @if($required) required @endif class="form-element" onchange="(function(el){ 
            var input = document.getElementById('new_{{ $name }}'); 
            if(el.value === '_new') { 
                input.classList.remove('hidden'); 
            } else { 
                input.classList.add('hidden'); 
            } 
        })(this)">
        <option value="">-- Select --</option>
        @foreach ($options as $option)
        <option value="{{ $option['value'] }}" @if(old($name, $value)==$option['value']) selected @endif>
            {{ $option['label'] }}
        </option>
        @endforeach
        <option value="_new">New {{ $label }}</option>
    </select>
    <input type="text" name="new_{{ $name }}" id="new_{{ $name }}" autocomplete="off" class="form-element hidden">
    @if($helptext != '')
    <p class="form-help hidden">{{ $helptext }}</p>
    @endif
</div>