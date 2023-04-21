<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\TableMaint;
use App\Traits\Orderable;

class Party extends BaseModel
{
    use HasFactory;
    use TableMaint;
    use SoftDeletes;
    use Orderable;

	protected $order_cohort = ['user_id'];
	protected $order_column = 'display_order';

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

    public function __construct() {
        parent::__construct();
        $this->form[0][3]['parameters']['list'] = $this->getSortOrderList();
    }

    protected $fillable = [
        'name',
        'income',
        'expense',
        'description',
        'display_order',
        'account_number',
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
                'type' => 'select',
                'parameters' =>
                [
                    'label' => "Display Order",
                    'datapoint' => 'display_order',
                    'grid_class' => 'col-lg-3',
                    'list' => []
                ]
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
