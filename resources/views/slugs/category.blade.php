<div class='category-row category-{{ $item->expense == 0 ? 'income': 'expense' }}' data-category-id='{{ $item->id }}'>
    <div class="grid sm:grid-cols-6  lg:grid-cols-12">

        <div class='col-span-6 text-start mr-2'>
            <div class='float-start'>
                <i class="fa-solid {{ $item->expense == 0 ? 'fa-badge-dollar': 'fa-file-invoice-dollar' }} fa-fw"></i>
            </div>
            {{ $item->label }}
        </div>
    </div>
</div>