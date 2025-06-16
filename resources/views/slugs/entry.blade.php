<div class='entry-row entry-{{ $item->status }}' data-entry-id='{{ $item->id }}'>
    <div class="grid sm:grid-cols-6  lg:grid-cols-12">

        <div class='col-span-2 text-end mr-2'>
            <div class='float-start'>
                <i class="fa-solid {{$item->status_icon}} fa-fw" title="{{ucfirst($item->status)}}"></i>
                @if($item->autopay) <i class='fa-solid fa-robot fa-fw' title='Autopay'></i> @endif
            </div>

            @if($item->estimated_date) <i class='fa-solid fa-circle-question' title='Estimated Date'></i> @endif
            {{ date_format($item->next_due_date, "M d y") }}
        </div>
        <div class='col-span-2 text-end mr-2'>
            @if($item->estimated_amount) <i class='fa-solid fa-circle-question' title='Estimated Amount'></i> @endif
            {{ number_format($item->amount, 2) }}
        </div>
        <div class='col-span-4 text-start mr-2'>
            {{ $item->name }}
        </div>
        <div class='col-span-2 text-start '>
            {{ $item->category }}
        </div>
    </div>
</div>