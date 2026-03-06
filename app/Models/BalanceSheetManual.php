<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceSheetManual extends Model
{
    protected $fillable = [
        'category',
        'balance_sheet_sub_categories_id',
        'item_name',
        'item_description',
        'item_value',
        'date',
        'attachment',
        'user_id',
    ];

    public function sub_category()
    {
        return $this->belongsTo(BalanceSheetSubCategories::class, 'balance_sheet_sub_categories_id');
    }
}
