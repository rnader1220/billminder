<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use ESolution\DBEncryption\Traits\EncryptedAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use ESolution\DBEncryption\Encrypter;
use App\Traits\TableMaint;
use Carbon\Carbon;


class Mile extends BaseModel
{
    use HasFactory;
    use TableMaint;
    use SoftDeletes;
    use EncryptedAttribute;

    protected $encryptable = [
        'name',
        'description',
    ];

    protected $fillable = [
        'name',
        'description',
        'beg_time',
        'end_time',
        'beg_odometer',
        'end_odometer',
        'billable',
        'recordable',
        'category_id',
    ];

    public function localGetForm($mode) {
        $this->form[0][9]['parameters']['list'] = Category::getSelectList();
        return $this->getForm($mode);
    }

    protected $form = [
        [

            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Beginning Odometer",
                    'title' => "Odometer reading at beginning of trip",
                    'datapoint' => 'beg_odometer',
                    'grid_class' => 'col-sm-6 col-md-4 col-lg-3'
                ],
            ],
            [
                'type' => 'input_date',
                'parameters' =>
                [
                    'label' => "Trip Started",
                    'title' => "When Did this Trip Begin?",
                    'datapoint' => 'beg_time',
                    'grid_class' => 'col-md-6 col-md-6 col-lg-3'
                ],
            ],
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Ending Odometer",
                    'title' => "Odometer reading at completion of trip",
                    'datapoint' => 'end_odometer',
                    'grid_class' => 'col-sm-6 col-md-4 col-lg-3'
                ],
            ],
            [
                'type' => 'input_date',
                'parameters' =>
                [
                    'label' => "Trip Ended",
                    'title' => "When Did this Trip End?",
                    'datapoint' => 'end_time',
                    'grid_class' => 'col-md-6 col-md-6 col-lg-3'
                ],
            ],
            [
                'type' => 'input_text',
                'parameters' =>
                [
                    'label' => "Name",
                    'title' => "This field is what will display on the list. (Required) (Encrypted)",
                    'datapoint' => 'name',
                    'grid_class' => 'col-sm-12 col-md-8 col-lg-6'
                ]
            ],
            [
                'type' => 'input_checkbox',
                'parameters' =>
                [
                    'label' => "Billable?",
                    'title' => "Is this mileage billable or reimbursable?",
                    'datapoint' => 'billable',
                    'grid_class' => 'col-sm-6 col-md-4 col-lg-3'
                ],
            ],
            [
                'type' => 'input_checkbox',
                'parameters' =>
                [
                    'label' => "Reportable",
                    'title' => "Is this mileage reportable for tax purposes?",
                    'datapoint' => 'reportable',
                    'grid_class' => 'col-sm-6 col-md-4 col-lg-3'
                ]
            ],
            [
                'type' => 'textarea',
                'parameters' =>
                [
                    'label' => "Description",
                    'title' => "Write whatever you like here: description, notes, and so forth, for this. (Encrypted)",
                    'datapoint' => 'description',
                    'grid_class' => 'col-12'
                ]
            ],
            [
                'type' => 'select',
                'parameters' =>
                [
                    'label' => "Category",
                    'title' => "This field is what will display on the list. Select from your category list, to organize your mileage for reporting purposes.  See the Categories tab for more details.",
                    'datapoint' => 'category_id',
                    'allow_null' => true,
                    'grid_class' => 'col-sm-6 col-md-4 col-lg-3',
                    'allow_new' => true,
                    'list' => [],
                ]
            ],
            [
                'type' => 'help_text',
                'parameters' =>
                [
                    'datapoint' => "help-text",
                    'grid_class' => 'col-md-12',
                    'text' => ''
                ]
            ],
        ],
    ];
}
