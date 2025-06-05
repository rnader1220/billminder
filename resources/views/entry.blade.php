


<div class="btn-group float-end" id="btn-group-show" role="group">
    <button type="button" id="control-edit" class="btn btn-warning" disabled><i
            class='fa-solid fa-edit'></i>&nbsp;Change @if($item->income ) Income @else Expense @endif</button>

    <button type="button" id="control-return" class="btn btn-danger" disabled><i
            class='fa-solid fa-trash'></i>&nbsp;Delete @if($item->income ) Income @else Expense @endif</button>
</div>

<form id="undefined_form" class="form" data-mode="show" accept-charset="UTF-8">
    <div class="edit-body container">
        <div class="row"><input autocomplete="off" type="hidden" id="income" name="income" value="1">

            <div class="col-sm-12 col-md-8 col-lg-6" id="name_div"
                title="This field is what will display on the list. (Required) (Encrypted)">
                <div class="form-group"><label for="name" class="control-label">Name</label>
                    <div class="input-group"><input autocomplete="off" type="text" id="name" name="name"
                            class="form-control" disabled="disabled" value="{{ $item->name }}"></div>
                    <div class="help-text app-hidden">This field is what will display on the list. (Required)
                        (Encrypted)</div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3" id="amount_div" title="How much is the bill, currently?">
                <div class="form-group"><label for="amount" class="control-label">Current Amount</label>
                    <div class="input-group"><input autocomplete="off" type="text" id="amount" name="amount"
                            class="form-control text-end" disabled="disabled" value="{{ $item->amount }}"></div>
                    <div class="help-text app-hidden">How much is the bill, currently?</div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3" id="estimated_amount_div"
                title="Is the current amount an estimate, or is it confirmed?">
                <div class="form-group"><label for="estimated_amount" class="control-label">Estimated
                        Amt?</label><br><label class="cb3switch"><input autocomplete="off" type="checkbox"
                            name="estimated_amount" id="is_estimated_amount" value="1" disabled="disabled"
                             @if($item->estimated_amount) checked="checked" @endif >
                        <span class="cb3slider" for="is_estimated_amount"></span></label>
                    <div class="help-text app-hidden">Is the current amount an estimate, or is it confirmed?</div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3" id="autopay_div" title="Does this happen automatically?">
                <div class="form-group"><label for="autopay" class="control-label">AutoPay</label><br><label
                        class="cb3switch"><input autocomplete="off" type="checkbox" name="autopay" id="is_autopay"
                            value="1" disabled="disabled" 
                            @if($item->autopay) checked="checked" @endif
                            ><span class="cb3slider"
                            for="is_autopay"></span></label>
                    <div class="help-text app-hidden">Does this happen automatically?</div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3" id="cycle_div"
                title="What is the billing cycle for this (monthly, annual, etc)?">
                <div class="form-group"><label for="cycle" class="control-label">Frequency</label><select
                        data-live-search="true" class="form-control selectpicker" id="sel_cycle" name="cycle"
                        disabled="disabled">
                   @foreach ($frequency_list as $frequency)
                        <option @if($frequency->value == $item->cycle) selected="selected" @endif
                        value="{{ $frequency->value }}">{{ $frequency->label }}</option>
                    @endforeach
                    </select>
                    <div class="help-text app-hidden">What is the billing cycle for this (monthly, annual, etc)?</div>
                </div>
            </div>
            <div class="col-md-6 col-md-6 col-lg-3" id="next_due_date_div" title="When is this due, currently?">
                <div class="form-group"><label for="next_due_date" class="control-label">Next Due Date</label>
                    <div class="input-group"><input autocomplete="off" class="form-control" type="date"
                            id="next_due_date" name="next_due_date" disabled="disabled" value="{{$item->next_due_date}}"></div>
                    <div class="help-text app-hidden">When is this due, currently?</div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-3" id="estimated_date_div"
                title=" Is the date an estimate, or is it confirmed?">
                <div class="form-group"><label for="estimated_date" class="control-label">Estimated
                        Date?</label><br><label class="cb3switch"><input autocomplete="off" type="checkbox"
                            name="estimated_date" id="is_estimated_date" value="1" disabled="disabled" 
                            if($item->estimated_date) checked="checked" @endif
                            ><span class="cb3slider" for="is_estimated_date"></span></label>
                    <div class="help-text app-hidden"> Is the date an estimate, or is it confirmed?</div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3" id="fixed_div"
                title="Is this a fixed amount? Cycling will not reset the estimate flag.">
                <div class="form-group"><label for="fixed" class="control-label">Fixed Amount?</label><br><label
                        class="cb3switch"><input autocomplete="off" type="checkbox" name="fixed" id="is_fixed" value="1"
                        @if($item->fixed) checked="checked" @endif
                            disabled="disabled"><span class="cb3slider" for="is_fixed"></span></label>
                    <div class="help-text app-hidden">Is this a fixed amount? Cycling will not reset the estimate flag.
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3" id="payments_remaining_div"
                title="Does this have a fixed number of payments?  If set, this value will go down on cycling.">
                <div class="form-group"><label for="payments_remaining" class="control-label">Payments Left</label>
                    <div class="input-group"><input autocomplete="off" type="text" id="payments_remaining"
                            name="payments_remaining" class="form-control text-end" disabled="disabled" value="{{ $item->payments_remaining }}"></div>
                    <div class="help-text app-hidden">Does this have a fixed number of payments? If set, this value will
                        go down on cycling.</div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3" id="balance_remaining_div"
                title="For informational purposes only:  Use to keep track of your balance.">
                <div class="form-group"><label for="balance_remaining" class="control-label">Balance Left</label>
                    <div class="input-group"><input autocomplete="off" type="text" id="balance_remaining" value="{{ $item->balance_remaining }}"
                            name="balance_remaining" class="form-control text-end" disabled="disabled"></div>
                    <div class="help-text app-hidden">For informational purposes only: Use to keep track of your
                        balance.</div>
                </div>
            </div>

            <div class="col-12" id="description_div"
                title="Write whatever you like here: description, notes, and so forth, for this. (Encrypted)">
                <div class="form-group"><label for="description" class="control-label">Description</label><textarea
                        class="form-control" disabled="disabled" id="description" name="description">{{ $item->description }}</textarea>
                    <div class="help-text app-hidden">Write whatever you like here: description, notes, and so forth,
                        for this. (Encrypted)</div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3" id="category_id_div"
                title="This field is what will display on the list. Select from your category list, to organize your bills and income for reporting purposes.  See the Categories tab for more details.">
                <div class="form-group"><label for="category_id" class="control-label">Category</label><select
                        data-live-search="true" class="form-control selectpicker" id="sel_category_id"
                        onchange="modal_form.check_new(&quot;category_id &quot;);" name="category_id"
                        disabled="disabled">
                   @foreach ($category_list as $category)
                        <option @if($category->value == $item->category_id) selected="selected" @endif
                        value="{{ $category->value }}">{{ $category->label }}</option>
                    @endforeach
                        <option value="_new">New Category</option>
                    </select><input autocomplete="off" class="form-control app-hidden" type="text" id="new_category_id"
                        name="new_category_id">
                    <div class="help-text app-hidden">This field is what will display on the list. Select from your
                        category list, to organize your bills and income for reporting purposes. See the Categories tab
                        for more details.</div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3" id="account_id_div"
                title="This can point to your internal account (bank, etc).  If set, and the account has a link, it will appear here.  See the Accounts tab for more details.">
                <div class="form-group"><label for="account_id" class="control-label">To Account</label><select
                        data-live-search="true" class="form-control selectpicker" id="sel_account_id"
                        onchange="modal_form.check_new(&quot;account_id &quot;);" name="account_id" disabled="disabled">
                   @foreach ($account_list as $account)
                        <option @if($account->value == $item->account_id) selected="selected" @endif
                        value="{{ $account->value }}">{{ $account->label }}</option>
                    @endforeach
                        <option value="_new">New To Account</option>
                    </select><input autocomplete="off" class="form-control app-hidden" type="text" id="new_account_id"
                        name="new_account_id">
                        @if($item->account && $account->url)
                        <a target="_new" href="{{ $account->url }}">{{ $account->name }}</a>
                        @endif
                    <div class="help-text app-hidden">This can point to your internal account (bank, etc). If set, and
                        the account has a link, it will appear here. See the Accounts tab for more details.</div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3" id="party_id_div"
                title="This can point to an external account (cc company, employer, etc).  If set, and the account has a link, it will appear here.  See the Accounts tab for more details.">
                <!-- the label here switches based on income/expense -->
                
                <div class="form-group"><label for="party_id" class="control-label">Collect From</label><select
                        data-live-search="true" class="form-control selectpicker" id="sel_party_id"
                        onchange="modal_form.check_new(&quot;party_id &quot;);" name="party_id" disabled="disabled">
                  @foreach ($party_list as $party)
                        <option @if($party->value == $item->party_id) selected="selected" @endif
                        value="{{ $party->value }}">{{ $party->label }}</option>
                    @endforeach
                        <option value="_new">New Collect From</option>
                    </select><input autocomplete="off" class="form-control app-hidden" type="text" id="new_party_id"
                        name="new_party_id">
                    <div class="help-text app-hidden">This can point to an external account (cc company, employer, etc).
                        If set, and the account has a link, it will appear here. See the Accounts tab for more details.
                    </div>
                </div>
            </div>
            <div id="help-text" class="col-md-12 help-text app-hidden">
                <p></p>
                <h5>Income</h5>

                <p>Enter in all the income you want to track, and when they are expected to arrive.
                    Categorize them for reporting purposes,
                    and link them to accounts for convenient access to them.</p>

                <p>Meaningful fields are encrypted in the database for your protection. These are indicated above.</p>

                <h5>Special Controls</h5>
                <ul>
                    <li>[ <i class="fa-solid fa-fw fa-rotate"></i> &nbsp;&nbsp;Cycle ]: This will 'cycle'
                        the expense, create a register record, and advance the date according to the frequency setting.
                    </li>
                </ul>

                <h5>Dialog Controls</h5>
                <ul>
                    <li>[ <i class="fa-solid fa-fw fa-edit"></i> ]&nbsp;&nbsp;Edit: This will let you edit
                        the record you're viewing.</li>
                    <li>[ <i class="fa-solid fa-fw fa-trash"></i> ]&nbsp;&nbsp;Delete: This will let you
                        delete the record you're viewing.</li>
                    <li>[ <i class="fa-solid fa-fw fa-xmark"></i> ]&nbsp;&nbsp;Close: Will always close the
                        dialog box, and return to the home page.</li>
                    <li>[ <i class="fa-solid fa-fw fa-person-drowning"></i> ]&nbsp;&nbsp;Help: This will
                        show/hide this help information.<br></li>
                </ul>
                <p></p>
            </div>
        </div>
    </div>
</form>

<div class="btn-group float-end" id="btn-group-show" role="group">
    <button type="button" id="control-help" class="btn btn-secondary" disabled><i
            class='fa-solid fa-person-drowning'></i>&nbsp;Help</button>

    <button type="button" id="control-close" class="btn btn-secondary" disabled><i
            class='fa-solid fa-xmark'></i>&nbsp;Close</button>

    <button type="button" id="control-save-edit" class="btn btn-success" disabled><i
            class='fa-solid fa-floppy-disk-pen'></i>&nbsp;Save Change@if($item->income ) Income @else Expense @endif</button>

    <button type="button" id="control-save-new" class="btn btn-success" disabled><i
            class='fa-solid fa-floppy-disk-pen'></i>&nbsp;Save New@if($item->income ) Income @else Expense @endif</button>

    <button type="button" id="control-cancel-edit" class="btn btn-secondary" disabled><i
            class='fa-solid fa-backward'></i>&nbsp;Cancel Change@if($item->income ) Income @else Expense @endif</button>

    <button type="button" id="control-cancel-new" class="btn btn-secondary" disabled><i
            class='fa-solid fa-backward'></i>&nbsp;Cancel Create@if($item->income ) Income @else Expense @endif</button>

</div>
