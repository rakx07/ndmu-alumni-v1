<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumnus_id')->constrained('alumni')->cascadeOnDelete();

            $table->string('position')->nullable();
            $table->string('company')->nullable();

            // unified org type across all forms
            $table->enum('org_type', [
                'government',
                'private',
                'ngo',
                'academe',
                'self_employed',
                'business_owner',
                'student',
                'others'
            ])->nullable()->index();

            $table->text('office_address')->nullable();
            $table->string('office_contact')->nullable();
            $table->string('office_email')->nullable();

            $table->date('start_date')->nullable(); // years of service derived if needed
            $table->string('licenses')->nullable();
            $table->string('achievements')->nullable();

            $table->timestamps();

            $table->index(['alumnus_id', 'company']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employments');
    }
};
