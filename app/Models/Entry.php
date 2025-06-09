<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class Entry extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'name',
        'amount',
        'estimated_amount',
        'income',
        'autopay',
        'cycle',
        'next_due_date',
        'estimated_date',
        'payments_remaining',
        'balance_remaining',
        'description',
        'category_id',
        'account_id',
        'party_id',
    ];

    protected $frequency = [
        ['value' => -1, 'label' => 'weekly'],
        ['value' => -2, 'label' => 'biweekly'],
        ['value' => -3, 'label' => 'monthly'],
        ['value' => -4, 'label' => 'quarterly'],
        ['value' => -5, 'label' => 'annual'],
        ['value' => -99, 'label' => 'manual'],
    ];

    protected $casts = [
        'name' => 'encrypted',
        'description' => 'encrypted',
        'next_due_date' => 'datetime',
    ];
    
    public function getStatusAttribute() {
        if($this->income) {
            return 'income';
        } else if ($this->next_due_date <= Carbon::today()) {
            return 'late';
        } else if($this->next_due_date < Auth::user()->next_pay_date()) {
            return 'due';
        } else {
            return 'expense';
        }
    }


    public function category() {
        return $this
            ->belongsTo(Category::class, 'category_id');
    }

    public function account() {
        return $this
            ->belongsTo(Account::class, 'account_id');
    }

    public function party() {
        return $this
            ->belongsTo(Account::class, 'party_id');
    }

}
