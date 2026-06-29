@extends('master_index')

@section('title', 'Seeker Dashboard')

@section('content')

    <div class="bg-[#f8f9fa] min-h-screen font-sans py-12 px-6">

        <div class="max-w-[1200px] mx-auto">

            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                <div>
                    <h1 class="text-[32px] font-extrabold text-[#0a192f] tracking-tight leading-tight">
                        {{ $greeting }}, {{ Auth::user()->name }}!
                    </h1>
                    <p class="text-[15px] text-gray-500 mt-1">

                </div>
                <a href="{{ route('seeker.jobs.index') ?? '#' }}"
                    class="px-8 py-3 bg-black text-white text-[14px] font-bold hover:bg-[#1a1a1a] transition duration-200">
                    Find Jobs
                </a>
            </div>

            {{-- Top Stats Row --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                {{-- Stat Card 1 --}}
                <div class="bg-white border border-gray-200 shadow-sm p-6 relative">
                    <ion-icon name="send-outline" class="absolute top-6 right-6 text-xl text-gray-300"></ion-icon>
                    <h3 class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-4">
                        Applied Jobs
                    </h3>
                    <p class="text-[32px] font-extrabold text-slate-900 leading-none">
                        {{ $appliedJobsCount }}
                    </p>
                </div>

                {{-- Stat Card 2 --}}
                <div class="bg-white border border-gray-200 shadow-sm p-6 relative">
                    <ion-icon name="bookmark-outline" class="absolute top-6 right-6 text-xl text-gray-300"></ion-icon>
                    <h3 class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-4">
                        Saved Jobs
                    </h3>
                    <p class="text-[32px] font-extrabold text-slate-900 leading-none">
                        {{ $savedJobsCount }}
                    </p>
                </div>

                {{-- Stat Card 3 --}}
                <div class="bg-white border border-gray-200 shadow-sm p-6 relative">
                    <ion-icon name="calendar-outline" class="absolute top-6 right-6 text-xl text-gray-300"></ion-icon>
                    <h3 class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-4">
                        Interviews
                    </h3>
                    <p class="text-[32px] font-extrabold text-slate-900 leading-none">
                        {{ $upcomingInterviews->count() }}
                    </p>
                </div>

                {{-- Stat Card 4 --}}
                <div class="bg-white border border-gray-200 shadow-sm p-6 relative">
                    <ion-icon name="search-outline" class="absolute top-6 right-6 text-xl text-gray-300"></ion-icon>
                    <h3 class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-4">
                        Profile Views
                    </h3>
                    <p class="text-[32px] font-extrabold text-slate-900 leading-none">
                        {{ $profileViews }}
                    </p>
                </div>

            </div>

            {{-- Main Dashboard Content --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- Left Column: Application Status Updates --}}
                <div class="bg-white border border-gray-200 shadow-sm">

                    <div class="px-8 py-6 border-b border-gray-100">
                        <h2 class="text-[13px] font-bold text-[#0a192f] uppercase tracking-[0.1em]">
                            Application Status Updates
                        </h2>
                    </div>

                    <div class="p-6 space-y-4">

                        @forelse($recentApplications as $application)
                            <div
                                class="flex items-center justify-between p-4 bg-[#fcfdfe] border border-gray-100 rounded-xl hover:bg-gray-50/80 transition duration-200 group">
                                <div class="flex items-center gap-5">
                                    <div
                                        class="w-12 h-12 bg-gray-50 border border-gray-200 rounded flex items-center justify-center shadow-sm">
                                        <ion-icon name="business-outline" class="text-xl text-gray-400"></ion-icon>
                                    </div>
                                    <div>
                                        <p class="text-[15px] font-bold text-slate-900 group-hover:text-black transition">
                                            {{ $application->job->title }}
                                        </p>
                                        <p class="text-[13px] text-gray-500 mt-0.5">
                                            {{ $application->job->company->name }}
                                        </p>
                                    </div>
                                </div>
                                <span class="inline-block border border-black px-3 py-1 text-[12px] font-bold text-black">
                                    {{ ucfirst(strtolower($application->status)) }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-[14px] text-gray-500">You haven't applied to any jobs yet.</p>
                            </div>
                        @endforelse

                    </div>

                </div>

                {{-- Right Column: Upcoming Interviews --}}
                <div class="bg-white border border-gray-200 shadow-sm">

                    <div class="px-8 py-6 border-b border-gray-100">
                        <h2 class="text-[13px] font-bold text-[#0a192f] uppercase tracking-[0.1em]">
                            Upcoming Interviews
                        </h2>
                    </div>

                    <div class="p-6 space-y-6">

                        @forelse($upcomingInterviews as $interview)
                            <div
                                class="bg-white border border-gray-200 shadow-sm p-6 hover:border-gray-300 transition duration-200">

                                {{-- Header: Job Info & Date/Time --}}
                                <div class="flex justify-between items-start mb-5">
                                    <div>
                                        <h3 class="text-[15px] font-bold text-slate-900 leading-tight">
                                            {{ $interview->application->job->title }}
                                        </h3>
                                        <p class="text-[13px] text-gray-500 mt-1">
                                          
                                            with <span
                                                class="font-bold text-slate-700">{{ $interview->application->job->company->name }}
                                            </span>
                                                for
                                                <span
                                                class="font-bold text-slate-700">{{ $interview->application->job->title }}
                                            </span>
                                              
                                        </p>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-[11px] font-bold text-black uppercase tracking-widest">
                                            {{ $interview->interview_at->format('d M Y') }}
                                        </p>
                                        <p class="text-[12px] font-semibold text-gray-500 mt-0.5">
                                            {{ $interview->interview_at->format('h:i A') }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Optional Notes Callout --}}
                                @if ($interview->notes)
                                    <div class="mb-6 bg-gray-50/50 p-4 border-l-2 border-gray-200">
                                        <p class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-1">
                                            Notes
                                        </p>
                                        <p class="text-[13px] text-slate-700 leading-relaxed">
                                            {{ $interview->notes }}
                                        </p>
                                    </div>
                                @else
                                    <div class="mb-6"></div>
                                @endif

                                <a href="{{ $interview->meeting_link }}" target="_blank"
                                    class="block w-full text-center py-2.5 border-2 border-black bg-white text-black text-[13px] font-bold hover:bg-gray-50 transition duration-200">
                                    Join Meeting
                                </a>

                            </div>
                        @empty

                            <div class="text-center py-12 px-6 border border-dashed border-gray-200 bg-gray-50/50">
                                <ion-icon name="calendar-clear-outline" class="text-4xl text-gray-300 mb-4"></ion-icon>
                                <p class="text-[12px] font-bold text-gray-400 uppercase tracking-widest">
                                    No Upcoming Interviews
                                </p>
                                <p class="text-[13px] text-gray-400 mt-1">
                                    You have no interviews scheduled at the moment.
                                </p>
                            </div>
                        @endforelse
                    </div>

                </div>

            </div>

        </div>



    </div>

@endsection
