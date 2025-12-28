<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('community_involvements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumnus_id')->constrained('alumni')->cascadeOnDelete();

            $table->string('organization');
            $table->string('role')->nullable();
            $table->string('years_active')->nullable();

            $table->timestamps();

            $table->index(['alumnus_id', 'organization']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_involvements');
    }
};
