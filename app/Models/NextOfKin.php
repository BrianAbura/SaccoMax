<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NextOfKin extends Model
{
    protected $fillable = [
        'member_id',
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'address'
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
