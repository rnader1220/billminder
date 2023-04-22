<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\TableMaint;

class Account extends BaseModel
{
    use HasFactory;
    use TableMaint;
    use SoftDeletes;

    public static function getList(string $q = '') {
        $result = Account::where('user_id', Auth::user()->id)
        ->whereNull('deleted_at')
        ->orderBy('name')
        ->get()
        ->toArray();
        return $result;
    }

    public static function getSelectList(string $q = '') {
        $result = Account::select(DB::raw('name as label'), DB::raw('id as value'))
            ->where('user_id', Auth::user()->id)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get()
            ->toArray();
        return $result;
    }

    protected $fillable = [
        'name',
        'balance',
        'bank_account',
        'description',
        'account_number',
        'routing_number',
        'website',
        'username',
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
                    'label' => "Account Name",
                    'datapoint' => 'name',
                    'grid_class' => 'col-md-6'
                ]
            ],
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Current Balance",
                    'datapoint' => 'balance',
                    'numeric' => true,

                    'grid_class' => 'col-lg-4'
                ],
            ],
            [
                'type' => 'input_checkbox',
                'parameters' =>
                [
                    'label' => "Is Bank Account?",
                    'datapoint' => 'bank_account',
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
                    'label' => "Routing Number",
                    'datapoint' => 'routing_number',
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
