@extends('master_index')

@section('title', 'Admin Overview')

@section('content')

<div class="bg-[#f8f9fa] min-h-screen font-sans py-12 px-6">

    <div class="max-w-[1200px] mx-auto">

        {{-- Page Header --}}
        <div class="mb-10">
            <h1 class="text-[28px] font-extrabold text-[#0a192f] uppercase tracking-tight leading-none mb-2">
                Admin Overview
            </h1>
            <p class="text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em]">
                Monitor system performance and user activity.
            </p>
        </div>

        {{-- Top Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            
            {{-- Stat Card: Total Users --}}
            <div class="bg-white border border-gray-200 shadow-sm p-6 relative">
                <ion-icon name="people-outline" class="absolute top-6 right-6 text-xl text-gray-300"></ion-icon>
                <h3 class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-4">
                    Total Users
                </h3>
                <p class="text-[28px] font-extrabold text-slate-900 leading-none mb-2">
                    12,482
                </p>
                <p class="text-[10px] font-bold text-gray-400">
                    +12% from last month
                </p>
            </div>

            {{-- Stat Card: Recruiters --}}
            <div class="bg-white border border-gray-200 shadow-sm p-6 relative">
                <ion-icon name="business-outline" class="absolute top-6 right-6 text-xl text-gray-300"></ion-icon>
                <h3 class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-4">
                    Recruiters
                </h3>
                <p class="text-[28px] font-extrabold text-slate-900 leading-none mb-2">
                    842
                </p>
                <p class="text-[10px] font-bold text-gray-400">
                    +5% from last month
                </p>
            </div>

            {{-- Stat Card: Job Seekers --}}
            <div class="bg-white border border-gray-200 shadow-sm p-6 relative">
                <ion-icon name="person-outline" class="absolute top-6 right-6 text-xl text-gray-300"></ion-icon>
                <h3 class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-4">
                    Job Seekers
                </h3>
                <p class="text-[28px] font-extrabold text-slate-900 leading-none mb-2">
                    11,640
                </p>
                <p class="text-[10px] font-bold text-gray-400">
                    +15% from last month
                </p>
            </div>

            {{-- Stat Card: Total Jobs --}}
            <div class="bg-white border border-gray-200 shadow-sm p-6 relative">
                <ion-icon name="briefcase-outline" class="absolute top-6 right-6 text-xl text-gray-300"></ion-icon>
                <h3 class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-4">
                    Total Jobs
                </h3>
                <p class="text-[28px] font-extrabold text-slate-900 leading-none mb-2">
                    3,156
                </p>
                <p class="text-[10px] font-bold text-gray-400">
                    +8% from last month
                </p>
            </div>

            {{-- Stat Card: Applications (Wraps to next row automatically) --}}
            <div class="bg-white border border-gray-200 shadow-sm p-6 relative">
                <ion-icon name="send-outline" class="absolute top-6 right-6 text-xl text-gray-300"></ion-icon>
                <h3 class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-4">
                    Applications
                </h3>
                <p class="text-[28px] font-extrabold text-slate-900 leading-none mb-2">
                    45,210
                </p>
                <p class="text-[10px] font-bold text-gray-400">
                    +22% from last month
                </p>
            </div>

        </div>

        {{-- Main Dashboard Content (2 Columns) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left Column: Recent Activities --}}
            <div class="lg:col-span-2 bg-white border border-gray-200 shadow-sm">
                
                <div class="px-8 py-6 border-b border-gray-100">
                    <h2 class="text-[13px] font-bold text-[#0a192f] uppercase tracking-[0.1em]">
                        Recent Activities
                    </h2>
                </div>

                <div class="p-8 space-y-8">
                    
                    {{-- Activity Item (Repeated) --}}
                    @for ($i = 0; $i < 5; $i++)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center gap-5">
                            <div class="w-10 h-10 bg-gray-50 border border-gray-200 rounded-full flex items-center justify-center shrink-0">
                                <ion-icon name="time-outline" class="text-lg text-gray-400"></ion-icon>
                            </div>
                            <div>
                                <p class="text-[14px] font-bold text-[#0a192f]">
                                    New recruiter registered
                                </p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.1em] mt-0.5">
                                    Google Inc. joined the platform
                                </p>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em]">
                            2 Mins Ago
                        </span>
                    </div>
                    @endfor

                </div>

            </div>

            {{-- Right Column: System Health --}}
            <div class="bg-white border border-gray-200 shadow-sm h-fit">
                
                <div class="px-8 py-6 border-b border-gray-100">
                    <h2 class="text-[13px] font-bold text-[#0a192f] uppercase tracking-[0.1em]">
                        System Health
                    </h2>
                </div>

                <div class="p-6 space-y-4">
                    
                    {{-- Health Metric 1 --}}
                    <div class="flex justify-between items-center bg-gray-50/80 p-5 rounded-md">
                        <span class="text-[11px] font-bold text-slate-700 uppercase tracking-[0.1em]">
                            Server Status
                        </span>
                        <span class="bg-black text-white px-3 py-1 text-[11px] font-bold uppercase tracking-widest rounded-sm">
                            Operational
                        </span>
                    </div>

                    {{-- Health Metric 2 --}}
                    <div class="flex justify-between items-center bg-gray-50/80 p-5 rounded-md">
                        <span class="text-[11px] font-bold text-slate-700 uppercase tracking-[0.1em]">
                            Database Latency
                        </span>
                        <span class="text-[14px] font-bold text-slate-900">
                            24ms
                        </span>
                    </div>

                    {{-- Health Metric 3 --}}
                    <div class="flex justify-between items-center bg-gray-50/80 p-5 rounded-md">
                        <span class="text-[11px] font-bold text-slate-700 uppercase tracking-[0.1em]">
                            New Errors
                        </span>
                        <span class="border border-black text-black px-3 py-1 text-[11px] font-bold uppercase tracking-widest rounded-sm">
                            0 Today
                        </span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection