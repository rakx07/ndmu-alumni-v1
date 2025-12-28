<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('engagement_options', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();  // e.g., events, mentor, networking, talks, donate, email_updates, sms_updates
            $table->string('label');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('engagement_options');
    }
};
