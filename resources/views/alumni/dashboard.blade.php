<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-semibold text-xl leading-tight text-green-900">
                    Alumni Dashboard
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Notre Dame of Marbel University — Office of Alumni Relations
                </p>
            </div>

            <a href="{{ route('alumni.intake') }}"
               class="inline-flex items-center px-4 py-2 rounded-lg font-semibold text-xs uppercase tracking-widest
                      bg-green-800 text-white hover:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2 transition">
                Complete / Update Tracer
            </a>
        </div>
    </x-slot>

    <div class="py-6 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold
                                bg-yellow-100 text-yellow-800 border border-yellow-200">
                        NDMU Alumni Portal
                    </div>

                    <div class="text-lg font-semibold text-gray-900">
                        Welcome, {{ auth()->user()->name }}!
                    </div>

                    <div class="text-sm text-gray-700">
                        You are logged in using:
                        <span class="font-medium">{{ auth()->user()->email }}</span>
                    </div>

                    <div class="text-sm text-gray-600 leading-relaxed">
                        Please proceed to complete or update your <span class="font-semibold text-green-900">Alumni Tracer Record</span>.
                        This information supports alumni engagement, reporting, and official communications of the University.
                    </div>

                    <div class="pt-2 flex flex-wrap gap-3">
                        <a href="{{ route('alumni.intake') }}"
                           class="inline-flex items-center px-4 py-2 rounded-lg font-semibold text-xs uppercase tracking-widest
                                  bg-green-800 text-white hover:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2 transition">
                            Go to Alumni Intake Form
                        </a>

                        <a href="{{ route('profile.edit') }}"
                           class="inline-flex items-center px-4 py-2 rounded-lg font-semibold text-xs uppercase tracking-widest
                                  bg-yellow-500 text-white hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition">
                            Edit Profile
                        </a>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md
                                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-700">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Quick Info Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                    <div class="p-5">
                        <div class="text-sm font-semibold text-green-900 mb-1">Tracer Record</div>
                        <div class="text-sm text-gray-600">
                            Keep your personal, academic, and employment information updated for alumni tracking.
                        </div>
                    </div>
                    <div class="px-5 pb-5">
                        <a href="{{ route('alumni.intake') }}"
                           class="text-sm font-semibold text-green-800 hover:text-green-900">
                            Open Intake Form →
                        </a>
                    </div>
                </div>

                <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                    <div class="p-5">
                        <div class="text-sm font-semibold text-yellow-700 mb-1">Data Privacy</div>
                        <div class="text-sm text-gray-600">
                            Information is collected for alumni record keeping and communication in compliance with RA 10173.
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                    <div class="p-5">
                        <div class="text-sm font-semibold text-green-900 mb-1">Announcements</div>
                        <div class="text-sm text-gray-600">
                            Official alumni updates and event notices will appear in this portal in future releases.
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
