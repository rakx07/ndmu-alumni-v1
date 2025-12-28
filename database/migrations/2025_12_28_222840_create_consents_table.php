<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('consents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumnus_id')->constrained('alumni')->cascadeOnDelete();

            $table->string('policy_version')->default('v1');
            $table->boolean('accepted')->default(false);
            $table->timestamp('accepted_at')->nullable();
            $table->ipAddress('accepted_ip')->nullable();

            $table->timestamps();

            $table->unique('alumnus_id'); // one consent record per alumnus (latest)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consents');
    }
};
