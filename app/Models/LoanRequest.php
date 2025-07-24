<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoanRequest extends Model
{
    protected $fillable = [
        'user_id',
        'loan_product_id',
        'amount',
        'purpose',
        'status',
        'approved_at',
        'rejected_at',
        'rejection_reason'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    /**
     * Get the member who requested the loan
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the loan product
     */
    public function loanProduct(): BelongsTo
    {
        return $this->belongsTo(LoanProduct::class, 'loan_product_id');
    }

    /**
     * Get the guarantors for this loan request
     */
    public function guarantees()
    {
        return $this->hasMany(Guarantor::class);
    }

    /**
     * Get the users who are guaranteeing this loan
     */
    public function guarantors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'loan_request_guarantors', 'loan_request_id', 'guarantor_id')
            ->withPivot('status', 'amount', 'responded_at', 'response_comment')
            ->withTimestamps();
    }

    /**
     * Get the histories for this loan request
     */
    public function histories(): HasMany
    {
        return $this->hasMany(LoanHistory::class);
    }

    /**
     * Get the payments for this loan request
     */
    public function payments(): HasMany
    {
        return $this->hasMany(LoanPayment::class);
    }

    /**
     * Check if the loan request is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the loan request is approved
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if the loan request is rejected
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Reset the guarantors for this loan request
     */
    public function resetGuarantors()
    {
        return $this->guarantors()->update(['loan_request_guarantors.status' => 'pending', 'loan_request_guarantors.responded_at' => null, 'loan_request_guarantors.response_comment' => null]);
    }


}
