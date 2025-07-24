<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LoanRequest;
use App\Models\User;

class LoanHistory extends Model
{
    protected $fillable = [
        'loan_request_id',
        'transaction_type',
        'comment',
        'added_by'
    ];

    public function loanRequest()
    {
        return $this->belongsTo(LoanRequest::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
