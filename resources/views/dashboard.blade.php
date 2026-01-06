<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-green-900 leading-tight">
                {{ __('Alumni Dashboard') }}
            </h2>

            {{-- Quick action --}}
            @if (Route::has('alumni.intake'))
                <a href="{{ route('alumni.intake') }}"
                   class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md
                          font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-900
                          focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition">
                    Complete Alumni Tracer
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-8 border-green-800">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-green-900 mb-1">
                        Welcome to the NDMU Alumni Portal
                    </h3>
                    <p class="text-sm text-gray-700 leading-relaxed">
                        You are successfully logged in. This dashboard allows you to manage your alumni information,
                        complete the Alumni Tracer Form, and stay connected with Notre Dame of Marbel University
                        through official alumni programs and announcements.
                    </p>
                </div>
            </div>

            {{-- Action Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Intake --}}
                <div class="bg-white shadow-sm rounded-lg border-t-4 border-green-800">
                    <div class="p-6">
                        <h4 class="font-semibold text-green-900 mb-2">
                            Alumni Tracer Form
                        </h4>
                        <p class="text-sm text-gray-600 mb-4">
                            Update your personal, academic, and employment information.
                            This data supports alumni tracking, reporting, and engagement initiatives.
                        </p>

                        @if (Route::has('alumni.intake'))
                            <a href="{{ route('alumni.intake') }}"
                               class="inline-flex items-center px-4 py-2 bg-green-800 text-white text-xs
                                      font-semibold rounded-md hover:bg-green-900 transition">
                                Go to Tracer Form
                            </a>
                        @else
                            <span class="text-xs text-red-600">
                                Intake form route not configured.
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Profile --}}
                <div class="bg-white shadow-sm rounded-lg border-t-4 border-yellow-500">
                    <div class="p-6">
                        <h4 class="font-semibold text-yellow-700 mb-2">
                            Account & Profile
                        </h4>
                        <p class="text-sm text-gray-600 mb-4">
                            Manage your account credentials and ensure your contact details
                            are accurate for official alumni communications.
                        </p>

                        <a href="{{ route('profile.edit') }}"
                           class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white text-xs
                                  font-semibold rounded-md hover:bg-yellow-600 transition">
                            Edit Profile
                        </a>
                    </div>
                </div>

                {{-- Information --}}
                <div class="bg-white shadow-sm rounded-lg border-t-4 border-green-700">
                    <div class="p-6">
                        <h4 class="font-semibold text-green-900 mb-2">
                            Alumni Programs & Updates
                        </h4>
                        <p class="text-sm text-gray-600">
                            Stay informed about alumni events, reunions, mentorship programs,
                            and University initiatives coordinated by the Office of Alumni Relations.
                        </p>
                    </div>
                </div>

            </div>

            {{-- Data Privacy Notice --}}
            <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-5">
                <h4 class="font-semibold text-yellow-800 mb-1">
                    Data Privacy Notice
                </h4>
                <p class="text-sm text-yellow-800 leading-relaxed">
                    Information submitted through this portal is processed solely for alumni record keeping,
                    communication, and program development purposes, in compliance with the
                    <strong>Data Privacy Act of 2012 (RA 10173)</strong>.
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
