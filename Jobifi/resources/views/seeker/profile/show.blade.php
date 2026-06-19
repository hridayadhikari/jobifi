@extends('master_index')
@section('title', $user->name . ' — Profile')

@section('content')

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-5">

    {{-- Cover Photo --}}
    <div class="relative h-36 bg-gradient-to-r from-slate-200 to-slate-300 flex items-center justify-center">
        @if($profile->cover_photo)
            <img src="{{ asset('storage/' . $profile->cover_photo) }}"
                 class="absolute inset-0 w-full h-full object-cover" alt="Cover Photo">
        @else
            <span class="text-sm text-gray-400 font-medium select-none z-10">Cover Photo Wireframe</span>
        @endif
    </div>

    {{-- Avatar + Info row --}}
    <div class="px-6 pb-5">
        <div class="flex items-end justify-between -mt-10 mb-3">

            {{-- Avatar --}}
            <div class="relative z-10 w-20 h-20 rounded-full ring-4 ring-white shadow-md shrink-0 overflow-hidden bg-gray-100">
                @if($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}"
                         class="w-full h-full object-cover object-top" alt="{{ $user->name }}">
                @else
                    {{-- Placeholder icon avatar --}}
                    <div class="w-full h-full flex items-center justify-center bg-indigo-100">
                        <span class="text-2xl font-bold text-indigo-500">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                @endif
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-2 mt-12">
                <a href="{{ route('seeker.profile.edit') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Profile
                </a>
                <a href="{{ route('seeker.profile.edit') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-white bg-gray-900 rounded-lg hover:bg-gray-700 transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Section
                </a>
            </div>
        </div>
        {{-- Name, Headline, Meta --}}
        <h1 class="text-2xl font-bold text-gray-900 leading-tight">{{ $user->name }}</h1>

        @if($profile->headline)
            <p class="text-base text-gray-600 mt-0.5">{{ $profile->headline }}</p>
        @endif

        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-sm text-gray-500">
            @if($profile->address)
            <span class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $profile->address }}
            </span>
            @endif
            <span class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Joined {{ $user->created_at->format('M Y') }}
            </span>
        </div>
    </div>
</div>



