<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawals extends Model
{
    public function member()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
