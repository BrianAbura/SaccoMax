<?php

use App\Models\BalanceSheetSubCategories;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('balance_sheet_manuals', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['Assets', 'Liabilities', 'Equity']);
            $table->foreignIdFor(BalanceSheetSubCategories::class);
            $table->string('item_name');
            $table->string('item_description');
            $table->decimal('item_value', 10, 2);
            $table->date('date');
            $table->string('attachment')->nullable();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balance_sheet_manuals');
    }
};
