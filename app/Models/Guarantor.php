<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Guarantor extends Model
{
    protected $table = 'loan_request_guarantors';

    protected $fillable = [
        'loan_request_id',
        'guarantor_id',
        'amount',
        'status',
        'response_comment',
        'responded_at'
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'amount' => 'float'
    ];

    /**
     * Get the loan request this guarantee is for
     */
    public function loanRequest(): BelongsTo
    {
        return $this->belongsTo(LoanRequest::class);
    }

    /**
     * Get the user who is guaranteeing
     */
    public function guarantor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guarantor_id');
    }

    /**
     * Calculate total amount guaranteed by a user for active loans
     */
    public static function totalGuaranteedAmount(int $userId): float
    {
        return static::query()
            ->join('loan_requests', 'loan_request_guarantors.loan_request_id', '=', 'loan_requests.id')
            ->where('guarantor_id', $userId)
            ->whereIn('loan_requests.status', ['pending', 'approved'])
            ->whereIn('loan_request_guarantors.status', ['pending', 'approved'])
            ->sum('loan_request_guarantors.amount');
    }

    /**
     * Calculate remaining amount a user can guarantee based on their savings
     */
    public static function remainingGuaranteeLimit(User $user): float
    {
        $totalGuaranteed = static::totalGuaranteedAmount($user->id);
        $maxLimit = $user->net_savings_balance();
        
        return max(0, $maxLimit - $totalGuaranteed);
    }

    /**
     * Scope a query to only include active guarantees
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'approved']);
    }

    /**
     * Scope a query to only include approved guarantees
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include pending guarantees
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
