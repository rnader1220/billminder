
        
<div class='grid'>
    <div class='col-12 mb-2'>
        <div class='app-draw-row entry-{{ $item->status }}' data-entry-id='{{ $item->id }}' onclick='dashboard.showentry'>
            <div class='row'>
                <div class='col-3 col-lg-1 text-start'>
                    <i class="fa-solid {{$item->status_icon}} fa-fw" title="{{ucfirst($item->status)}}"></i>
                    @if($item->autopay) <i class='fa fa-solid fa-robot' title='Autopay'></i> @endif
                </div>
                <div class='col-4 col-lg-2 text-end'>
                    @if($item->estimated_date) <i class='fa fa-solid fa-circle-question' title='Estimated Date'></i> @endif
                    {{ $item->next_due_date }} 
                </div>
                <div class='col-5 col-lg-2 text-end'>
                    @if($item->estimated_amount) <i class='fa fa-solid fa-circle-question' title='Estimated Amount'></i> @endif
                    {{ number_format($item->amount, 2) }} 
                </div>
                <div class='col-12 col-lg-4 text-start'>
                {{ $item->name }} 
                </div>
                <div class='d-none d-lg-inline col-lg-3 text-start'>
                {{ $item->category }} 
                </div>


"<div class='d-none d-lg-inline col-lg-3 text-start'>"+ (typeof(el.category) != 'string'?'Unassigned':el.category) + "</div>";
</div></div></div>
