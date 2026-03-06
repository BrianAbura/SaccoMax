<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMSMessages extends Model
{
    protected $table = 'sms_messages';

    public function member()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
