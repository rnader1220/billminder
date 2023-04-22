<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Traits\TableMaint;

class Entry extends BaseModel
{
    use HasFactory;
    use TableMaint;
    use SoftDeletes;

    public static function getList(string $q = '') {
        $result = Entry::where('user_id', Auth::user()->id)
        ->orderBy('next_due_date')
        ->whereNull('deleted_at')
        ->get()
        ->toArray();
        return $result;
    }

    public function __construct() {
        parent::__construct();
        $this->form[0][12]['parameters']['list'] = Category::getSelectList();
        $this->form[0][13]['parameters']['list'] = Account::getSelectList();
        $this->form[0][14]['parameters']['list'] = Account::getSelectList();

    }

    protected function customUpdate(array &$data)
    {
        $data['income'] = (isset($data['income'])?1:0);
        $data['autopay'] = (isset($data['autopay'])?1:0);
        $data['estimated_amount'] = (isset($data['estimated_amount'])?1:0);
        $data['fixed_amount'] = (isset($data['fixed_amount'])?1:0);
        $data['estimated_date'] = (isset($data['estimated_date'])?1:0);
    }


    protected $fillable = [
        'name',
        'amount',
        'estimated_amount',
        'income',
        'autopay',
        'cycle',
        'next_due_date',
        'estimated_date',
        'fixed',
        'payments_remaining',
        'balance_remaining',
        'description',
        'category_id',
        'account_id',
        'party_id',
    ];

    protected $utilities = [
        [
            'label' => 'Cycle',
            'title' => 'Cycle This Entry',
            'button_class' => 'btn-primary m-1',
            'icon' => 'fas fa-rotate',
            'id' => 'control-cycle',
        ],
    ];


    protected $form = [
        [
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Entry Name",
                    'datapoint' => 'name',
                    'grid_class' => 'col-md-6'
                ]
            ],
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Current Amount",
                    'datapoint' => 'amount',
                    'grid_class' => 'col-lg-3'
                ],
            ],
            [
                'type' => 'input_checkbox',
                'parameters' =>
                [
                    'label' => "Estimated?",
                    'datapoint' => 'estimated_amount',
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
                'type' => 'input_checkbox',
                'parameters' =>
                [
                    'label' => "AutoPay",
                    'datapoint' => 'autopay',
                    'grid_class' => 'col-md-3'
                ]
            ],
            [
                'type' => 'select',
                'parameters' =>
                [
                    'label' => "Billing Cycle",
                    'datapoint' => 'cycle',
                    'grid_class' => 'col-md-3',
                    'list' => [
                        ['value' => -1, 'label' => 'monthly'],
                        ['value' => -2, 'label' => 'quarterly'],
                        ['value' => -3, 'label' => 'annual'],
                    ]
                ]
            ],
            [
                'type' => 'input_date',
                'parameters' =>
                [
                    'label' => "Next Due Date",
                    'datapoint' => 'next_due_date',
                    'grid_class' => 'col-lg-3'
                ],
            ],
            [
                'type' => 'input_checkbox',
                'parameters' =>
                [
                    'label' => "Estimated?",
                    'datapoint' => 'estimated_date',
                    'grid_class' => 'col-lg-3'
                ],
            ],
            [
                'type' => 'input_checkbox',
                'parameters' =>
                [
                    'label' => "Fixed Amount?",
                    'datapoint' => 'fixed',
                    'grid_class' => 'col-lg-6'
                ],
            ],

            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Payments Remaining",
                    'datapoint' => 'payments_remaining',
                    'grid_class' => 'col-lg-6'
                ],
            ],
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Balance Remaining",
                    'datapoint' => 'balance_remaining',
                    'grid_class' => 'col-lg-6'
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
                'type' => 'select',
                'parameters' =>
                [
                    'label' => "Category",
                    'datapoint' => 'category_id',
                    'allow_null' => true,
                    'grid_class' => 'col-md-4',
                    'list' => [],
                ]
            ],
            [
                'type' => 'select',
                'parameters' =>
                [
                    'label' => "From Account",
                    'label_income' => "To Account",
                    'allow_null' => true,
                    'datapoint' => 'account_id',
                    'grid_class' => 'col-md-4',
                    'list' => [],
                ]
            ],
            [
                'type' => 'select',
                'parameters' =>
                [
                    'label' => "Pay To",
                    'label_income' => "Pay From",
                    'allow_null' => true,
                    'datapoint' => 'party_id',
                    'grid_class' => 'col-md-4',
                    'list' => [],
                ]
            ],
        ],
    ];

}
