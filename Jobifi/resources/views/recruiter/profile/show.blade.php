@extends('master_index')
@section('title', ($user->company->name ?? $user->name) . ' — Company Profile')

@section('content')

{{-- Flash: company created --}}
@if(session('status') === 'company-created')
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
     class="mb-4 flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg">
    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
    Company profile created successfully!
</div>
@endif

{{-- Flash: company updated --}}
@if(session('status') === 'company-updated')
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
     class="mb-4 flex items-center gap-2 bg-blue-50 border border-blue-200 text-blue-700 text-sm px-4 py-3 rounded-lg">
    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
    Company profile updated successfully!
</div>
@endif

{{-- ══════════════ COMPANY BANNER + HEADER ══════════════ --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-5">

    {{-- Banner --}}
    <div class="relative h-36 bg-gradient-to-r from-slate-200 to-slate-300 flex items-center justify-center overflow-hidden">
        @if($user->company && $user->company->cover_photo)
            <img src="{{ asset('storage/' . $user->company->cover_photo) }}"
                 class="absolute inset-0 w-full h-full object-cover" alt="Company Cover Photo">
            
        @endif
      
    </div>

    {{-- Logo + Info row --}}
    <div class="px-6 pb-5">
        <div class="flex items-end justify-between -mt-10 mb-4">

            {{-- Company Logo --}}
            <div class="relative z-10 w-20 h-20 rounded-xl ring-4 ring-white shadow-md shrink-0 overflow-hidden bg-gray-100 flex items-center justify-center border border-gray-200">
                @if($user->company && $user->company->logo_path)
                    <img src="{{ asset('storage/' . $user->company->logo_path) }}"
                         class="w-full h-full object-cover" alt="{{ $user->company->name }}">
                @else
                    {{-- Building placeholder icon --}}
                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                @endif
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-2 mt-12">
                <a href="{{ route('recruiter.profile.company.edit') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Profile
                </a>
                <a href="{{ route('recruiter.profile.show') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-white bg-gray-900 rounded-lg hover:bg-gray-700 transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    View Public Page
                </a>
            </div>
        </div>

        {{-- Company Name + Tagline --}}
        <h1 class="text-2xl font-bold text-gray-900 leading-tight">
            {{ $user->company->name ?? $user->name }}
        </h1>
@php
    $nameLength = str_word_count($user->company->name);
@endphp
        @if($user->company && $user->company->description)
            <p class="text-sm text-gray-500 mt-0.5 line-clamp-1">
                {{ Str::words($user->company->description, $nameLength,'') }}
            </p>
        @endif

        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-sm text-gray-500">
            @if($user->company && $user->company->headquarters_location)
            <span class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $user->company->headquarters_location }}
            </span>
            @endif
            <span class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                @if($totalJobs > 0)
                    {{ $totalJobs }} Active Job{{ $totalJobs === 1 ? '' : 's' }}
                @else
                    No active jobs
                @endif
            </span>
        </div>
    </div>
</div>


