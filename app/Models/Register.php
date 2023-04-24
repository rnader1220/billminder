<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Traits\TableMaint;

class Register extends BaseModel
{
    use HasFactory;
    use TableMaint;
    use SoftDeletes;


    public static function getList(string $q = '') {
        $result = Entry::select('register.id', 'register.paid_date', 'register.amount', 'register.name',
            DB::raw('categories.label as category'),
        )
        ->leftjoin('categories', function($join) {
            $join->on('categories.id', '=', 'entries.category_id')
            ->whereNull('categories.deleted_at');
        })
        ->where('register.user_id', Auth::user()->id)
        ->orderBy('register.paid_date', 'desc')
        ->whereNull('register.deleted_at')
        ->get()
        ->toArray();
        return $result;
    }

    public function __construct() {
        parent::__construct();
        $this->form[0][6]['parameters']['list'] = Category::getSelectList();
        $this->form[0][7]['parameters']['list'] = Account::getSelectList();
        $this->form[0][8]['parameters']['list'] = Account::getSelectList();

    }

    public function getCycle() {
        $entry = Entry::find($this->entry_id)->toArray();
        $this->fill($entry);
        $this->id = null;
        $this->paid_date = $entry['next_due_date'];
        $this->label = ($this->income?'Income Register':'Expense Register');
        if($this->income) {
            $this->form[0][7]['parameters']['label'] = $this->form[0][7]['parameters']['label_income'];
            $this->form[0][8]['parameters']['label'] = $this->form[0][8]['parameters']['label_income'];
        }
        $form = $this->getForm('create');
        $form['action'] = 'create';
        return $form;
    }

    public function storeCycle(Request $request) {
        $this->saveRecord($request);
        $entry = Entry::find($this->entry_id);
        return $entry->postCycle();
    }

    protected $fillable = [
        'name',
        'amount',
        'income',
        'paid_date',
        'fixed',
        'description',
        'category_id',
        'account_id',
        'party_id',
    ];


    protected $form = [
        [
            [
                'type' => 'input_hidden',
                'parameters' =>
                [
                    'datapoint' => 'income',
                ],
            ],
            [
                'type' => 'input_hidden',
                'parameters' =>
                [
                    'datapoint' => 'entry_id',
                ],
            ],
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Name",
                    'datapoint' => 'name',
                    'grid_class' => 'col-sm-12 col-md-8 col-lg-6'
                ]
            ],
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Paid Amount",
                    'datapoint' => 'amount',
                    'grid_class' => 'col-sm-6 col-md-4 col-lg-3'
                ],
            ],
            [
                'type' => 'input_date',
                'parameters' =>
                [
                    'label' => "Paid Date",
                    'datapoint' => 'paid_date',
                    'grid_class' => 'col-md-6 col-md-6 col-lg-3'
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
