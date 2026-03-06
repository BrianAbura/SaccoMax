<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceSheetSubCategories extends Model
{
    protected $fillable = [
        'category',
        'description',
    ];

    public function entries()
    {
        return $this->hasMany(BalanceSheetManual::class, 'balance_sheet_sub_categories_id');
    }
}
