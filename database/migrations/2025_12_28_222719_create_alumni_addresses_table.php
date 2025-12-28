<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alumni_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumnus_id')->constrained('alumni')->cascadeOnDelete();

            // home/permanent/current/office based on your forms
            $table->enum('type', ['home', 'permanent', 'current', 'office'])->index();

            $table->string('line1')->nullable();
            $table->string('line2')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->default('Philippines');
            $table->string('postal_code')->nullable();

            $table->timestamps();

            $table->index(['alumnus_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_addresses');
    }
};
