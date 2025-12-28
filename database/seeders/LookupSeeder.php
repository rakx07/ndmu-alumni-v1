<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LookupSeeder extends Seeder
{
    public function run(): void
    {
        // Engagement options (checkboxes)
        DB::table('engagement_options')->upsert([
            ['code' => 'events',         'label' => 'Willing to be contacted for alumni events'],
            ['code' => 'mentor',         'label' => 'Willing to mentor current students'],
            ['code' => 'networking',     'label' => 'Interested in alumni networking / reunions'],
            ['code' => 'talks',          'label' => 'Open to giving career talks or sharing expertise'],
            ['code' => 'donate',         'label' => 'Interested in contributing to alumni fund or scholarship'],
            ['code' => 'email_updates',  'label' => 'Prefer email updates'],
            ['code' => 'sms_updates',    'label' => 'Prefer SMS updates'],

            // Grad/Law specific
            ['code' => 'grad_events',    'label' => 'Willing to be contacted for Graduate / Law Alumni activities'],
            ['code' => 'research_collab','label' => 'Interested in research collaborations or seminars'],
        ], ['code'], ['label']);

        // SHS strands (edit as needed)
        DB::table('strands')->upsert([
            ['name' => 'STEM'],
            ['name' => 'ABM'],
            ['name' => 'HUMSS'],
            ['name' => 'GAS'],
            ['name' => 'TVL'],
        ], ['name'], ['name']);
    }
}
