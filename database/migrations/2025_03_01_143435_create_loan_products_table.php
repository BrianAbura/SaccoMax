<?php

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
        Schema::create('loan_products', function (Blueprint $table) {
            $table->id();
            $table->string('loan_type');
            $table->bigInteger('max_loan_amount');
            $table->integer('loan_period');
            $table->float('annual_interest_rate');
            $table->float('monthly_interest_rate')->nullable();
            $table->integer('grace_period')->nullable();
            $table->string('payment_frequency');
            $table->foreignIdFor(User::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_products');
    }
};
