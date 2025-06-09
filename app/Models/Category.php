<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    //
    //use SoftDeletes;

    protected $fillable = [
        'label',
        'description',
    ];
    protected $casts = [
        'label' => 'encrypted',
        'description' => 'encrypted',
    ];    


    public function scopeIncome($query)
    {
        return $query->where('expense', false);
    }

    public function scopeExpense($query)
    {
        return $query->where('expense', true);
    }
}
