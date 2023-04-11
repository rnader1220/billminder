<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Model\TableMaint;

class Payor extends Model
{
    use HasFactory;
    use TableMaint;
    use SoftDeletes;
/*
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('account_number')->nullable();
            $table->string('website')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
*/


protected $form = [
    [
        [
            'type' => 'input_text',
            'parameters' =>
            [
                'label' => "Payor Name",
                'datapoint' => 'name',
                'grid_class' => 'col-md-6'
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
                'datapoint' => 'password',
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
