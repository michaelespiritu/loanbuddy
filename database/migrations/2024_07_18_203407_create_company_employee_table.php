<?php

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_employee', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::table('company_employee', function (Blueprint $table) {
            $table->foreignUlid('company_id')->constrained('companies')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_employee');
    }
};
