<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\TableMaint;
use Hamcrest\Type\IsBoolean;

class Entry extends BaseModel
{
    use HasFactory;
    use TableMaint;
    use SoftDeletes;

    public static function getList(string $q = '') {
        $result = Entry::select('entries.id', 'entries.next_due_date', 'entries.amount', 'entries.name',
            DB::raw('categories.label as category'),
            DB::raw(
                "case when income = 1 then 'income' when next_due_date < NOW() then 'late' " .
                "when next_due_date < (select min(next_due_date) from entries where user_id = 2 and income=1 and deleted_at is null) then 'due' " .
                "else 'expense' end as status"
            )
        )
        ->leftjoin('categories', function($join) {
            $join->on('categories.id', '=', 'entries.category_id')
            ->whereNull('categories.deleted_at');
        })
        ->where('entries.user_id', Auth::user()->id)
        ->orderBy('entries.next_due_date')
        ->whereNull('entries.deleted_at')
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

    public function localGetForm($mode) {
        $this->label = ($this->income?'Income':'Expense');
        if($this->income) {
            $this->form[0][13]['parameters']['label'] = $this->form[0][13]['parameters']['label_income'];
            $this->form[0][14]['parameters']['label'] = $this->form[0][14]['parameters']['label_income'];
        }
        return$this->getForm($mode);
    }


    protected function customUpdate(array &$data)
    {
        $data['autopay'] = (isset($data['autopay'])?1:0);
        $data['estimated_amount'] = (isset($data['estimated_amount'])?1:0);
        $data['fixed_amount'] = (isset($data['fixed_amount'])?1:0);
        $data['estimated_date'] = (isset($data['estimated_date'])?1:0);
        if(is_bool($data['income'])) {
            $data['income'] = ($data['income']?1:0);
        }
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
                'type' => 'input_hidden',
                'parameters' =>
                [
                    'label' => "Income?",
                    'datapoint' => 'income',
                ],
            ],
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Entry Name",
                    'datapoint' => 'name',
                    'grid_class' => 'col-sm-12 col-md-8 col-lg-6'
                ]
            ],
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Current Amount",
                    'datapoint' => 'amount',
                    'grid_class' => 'col-sm-6 col-md-4 col-lg-3'
                ],
            ],
            [
                'type' => 'input_checkbox',
                'parameters' =>
                [
                    'label' => "Estimated Amt?",
                    'datapoint' => 'estimated_amount',
                    'grid_class' => 'col-sm-6 col-md-4 col-lg-3'
                ],
            ],
            [
                'type' => 'input_checkbox',
                'parameters' =>
                [
                    'label' => "AutoPay",
                    'datapoint' => 'autopay',
                    'grid_class' => 'col-sm-6 col-md-4 col-lg-3'
                ]
            ],
            [
                'type' => 'select',
                'parameters' =>
                [
                    'label' => "Frequency",
                    'datapoint' => 'cycle',
                    'grid_class' => 'col-sm-6 col-md-4 col-lg-3',
                    'allow_null' => true,
                    'list' => [
                        ['value' => -1, 'label' => 'weekly'],
                        ['value' => -2, 'label' => 'biweekly'],
                        ['value' => -3, 'label' => 'monthly'],
                        ['value' => -4, 'label' => 'quarterly'],
                        ['value' => -5, 'label' => 'annual'],
                        ['value' => -99, 'label' => 'manual'],
                    ]
                ]
            ],
            [
                'type' => 'input_date',
                'parameters' =>
                [
                    'label' => "Next Due Date",
                    'datapoint' => 'next_due_date',
                    'grid_class' => 'col-md-6 col-md-6 col-lg-3'
                ],
            ],
            [
                'type' => 'input_checkbox',
                'parameters' =>
                [
                    'label' => "Estimated Date?",
                    'datapoint' => 'estimated_date',
                    'grid_class' => 'col-sm-6 col-md-6 col-lg-3'
                ],
            ],
            [
                'type' => 'input_checkbox',
                'parameters' =>
                [
                    'label' => "Fixed Amount?",
                    'datapoint' => 'fixed',
                    'grid_class' => 'col-sm-6 col-md-4 col-lg-3'
                ],
            ],

            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Payments Left",
                    'datapoint' => 'payments_remaining',
                    'grid_class' => 'col-sm-6 col-md-4 col-lg-3'
                ],
            ],
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Balance Left",
                    'datapoint' => 'balance_remaining',
                    'grid_class' => 'col-sm-6 col-md-4 col-lg-3'
                ],
            ],
            [
                'type' => 'textarea',
                'parameters' =>
                [
                    'label' => "Description",
                    'datapoint' => 'description',
                    'grid_class' => 'col-12'
                ]
            ],
            [
                'type' => 'select',
                'parameters' =>
                [
                    'label' => "Category",
                    'datapoint' => 'category_id',
                    'allow_null' => true,
                    'grid_class' => 'col-sm-6 col-md-4 col-lg-3',
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
                    'grid_class' => 'col-sm-6 col-md-4 col-lg-3',
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
                    'grid_class' => 'col-sm-6 col-md-4 col-lg-3',
                    'list' => [],
                ]
            ],
        ],
    ];

}
