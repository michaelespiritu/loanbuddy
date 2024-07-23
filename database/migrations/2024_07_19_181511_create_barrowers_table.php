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
        Schema::create('barrowers', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUlid('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignUlid('company_id')->constrained('companies')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('loans', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('barrower_id')->constrained('barrowers')->cascadeOnDelete();
            $table->string('loan_amount');
            $table->string('interest')->default('7');
            $table->string('duration');
            $table->string('frequency_of_payment');
            $table->dateTime('start_of_payment_date');
            $table->string('penalty');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barrower_details');
        Schema::dropIfExists('barrowers');
    }
};
