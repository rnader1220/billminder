<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Register extends Model
{
    
    protected $fillable = [
        'amount',
        'entry_id',
        'income',
        'paid_date',
        'note',
        'category_id',
        'account_id',
        'party_id',
    ];

    protected function casts(): array
    {
        return [
            'paid_date' => 'datetime',
            'note' => 'encrypted',
        ];
    }


    public function entry() {
        return $this
            ->belongsTo(Entry::class, 'entry_id');
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
