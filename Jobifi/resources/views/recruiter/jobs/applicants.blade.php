@extends('master_index')

@section('title', 'Job Applicants')

@section('content')

    <div class="p-8">

        {{-- Top Bar: Header & Actions --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-6">

            {{-- Job Context Header --}}
            <div>
                {{-- Back Navigation --}}
                <a href="{{route('recruiter.jobs.index')}}"
                    class="inline-flex items-center gap-2 text-[11px] font-bold text-gray-400 hover:text-black uppercase tracking-wider transition mb-4">
                    <ion-icon name="arrow-back-outline" class="text-lg"></ion-icon>
                    Back to Jobs
                </a>

                <h1 class="text-3xl font-bold text-slate-900 uppercase tracking-tight">
                    {{ $job->title ?? 'Job Title' }}
                </h1>

                <div class="flex items-center gap-2 text-xs font-semibold text-gray-500 uppercase tracking-wide mt-2">
                    <ion-icon name="location-outline" class="text-sm"></ion-icon>
                    <span>{{ $job->location ?? 'Location Not Specified' }}</span>
                    <span class="text-gray-300">&bull;</span>
                    <span>{{ $job->type ?? 'Type Not Specified' }}</span>
                    <span class="text-gray-300">&bull;</span>
                    <span class="text-black">{{ $applications->total() ?? '0' }} Applicants</span>
                </div>
            </div>

            {{-- Filter & Export Actions --}}
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">

                {{-- Status Filter --}}
                <form method="GET" action="{{ route('recruiter.jobs.applicants', $job) }}"
                    class="relative w-full sm:w-56">

                    <ion-icon name="filter-outline"
                        class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">
                    </ion-icon>

                    <select name="status" onchange="this.form.submit()"
                        class="w-full pl-10 pr-8 py-2 text-sm border border-gray-200 rounded-md focus:ring-1 focus:ring-black focus:border-black outline-none transition cursor-pointer appearance-none bg-white">

                        <option value="">All Statuses</option>

                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>
                            Reviewed
                        </option>

                        <option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>
                            Shortlisted
                        </option>

                        <option value="interview_scheduled"
                            {{ request('status') == 'interview_scheduled' ? 'selected' : '' }}>
                            Interview Scheduled
                        </option>

                        <option value="selected" {{ request('status') == 'selected' ? 'selected' : '' }}>
                            Selected
                        </option>

                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>

                        <option value="withdrawn" {{ request('status') == 'withdrawn' ? 'selected' : '' }}>
                            Withdrawn
                        </option>

                    </select>

                    <ion-icon name="chevron-down-outline"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none">
                    </ion-icon>

                </form>

                {{-- Export Button (Optional Action) --}}
                <a href="#"
                    class="flex items-center justify-center gap-2 px-4 py-2 border-2 border-black bg-white hover:bg-gray-50 text-black rounded-md text-xs font-bold uppercase tracking-wider transition whitespace-nowrap">
                    <ion-icon name="download-outline" class="text-lg"></ion-icon>
                    Export CSV
                </a>

            </div>

        </div>

        {{-- Table Container --}}
        <div class="bg-white border border-gray-200 rounded-sm overflow-hidden">

            {{-- Scrollable Wrapper --}}
            <div class="overflow-x-auto overflow-y-auto max-h-[calc(100vh-16rem)] relative">
                <table class="w-full text-left border-collapse">

                    {{-- Sticky Table Header --}}
                    <thead class="sticky top-0 z-10 bg-white shadow-[0_1px_0_0_#f3f4f6]">
                        <tr>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400 bg-white">
                                Applicant
                            </th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400 bg-white">
                                Email
                            </th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400 bg-white">
                                Status
                            </th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400 bg-white">
                                Applied Date
                            </th>
                            <th
                                class="px-6 py-5 text-right text-xs font-bold uppercase tracking-widest text-gray-400 bg-white">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($applications as $application)
                            @php
                                $status = strtolower($application->status ?? 'pending');
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition duration-200">

                                {{-- Applicant Info --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded bg-gray-50 border border-gray-200 flex items-center justify-center">
                                            @if ($application->user->profile_photo)
                                                <img src="{{ asset('storage/' . $application->user->profile_photo) }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <ion-icon name="person-outline" class="text-gray-400 text-lg"></ion-icon>
                                            @endif

                                        </div>
                                        <span class="font-bold text-slate-900 text-[14px]">
                                            {{ $application->user->name ?? 'Applicant Name' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Email --}}
                                <td class="px-6 py-4">
                                    <span class="text-[13px] font-semibold text-gray-500">
                                        {{ $application->user->email ?? 'applicant@example.com' }}
                                    </span>
                                </td>

                                {{-- Status Badge --}}
                                <td class="px-6 py-4">
                                    @if ($status === 'shortlisted')
                                        <span
                                            class="inline-block px-3 py-1 bg-black text-white text-[10px] font-bold uppercase tracking-widest rounded-sm">
                                            Shortlisted
                                        </span>
                                    @elseif($status === 'reviewed')
                                        <span
                                            class="inline-block px-3 py-1 bg-gray-800 text-white text-[10px] font-bold uppercase tracking-widest rounded-sm">
                                            Reviewed
                                        </span>
                                    @elseif($status === 'rejected')
                                        <span
                                            class="inline-block px-3 py-1 bg-white text-gray-500 border border-gray-300 text-[10px] font-bold uppercase tracking-widest rounded-sm">
                                            Rejected
                                        </span>
                                    @else
                                        <span
                                            class="inline-block px-3 py-1 bg-gray-100 text-slate-600 border border-gray-200 text-[10px] font-bold uppercase tracking-widest rounded-sm">
                                            Pending
                                        </span>
                                    @endif
                                </td>

                                {{-- Applied Date --}}
                                <td class="px-6 py-4">
                                    <span class="text-[12px] font-bold text-gray-500 uppercase tracking-widest">
                                        {{ $application->created_at->format('M d, Y') ?? 'N/A' }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-6">

                                        {{-- Secondary Action (Clean text link to reduce visual clutter) --}}
                                        <a href="{{ route('recruiter.seeker.show', $application->user) }}"
                                            class="text-[11px] font-bold text-slate-500 hover:text-black uppercase tracking-widest transition duration-200">
                                            Profile
                                        </a>

                                        {{-- Primary Action (Heavy bordered button) --}}
                                        <a href="{{ route('recruiter.applicants.show', $application->id) }}"
                                            class="inline-block px-5 py-2 bg-white border-2 border-black text-black text-[12px] font-bold hover:bg-gray-50 transition duration-200">
                                            Review
                                        </a>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <ion-icon name="people-outline" class="text-5xl text-gray-200 mb-4"></ion-icon>
                                    <p class="text-[13px] font-bold text-gray-400 uppercase tracking-widest">
                                        No applicants yet.
                                    </p>
                                    <p class="text-[12px] text-gray-400 mt-1.5">Candidates who apply will appear here.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($applications->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $applications->links() }}
            </div>
        @endif

    </div>

@endsection
