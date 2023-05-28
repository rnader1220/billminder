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

class Hour extends BaseModel
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
        'billable',
        'category_id',
    ];

    public static function getList(string $q = '') {
        $result = Entry::select(
            'entries.id',
            'entries.next_due_date',
            'entries.estimated_date',
            'entries.amount',
            'entries.estimated_amount',
            'entries.name',
            'entries.autopay',
            DB::raw('categories.label as category'),
            DB::raw(
                "case when income = 1 then 'income' when next_due_date < CURDATE() then 'late' " .
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

        foreach($result as $index => $row) {
            $result[$index]['category'] = Encrypter::decrypt($row['category']);
        }

        return $result;
    }

    public function localGetForm($mode) {
        $this->form[0][5]['parameters']['list'] = Category::getSelectList();
        return $this->getForm($mode);
    }

    protected $form = [
        [
            [
                'type' => 'input_date',
                'parameters' =>
                [
                    'label' => "DateTime Started",
                    'title' => "When did this activity begin?",
                    'datapoint' => 'beg_time',
                    'grid_class' => 'col-md-6 col-md-6 col-lg-3'
                ],
            ],
            [
                'type' => 'input_date',
                'parameters' =>
                [
                    'label' => "Trip Ended",
                    'title' => "When did this activity end?",
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
                    'title' => "Is this time billable or reimbursable?",
                    'datapoint' => 'billable',
                    'grid_class' => 'col-sm-6 col-md-4 col-lg-3'
                ],
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
                    'title' => "This field is what will display on the list. Select from your category list, to organize your time for reporting purposes.  See the Categories tab for more details.",
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
