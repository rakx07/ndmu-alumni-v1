<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollegeProgramSeeder extends Seeder
{
    public function run(): void
    {
        // NOTE: Replace these with the official NDMU lists.
        $colleges = [
            'College of Arts and Sciences',
            'College of Business, Governance and Accountancy',
            'College of Engineering, Architecture and Computing',
            'College of Health Sciences',
            'Graduate School',
            'Law School',
        ];

        foreach ($colleges as $name) {
            DB::table('colleges')->updateOrInsert(['name' => $name], ['name' => $name]);
        }

        $collegeId = fn(string $collegeName) =>
            DB::table('colleges')->where('name', $collegeName)->value('id');

        // Programs (example placeholders — replace with your real pre-list)
        $programs = [
            // College programs
            ['college' => 'College of Arts and Sciences', 'name' => 'Bachelor of Arts in English', 'level' => 'college'],
            ['college' => 'College of Business, Governance and Accountancy', 'name' => 'Bachelor of Science in Accountancy', 'level' => 'college'],
            ['college' => 'College of Engineering, Architecture and Computing', 'name' => 'Bachelor of Science in Information Technology', 'level' => 'college'],
            ['college' => 'College of Health Sciences', 'name' => 'Bachelor of Science in Nursing', 'level' => 'college'],

            // Graduate programs
            ['college' => 'Graduate School', 'name' => 'Master in Public Administration', 'level' => 'grad'],
            ['college' => 'Graduate School', 'name' => 'Doctor of Philosophy in Education', 'level' => 'grad'],

            // Law
            ['college' => 'Law School', 'name' => 'Juris Doctor', 'level' => 'law'],
        ];

        foreach ($programs as $p) {
            DB::table('programs')->updateOrInsert(
                ['name' => $p['name'], 'level' => $p['level']],
                ['college_id' => $collegeId($p['college'])]
            );
        }
    }
}
