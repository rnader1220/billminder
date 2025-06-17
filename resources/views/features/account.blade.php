<form id="cycle_form" class="form" data-mode="{{ $mode }}" accept-charset="UTF-8"   autocomplete="off">
    <div class="container mx-auto px-4">
                'name',
        'description',
        'account',
        'payor',
        'payee',
        'website',

        <div class="grid grid-cols-12 gap-4">

            <div class="sm:col-span-12 md:col-span-8 lg:col-span-6">
                @include('forms.input', [
                'label' => 'Name',
                'name' => 'name',
                'title' => 'This field is what will display on the list. (Required) (Encrypted)',
                'value' => $item->name,
                'disabled' => true,
                'required' => true,
                'helptext' => 'This field is what will display on the list. (Required) (Encrypted)',
                ])
            </div>

            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.toggle', [
                'label' => 'Is To/From Account?',
                'name' => 'account',
                'title' => 'Is this one of your accounts?',
                'checked' => $item->account,
                'disabled' => true,
                'helptext' => 'Is the date an estimate, or is it confirmed?'
                ])
            </div>
            div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.toggle', [
                'label' => 'Payor?',
                'name' => 'estimated_date',
                'title' => 'Is this someone who pays you?',
                'checked' => $item->payor,
                'disabled' => true,
                'helptext' => 'Is this someone who pays you?'
                ])
            </div>
            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.toggle', [
                'label' => 'Payee?',
                'name' => 'payee',
                'title' => 'Is this someone you pay?',
                'checked' => $item->payee,
                'disabled' => true,
                'helptext' => 'Is this someone you pay?'
                ])
            </div>
            <div class="sm:col-span-12 md:col-span-8 lg:col-span-6">
                @include('forms.input', [
                'label' => 'Website URL',
                'name' => 'url',
                'title' => 'the website for this account, where you can log in to pay, check balances, etc. A link will appear on the Expense dialog when this is populated. (Encrypted)',
                'value' => $item->url,
                'disabled' => true,
                'required' => true,
                'helptext' => 'the website for this account, where you can log in to pay, check balances, etc. A link will appear on the Expense dialog when this is populated. (Encrypted)',
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
