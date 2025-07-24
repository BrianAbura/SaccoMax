<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
        ];
    }

    public function next_of_kin()
    {
        return $this->hasMany(UserKinDetails::class, 'user_id');
    }

    public function roles()
    {
        return $this->hasMany(UserRoles::class, 'user_id');
    }

    public function savings()
    {
        return $this->hasMany(Savings::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawals::class);
    }

    /**
     * Calculate the maximum guarantor limit based on savings and withdrawals
     *
     * @return float
     */
    public function net_savings_balance()
    {
        $totalSavings = $this->savings()->sum('amount');
        $totalWithdrawals = $this->withdrawals()->sum('amount');
        $totalCharges = $this->withdrawals()->sum('charges');
        return $totalSavings - $totalWithdrawals - $totalCharges;
    }

    /**
     * Get all guarantees made by this user
     */
    public function guarantees()
    {
        return $this->hasMany(Guarantor::class, 'guarantor_id');
    }

    /**
     * Calculate how much more a user can guarantee for loans based on their savings balance
     * and existing guarantees.
     * 
     * @return float The remaining amount that can be guaranteed
     */
    public function guarantor_max_limit()
    {
        return Guarantor::remainingGuaranteeLimit($this);
    }
}
