<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Alumnus;
use App\Models\AlumniAddress;
use App\Models\AlumniProfile;
use App\Models\College;
use App\Models\Consent;
use App\Models\EngagementOption;
use App\Models\Program;
use App\Models\Strand;
use App\Models\Education;
use App\Models\Employment;
use App\Models\CommunityInvolvement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class IntakeController extends Controller
{
    /**
     * Map alumni.track to educations.context enum values.
     */
    private function ndmuContextFromTrack(string $track): string
    {
        return match ($track) {
            'college'    => 'ndmu_college',
            'grad_law'   => 'ndmu_grad_law',
            'elementary' => 'ndmu_elem',
            'jhs_shs'    => 'ndmu_shs', // main record for JHS/SHS track
            default      => 'ndmu_college',
        };
    }

    public function edit()
    {
        $user = Auth::user();

        $alumnus = Alumnus::firstOrCreate(
            ['user_id' => $user->id],
            ['track' => 'college', 'full_name' => $user->name, 'sex' => 'Prefer not to say']
        );

        $profile = AlumniProfile::firstOrCreate(
            ['alumnus_id' => $alumnus->id],
            ['email' => $user->email]
        );

        $permanent = AlumniAddress::firstOrCreate(
            ['alumnus_id' => $alumnus->id, 'type' => 'permanent'],
            []
        );

        $current = AlumniAddress::firstOrCreate(
            ['alumnus_id' => $alumnus->id, 'type' => 'current'],
            []
        );

        $employment = Employment::firstOrCreate(
            ['alumnus_id' => $alumnus->id],
            []
        );

        // ✅ FIX: use enum values
        $ndmuContext = $this->ndmuContextFromTrack($alumnus->track);

        $ndmuEducation = Education::firstOrCreate(
            ['alumnus_id' => $alumnus->id, 'context' => $ndmuContext],
            []
        );

        // ✅ FIX: post/continuing use enum values
        $postEducations = Education::where('alumnus_id', $alumnus->id)
            ->whereIn('context', ['post_ndmu', 'continuing'])
            ->get();

        $community = CommunityInvolvement::where('alumnus_id', $alumnus->id)->get();

        $consent = Consent::firstOrCreate(
            ['alumnus_id' => $alumnus->id],
            ['accepted' => false, 'policy_version' => 'RA10173-v1']
        );

        $engagementOptions = EngagementOption::orderBy('label')->get();
        $selectedEngagementIds = $alumnus->engagementOptions()->pluck('engagement_option_id')->toArray();

        return view('alumni.intake', [
            'alumnus' => $alumnus,
            'profile' => $profile,
            'permanent' => $permanent,
            'current' => $current,
            'employment' => $employment,
            'ndmuEducation' => $ndmuEducation,
            'postEducations' => $postEducations,
            'community' => $community,
            'consent' => $consent,
            'engagementOptions' => $engagementOptions,
            'selectedEngagementIds' => $selectedEngagementIds,
            'colleges' => College::orderBy('name')->get(),
            'programs' => Program::orderBy('name')->get(),
            'strands' => Strand::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            // Alumni core
            'track' => 'required|in:college,grad_law,elementary,jhs_shs',
            'full_name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'sex' => 'nullable|in:Male,Female,Prefer not to say',
            'date_of_birth' => 'nullable|date',
            'civil_status' => 'nullable|in:Single,Married,Widowed,Separated',
            'nationality' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'student_number' => 'nullable|string|max:100',

            // Profile
            'contact_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'facebook_handle' => 'nullable|string|max:255',

            // Addresses
            'permanent.line1' => 'nullable|string|max:255',
            'permanent.line2' => 'nullable|string|max:255',
            'permanent.city' => 'nullable|string|max:255',
            'permanent.province' => 'nullable|string|max:255',
            'permanent.country' => 'nullable|string|max:255',
            'permanent.postal_code' => 'nullable|string|max:30',

            'current.line1' => 'nullable|string|max:255',
            'current.line2' => 'nullable|string|max:255',
            'current.city' => 'nullable|string|max:255',
            'current.province' => 'nullable|string|max:255',
            'current.country' => 'nullable|string|max:255',
            'current.postal_code' => 'nullable|string|max:30',

            // NDMU Education (single row)
            'ndmu.college_id' => 'nullable|integer',
            'ndmu.program_id' => 'nullable|integer',
            'ndmu.strand_id' => 'nullable|integer',
            'ndmu.year_entered' => 'nullable|integer|min:1900|max:2100',
            'ndmu.year_graduated' => 'nullable|integer|min:1900|max:2100',
            'ndmu.honors' => 'nullable|string|max:255',
            'ndmu.thesis_title' => 'nullable|string|max:255',
            'ndmu.remarks' => 'nullable|string|max:255',

            // Employment (single row)
            'employment.position' => 'nullable|string|max:255',
            'employment.company' => 'nullable|string|max:255',
            'employment.org_type' => 'nullable|in:Government,Private,NGO,Academe,Self-employed,Business Owner,Student,Others',
            'employment.office_address' => 'nullable|string|max:255',
            'employment.office_contact' => 'nullable|string|max:255',
            'employment.office_email' => 'nullable|email|max:255',
            'employment.start_date' => 'nullable|date',
            'employment.licenses' => 'nullable|string|max:255',
            'employment.achievements' => 'nullable|string|max:255',

            // Post-NDMU education (multiple rows)
            'post.*.degree' => 'nullable|string|max:255',
            'post.*.institution' => 'nullable|string|max:255',
            'post.*.year' => 'nullable|string|max:50',

            // Community (multiple rows)
            'community.*.organization' => 'nullable|string|max:255',
            'community.*.role' => 'nullable|string|max:255',
            'community.*.years_active' => 'nullable|string|max:100',

            // Engagement
            'engagement' => 'array',
            'engagement.*' => 'integer',

            // Consent
            'consent' => 'accepted',
        ]);

        DB::transaction(function () use ($validated, $user) {
            $alumnus = Alumnus::firstOrCreate(['user_id' => $user->id]);

            $alumnus->update([
                'track' => $validated['track'],
                'full_name' => $validated['full_name'],
                'nickname' => $validated['nickname'] ?? null,
                'sex' => $validated['sex'] ?? 'Prefer not to say',
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'civil_status' => $validated['civil_status'] ?? null,
                'nationality' => $validated['nationality'] ?? null,
                'religion' => $validated['religion'] ?? null,
                'student_number' => $validated['student_number'] ?? null,
            ]);

            AlumniProfile::updateOrCreate(
                ['alumnus_id' => $alumnus->id],
                [
                    'contact_number' => $validated['contact_number'] ?? null,
                    'email' => $validated['email'] ?? $user->email,
                    'facebook_handle' => $validated['facebook_handle'] ?? null,
                ]
            );

            AlumniAddress::updateOrCreate(
                ['alumnus_id' => $alumnus->id, 'type' => 'permanent'],
                $validated['permanent'] ?? []
            );

            AlumniAddress::updateOrCreate(
                ['alumnus_id' => $alumnus->id, 'type' => 'current'],
                $validated['current'] ?? []
            );

            // ✅ FIX: NDMU context based on track
            $ndmuContext = $this->ndmuContextFromTrack($validated['track']);

            $ndmu = $validated['ndmu'] ?? [];

            Education::updateOrCreate(
                ['alumnus_id' => $alumnus->id, 'context' => $ndmuContext],
                [
                    'college_id' => $ndmu['college_id'] ?? null,
                    'program_id' => $ndmu['program_id'] ?? null,
                    'strand_id' => $ndmu['strand_id'] ?? null,
                    'year_entered' => $ndmu['year_entered'] ?? null,
                    'year_graduated' => $ndmu['year_graduated'] ?? null,
                    'honors' => $ndmu['honors'] ?? null,
                    'thesis_title' => $ndmu['thesis_title'] ?? null,
                    'remarks' => $ndmu['remarks'] ?? null,
                ]
            );

            // Employment
            $emp = $validated['employment'] ?? [];
            Employment::updateOrCreate(
                ['alumnus_id' => $alumnus->id],
                [
                    'position' => $emp['position'] ?? null,
                    'company' => $emp['company'] ?? null,
                    'org_type' => $emp['org_type'] ?? null,
                    'office_address' => $emp['office_address'] ?? null,
                    'office_contact' => $emp['office_contact'] ?? null,
                    'office_email' => $emp['office_email'] ?? null,
                    'start_date' => $emp['start_date'] ?? null,
                    'licenses' => $emp['licenses'] ?? null,
                    'achievements' => $emp['achievements'] ?? null,
                ]
            );

            // ✅ FIX: Replace post/continuing rows using enum values
            Education::where('alumnus_id', $alumnus->id)
                ->whereIn('context', ['post_ndmu', 'continuing'])
                ->delete();

            foreach (($validated['post'] ?? []) as $row) {
                if (!empty($row['degree']) || !empty($row['institution']) || !empty($row['year'])) {
                    Education::create([
                        'alumnus_id' => $alumnus->id,
                        'context' => 'post_ndmu', // you can change to 'continuing' if you add a toggle later
                        'level_label' => $row['degree'] ?? null,
                        'institution_name' => $row['institution'] ?? null,
                        'remarks' => $row['year'] ?? null,
                    ]);
                }
            }

            // Replace community rows
            CommunityInvolvement::where('alumnus_id', $alumnus->id)->delete();
            foreach (($validated['community'] ?? []) as $row) {
                if (!empty($row['organization']) || !empty($row['role']) || !empty($row['years_active'])) {
                    CommunityInvolvement::create([
                        'alumnus_id' => $alumnus->id,
                        'organization' => $row['organization'] ?? null,
                        'role' => $row['role'] ?? null,
                        'years_active' => $row['years_active'] ?? null,
                    ]);
                }
            }

            // Engagement options pivot
            $alumnus->engagementOptions()->sync($validated['engagement'] ?? []);

            // Consent
            Consent::updateOrCreate(
                ['alumnus_id' => $alumnus->id],
                [
                    'policy_version' => 'RA10173-v1',
                    'accepted' => true,
                    'accepted_at' => now(),
                    'accepted_ip' => request()->ip(),
                ]
            );
        });

        return redirect()->route('alumni.dashboard')
            ->with('status', 'Alumni Tracer form saved successfully.');
    }
}
