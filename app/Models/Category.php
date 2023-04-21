<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\TableMaint;
use App\Traits\Orderable;

class Category extends Model
{
    use HasFactory;
    use TableMaint;
    use SoftDeletes;
    use Orderable;


    protected $label = 'Category';

    public function getList(string $q = '') {
        $result = Category::where('user_id', Auth::user()->id)-> orderBy('display_order')->get()->toArray();
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

    protected $form = [
        [
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Category Name",
                    'datapoint' => 'name',
                    'grid_class' => 'col-md-12'
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
