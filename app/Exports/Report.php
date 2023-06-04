<?php

namespace App\Exports;

use App\Models\Mile;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Report implements FromQuery
{
    use Exportable;
    var $user_id;
    var $beg_date;
    var $end_date;
    var $category_list;

    public function __construct(Array $request)
    {
        $this->user_id = Auth::user()->id;
        $beg_date = new Carbon($request['beg_date']);
        $this->beg_date = $beg_date->startOfDay();
        $end_date = new Carbon($request['end_date']);
        $this->end_date = $end_date->endOfDay();
    }

    public function query()
    {
        return Mile::query()
        //->where('miles.user_id', Auth::user()->id)
        //->where('miles.travel_time', '>=', $this->beg_date)
        //->where('miles.travel_time', '<=', $this->end_date)
        //->whereNull('miles.deleted_at')
        //->orderBy('miles.travel_time', 'asc')
        ;
    }
}

/*
->select(
            'miles.id',
            'miles.travel_time',
            'miles.beg_odometer',
            'miles.distance',
            'miles.name',
            DB::raw(
                "case when distance = null then 'open' " .
                "else 'closed' end as status"
            ),
            DB::raw('categories.label as category'),
        )
        ->leftjoin('categories', function($join) {
            $join->on('categories.id', '=', 'miles.category_id')
            ->whereNull('categories.deleted_at');
        })

        */
