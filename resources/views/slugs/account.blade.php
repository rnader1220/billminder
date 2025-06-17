<div class='account-row account-{{ $item->account == '1' ? 'bank': 'card' }}' data-entry-id='{{ $item->id }}'>
    <div class="grid sm:grid-cols-6  lg:grid-cols-12">

        <div class='col-span-6 text-start mr-2'>
            <div class='float-start'>
                <i class="fa-solid {{ $item->account == '1' ? 'fa-bank': 'fa-card' }} fa-fw"></i>
            </div>
            <div class='float-end'>
                <i class="fa-solid {{ strlen($item->url) >  3 ? 'fa-link-simple': 'fa-link-simple-slash' }} fa-fw"></i>
            </div>

            {{ $item->name }}
        </div>
    </div>
</div>