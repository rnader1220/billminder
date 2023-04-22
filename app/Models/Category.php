<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\TableMaint;

class Category extends BaseModel
{
    use HasFactory;
    use TableMaint;
    use SoftDeletes;



    protected $fillable = [
        'label',
        'description',
    ];

    public function getList(string $q = '') {
        $result = Category::where('user_id', Auth::user()->id)
        ->whereNull('deleted_at')
        ->orderBy('label')
        ->get()
        ->toArray();
        return $result;
    }

    public static function getSelectList(string $q = '') {
        $result = Category::select('label', DB::raw('id as value'))
            ->where('user_id', Auth::user()->id)
            ->whereNull('deleted_at')
            ->orderBy('label')
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
                    'label' => "Category Label",
                    'datapoint' => 'label',
                    'grid_class' => 'col-md-9'
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
