<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Account extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'balance',
        'bank_account',
        'account',
        'payor',
        'payee',
        'website',
    ];    

    protected $casts = [
        'name' => 'encrypted',
        'description' => 'encrypted',
    ];


    public function scopePayors($query)
    {
        return $query->where('payor', true);
    }

    public function scopePayees($query)
    {
        return $query->where('payee', true);
    }

    public function scopeAccounts($query)
    {
        return $query->where('account', true);
    }
}