{{-- ══════════════ TWO-COLUMN LAYOUT ══════════════ --}}
<div class="grid grid-cols-3 gap-5">

    {{-- ──────────── LEFT COLUMN ──────────── --}}
    <div class="col-span-2 space-y-5">

        {{-- About the Company --}}
        @if($user->company && $user->company->description)
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-4">About the Company</h2>
            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $user->company->description }}</p>
        </div>
        @endif

        {{-- Current Job Openings --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-4">Current Job Openings</h2>

            @if($jobs->count())
                <div class="space-y-1">
                    @foreach($jobs->take(5) as $job)
                    <a href="#"
                       class="flex items-center justify-between p-4 rounded-lg hover:bg-gray-50 transition group border border-transparent hover:border-gray-200">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm group-hover:text-gray-700">{{ $job->title }}</p>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1 text-xs text-gray-500">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $job->location }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Posted {{ $job->created_at->diffForHumans() }}
                                </span>
                                @if($job->salary_range)
                                <span class="font-semibold text-gray-700">{{ $job->salary_range }}</span>
                                @endif
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 shrink-0 ml-3 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    @if(!$loop->last)
                        <hr class="border-gray-100">
                    @endif
                    @endforeach
                </div>

                @if($totalJobs > 5)
                <div class="mt-5 pt-4 border-t border-gray-100 text-center">
                    <a href="#" class="text-xs font-bold tracking-widest text-gray-400 hover:text-gray-600 uppercase transition">
                        VIEW ALL {{ $totalJobs }} JOB OPENINGS
                    </a>
                </div>
                @endif

            @else
                {{-- Empty state --}}
                <div class="py-10 text-center">
                    <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm text-gray-500">No job openings at this time.</p>
                </div>
            @endif
        </div>

    </div>{{-- /left col --}}


    {{-- ──────────── RIGHT COLUMN ──────────── --}}
    <div class="col-span-1 space-y-5">

        {{-- Company Details --}}
        @if($user->company)
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-4">Company Details</h2>

            {{-- Links --}}
            <ul class="space-y-3 mb-4">
                @if($user->company->website)
                <li class="flex items-center gap-2.5 text-sm">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                    <a href="{{ $user->company->website }}" target="_blank" class="text-blue-600 hover:underline truncate">
                        {{ str_replace(['https://www.', 'https://', 'http://'], '', $user->company->website) }}
                    </a>
                </li>
                @endif

                @if($user->linkedin_url)
                <li class="flex items-center gap-2.5 text-sm">
                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    <a href="{{ $user->linkedin_url }}" target="_blank" class="text-blue-600 hover:underline truncate">
                        {{ str_replace(['https://www.', 'https://', 'http://'], '', $user->linkedin_url) }}
                    </a>
                </li>
                @endif
            </ul>

            {{-- Stats --}}
            <div class="divide-y divide-gray-100">
                <div class="flex justify-between py-2.5 text-sm">
                    <span class="text-gray-500">Industry</span>
                    <span class="font-semibold text-gray-800">{{ $user->company->industry ?? '—' }}</span>
                </div>
                <div class="flex justify-between py-2.5 text-sm">
                    <span class="text-gray-500">Founded</span>
                    <span class="font-semibold text-gray-800">{{ $user->company->founded_year ?? '—' }}</span>
                </div>
                <div class="flex justify-between py-2.5 text-sm">
                    <span class="text-gray-500">Size</span>
                    <span class="font-semibold text-gray-800">{{ $user->company->employee_count ?? '—' }}</span>
                </div>
                <div class="flex justify-between py-2.5 text-sm">
                    <span class="text-gray-500">Location</span>
                    <span class="font-semibold text-gray-800">{{ $user->company->headquarters_location ?? '—' }}</span>
                </div>
            </div>
        </div>
        @endif

        {{-- ══════ RECRUITER CONTACT ══════ --}}
        @if($user->designation || $user->phone || $user->email)
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-4">Recruiter Contact</h2>

            {{-- Avatar + Name --}}
            <div class="flex items-center gap-3 mb-4">
                <div class="w-11 h-11 rounded-full bg-gray-100 flex items-center justify-center shrink-0 overflow-hidden ring-2 ring-gray-100">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}"
                             class="w-full h-full object-cover" alt="{{ $user->name }}">
                    @else
                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">{{ $user->name }}</p>
                    <p class="text-xs text-gray-500">Recruiter</p>
                </div>
            </div>

            {{-- Contact Details --}}
            <ul class="space-y-2.5">
                <li class="flex items-center gap-2.5 text-sm text-gray-600">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <a href="mailto:{{ $user->email }}" class="text-blue-600 hover:underline truncate">
                        {{ $user->email }}
                    </a>
                </li>

                @if($user->phone)
                <li class="flex items-center gap-2.5 text-sm text-gray-600">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span>{{ $user->phone }}</span>
                </li>
                @endif
            </ul>
        </div>
        @endif

    </div>{{-- /right col --}}

</div>{{-- /grid --}}

@endsection
