<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alumni_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumnus_id')->constrained('alumni')->cascadeOnDelete();

            $table->string('contact_number')->nullable();
            $table->string('email')->nullable()->index();
            $table->string('facebook_handle')->nullable();

            $table->timestamps();

            $table->unique('alumnus_id'); // one profile per alumnus
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_profiles');
    }
};
