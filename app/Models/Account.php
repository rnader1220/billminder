<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Model\TableMaint;

class Account extends Model
{
    use HasFactory;
    use TableMaint;
    use SoftDeletes;

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
                'type' => 'input_checkbox',
                'parameters' =>
                [
                    'label' => "Current Balance",
                    'datapoint' => 'balance',
                    'grid_class' => 'col-lg-4'
                ],
            ],
            [
                'type' => 'input_checkbox',
                'parameters' =>
                [
                    'label' => "Is Bank Account?",
                    'datapoint' => 'bank_account',
                    'grid_class' => 'col-lg-2'
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
