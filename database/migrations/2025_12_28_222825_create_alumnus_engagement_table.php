<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alumnus_engagement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumnus_id')->constrained('alumni')->cascadeOnDelete();
            $table->foreignId('engagement_option_id')->constrained('engagement_options')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['alumnus_id', 'engagement_option_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumnus_engagement');
    }
};
