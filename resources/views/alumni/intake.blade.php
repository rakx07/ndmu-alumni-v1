{{-- resources/views/alumni/intake.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Alumni Tracer Intake Form
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Please complete the required fields. You may update this information anytime.
                </p>
            </div>
        </div>
    </x-slot>

    @php
        /**
         * UI helpers (Tailwind)
         */
        $inputBase = 'w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500';
        $selectBase = 'w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500';
        $card = 'rounded-xl border border-gray-200 bg-white p-5 sm:p-6';
        $cardTitle = 'text-base sm:text-lg font-semibold text-gray-900';
        $cardDesc = 'text-sm text-gray-600';
        $grid2 = 'grid grid-cols-1 md:grid-cols-2 gap-4';
        $grid3 = 'grid grid-cols-1 md:grid-cols-3 gap-3';
    @endphp

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-5 sm:p-8 space-y-8">

                <form method="POST" action="{{ route('alumni.intake.update') }}" class="space-y-8">
                    @csrf

                    {{-- TRACK --}}
                    <section class="{{ $card }}">
                        <div class="flex flex-col gap-1 mb-4">
                            <h3 class="{{ $cardTitle }}">Track / Level</h3>
                            <p class="{{ $cardDesc }}">Select the level where you were enrolled at NDMU.</p>
                        </div>

                        <div>
                            <x-input-label for="track" value="Track / Level" />
                            @php($t = old('track', $alumnus->track ?? null))
                            <select id="track" name="track" class="{{ $selectBase }}">
                                <option value="college" @selected($t==='college')>College</option>
                                <option value="grad_law" @selected($t==='grad_law')>Graduate School / Law School</option>
                                <option value="elementary" @selected($t==='elementary')>Elementary</option>
                                <option value="jhs_shs" @selected($t==='jhs_shs')>Junior / Senior High School</option>
                            </select>
                            <x-input-error :messages="$errors->get('track')" class="mt-2" />
                        </div>
                    </section>

                    {{-- PERSONAL INFORMATION --}}
                    <section class="{{ $card }}">
                        <div class="flex flex-col gap-1 mb-4">
                            <h3 class="{{ $cardTitle }}">I. Personal Information</h3>
                            <p class="{{ $cardDesc }}">Provide your basic personal details.</p>
                        </div>

                        <div class="{{ $grid2 }}">
                            <div>
                                <x-input-label value="Full Name" />
                                <x-text-input class="{{ $inputBase }}" name="full_name"
                                    value="{{ old('full_name', $alumnus->full_name ?? '') }}" required />
                                <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label value="Nickname" />
                                <x-text-input class="{{ $inputBase }}" name="nickname"
                                    value="{{ old('nickname', $alumnus->nickname ?? '') }}" />
                            </div>

                            <div>
                                <x-input-label value="Sex" />
                                @php($sx = old('sex', $alumnus->sex ?? ''))
                                <select name="sex" class="{{ $selectBase }}">
                                    <option value="">—</option>
                                    <option value="Male" @selected($sx==='Male')>Male</option>
                                    <option value="Female" @selected($sx==='Female')>Female</option>
                                    <option value="Prefer not to say" @selected($sx==='Prefer not to say')>Prefer not to say</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label value="Date of Birth" />
                                <x-text-input class="{{ $inputBase }}" type="date" name="date_of_birth"
                                    value="{{ old('date_of_birth', isset($alumnus->date_of_birth) ? \Carbon\Carbon::parse($alumnus->date_of_birth)->format('Y-m-d') : '') }}" />
                            </div>

                            <div>
                                <x-input-label value="Civil Status" />
                                @php($cs = old('civil_status', $alumnus->civil_status ?? ''))
                                <select name="civil_status" class="{{ $selectBase }}">
                                    <option value="">—</option>
                                    <option value="Single" @selected($cs==='Single')>Single</option>
                                    <option value="Married" @selected($cs==='Married')>Married</option>
                                    <option value="Widowed" @selected($cs==='Widowed')>Widowed</option>
                                    <option value="Separated" @selected($cs==='Separated')>Separated</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label value="Student Number (if known)" />
                                <x-text-input class="{{ $inputBase }}" name="student_number"
                                    value="{{ old('student_number', $alumnus->student_number ?? '') }}" />
                            </div>

                            <div>
                                <x-input-label value="Nationality" />
                                <x-text-input class="{{ $inputBase }}" name="nationality"
                                    value="{{ old('nationality', $alumnus->nationality ?? '') }}" />
                            </div>

                            <div>
                                <x-input-label value="Religion" />
                                <x-text-input class="{{ $inputBase }}" name="religion"
                                    value="{{ old('religion', $alumnus->religion ?? '') }}" />
                            </div>

                            <div>
                                <x-input-label value="Contact Number" />
                                <x-text-input class="{{ $inputBase }}" name="contact_number"
                                    value="{{ old('contact_number', $profile->contact_number ?? '') }}" />
                            </div>

                            <div>
                                <x-input-label value="Email Address" />
                                <x-text-input class="{{ $inputBase }}" type="email" name="email"
                                    value="{{ old('email', $profile->email ?? '') }}" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label value="Facebook / Social Media Handle" />
                                <x-text-input class="{{ $inputBase }}" name="facebook_handle"
                                    value="{{ old('facebook_handle', $profile->facebook_handle ?? '') }}" />
                            </div>
                        </div>
                    </section>

                    {{-- ADDRESSES --}}
                    <section class="{{ $card }}">
                        <div class="flex flex-col gap-1 mb-4">
                            <h3 class="{{ $cardTitle }}">Address Information</h3>
                            <p class="{{ $cardDesc }}">Provide your permanent address and current address (if different).</p>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <div class="font-semibold text-gray-900">Permanent Address</div>

                                <x-text-input class="{{ $inputBase }}" name="permanent[line1]" placeholder="Line 1"
                                    value="{{ old('permanent.line1', $permanent->line1 ?? '') }}" />
                                <x-text-input class="{{ $inputBase }}" name="permanent[line2]" placeholder="Line 2"
                                    value="{{ old('permanent.line2', $permanent->line2 ?? '') }}" />

                                <div class="{{ $grid2 }}">
                                    <x-text-input class="{{ $inputBase }}" name="permanent[city]" placeholder="City"
                                        value="{{ old('permanent.city', $permanent->city ?? '') }}" />
                                    <x-text-input class="{{ $inputBase }}" name="permanent[province]" placeholder="Province"
                                        value="{{ old('permanent.province', $permanent->province ?? '') }}" />
                                </div>

                                <div class="{{ $grid2 }}">
                                    <x-text-input class="{{ $inputBase }}" name="permanent[country]" placeholder="Country"
                                        value="{{ old('permanent.country', $permanent->country ?? '') }}" />
                                    <x-text-input class="{{ $inputBase }}" name="permanent[postal_code]" placeholder="Postal Code"
                                        value="{{ old('permanent.postal_code', $permanent->postal_code ?? '') }}" />
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="font-semibold text-gray-900">Current Address (if different)</div>

                                <x-text-input class="{{ $inputBase }}" name="current[line1]" placeholder="Line 1"
                                    value="{{ old('current.line1', $current->line1 ?? '') }}" />
                                <x-text-input class="{{ $inputBase }}" name="current[line2]" placeholder="Line 2"
                                    value="{{ old('current.line2', $current->line2 ?? '') }}" />

                                <div class="{{ $grid2 }}">
                                    <x-text-input class="{{ $inputBase }}" name="current[city]" placeholder="City"
                                        value="{{ old('current.city', $current->city ?? '') }}" />
                                    <x-text-input class="{{ $inputBase }}" name="current[province]" placeholder="Province"
                                        value="{{ old('current.province', $current->province ?? '') }}" />
                                </div>

                                <div class="{{ $grid2 }}">
                                    <x-text-input class="{{ $inputBase }}" name="current[country]" placeholder="Country"
                                        value="{{ old('current.country', $current->country ?? '') }}" />
                                    <x-text-input class="{{ $inputBase }}" name="current[postal_code]" placeholder="Postal Code"
                                        value="{{ old('current.postal_code', $current->postal_code ?? '') }}" />
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- NDMU EDUCATION --}}
                    <section class="{{ $card }}">
                        <div class="flex flex-col gap-1 mb-4">
                            <h3 class="{{ $cardTitle }}">II. Academic / NDMU Information</h3>
                            <p class="{{ $cardDesc }}">Complete fields that apply to your selected track.</p>
                        </div>

                        <div class="{{ $grid2 }}">
                            <div>
                                <x-input-label value="College (if applicable)" />
                                <select name="ndmu[college_id]" class="{{ $selectBase }}">
                                    <option value="">—</option>
                                    @foreach(($colleges ?? []) as $c)
                                        <option value="{{ $c->id }}"
                                            @selected(old('ndmu.college_id', $ndmuEducation->college_id ?? null) == $c->id)>
                                            {{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label value="Program / Degree (if applicable)" />
                                <select name="ndmu[program_id]" class="{{ $selectBase }}">
                                    <option value="">—</option>
                                    @foreach(($programs ?? []) as $p)
                                        <option value="{{ $p->id }}"
                                            @selected(old('ndmu.program_id', $ndmuEducation->program_id ?? null) == $p->id)>
                                            {{ $p->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label value="Strand (for SHS only)" />
                                <select name="ndmu[strand_id]" class="{{ $selectBase }}">
                                    <option value="">—</option>
                                    @foreach(($strands ?? []) as $s)
                                        <option value="{{ $s->id }}"
                                            @selected(old('ndmu.strand_id', $ndmuEducation->strand_id ?? null) == $s->id)>
                                            {{ $s->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label value="Year Entered" />
                                <x-text-input class="{{ $inputBase }}" name="ndmu[year_entered]"
                                    value="{{ old('ndmu.year_entered', $ndmuEducation->year_entered ?? '') }}" />
                            </div>

                            <div>
                                <x-input-label value="Year Graduated / Last Year Attended" />
                                <x-text-input class="{{ $inputBase }}" name="ndmu[year_graduated]"
                                    value="{{ old('ndmu.year_graduated', $ndmuEducation->year_graduated ?? '') }}" />
                            </div>

                            <div>
                                <x-input-label value="Honors / Awards (if any)" />
                                <x-text-input class="{{ $inputBase }}" name="ndmu[honors]"
                                    value="{{ old('ndmu.honors', $ndmuEducation->honors ?? '') }}" />
                            </div>
                        </div>
                    </section>

                    {{-- POST-NDMU EDUCATION (BULLETPROOF) --}}
                    <section class="{{ $card }}">
                        <div class="flex flex-col gap-1 mb-4">
                            <h3 class="{{ $cardTitle }}">IV. Post-Graduate / Continuing Education (After NDMU)</h3>
                            <p class="{{ $cardDesc }}">Add degrees, courses, or certifications completed after NDMU.</p>
                        </div>

                        @php($postRows = old('post'))

                        @php(
                            $postRows = is_array($postRows)
                                ? $postRows
                                : collect($postEducations ?? $post_educations ?? $postEdu ?? [])->map(function ($e) {
                                    return [
                                        'degree' => $e->level_label ?? $e->degree ?? '',
                                        'institution' => $e->institution_name ?? $e->institution ?? '',
                                        'year' => $e->remarks ?? $e->year ?? '',
                                    ];
                                })->values()->toArray()
                        )

                        @php(
                            $postRows = !empty($postRows)
                                ? $postRows
                                : [['degree' => '', 'institution' => '', 'year' => '']]
                        )

                        <div id="postWrap" class="space-y-3">
                            @foreach(($postRows ?? [['degree'=>'','institution'=>'','year'=>'']]) as $i => $row)
                                <div class="post-row rounded-lg border border-gray-200 p-4">
                                    <div class="{{ $grid3 }}">
                                        <x-text-input class="{{ $inputBase }}" name="post[{{ $i }}][degree]"
                                            placeholder="Course / Degree" value="{{ $row['degree'] ?? '' }}" />
                                        <x-text-input class="{{ $inputBase }}" name="post[{{ $i }}][institution]"
                                            placeholder="Institution" value="{{ $row['institution'] ?? '' }}" />
                                        <x-text-input class="{{ $inputBase }}" name="post[{{ $i }}][year]"
                                            placeholder="Year Completed / In Progress" value="{{ $row['year'] ?? '' }}" />
                                    </div>

                                    <div class="mt-3 flex justify-end">
                                        <button type="button" class="remove-row text-sm text-rose-600 hover:text-rose-700 font-medium">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <button type="button" id="addPost"
                                class="inline-flex items-center gap-2 text-sm font-medium text-indigo-600 hover:text-indigo-700">
                                <span>+ Add another</span>
                            </button>
                        </div>

                        <template id="postTemplate">
                            <div class="post-row rounded-lg border border-gray-200 p-4">
                                <div class="{{ $grid3 }}">
                                    <input class="{{ $inputBase }}" name="__NAME__[degree]" placeholder="Course / Degree" />
                                    <input class="{{ $inputBase }}" name="__NAME__[institution]" placeholder="Institution" />
                                    <input class="{{ $inputBase }}" name="__NAME__[year]" placeholder="Year Completed / In Progress" />
                                </div>
                                <div class="mt-3 flex justify-end">
                                    <button type="button" class="remove-row text-sm text-rose-600 hover:text-rose-700 font-medium">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </template>
                    </section>

                    {{-- COMMUNITY (also bulletproof) --}}
                    <section class="{{ $card }}">
                        <div class="flex flex-col gap-1 mb-4">
                            <h3 class="{{ $cardTitle }}">V. Community Involvement & Affiliations</h3>
                            <p class="{{ $cardDesc }}">Organizations you belong to, roles, and years active.</p>
                        </div>

                        @php($commRows = old('community'))

                        @php(
                            $commRows = is_array($commRows)
                                ? $commRows
                                : collect($community ?? $communityRows ?? $community_items ?? [])->map(function ($c) {
                                    return [
                                        'organization' => $c->organization ?? $c->organization_name ?? '',
                                        'role' => $c->role ?? '',
                                        'years_active' => $c->years_active ?? '',
                                    ];
                                })->values()->toArray()
                        )

                        @php(
                            $commRows = !empty($commRows)
                                ? $commRows
                                : [['organization' => '', 'role' => '', 'years_active' => '']]
                        )

                        <div id="commWrap" class="space-y-3">
                            @foreach(($commRows ?? [['organization'=>'','role'=>'','years_active'=>'']]) as $i => $row)
                                <div class="comm-row rounded-lg border border-gray-200 p-4">
                                    <div class="{{ $grid3 }}">
                                        <x-text-input class="{{ $inputBase }}" name="community[{{ $i }}][organization]"
                                            placeholder="Organization / Association" value="{{ $row['organization'] ?? '' }}" />
                                        <x-text-input class="{{ $inputBase }}" name="community[{{ $i }}][role]"
                                            placeholder="Role / Position" value="{{ $row['role'] ?? '' }}" />
                                        <x-text-input class="{{ $inputBase }}" name="community[{{ $i }}][years_active]"
                                            placeholder="Years Active" value="{{ $row['years_active'] ?? '' }}" />
                                    </div>

                                    <div class="mt-3 flex justify-end">
                                        <button type="button" class="remove-row text-sm text-rose-600 hover:text-rose-700 font-medium">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <button type="button" id="addComm"
                                class="inline-flex items-center gap-2 text-sm font-medium text-indigo-600 hover:text-indigo-700">
                                <span>+ Add another</span>
                            </button>
                        </div>

                        <template id="commTemplate">
                            <div class="comm-row rounded-lg border border-gray-200 p-4">
                                <div class="{{ $grid3 }}">
                                    <input class="{{ $inputBase }}" name="__NAME__[organization]" placeholder="Organization / Association" />
                                    <input class="{{ $inputBase }}" name="__NAME__[role]" placeholder="Role / Position" />
                                    <input class="{{ $inputBase }}" name="__NAME__[years_active]" placeholder="Years Active" />
                                </div>
                                <div class="mt-3 flex justify-end">
                                    <button type="button" class="remove-row text-sm text-rose-600 hover:text-rose-700 font-medium">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </template>
                    </section>

                    {{-- ✅ EMPLOYMENT STATUS + EMPLOYMENTS (NEW) --}}
                    <section class="{{ $card }}">
                        <div class="flex flex-col gap-1 mb-4">
                            <h3 class="{{ $cardTitle }}">VI. Employment Information</h3>
                            <p class="{{ $cardDesc }}">Tell us your current employment status and (if applicable) your employment details.</p>
                        </div>

                        {{-- Employment Status (encoded by alumna/alumnus) --}}
                        <div class="{{ $grid2 }} mb-4">
                            <div class="md:col-span-2">
                                <x-input-label value="Employment Status" />
                                @php($empStatus = old('employment_status', $employment_status ?? $profile->employment_status ?? $alumnus->employment_status ?? ''))
                                <select name="employment_status" id="employment_status" class="{{ $selectBase }}">
                                    <option value="">—</option>
                                    <option value="employed" @selected($empStatus==='employed')>Employed</option>
                                    <option value="self_employed" @selected($empStatus==='self_employed')>Self-employed / Freelancer</option>
                                    <option value="business_owner" @selected($empStatus==='business_owner')>Business Owner</option>
                                    <option value="unemployed" @selected($empStatus==='unemployed')>Unemployed</option>
                                    <option value="student" @selected($empStatus==='student')>Student</option>
                                    <option value="ofw" @selected($empStatus==='ofw')>OFW</option>
                                    <option value="retired" @selected($empStatus==='retired')>Retired</option>
                                    <option value="prefer_not_to_say" @selected($empStatus==='prefer_not_to_say')>Prefer not to say</option>
                                </select>
                                <x-input-error :messages="$errors->get('employment_status')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Employment rows --}}
                        @php($empRows = old('employment'))

                        @php(
                            $empRows = is_array($empRows)
                                ? $empRows
                                : collect($employments ?? $employmentRows ?? $employment_items ?? [])->map(function ($e) {
                                    return [
                                        'position' => $e->position ?? '',
                                        'company' => $e->company ?? '',
                                        'org_type' => $e->org_type ?? '',
                                        'office_address' => $e->office_address ?? '',
                                        'office_contact' => $e->office_contact ?? '',
                                        'office_email' => $e->office_email ?? '',
                                        'start_date' => $e->start_date ?? '',
                                        'licenses' => $e->licenses ?? '',
                                        'achievements' => $e->achievements ?? '',
                                    ];
                                })->values()->toArray()
                        )

                        @php(
                            $empRows = !empty($empRows)
                                ? $empRows
                                : [[
                                    'position' => '',
                                    'company' => '',
                                    'org_type' => '',
                                    'office_address' => '',
                                    'office_contact' => '',
                                    'office_email' => '',
                                    'start_date' => '',
                                    'licenses' => '',
                                    'achievements' => '',
                                ]]
                        )

                        <div id="empWrap" class="space-y-3">
                            @foreach(($empRows ?? []) as $i => $row)
                                <div class="emp-row rounded-lg border border-gray-200 p-4">
                                    <div class="{{ $grid2 }}">
                                        <div class="md:col-span-2">
                                            <x-input-label value="Position" />
                                            <x-text-input class="{{ $inputBase }}" name="employment[{{ $i }}][position]"
                                                value="{{ $row['position'] ?? '' }}" placeholder="e.g., IT Officer, Teacher, Engineer" />
                                        </div>

                                        <div class="md:col-span-2">
                                            <x-input-label value="Company / Organization" />
                                            <x-text-input class="{{ $inputBase }}" name="employment[{{ $i }}][company]"
                                                value="{{ $row['company'] ?? '' }}" placeholder="e.g., NDMU, ABC Corp" />
                                        </div>

                                        <div>
                                            <x-input-label value="Organization Type" />
                                            @php($ot = $row['org_type'] ?? '')
                                            <select name="employment[{{ $i }}][org_type]" class="{{ $selectBase }}">
                                                <option value="">—</option>
                                                <option value="government" @selected($ot==='government')>Government</option>
                                                <option value="private" @selected($ot==='private')>Private</option>
                                                <option value="ngo" @selected($ot==='ngo')>NGO</option>
                                                <option value="academe" @selected($ot==='academe')>Academe</option>
                                                <option value="self-employed" @selected($ot==='self-employed')>Self-employed</option>
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label value="Start Date" />
                                            <x-text-input class="{{ $inputBase }}" type="date" name="employment[{{ $i }}][start_date]"
                                                value="{{ $row['start_date'] ?? '' }}" />
                                        </div>

                                        <div class="md:col-span-2">
                                            <x-input-label value="Office Address" />
                                            <textarea class="{{ $inputBase }}" rows="3" name="employment[{{ $i }}][office_address]"
                                                placeholder="Office Address">{{ $row['office_address'] ?? '' }}</textarea>
                                        </div>

                                        <div>
                                            <x-input-label value="Office Contact" />
                                            <x-text-input class="{{ $inputBase }}" name="employment[{{ $i }}][office_contact]"
                                                value="{{ $row['office_contact'] ?? '' }}" placeholder="Contact number" />
                                        </div>

                                        <div>
                                            <x-input-label value="Office Email" />
                                            <x-text-input class="{{ $inputBase }}" type="email" name="employment[{{ $i }}][office_email]"
                                                value="{{ $row['office_email'] ?? '' }}" placeholder="email@company.com" />
                                        </div>

                                        <div class="md:col-span-2">
                                            <x-input-label value="Licenses / Certifications" />
                                            <x-text-input class="{{ $inputBase }}" name="employment[{{ $i }}][licenses]"
                                                value="{{ $row['licenses'] ?? '' }}" placeholder="e.g., PRC, TESDA, CCNA" />
                                        </div>

                                        <div class="md:col-span-2">
                                            <x-input-label value="Achievements" />
                                            <x-text-input class="{{ $inputBase }}" name="employment[{{ $i }}][achievements]"
                                                value="{{ $row['achievements'] ?? '' }}" placeholder="Awards, milestones, recognitions" />
                                        </div>
                                    </div>

                                    <div class="mt-3 flex justify-end">
                                        <button type="button" class="remove-row text-sm text-rose-600 hover:text-rose-700 font-medium">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <button type="button" id="addEmp"
                                class="inline-flex items-center gap-2 text-sm font-medium text-indigo-600 hover:text-indigo-700">
                                <span>+ Add another employment</span>
                            </button>
                        </div>

                        <template id="empTemplate">
                            <div class="emp-row rounded-lg border border-gray-200 p-4">
                                <div class="{{ $grid2 }}">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                                        <input class="{{ $inputBase }}" name="__NAME__[position]" placeholder="e.g., IT Officer, Teacher, Engineer" />
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Company / Organization</label>
                                        <input class="{{ $inputBase }}" name="__NAME__[company]" placeholder="e.g., NDMU, ABC Corp" />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Organization Type</label>
                                        <select class="{{ $selectBase }}" name="__NAME__[org_type]">
                                            <option value="">—</option>
                                            <option value="government">Government</option>
                                            <option value="private">Private</option>
                                            <option value="ngo">NGO</option>
                                            <option value="academe">Academe</option>
                                            <option value="self-employed">Self-employed</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                        <input class="{{ $inputBase }}" type="date" name="__NAME__[start_date]" />
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Office Address</label>
                                        <textarea class="{{ $inputBase }}" rows="3" name="__NAME__[office_address]" placeholder="Office Address"></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Office Contact</label>
                                        <input class="{{ $inputBase }}" name="__NAME__[office_contact]" placeholder="Contact number" />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Office Email</label>
                                        <input class="{{ $inputBase }}" type="email" name="__NAME__[office_email]" placeholder="email@company.com" />
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Licenses / Certifications</label>
                                        <input class="{{ $inputBase }}" name="__NAME__[licenses]" placeholder="e.g., PRC, TESDA, CCNA" />
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Achievements</label>
                                        <input class="{{ $inputBase }}" name="__NAME__[achievements]" placeholder="Awards, milestones, recognitions" />
                                    </div>
                                </div>

                                <div class="mt-3 flex justify-end">
                                    <button type="button" class="remove-row text-sm text-rose-600 hover:text-rose-700 font-medium">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </template>
                    </section>

                    {{-- CONSENT --}}
                    <section class="{{ $card }}">
                        <div class="flex flex-col gap-1 mb-4">
                            <h3 class="{{ $cardTitle }}">Consent and Signature</h3>
                            <p class="{{ $cardDesc }}">Required to proceed.</p>
                        </div>

                        <label class="flex items-start gap-3 rounded-lg border border-gray-200 p-4 bg-gray-50">
                            <input type="checkbox" name="consent" value="1"
                                   class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                   required
                                   @checked(old('consent'))>
                            <span class="text-sm text-gray-700 leading-relaxed">
                                I certify that the information provided is true and correct. I authorize Notre Dame of Marbel University Alumni Relations Office to collect, store, and process my personal data in accordance with the Data Privacy Act of 2012 (RA 10173) for alumni record keeping, networking, research, and communication purposes.
                            </span>
                        </label>

                        <x-input-error :messages="$errors->get('consent')" class="mt-2" />
                    </section>

                    <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3">
                        <x-primary-button class="justify-center sm:justify-start">
                            Save Tracer Record
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- JS for Add/Remove rows --}}
    <script>
        (function () {
            const postWrap = document.getElementById('postWrap');
            const addPost = document.getElementById('addPost');
            const postTemplate = document.getElementById('postTemplate');

            const commWrap = document.getElementById('commWrap');
            const addComm = document.getElementById('addComm');
            const commTemplate = document.getElementById('commTemplate');

            const empWrap = document.getElementById('empWrap');
            const addEmp = document.getElementById('addEmp');
            const empTemplate = document.getElementById('empTemplate');

            function escapeRegExp(str) {
                return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            }

            function nextIndexFromInputs(container, prefix) {
                const inputs = container.querySelectorAll('input[name^="' + prefix + '["], textarea[name^="' + prefix + '["], select[name^="' + prefix + '["]');
                let max = -1;

                inputs.forEach((el) => {
                    const re = new RegExp('^' + escapeRegExp(prefix) + '\\[(\\d+)\\]');
                    const m = el.name.match(re);
                    if (m && m[1]) max = Math.max(max, parseInt(m[1], 10));
                });

                return max + 1;
            }

            function addRow(container, tpl, prefix) {
                if (!container || !tpl) return;

                const i = nextIndexFromInputs(container, prefix);
                const html = tpl.innerHTML.replaceAll('__NAME__', `${prefix}[${i}]`);

                const wrapper = document.createElement('div');
                wrapper.innerHTML = html.trim();
                container.appendChild(wrapper.firstElementChild);
            }

            function bindRemove(container, ensureOneBlankCb) {
                if (!container) return;

                container.addEventListener('click', (e) => {
                    const btn = e.target.closest('.remove-row');
                    if (!btn) return;

                    const row = btn.closest('.post-row, .comm-row, .emp-row');
                    if (!row) return;

                    row.remove();

                    if (container.children.length === 0 && typeof ensureOneBlankCb === 'function') {
                        ensureOneBlankCb();
                    }
                });
            }

            addPost?.addEventListener('click', () => addRow(postWrap, postTemplate, 'post'));
            addComm?.addEventListener('click', () => addRow(commWrap, commTemplate, 'community'));
            addEmp?.addEventListener('click', () => addRow(empWrap, empTemplate, 'employment'));

            bindRemove(postWrap, () => addRow(postWrap, postTemplate, 'post'));
            bindRemove(commWrap, () => addRow(commWrap, commTemplate, 'community'));
            bindRemove(empWrap, () => addRow(empWrap, empTemplate, 'employment'));
        })();
    </script>
</x-app-layout>
