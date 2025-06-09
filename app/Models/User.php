<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'next_pay_date'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'name' => 'encrypted',
        ];
    }

    ## UNTESTED ##
    public function getNextPayDateAttribute() {
        $next_pay_date = Carbon::today();
        $next_income = $this->entries->where('income', 1)->first();
        if($next_income && $next_income->next_due_date) {
            $next_pay_date = $next_income->next_due_date;
        }
        return $next_pay_date;

    }


# relationships
public function categories() {
            return $this
            ->hasMany(Category::class);
}

public function entries() {
        return $this
            ->hasMany(Entry::class);
    }
    public function expenseCats() {
        return $this
            ->hasMany(Category::class)->expense();
    }

    public function incomeCats() {
        return $this
            ->hasMany(Category::class)->income();
    }
    
    public function accounts() {
        return $this
            ->hasMany(Account::class)->accounts();
    }

    public function payors() {
        return $this
            ->hasMany(Account::class)->payors();
    }

    public function payees() {
        return $this
            ->hasMany(Account::class)->payees();
    }

}
