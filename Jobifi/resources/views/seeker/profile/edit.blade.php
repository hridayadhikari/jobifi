@extends('master_index')
@section('title', 'Edit Profile')
@section('content')


    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Profile</h1>
            <p class="text-sm text-gray-500 mt-0.5">Update your professional information and settings.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('seeker.dashboard') }}"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Cancel
            </a>
            <button form="basic-info-form"
                class="px-4 py-2 text-sm font-semibold text-white bg-gray-900 rounded-lg hover:bg-gray-700 transition">
                Save Changes
            </button>
        </div>
    </div>


    {{-- 
     COVER PHOTO
 --}}
    <div class="relative mb-6 rounded-xl overflow-hidden h-40 bg-gradient-to-r from-slate-200 to-slate-300 group">
        @if ($profile->cover_photo)
            <img src="{{ asset('storage/' . $profile->cover_photo) }}" class="w-full h-full object-cover" alt="Cover">
        @endif
        <form method="POST" action="{{ route('seeker.profile.cover.update') }}" enctype="multipart/form-data"
            id="cover-form">
            @csrf
            <input type="file" id="cover_input" name="cover_photo" accept="image/*" class="hidden"
                onchange="document.getElementById('cover-form').submit()">
        </form>
        <button type="button" onclick="document.getElementById('cover_input').click()"
            class="absolute inset-0 flex flex-col items-center justify-center gap-1 bg-black/0 group-hover:bg-black/30 transition-all duration-200 cursor-pointer">
            <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 7h4l2-2h6l2 2h4v12H3V7zm9 10a4 4 0 100-8 4 4 0 000 8z" />
            </svg>
            <span class="text-white text-xs font-medium opacity-0 group-hover:opacity-100 transition">Change Cover
                Photo</span>
        </button>
    </div>


    {{-- 
     PROFILE PHOTO  (click-to-change, overlaid on cover)
 --}}
    <div class="flex items-center gap-4 -mt-12 mb-8 px-2">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="photo-form">
            @csrf @method('PATCH')
            <input type="hidden" name="name" value="{{ $user->name }}">
            <input type="hidden" name="email" value="{{ $user->email }}">
            <input type="file" id="photo_input" name="profile_photo" accept="image/jpg,image/jpeg,image/png"
                class="hidden" onchange="previewAndSubmitPhoto()">
            <div class="relative w-20 h-20 rounded-full cursor-pointer ring-4 ring-white shadow-md group"
                onclick="document.getElementById('photo_input').click()">
                <img id="profile-avatar"
                    src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=80&background=6366f1&color=fff' }}"
                    class="w-20 h-20 rounded-full object-cover" alt="Avatar">
                <div
                    class="absolute inset-0 rounded-full bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h4l2-2h6l2 2h4v12H3V7zm9 10a4 4 0 100-8 4 4 0 000 8z" />
                    </svg>
                </div>
            </div>
        </form>
        <div class="mt-10">
            <p class="font-semibold text-gray-900">{{ $user->name }}</p>
            <p class="text-sm text-gray-500">{{ $user->email }}</p>
        </div>
    </div>


    {{--
     GENERAL INFORMATION
 --}}
    <form method="POST" action="{{ route('seeker.profile.basic.update') }}" id="basic-info-form" class="space-y-5 mb-6">
        @csrf @method('PATCH')

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-base font-semibold text-gray-900 mb-5">General Information</h2>

            {{-- First / Last name --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">First
                        Name</label>
                    @php [$firstName, $lastName] = array_pad(explode(' ', $user->name, 2), 2, ''); @endphp
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $firstName) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition @error('first_name') border-red-400 @enderror">
                    @error('first_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Last
                        Name</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $lastName) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition @error('last_name') border-red-400 @enderror">
                    @error('last_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Headline --}}
            <div class="mb-4">
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Headline</label>
                <input type="text" name="headline" id="headline" value="{{ old('headline', $profile->headline) }}"
                    placeholder="e.g. Senior Product Designer at Stripe"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
                @error('headline')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email / Phone --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Email
                        Address</label>
                    <div
                        class="flex items-center gap-2 px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-sm text-gray-500">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $user->email }}
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Change email in <a href="{{ route('profile.edit') }}"
                            class="underline">account settings</a>.</p>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Phone
                        Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $profile->phone) }}"
                        placeholder="+1 234 567 890"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
                </div>
            </div>

            {{-- Location / Website --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label
                        class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Location</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $profile->address) }}"
                        placeholder="San Francisco, CA"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
                </div>
                <div>
                    <label
                        class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Website</label>
                    <input type="url" name="portfolio_url" id="portfolio_url"
                        value="{{ old('portfolio_url', $profile->portfolio_url) }}" placeholder="https://johndoe.design"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
                </div>
            </div>
        </div>

        {{--  PROFESSIONAL SUMMARY --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-base font-semibold text-gray-900 mb-4">Professional Summary</h2>
            <textarea name="bio" id="bio" rows="6"
                placeholder="Tell recruiters about yourself, your skills, and your career goals..."
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition resize-y">{{ old('bio', $profile->bio) }}</textarea>
            @error('bio')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- SOCIAL PROFILES --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-base font-semibold text-gray-900 mb-5">Social Profiles</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">LinkedIn
                        URL</label>
                    <div
                        class="flex items-center border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-gray-900 focus-within:border-transparent transition">
                        <span class="px-3 py-2 bg-gray-50 border-r border-gray-300">
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </span>
                        <input type="url" name="linkedin_url"
                            value="{{ old('linkedin_url', $profile->linkedin_url) }}"
                            placeholder="https://linkedin.com/in/username"
                            class="flex-1 px-3 py-2 text-sm outline-none bg-white">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">GitHub
                        URL</label>
                    <div
                        class="flex items-center border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-gray-900 focus-within:border-transparent transition">
                        <span class="px-3 py-2 bg-gray-50 border-r border-gray-300">
                            <svg class="w-4 h-4 text-gray-800" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z" />
                            </svg>
                        </span>
                        <input type="url" name="github_url" value="{{ old('github_url', $profile->github_url) }}"
                            placeholder="https://github.com/username"
                            class="flex-1 px-3 py-2 text-sm outline-none bg-white">
                    </div>
                </div>
            </div>
        </div>

    </form>{{-- end #basic-info-form --}}


    {{--
     RESUME UPLOAD
 --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
        <h2 class="text-base font-semibold text-gray-900 mb-4">Resume / CV</h2>

        @if ($profile->resume_path)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 mb-4">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span
                        class="text-sm text-gray-700 font-medium">{{ $profile->resume_original_name ?? 'resume' }}</span>
                </div>
                <a href="{{ asset('storage/' . $profile->resume_path) }}" target="_blank"
                    class="text-xs text-blue-600 hover:underline">View</a>
            </div>
        @endif

        <form method="POST" action="{{ route('seeker.profile.resume.update') }}" enctype="multipart/form-data">
            @csrf
            <label
                class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-gray-400 hover:bg-gray-50 transition">
                <svg class="w-7 h-7 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                <p class="text-sm text-gray-500"><span class="font-medium text-gray-700">Click to upload</span> or drag &
                    drop</p>
                <p class="text-xs text-gray-400 mt-1">PDF, DOC, DOCX — max 5 MB</p>
                <input type="file" name="resume" accept=".pdf,.doc,.docx" class="hidden"
                    onchange="this.closest('form').submit()">
            </label>
            @error('resume')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </form>
    </div>


    {{-- 
     SKILLS
 --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
        <h2 class="text-base font-semibold text-gray-900 mb-4">Skills</h2>
        <form method="POST" action="{{ route('seeker.profile.skills.update') }}" id="skillsForm">
            @csrf
            @method('PATCH')

            <div class="flex flex-wrap gap-2 mb-4">

                @foreach ($allSkills as $skill)
                    <span
                        class="skill-pill inline-block px-3 py-1 rounded-full text-sm border cursor-pointer transition
        {{ $profile->skills->contains($skill->id)
            ? 'bg-gray-900 text-white border-gray-900'
            : 'bg-white text-gray-700 border-gray-300' }}"
                        data-id="{{ $skill->id }}">
                        {{ $skill->name }}
                    </span>
                @endforeach

            </div>

            <div id="hiddenSkills"></div>

            <button type="submit"
                class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-gray-700 transition">
                Save Skills
            </button>
        </form>

        <script>
            let selectedSkills = [
                @foreach ($profile->skills as $skill)
                    {{ $skill->id }},
                @endforeach
            ];
            document.addEventListener('DOMContentLoaded', () => {

                const pills = document.querySelectorAll('.skill-pill');
                const hiddenContainer = document.getElementById('hiddenSkills');

                let selectedSkills = [
                    @foreach ($profile->skills as $skill)
                        {{ $skill->id }},
                    @endforeach
                ];

                pills.forEach(pill => {

                    const skillId = Number(pill.dataset.id);

                    pill.addEventListener('click', () => {

                        if (selectedSkills.includes(skillId)) {

                            selectedSkills = selectedSkills.filter(
                                id => id !== skillId
                            );

                            pill.classList.remove(
                                'bg-gray-900',
                                'text-white',
                                'border-gray-900'
                            );

                            pill.classList.add(
                                'bg-white',
                                'text-gray-700',
                                'border-gray-300'
                            );

                        } else {

                            selectedSkills.push(skillId);

                            pill.classList.remove(
                                'bg-white',
                                'text-gray-700',
                                'border-gray-300'
                            );

                            pill.classList.add(
                                'bg-gray-900',
                                'text-white',
                                'border-gray-900'
                            );

                        }

                        renderHiddenInputs();
                    });

                });

                function renderHiddenInputs() {

                    hiddenContainer.innerHTML = '';

                    selectedSkills.forEach(id => {

                        const input = document.createElement('input');

                        input.type = 'hidden';
                        input.name = 'skill_ids[]';
                        input.value = id;

                        hiddenContainer.appendChild(input);

                    });

                }

                renderHiddenInputs();

            });
        </script>
    </div>


    {{-- 
     EXPERIENCE
 --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6" x-data="{ addExp: false, editExp: null }">
        <h2 class="text-base font-semibold text-gray-900 mb-4">Experience</h2>

        {{-- Existing entries --}}
        <div class="space-y-3 mb-4">
            @forelse($profile->experiences as $exp)
                <div class="flex items-start justify-between p-4 border border-gray-200 rounded-lg"
                    x-data="{ editing: false }">
                    <div class="flex-1" x-show="!editing">
                        <p class="font-semibold text-gray-900 text-sm">{{ $exp->job_title }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            {{ $exp->company_name }} &bull;
                            {{ $exp->start_date->format('Y') }}
                            {{ $exp->is_current ? 'Present' : $exp->end_date?->format('Y') ?? '—' }}
                        </p>
                        @if ($exp->description)
                            <p class="text-xs text-gray-600 mt-1 leading-relaxed">{{ Str::limit($exp->description, 100) }}
                            </p>
                        @endif
                    </div>

                    {{-- Inline Edit Form --}}
                    <form method="POST" action="{{ route('seeker.experience.update', $exp) }}" x-show="editing"
                        class="w-full space-y-3">
                        @csrf @method('PATCH')
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Job
                                    Title</label>
                                <input type="text" name="job_title" value="{{ $exp->job_title }}" required
                                    class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                            </div>
                            <div>
                                <label
                                    class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Company</label>
                                <input type="text" name="company_name" value="{{ $exp->company_name }}" required
                                    class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                            </div>
                            <div>
                                <label class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Start
                                    Date</label>
                                <input type="date" name="start_date" value="{{ $exp->start_date?->format('Y-m-d') }}"
                                    required
                                    class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                            </div>
                            <div>
                                <label class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">End
                                    Date</label>
                                <input type="date" name="end_date" value="{{ $exp->end_date?->format('Y-m-d') }}"
                                    class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                                <label class="flex items-center gap-1 mt-1 text-xs text-gray-500 cursor-pointer">
                                    <input type="checkbox" name="is_current" value="1"
                                        {{ $exp->is_current ? 'checked' : '' }}>
                                    Currently working here
                                </label>
                            </div>
                        </div>
                        <div>
                            <label
                                class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Description</label>
                            <textarea name="description" rows="2"
                                class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 resize-none">{{ $exp->description }}</textarea>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit"
                                class="px-3 py-1.5 text-xs font-semibold text-white bg-gray-900 rounded-lg hover:bg-gray-700 transition">Save</button>
                            <button type="button" @click="editing = false"
                                class="px-3 py-1.5 text-xs font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                        </div>
                    </form>

                    <div class="flex items-center gap-2 ml-3 shrink-0" x-show="!editing">
                        <button type="button" @click="editing = true"
                            class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <form method="POST" action="{{ route('seeker.experience.destroy', $exp) }}">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="delete-btn p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition"
                                data-name="this experience">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-400 text-center py-4">No experience added yet.</p>
            @endforelse
        </div>

        {{-- Add Experience --}}
        <div class="border border-dashed border-gray-300 rounded-lg">
            <button type="button" @click="addExp = !addExp"
                class="w-full flex items-center justify-center gap-2 py-3 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition rounded-lg">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Experience
            </button>
            <form method="POST" action="{{ route('seeker.experience.store') }}" x-show="addExp" x-cloak
                class="p-4 border-t border-gray-200 space-y-3">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Job Title</label>
                        <input type="text" name="job_title" required placeholder="Senior Designer"
                            class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Company</label>
                        <input type="text" name="company_name" required placeholder="Stripe"
                            class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Start Date</label>
                        <input type="date" name="start_date" required
                            class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">End Date</label>
                        <input type="date" name="end_date"
                            class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                        <label class="flex items-center gap-1 mt-1 text-xs text-gray-500 cursor-pointer">
                            <input type="checkbox" name="is_current" value="1">
                            Currently working here
                        </label>
                    </div>
                </div>
                <div>
                    <label class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Description</label>
                    <textarea name="description" rows="2" placeholder="Describe your role and achievements..."
                        class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 resize-none"></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-3 py-1.5 text-xs font-semibold text-white bg-gray-900 rounded-lg hover:bg-gray-700 transition">Add</button>
                    <button type="button" @click="addExp = false"
                        class="px-3 py-1.5 text-xs font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                </div>
            </form>
        </div>
    </div>


    {{--
     EDUCATION
 --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6" x-data="{ addEdu: false }">
        <h2 class="text-base font-semibold text-gray-900 mb-4">Education</h2>

        <div class="space-y-3 mb-4">
            @forelse($profile->educations as $edu)
                <div class="flex items-start justify-between p-4 border border-gray-200 rounded-lg"
                    x-data="{ editing: false }">
                    <div x-show="!editing">
                        <p class="font-semibold text-gray-900 text-sm">{{ $edu->degree }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            {{ $edu->institution }} &bull; {{ $edu->start_year }} – {{ $edu->end_year ?? 'Present' }}
                        </p>
                        @if ($edu->description)
                            <p class="text-xs text-gray-600 mt-1">{{ Str::limit($edu->description, 100) }}</p>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('seeker.education.update', $edu) }}" x-show="editing"
                        class="w-full space-y-3">
                        @csrf @method('PATCH')
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label
                                    class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Degree</label>
                                <input type="text" name="degree" value="{{ $edu->degree }}" required
                                    class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                            </div>
                            <div>
                                <label
                                    class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Institution</label>
                                <input type="text" name="institution" value="{{ $edu->institution }}" required
                                    class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                            </div>
                            <div>
                                <label class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Start
                                    Year</label>
                                <input type="number" name="start_year" value="{{ $edu->start_year }}" min="1950"
                                    max="{{ date('Y') }}" required
                                    class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                            </div>
                            <div>
                                <label class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">End
                                    Year</label>
                                <input type="number" name="end_year" value="{{ $edu->end_year }}" min="1950"
                                    max="{{ date('Y') + 10 }}"
                                    class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                            </div>
                        </div>
                        <div>
                            <label
                                class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Description</label>
                            <textarea name="description" rows="2"
                                class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 resize-none">{{ $edu->description }}</textarea>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit"
                                class="px-3 py-1.5 text-xs font-semibold text-white bg-gray-900 rounded-lg hover:bg-gray-700 transition">Save</button>
                            <button type="button" @click="editing = false"
                                class="px-3 py-1.5 text-xs font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                        </div>
                    </form>

                    <div class="flex items-center gap-2 ml-3 shrink-0" x-show="!editing">
                        <button type="button" @click="editing = true"
                            class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <form method="POST" action="{{ route('seeker.education.destroy', $edu) }}">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="delete-btn p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition"
                                data-name="this education entry">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-400 text-center py-4">No education added yet.</p>
            @endforelse
        </div>

        <div class="border border-dashed border-gray-300 rounded-lg">
            <button type="button" @click="addEdu = !addEdu"
                class="w-full flex items-center justify-center gap-2 py-3 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition rounded-lg">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Education
            </button>
            <form method="POST" action="{{ route('seeker.education.store') }}" x-show="addEdu" x-cloak
                class="p-4 border-t border-gray-200 space-y-3">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Degree</label>
                        <input type="text" name="degree" required placeholder="B.S. Computer Science"
                            class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Institution</label>
                        <input type="text" name="institution" required placeholder="Stanford University"
                            class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Start Year</label>
                        <input type="number" name="start_year" required min="1950" max="{{ date('Y') }}"
                            placeholder="{{ date('Y') - 4 }}"
                            class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">End Year</label>
                        <input type="number" name="end_year" min="1950" max="{{ date('Y') + 10 }}"
                            placeholder="{{ date('Y') }}"
                            class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                    </div>
                </div>
                <div>
                    <label class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Description
                        (optional)</label>
                    <textarea name="description" rows="2" placeholder="Major achievements, GPA, activities..."
                        class="mt-1 w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 resize-none"></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-3 py-1.5 text-xs font-semibold text-white bg-gray-900 rounded-lg hover:bg-gray-700 transition">Add</button>
                    <button type="button" @click="addEdu = false"
                        class="px-3 py-1.5 text-xs font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function previewAndSubmitPhoto() {
            const input = document.getElementById('photo_input');
            const avatar = document.getElementById('profile-avatar');
            if (!input.files || !input.files[0]) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                avatar.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
            document.getElementById('photo-form').submit();
        }
    </script>

@endsection
