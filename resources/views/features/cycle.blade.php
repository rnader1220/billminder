<form id="cycle_form" class="form" data-mode="{{ $mode }}" accept-charset="UTF-8"   autocomplete="off">
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
                'value' => $name,
                'disabled' => true,
                'required' => true,
                'helptext' => 'This field is what will display on the list. (Required) (Encrypted)',
                ])
            </div>

            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.amount', [
                'label' => 'Current Amount',
                'name' => 'amount',
                'title' => 'How much did you pay/recieve, this time?',
                'value' => $item->amount,
                'disabled' => true,
                'required' => true,
                'helptext' => 'How much did you pay/recieve, this time?',
                ])
            </div>

            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.date', [
                'label' => 'Paid Date',
                'name' => 'paid_date',
                'title' => 'When did you pay/recieve it, this time?',
                'value' => $item->paid_date,
                'disabled' => true,
                'required' => true,
                'helptext' => 'When did you pay/recieve it, this time?',
                ])
            </div>
      
            <div class="col-span-12">
                @include('forms.tinymce', [
                'label' => 'Note',
                'name' => 'note',
                'title' => 'Write whatever you like here: description, notes, and so forth, for this. (Encrypted)',
                'value' => $item->note,
                'disabled' => true,
                'required' => false,
                'helptext' => 'Write whatever you like here: description, notes, and so forth, for this. (Encrypted)',
                ])
            </div>

             <div class="sm:col-span-6 md:col-span-4 lg:col-span-3">
                @include('forms.select_new', [
                'label' => 'Category',
                'name' => 'category_id',
                'options' => $categories,
                'title' => 'This field is what will display on the list. Select from your ' .
                'category list, to organize your register for reporting purposes. See the Categories tab' .
                'for more details.',
                'value' => $item->category_id,
                'disabled' => true,
                'required' => false,
                'helptext' => 'This field is what will display on the list. Select from your ' .
                'category list, to organize your register for reporting purposes. See the Categories tab' .
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
                'required' => false,
                'helptext' => 'This can point to your internal account (bank, card, etc). If set, and
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
                'title' => 'This can point to your external account (utility, card, etc). If set, and
                the account has a link, it will appear here. See the Accounts tab for more details.',
                'value' => $item->party_id,
                'disabled' => true,
                'required' => false,
                'helptext' => 'This can point to your internal account (utility, card, etc). If set, and
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
    <div class='form-help hidden'>
        @include('help.register')
    </div>
</div>
