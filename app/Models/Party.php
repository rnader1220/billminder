<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\TableMaint;
use App\Traits\Orderable;

class Party extends Model
{
    use HasFactory;
    use TableMaint;
    use SoftDeletes;
    use Orderable;


    protected $label = 'Party';

    public static function getList(string $q = '') {
        $result = Party::where('user_id', Auth::user()->id)
            ->orderBy('display_order')
            ->get()
            ->toArray();
        return $result;
    }

    public static function getSelectList(string $q = '') {
        $result = Party::select(DB::raw('name as label'), DB::raw('id as value'))
            ->where('user_id', Auth::user()->id)
            ->orderBy('display_order')
            ->get()
            ->toArray();
        return $result;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'website',
        'username',
        'password',
    ];


    protected $form = [
        [
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Name",
                    'datapoint' => 'name',
                    'grid_class' => 'col-md-6'
                ]
            ],
            [
                'type' => 'input_checkbox',
                'parameters' =>
                [
                    'label' => "Expense?",
                    'datapoint' => 'expense',
                    'grid_class' => 'col-lg-3'
                ],
            ],
            [
                'type' => 'input_checkbox',
                'parameters' =>
                [
                    'label' => "Income?",
                    'datapoint' => 'income',
                    'grid_class' => 'col-lg-3'
                ],
            ],
            [
                'type' => 'textarea',
                'parameters' =>
                [
                    'label' => "Description",
                    'datapoint' => 'description',
                    'grid_class' => 'col-md-12'
                ]
            ],
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Account Number",
                    'datapoint' => 'account_number',
                    'grid_class' => 'col-md-6'
                ]
            ],
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Website URL",
                    'datapoint' => 'website',
                    'grid_class' => 'col-md-12'
                ]
            ],
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Website User",
                    'datapoint' => 'username',
                    'grid_class' => 'col-md-6'
                ]
            ],
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Website Password",
                    'datapoint' => 'password',
                    'grid_class' => 'col-md-6'
                ]
            ],
        ],
    ];
}
