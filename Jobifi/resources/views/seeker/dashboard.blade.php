@extends('master_index')

@section('title', 'Seeker Dashboard')

@section('content')

<div class="space-y-6">

    {{-- Welcome Section --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h1 class="page-heading">
            Welcome Back, {{ Auth::user()->name }} 👋
        </h1>
        <p class="page-subheading mt-2">
            Find and apply for your dream job today.
        </p>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Applied Jobs</h3>
            <p class="text-3xl font-bold text-blue-600">12</p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Saved Jobs</h3>
            <p class="text-3xl font-bold text-green-600">8</p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Interview Invites</h3>
            <p class="text-3xl font-bold text-purple-600">3</p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Profile Strength</h3>
            <p class="text-3xl font-bold text-orange-600">85%</p>
        </div>

    </div>

    {{-- Recommended Jobs --}}
    <div class="bg-white rounded-xl shadow p-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-base font-semibold text-gray-900">
                Recommended Jobs
            </h2>
            <a href="#" class="text-sm text-gray-500 hover:text-gray-800 transition">
                View All
            </a>
        </div>

        <div class="space-y-3">

            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-900">
                    Software Developer Intern
                </h3>
                <p class="text-sm text-gray-500 mt-0.5">
                    ABC Technologies • Agartala
                </p>
            </div>

            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-900">
                    Frontend Developer
                </h3>
                <p class="text-sm text-gray-500 mt-0.5">
                    XYZ Solutions • Remote
                </p>
            </div>

        </div>

    </div>

    {{-- Recent Applications --}}
    <div class="bg-white rounded-xl shadow p-6">

        <h2 class="text-base font-semibold text-gray-900 mb-4">
            Recent Applications
        </h2>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Job Title</th>
                        <th class="text-left py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Company</th>
                        <th class="text-left py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                    </tr>
                </thead>

                <tbody>

                    <tr class="border-b border-gray-100">
                        <td class="py-3 text-sm text-gray-800">Software Engineer</td>
                        <td class="py-3 text-sm text-gray-500">ABC Technologies</td>
                        <td class="py-3 text-sm text-yellow-600 font-medium">
                            Under Review
                        </td>
                    </tr>

                    <tr>
                        <td class="py-3 text-sm text-gray-800">Web Developer</td>
                        <td class="py-3 text-sm text-gray-500">XYZ Solutions</td>
                        <td class="py-3 text-sm text-green-600 font-medium">
                            Shortlisted
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
