<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumnus_id')->constrained('alumni')->cascadeOnDelete();

            // Where this education belongs in the forms
            $table->enum('context', [
                'ndmu_college',
                'ndmu_grad_law',
                'ndmu_elem',
                'ndmu_jhs',
                'ndmu_shs',
                'post_ndmu',
                'continuing'
            ])->index();

            // NDMU pre-lists
            $table->foreignId('college_id')->nullable()->constrained('colleges')->nullOnDelete();
            $table->foreignId('program_id')->nullable()->constrained('programs')->nullOnDelete();

            // SHS
            $table->foreignId('strand_id')->nullable()->constrained('strands')->nullOnDelete();

            // Generic fields for Elementary/JHS/SHS and other schools
            $table->string('level_label')->nullable();      // e.g., Junior High School, Senior High School
            $table->string('institution_name')->nullable(); // for post-NDMU schools
            $table->string('institution_location')->nullable();

            $table->year('year_entered')->nullable();
            $table->year('year_graduated')->nullable();

            // Graduate/Law
            $table->string('thesis_title')->nullable();

            // Honors/awards (any track)
            $table->string('honors')->nullable();

            // Notes for “Last year attended”, etc.
            $table->string('remarks')->nullable();

            $table->timestamps();

            $table->index(['alumnus_id', 'context']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
