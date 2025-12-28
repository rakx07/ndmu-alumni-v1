<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();

            // Optional linkage if you want alumni to log in later
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Which intake form
            $table->enum('track', ['college', 'grad_law', 'elementary', 'jhs_shs'])->index();

            // Personal info
            $table->string('full_name');
            $table->string('nickname')->nullable();
            $table->enum('sex', ['Male', 'Female', 'Prefer not to say'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('civil_status', ['Single', 'Married', 'Widowed', 'Separated'])->nullable();

            $table->string('nationality')->nullable();
            $table->string('religion')->nullable();

            // Student number (if known)
            $table->string('student_number')->nullable()->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