<div class="grid grid-cols-3 gap-5">

    {{-- ──────────── LEFT COLUMN ──────────── --}}
    <div class="col-span-2 space-y-5">

        {{-- About --}}
        @if($profile->bio)
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="card-heading">About</h2>
            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $profile->bio }}</p>
        </div>
        @endif

        {{-- Experience --}}
        @php $experiences = $profile->experiences; $expCount = $experiences->count(); @endphp
        @if($expCount)
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="card-heading">Experience</h2>
            <div class="space-y-5">
                {{-- Show only first 2, rest hidden --}}
                @foreach($experiences as $i => $exp)
                <div class="{{ $i >= 2 ? 'hidden exp-extra' : '' }} flex gap-4">
                    {{-- Company icon --}}
                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $exp->job_title }}</p>
                                <p class="text-sm text-gray-500">{{ $exp->company_name }}</p>
                            </div>
                            <span class="text-xs text-gray-400 shrink-0 ml-2">
                                {{ $exp->start_date->format('Y') }} - {{ $exp->is_current ? 'Present' : ($exp->end_date?->format('Y') ?? '—') }}
                            </span>
                        </div>
                        @if($exp->description)
                            <p class="text-sm text-gray-600 mt-1.5 leading-relaxed">{{ $exp->description }}</p>
                        @endif
                    </div>
                </div>
                @if(!$loop->last && $i < 1)
                    <hr class="border-gray-100">
                @endif
                @endforeach
            </div>

            {{-- Show All / Collapse --}}
            @if($expCount > 2)
            <div class="mt-5 pt-4 border-t border-gray-100 text-center" id="exp-toggle-row">
                <button onclick="toggleExperiences()" id="exp-toggle-btn"
                        class="text-xs font-semibold tracking-widest text-gray-400 hover:text-gray-600 uppercase transition">
                    SHOW ALL {{ $expCount }} EXPERIENCES
                </button>
            </div>
            @endif
        </div>
        @endif

        {{-- Education --}}
        @if($profile->educations->count())
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="card-heading">Education</h2>
            <div class="space-y-5">
                @foreach($profile->educations as $edu)
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 text-sm">{{ $edu->degree }}</p>
                        <p class="text-sm text-gray-500">{{ $edu->institution }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $edu->start_year }} - {{ $edu->end_year ?? 'Present' }}</p>
                        @if($edu->description)
                            <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $edu->description }}</p>
                        @endif
                    </div>
                </div>
                @if(!$loop->last)
                    <hr class="border-gray-100">
                @endif
                @endforeach
            </div>
        </div>
        @endif

        {{-- Empty state --}}
        @if(!$profile->bio && !$profile->experiences->count() && !$profile->educations->count())
        <div class="bg-white rounded-xl border border-dashed border-gray-300 p-10 text-center">
            <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
            </svg>
            <p class="text-sm text-gray-500 mb-3">Your profile looks empty. Add your bio, experience, and education to stand out.</p>
            <a href="{{ route('seeker.profile.edit') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-white bg-gray-900 rounded-lg hover:bg-gray-700 transition">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Complete Your Profile
            </a>
        </div>
        @endif

    </div>{{-- /left col --}}


    {{-- ──────────── RIGHT COLUMN ──────────── --}}
    <div class="col-span-1 space-y-5">

        {{-- Contact Info --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="card-heading">Contact Info</h2>
            <ul class="space-y-3">
                <li class="flex items-center gap-2.5 text-sm text-gray-600">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ $user->email }}
                </li>
                @if($profile->phone)
                <li class="flex items-center gap-2.5 text-sm text-gray-600">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    {{ $profile->phone }}
                </li>
                @endif
                @if($profile->portfolio_url)
                <li class="flex items-center gap-2.5 text-sm">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                    <a href="{{ $profile->portfolio_url }}" target="_blank" class="font-semibold text-gray-800 hover:underline truncate">
                        {{ str_replace(['https://', 'http://'], '', $profile->portfolio_url) }}
                    </a>
                </li>
                @endif
                @if($profile->linkedin_url)
                <li class="flex items-center gap-2.5 text-sm">
                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    <a href="{{ $profile->linkedin_url }}" target="_blank" class="font-semibold text-gray-800 hover:underline truncate">
                        {{ str_replace(['https://www.', 'https://', 'http://'], '', $profile->linkedin_url) }}
                    </a>
                </li>
                @endif
                @if($profile->github_url)
                <li class="flex items-center gap-2.5 text-sm">
                    <svg class="w-4 h-4 text-gray-800 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                    </svg>
                    <a href="{{ $profile->github_url }}" target="_blank" class="font-semibold text-gray-800 hover:underline truncate">
                        {{ str_replace(['https://www.', 'https://', 'http://'], '', $profile->github_url) }}
                    </a>
                </li>
                @endif
            </ul>
        </div>

        {{-- Skills --}}
        @if($profile->skills->count())
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="card-heading">Skills</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($profile->skills as $skill)
                <span class="px-3 py-1 bg-white border border-gray-300 text-gray-700 text-xs font-medium rounded-full">
                    {{ $skill->name }}
                </span>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Languages --}}
        @if($profile->languages->count())
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="card-heading">Languages</h2>
            <ul class="divide-y divide-gray-100">
                @foreach($profile->languages as $lang)
                <li class="flex items-center justify-between py-2.5 first:pt-0 last:pb-0">
                    <span class="text-sm font-semibold text-gray-800">{{ $lang->language }}</span>
                    <span class="text-sm text-gray-400 capitalize">{{ $lang->proficiency }}</span>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Resume --}}
        @if($profile->resume_path)
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="card-heading">Resume</h2>
            <a href="{{ asset('storage/' . $profile->resume_path) }}" target="_blank"
               class="flex items-center gap-2.5 p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition group">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm text-gray-700 font-medium group-hover:text-gray-900 truncate">
                    {{ $profile->resume_original_name ?? 'View Resume' }}
                </span>
                <svg class="w-3.5 h-3.5 text-gray-400 ml-auto shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
        </div>
        @endif

    </div>{{-- /right col --}}

</div>{{-- /grid --}}

<script>
    var expExpanded = false;
    function toggleExperiences() {
        expExpanded = !expExpanded;
        var extras = document.querySelectorAll('.exp-extra');
        var btn    = document.getElementById('exp-toggle-btn');
        extras.forEach(function(el) {
            el.classList.toggle('hidden', !expExpanded);
        });
        btn.textContent = expExpanded
            ? 'SHOW LESS'
            : 'SHOW ALL {{ $expCount }} EXPERIENCES';
    }
</script>

@endsection
