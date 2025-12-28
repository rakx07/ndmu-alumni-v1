<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('strands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., STEM, ABM, HUMSS, GAS, TVL
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('strands');
    }
};
