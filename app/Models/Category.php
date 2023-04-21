<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\TableMaint;
use App\Traits\Orderable;

class Category extends BaseModel
{
    use HasFactory;
    use TableMaint;
    use SoftDeletes;
    use Orderable;

	protected $order_cohort = ['user_id'];
	protected $order_column = 'display_order';


    protected $fillable = [
        'label',
        'display_order',
        'description',
    ];

    public function getList(string $q = '') {
        $result = Category::where('user_id', Auth::user()->id)
        ->orderBy('display_order')
        ->get()
        ->toArray();
        return $result;
    }

    public static function getSelectList(string $q = '') {
        $result = Category::select('label', DB::raw('id as value'))
            ->where('user_id', Auth::user()->id)
            ->orderBy('display_order')
            ->get()
            ->toArray();
        return $result;
    }

    public function __construct() {
        parent::__construct();
        $this->form[0][1]['parameters']['list'] = $this->getSortOrderList();
    }

    protected $form = [
        [
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Category Label",
                    'datapoint' => 'label',
                    'grid_class' => 'col-md-9'
                ]
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
            ]
        ],
    ];


}
