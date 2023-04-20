<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TableMaint;
use App\Traits\Orderable;

class Category extends Model
{
    use HasFactory;
    use TableMaint;
    use SoftDeletes;
    use Orderable;

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
