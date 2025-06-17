<form id="cateogry_form" class="form" data-mode="{{ $mode }}" accept-charset="UTF-8"   autocomplete="off">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-12 gap-4">

            <div class="sm:col-span-12 md:col-span-8 lg:col-span-6">
                @include('forms.input', [
                'label' => 'Label',
                'name' => 'label',
                'title' => 'This field is what will display on the list. (Required) (Encrypted)',
                'value' => $item->label,
                'disabled' => true,
                'required' => true,
                'helptext' => 'This field is what will display on the list. (Required) (Encrypted)',
                ])
            </div>

            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.select', [
                'label' => 'Type',
                'name' => 'expense',
                'options' => ['0' => 'Expense', '1' => 'Income'],
                'title' => 'Is this an Expense Category, or an Income Category?',
                'value' => $item->expense,
                'disabled' => true,
                'required' => true,
                'helptext' => 'Is this an Expense Category, or an Income Category?',
                ])
            </div>

            <div class="col-span-12">
                @include('forms.tinymce', [
                'label' => 'Description',
                'name' => 'description',
                'title' => 'Write whatever you like here: description, notes, and so forth, for this. (Encrypted)',
                'value' => $item->description,
                'disabled' => true,
                'required' => false,
                'helptext' => 'Write whatever you like here: description, notes, and so forth, for this. (Encrypted)',
                ])
            </div>


  
        </div>

    </div>
</form>

</div>
<div class="container mx-auto px-4 ">
    <div class='form-help hidden'>
        @include('help.register')
    </div>
</div>
