<?php

namespace App\Exports;

use App\Models\Mile;
use App\Models\Hour;
use App\Models\Entry;
use App\Models\Register;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class Report implements WithColumnFormatting, WithMapping, WithHeadings, WithCustomStartCell, ShouldAutoSize, FromQuery
{
    use Exportable;
    var $user_id;
    var $report_type;
    var $beg_date;
    var $end_date;
    var $category_list;


    public function startCell(): string
    {
        return 'B3';
    }

    public function __construct(Array $request)
    {
        $this->user_id = Auth::user()->id;
        $beg_date = new Carbon($request['beg_date']);
        $this->beg_date = $beg_date->startOfDay();
        $end_date = new Carbon($request['end_date']);
        $this->end_date = $end_date->endOfDay();
        $this->report_type = $request['type'];
    }

    public function headings(): array
    {
        switch($this->report_type) {
            case 'register-income':
                $map = [
                    'Date',
                    'Amount',
                    'Name',
                    'Description',
                    'Category',
                    'Account',
                    'Payor',
                ];
                break;
            case 'register-expense':
            default:
                $map = [
                    'Date',
                    'Amount',
                    'Name',
                    'Description',
                    'Category',
                    'Account',
                    'Payee',
                ];
                break;
            case 'entry-income':
                $map = [
                    'Date',
                    'Est. Date',
                    'Amount',
                    'Est. Amount',
                    'Name',
                    'Description',
                    'Is Autopay',
                    'Category',
                    'Account',
                    'Payor',
                ];
                break;
            case 'entry-expense':
                $map = [
                    'Date',
                    'Est. Date',
                    'Amount',
                    'Est. Amount',
                    'Name',
                    'Description',
                    'Is Autopay',
                    'Category',
                    'Account',
                    'Payee',
                ];
                break;
            case 'hour-none':
                $map = [
                    'Date',
                    'Start',
                    'End',
                    'Name',
                    'Description',
                    'Distance',
                    'Category',
                ];
                break;
            case 'mile-none':
                $map = [
                    'Date',
                    'Start',
                    'End',
                    'Name',
                    'Description',
                    'Duration',
                    'Category',
                ];
                break;
            }

        return $map;

    }


    public function map($record): array
    {

        switch($this->report_type) {
            case 'register-income':
            case 'register-expense':
            default:
                $map = [
                    Date::dateTimeToExcel(new Carbon($record->paid_date)),
                    $record->amount,
                    $record->name,
                    $record->description,
                    (isset($record->category->label)? $record->category->label:'Unassigned'),
                    (isset($record->account->name)? $record->account->name:'Unassigned'),
                    (isset($record->party->name)? $record->party->name:'Unassigned'),
                ];
                break;
            case 'entry-income':
            case 'entry-expense':
                $map = [
                    Date::dateTimeToExcel(new Carbon($record->next_due_date)),
                    ($record->estimated_date==1?'[X]':''),
                    $record->amount,
                    ($record->estimated_amount==1?'[X]':''),
                    $record->name,
                    $record->description,
                    ($record->autopay==1?'[X]':''),
                    (isset($record->category->label)? $record->category->label:'Unassigned'),
                    (isset($record->account->name)? $record->account->name:'Unassigned'),
                    (isset($record->party->name)? $record->party->name:'Unassigned'),
                ];
                break;
            case 'hour-none':
                $map = [
                    Date::dateTimeToExcel(new Carbon($record->act_date)),
                    $record->beg_time,
                    $record->end_time,
                    $record->name,
                    $record->description,
                    $record->distance,
                    (isset($record->category->label)? $record->category->label:'Unassigned'),
                ];
                break;
            case 'mile-none':
                $map = [
                    Date::dateTimeToExcel(new Carbon($record->travel_time)),
                    $record->beg_odometer,
                    $record->end_odometer,
                    $record->name,
                    $record->description,
                    $record->duration,
                    (isset($record->category->label)? $record->category->label:'Unassigned'),
                ];
                break;
            }

        return $map;
    }

    public function columnFormats(): array
    {
        $format = [];
        switch($this->report_type) {
            case 'register-income':
            case 'register-expense':
                default:
                $format = [
                    'B' => ' m/d/yy',
                    'C' => NumberFormat::FORMAT_CURRENCY_USD, // amount
                ];
                break;

                case 'entry-income':
                case 'entry-expense':
                $format = [
                    'B' => ' m/d/yy',
                    'D' => NumberFormat::FORMAT_CURRENCY_USD, // amount
                ];
                break;

                case 'mile-none':
                    $format = [
                        'B' => ' m/d/yy',
                        'C' => NumberFormat::FORMAT_DATE_TIME1, //time
                        'D' => NumberFormat::FORMAT_DATE_TIME1, //time
                        'G' => NumberFormat::FORMAT_NUMBER,
                    ];
                    break;

            case 'mile-none':
                $format = [
                    'B' => ' m/d/yy',
                    'C' => NumberFormat::FORMAT_NUMBER_0,
                    'D' => NumberFormat::FORMAT_NUMBER_0,
                    'G' => NumberFormat::FORMAT_NUMBER_0,
                ];
                break;
        }
        return $format;
    }

    public function query()
    {
        switch($this->report_type) {
            case 'register-income':
                $query = Register::query()
                ->where('user_id', Auth::user()->id)
                ->where('paid_date', '>=', $this->beg_date)
                ->where('paid_date', '<=', $this->end_date)
                ->where('income', true)
                ->whereNull('deleted_at')
                ->orderBy('paid_date');

                break;
            case 'register-expense':
            default:
                $query = Register::query()
                ->where('user_id', Auth::user()->id)
                ->where('paid_date', '>=', $this->beg_date)
                ->where('paid_date', '<=', $this->end_date)
                ->where('income', false)
                ->whereNull('deleted_at')
                ->orderBy('paid_date');
                break;
            case 'entry-income':
                $query = Entry::query()
                ->where('user_id', Auth::user()->id)
                ->where('next_due_date', '>=', $this->beg_date)
                ->where('next_due_date', '<=', $this->end_date)
                ->where('income', true)
                ->whereNull('deleted_at')
                ->orderBy('next_due_date');
                break;
            case 'entry-expense':
                $query = Entry::query()
                ->where('user_id', Auth::user()->id)
                ->where('next_due_date', '>=', $this->beg_date)
                ->where('next_due_date', '<=', $this->end_date)
                ->where('income', false)
                ->whereNull('deleted_at')
                ->orderBy('next_due_date');
                break;
            case 'hour-none':
                $result = Hour::query()
                ->where('user_id', Auth::user()->id)
                ->where('act_date', '>=', $this->beg_date)
                ->where('act_date', '<=', $this->end_date)
                ->whereNull('deleted_at')
                ->orderBy('beg_time');
                break;
            case 'mile-none':
                $query = Mile::query()
                ->where('user_id', Auth::user()->id)
                ->where('travel_time', '>=', $this->beg_date)
                ->where('travel_time', '<=', $this->end_date)
                ->whereNull('deleted_at')
                ->orderBy('travel_time');
                break;
            }
        return $query;
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
