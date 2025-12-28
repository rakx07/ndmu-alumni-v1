<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('provider')->nullable()->index();      // google, microsoft, yahoo
            $table->string('provider_id')->nullable()->index();   // user id from provider
            $table->boolean('is_admin')->default(false)->index(); // for Filament admin
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['provider', 'provider_id', 'is_admin']);
        });
    }
};
