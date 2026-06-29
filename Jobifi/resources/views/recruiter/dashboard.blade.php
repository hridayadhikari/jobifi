@extends('master_index')

@section('title', 'Recruiter Dashboard')

@section('content')

    <div class="bg-[#f8f9fa] min-h-screen font-sans py-12 px-6">

        <div class="max-w-[1200px] mx-auto">

            {{-- Page Header --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                <div>
                    <h1 class="text-[28px] font-extrabold text-[#0a192f] tracking-tight leading-none mb-2">
                        Recruiter Dashboard
                    </h1>
                    <p class="text-[13px] text-gray-500">
                        Welcome back! Here's what's happening with your jobs.
                    </p>
                </div>

                <a href="{{ route('recruiter.jobs.create') ?? '#' }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-black text-white text-[13px] font-bold hover:bg-[#1a1a1a] transition duration-200 shadow-sm">
                    <ion-icon name="add-outline" class="text-lg"></ion-icon>
                    Post New Job
                </a>
            </div>

            {{-- Top Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                {{-- Stat Card: Active Jobs --}}
                <div class="bg-white border border-gray-200 shadow-sm p-6 relative">
                    <ion-icon name="briefcase-outline" class="absolute top-6 right-6 text-xl text-gray-300"></ion-icon>
                    <h3 class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-4">
                        Active Jobs
                    </h3>
                    <p class="text-[32px] font-extrabold text-slate-900 leading-none">
                        {{ number_format($activeJobs) }}
                    </p>
                </div>

                {{-- Stat Card: Total Applicants --}}
                <div class="bg-white border border-gray-200 shadow-sm p-6 relative">
                    <ion-icon name="people-outline" class="absolute top-6 right-6 text-xl text-gray-300"></ion-icon>
                    <h3 class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-4">
                        Total Applicants
                    </h3>
                    <p class="text-[32px] font-extrabold text-slate-900 leading-none">
                        {{ number_format($totalApplicants) }}
                    </p>
                </div>

                {{-- Stat Card: Shortlisted / Reviewed --}}
                <div class="bg-white border border-gray-200 shadow-sm p-6 relative">
                    <ion-icon name="checkmark-circle-outline"
                        class="absolute top-6 right-6 text-xl text-gray-300"></ion-icon>
                    <h3 class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-4">
                        Reviewed Profiles
                    </h3>
                    <p class="text-[32px] font-extrabold text-slate-900 leading-none">
                        {{ number_format($shortlisted) }}
                    </p>
                </div>

                {{-- Stat Card: Interviews --}}
                <div class="bg-white border border-gray-200 shadow-sm p-6 relative">
                    <ion-icon name="calendar-outline" class="absolute top-6 right-6 text-xl text-gray-300"></ion-icon>
                    <h3 class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-4">
                        Interviews
                    </h3>
                    <p class="text-[32px] font-extrabold text-slate-900 leading-none">
                        {{ number_format($interviews) }}
                    </p>
                </div>

            </div>

            {{-- Main Content Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left Column: Recent Applications --}}
                <div class="lg:col-span-2 bg-white border border-gray-200 shadow-sm overflow-hidden h-fit">

                    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-[13px] font-bold text-[#0a192f] uppercase tracking-[0.1em]">
                            Recent Applications
                        </h2>
                        <a href="{{ route('recruiter.jobs.index') ?? '#' }}"
                            class="text-[11px] font-bold text-gray-400 hover:text-black uppercase tracking-widest transition">
                            View All
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-gray-50">
                                    <th class="px-8 py-4 text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em]">
                                        Applicant</th>
                                    <th class="px-8 py-4 text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em]">
                                        Job Title</th>
                                    <th class="px-8 py-4 text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em]">
                                        Status</th>
                                    <th class="px-8 py-4 text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em]">
                                        Applied</th>

                                </tr>
                            </thead>

                            @forelse($recentApplications as $app)
                                <tbody class="divide-y divide-gray-50">
                               
                                    @php

                                        $status = $app->status ?? 'pending';

                                    @endphp
                                    <tr class="hover:bg-gray-50/50 transition duration-200 group">
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-10 h-10 rounded bg-gray-50 border border-gray-200 flex items-center justify-center flex-shrink-0">
                                                    @if ($app->user->profile_photo)
                                                        <img src="{{ asset('storage/' . $app->user->profile_photo) }}"
                                                            class="w-full h-full object-cover object-top"
                                                            alt="{{ $app->user->name }}">
                                                    @else
                                                        <ion-icon name="person-outline" class="text-gray-400"></ion-icon>
                                                    @endif

                                                </div>
                                                <div>
                                                    <p
                                                        class="text-[14px] font-bold text-slate-900 group-hover:text-black transition">
                                                        {{ $app->user->name ?? 'Unknown Applicant' }}
                                                    </p>
                                                    <p class="text-[12px] text-gray-500 mt-0.5 truncate max-w-[150px]">
                                                        {{ $app->user->email ?? '' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 text-[14px] font-semibold text-slate-800">
                                            {{ $app->job->title ?? 'N/A' }}
                                        </td>
                                        <td class="px-8 py-5">
                                            @switch($status)
                                                @case('pending')
                                                    <span
                                                        class="inline-block px-3 py-1 bg-gray-100 text-slate-600 border border-gray-200 text-[10px] font-bold uppercase tracking-widest rounded-sm">
                                                        Pending
                                                    </span>
                                                @break

                                                @case('reviewed')
                                                    <span
                                                        class="inline-block px-3 py-1 bg-gray-800 text-white text-[10px] font-bold uppercase tracking-widest rounded-sm">
                                                        Reviewed
                                                    </span>
                                                @break

                                                @case('interview_scheduled')
                                                    <span
                                                        class="inline-block px-3 py-1 bg-blue-600 text-white text-[10px] font-bold uppercase tracking-widest rounded-sm">
                                                        Interview
                                                    </span>
                                                @break

                                                @case('accepted')
                                                    <span
                                                        class="inline-block px-3 py-1 bg-green-600 text-white text-[10px] font-bold uppercase tracking-widest rounded-sm">
                                                        Accepted
                                                    </span>
                                                @break

                                                @case('rejected')
                                                    <span
                                                        class="inline-block px-3 py-1 bg-red-600 text-white text-[10px] font-bold uppercase tracking-widest rounded-sm">
                                                        Rejected
                                                    </span>
                                                @break

                                                @default
                                                    <span
                                                        class="inline-block px-3 py-1 bg-gray-100 text-slate-600 border border-gray-200 text-[10px] font-bold uppercase tracking-widest rounded-sm">
                                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                                    </span>
                                            @endswitch
                                        </td>
                                        <td class="px-8 py-5 text-[13px] text-gray-500">
                                            {{ $app->created_at->diffForHumans() }}
                                        </td>

                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-8 py-16 text-center">
                                                <ion-icon name="document-text-outline"
                                                    class="text-4xl text-gray-300 mb-3"></ion-icon>
                                                <p class="text-[12px] font-bold text-gray-400 uppercase tracking-widest">
                                                    No recent applications
                                                </p>
                                            </td>
                                        </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>

                    </div>

                    {{-- Right Column Container --}}
                    <div class="space-y-8">

                        {{-- Quick Actions --}}
                        <div class="bg-white border border-gray-200 shadow-sm">
                            <div class="px-8 py-6 border-b border-gray-100">
                                <h2 class="text-[13px] font-bold text-[#0a192f] uppercase tracking-[0.1em]">
                                    Quick Actions
                                </h2>
                            </div>

                            <div class="p-8 space-y-4">
                                <a href="#"
                                    class="flex items-center gap-3 px-6 py-3.5 border border-black text-slate-900 hover:bg-gray-50 transition duration-200 group">
                                    <ion-icon name="mail-outline"
                                        class="text-xl text-gray-500 group-hover:text-black transition"></ion-icon>
                                    <span class="text-[13px] font-bold">Message Applicants</span>
                                </a>

                                <a href="#"
                                    class="flex items-center gap-3 px-6 py-3.5 border border-black text-slate-900 hover:bg-gray-50 transition duration-200 group">
                                    <ion-icon name="download-outline"
                                        class="text-xl text-gray-500 group-hover:text-black transition"></ion-icon>
                                    <span class="text-[13px] font-bold">Export Report</span>
                                </a>

                                <a href="{{ route('recruiter.profile.show') }}"
                                    class="flex items-center gap-3 px-6 py-3.5 border border-black text-slate-900 hover:bg-gray-50 transition duration-200 group">
                                    <ion-icon name="business-outline"
                                        class="text-xl text-gray-500 group-hover:text-black transition"></ion-icon>
                                    <span class="text-[13px] font-bold">Company Profile</span>
                                </a>
                            </div>
                        </div>

                        {{-- Upcoming Interviews --}}
                        <div class="bg-white border border-gray-200 shadow-sm">
                            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                                <h2 class="text-[13px] font-bold text-[#0a192f] uppercase tracking-[0.1em]">
                                    Upcoming Interviews
                                </h2>
                            </div>

                            <div class="divide-y divide-gray-100">
                                @forelse($upcomingInterviews as $interview)
                                    <div class="p-6 hover:bg-gray-50/50 transition duration-200 group">
                                        <div class="flex justify-between items-start mb-3">
                                            <div>
                                                <h3
                                                    class="text-[14px] font-bold text-slate-900 group-hover:text-black transition">
                                                    {{ $interview->application->user->name ?? 'Candidate' }}
                                                </h3>
                                                <p class="text-[12px] font-semibold text-gray-500 mt-0.5">
                                                    {{ $interview->application->job->title ?? 'Position' }}
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-[11px] font-bold text-black uppercase tracking-widest">
                                                    {{ $interview->interview_at->format('M d') }}
                                                </p>
                                                <p class="text-[12px] font-semibold text-gray-500 mt-0.5">
                                                    {{ $interview->interview_at->format('h:i A') }}
                                                </p>
                                            </div>
                                        </div>

                                        @if ($interview->meeting_link)
                                            <a href="{{ $interview->meeting_link }}" target="_blank"
                                                class="inline-flex items-center gap-1.5 text-[11px] font-bold text-slate-500 border-b border-slate-300 pb-0.5 hover:text-black hover:border-black transition duration-200">
                                                <ion-icon name="videocam-outline" class="text-sm"></ion-icon>
                                                Join Meeting
                                            </a>
                                        @endif
                                    </div>
                                @empty
                                    <div class="p-8 text-center">
                                        <ion-icon name="calendar-clear-outline"
                                            class="text-3xl text-gray-300 mb-2"></ion-icon>
                                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                                            No scheduled interviews
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    @endsection
