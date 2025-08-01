<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\LoanRequest;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loan_request_guarantors', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(LoanRequest::class)->constrained()->onDelete('cascade');
            $table->foreignId('guarantor_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('responded_at')->nullable();
            $table->text('response_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_request_guarantors');
    }
};
