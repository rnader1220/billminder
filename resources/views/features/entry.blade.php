<form id="entry_form" class="form" data-mode="{{ $mode }}" accept-charset="UTF-8"   autocomplete="off">
    <div class="container mx-auto px-4">
        @include('forms.hidden', [
        'name' => 'income',
        'value' => $item->income,
        ])

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
                @include('forms.amount', [
                'label' => 'Current Amount',
                'name' => 'amount',
                'title' => 'How much is the bill, currently?',
                'value' => $item->amount,
                'disabled' => true,
                'required' => true,
                'helptext' => 'How much is the bill, currently?',
                ])
            </div>

            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.toggle', [
                'label' => 'Estimated Amt?',
                'name' => 'estimated_amount',
                'title' => 'Is the current amount an estimate, or is it confirmed?',
                'checked' => $item->estimated_amount,
                'disabled' => true,
                'helptext' => 'Is the current amount an estimate, or is it confirmed?'
                ])
            </div>
        
            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.toggle', [
                'label' => 'AutoPay?',
                'name' => 'autopay',
                'title' => 'Does this happen automatically?',
                'checked' => $item->autopay,
                'disabled' => true,
                'helptext' => 'Does this happen automatically?'
                ])
            </div>

            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.select', [
                'label' => 'Frequency',
                'name' => 'cycle',
                'options' => $item->frequency_list,
                'title' => 'What is the billing cycle for this (monthly, annual, etc)?',
                'value' => $item->cycle,
                'disabled' => true,
                'required' => true,
                'helptext' => 'What is the billing cycle for this (monthly, annual, etc)?',
                ])
            </div>

            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.date', [
                'label' => 'Next Due Date',
                'name' => 'next_due_date',
                'title' => 'When is this due, currently?',
                'value' => $item->next_due_date,
                'disabled' => true,
                'required' => false,
                'helptext' => 'When is this due, currently?',
                ])
            </div>
      
            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.toggle', [
                'label' => 'Estimated Date?',
                'name' => 'estimated_date',
                'title' => 'Is the date an estimate, or is it confirmed?',
                'checked' => $item->estimated_date,
                'disabled' => true,
                'helptext' => 'Is the date an estimate, or is it confirmed?'
                ])
            </div>

            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.toggle', [
                'label' => 'Fixed Amount?',
                'name' => 'fixed',
                'title' => 'Is this a fixed amount? Cycling will not reset the estimate flag.',
                'checked' => $item->fixed,
                'disabled' => true,
                'helptext' => 'Is this a fixed amount? Cycling will not reset the estimate flag.'
                ])
            </div>

            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.amount', [
                'label' => 'Payments Left',
                'name' => 'payments_remaining',
                'title' => 'Does this have a fixed number of payments? If set, this value will go down on cycling.',
                'value' => $item->payments_remaining,
                'disabled' => true,
                'required' => true,
                'helptext' => 'Does this have a fixed number of payments? If set, this value will go down on cycling.',
                ])
            </div>

            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.amount', [
                'label' => 'Balance Left',
                'name' => 'balance_remaining',
                'title' => 'For informational purposes only: Use to keep track of your balance.',
                'value' => $item->balance_remaining,
                'disabled' => true,
                'required' => false,
                'helptext' => 'For informational purposes only: Use to keep track of your balance.',
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

             <div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.select_new', [
                'label' => 'Category',
                'name' => 'name',
                'options' => $categories,
                'title' => 'This field is what will display on the list. Select from your ' .
                'category list, to organize your bills and income for reporting purposes. See the Categories tab' .
                'for more details.',
                'value' => $item->category_id,
                'disabled' => true,
                'required' => true,
                'helptext' => 'This field is what will display on the list. Select from your ' .
                'category list, to organize your bills and income for reporting purposes. See the Categories tab' .
                'for more details.',
                ])
            </div>

            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.select_new', [
                'label' => $item->income ? 'To Account': 'From Account',
                'name' => 'account_id',
                'options' => $accounts,
                'title' => 'This can point to your internal account (bank, etc). If set, and
                the account has a link, it will appear here. See the Accounts tab for more details.',
                'value' => $item->account_id,
                'disabled' => true,
                'required' => true,
                'helptext' => 'This can point to your internal account (bank, etc). If set, and
                the account has a link, it will appear here. See the Accounts tab for more details.',
                ])
                @if($item->account && $item->account->url)
                <a target="_new" href="{{ $item->account->url }}">{{ $item->account->name }}</a>
                @endif
            </div>

            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.select_new', [
                'label' => $item->income ? 'Collect From': 'Pay To',
                'name' => 'party_id',
                'options' => $parties,
                'title' => 'This can point to your internal account (bank, etc). If set, and
                the account has a link, it will appear here. See the Accounts tab for more details.',
                'value' => $item->party_id,
                'disabled' => true,
                'required' => true,
                'helptext' => 'This can point to your internal account (bank, etc). If set, and
                the account has a link, it will appear here. See the Accounts tab for more details.',
                ])
                @if($item->party && $item->party->url)
                <a target="_new" href="{{ $item->party->url }}">{{ $item->party->name }}</a>
                @endif
            </div>
        </div>

    </div>
</form>

</div>
<div class="container mx-auto px-4 ">
    <div x-show='showHelp' class='form-help'>
        @include($item->income ? 'help.income': 'help.expense')
    </div>
</div>
