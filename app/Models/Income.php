<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Model\TableMaint;

class Income extends Model
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
                        'label' => "Income Name",
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
                    'type' => 'checkbox',
                    'parameters' =>
                    [
                        'label' => "Estimated?",
                        'datapoint' => 'estimated_amount',
                        'grid_class' => 'col-lg-3'
                    ],
                ],
                [
                    'type' => 'select',
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
                        'label' => "Pay Cycle",
                        'datapoint' => 'cycle',
                        'grid_class' => 'col-md-3'
                    ]
                ],
                [
                    'type' => 'input_date',
                    'parameters' =>
                    [
                        'label' => "Next Pay Date",
                        'datapoint' => 'next_due_date',
                        'grid_class' => 'col-lg-3'
                    ],
                ],
                [
                    'type' => 'checkbox',
                    'parameters' =>
                    [
                        'label' => "Estimated?",
                        'datapoint' => 'estimated_date',
                        'grid_class' => 'col-lg-3'
                    ],
                ],
                [
                    'type' => 'checkbox',
                    'parameters' =>
                    [
                        'label' => "Fixed Amount?",
                        'datapoint' => 'payments_remaining',
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
                        'label' => "Balance",
                        'datapoint' => 'balance',
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
                        'grid_class' => 'col-md-4'
                    ]
                ],
                [
                    'type' => 'select',
                    'parameters' =>
                    [
                        'label' => "Paid To Account",
                        'datapoint' => 'account_id',
                        'grid_class' => 'col-md-4'
                    ]
                ],
                [
                    'type' => 'select',
                    'parameters' =>
                    [
                        'label' => "Payor",
                        'datapoint' => 'payee_id',
                        'grid_class' => 'col-md-4'
                    ]
                ],
            ],
        ];


}
