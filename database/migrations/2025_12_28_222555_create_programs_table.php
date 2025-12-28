<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_id')->nullable()->constrained('colleges')->nullOnDelete();
            $table->string('name');
            $table->enum('level', ['college', 'grad', 'law']); // pre-list scope
            $table->timestamps();

            $table->unique(['name', 'level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
