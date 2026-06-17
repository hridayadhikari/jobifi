@extends('master_index')
@section('title', 'Create Company Profile')

@section('content')

{{-- Header --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Create Company Profile</h1>
    <p class="text-sm text-gray-500 mt-0.5">Set up your company page so job seekers can find you.</p>
</div>

<div class="grid grid-cols-3 gap-6">

    {{-- ──────────── LEFT: FORM ──────────── --}}
    <div class="col-span-2">
        <form method="POST" action="{{ route('recruiter.profile.company.store') }}"
              enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Company Logo --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-4">Company Logo</h2>
                <div class="flex items-center gap-5">
                    <div id="logo-preview"
                         class="w-20 h-20 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 flex items-center justify-center overflow-hidden shrink-0">
                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <label for="logo"
                               class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Upload Logo
                        </label>
                        <input type="file" id="logo" name="logo" accept="image/png,image/jpg,image/jpeg,image/webp"
                               class="hidden" onchange="previewLogo(this)">
                        <p class="text-xs text-gray-400 mt-1.5">PNG, JPG, WEBP · Max 2 MB</p>
                        @error('logo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Company Cover Photo --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-4">Company Cover Photo</h2>
                <div class="space-y-4">
                    <div id="cover-preview" class="relative overflow-hidden rounded-xl border border-gray-200 bg-gray-50 h-40 flex items-center justify-center">
                        <span class="text-sm text-gray-400">No cover photo uploaded yet.</span>
                    </div>
                    <div>
                        <label for="cover"
                               class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Upload Cover Photo
                        </label>
                        <input type="file" id="cover" name="cover_photo" accept="image/png,image/jpg,image/jpeg,image/webp"
                               class="hidden" onchange="previewCover(this)">
                        <p class="text-xs text-gray-400 mt-1.5">PNG, JPG, WEBP · Max 4 MB</p>
                        @error('cover_photo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Company Information --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
                <h2 class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Company Information</h2>

                {{-- Name --}}
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">
                        Company Name <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 transition @error('name') border-red-400 @enderror"
                           placeholder="e.g. Stripe Inc.">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">About the Company</label>
                    <textarea name="description" rows="5"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 transition resize-y @error('description') border-red-400 @enderror"
                              placeholder="Describe your company, mission, and culture…">{{ old('description') }}</textarea>
                    @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Website --}}
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Website URL</label>
                    <input type="url" name="website" value="{{ old('website') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 transition @error('website') border-red-400 @enderror"
                           placeholder="https://yourcompany.com">
                    @error('website')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- HQ Location --}}
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Headquarters Location</label>
                    <input type="text" name="headquarters_location" value="{{ old('headquarters_location') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 transition @error('headquarters_location') border-red-400 @enderror"
                           placeholder="e.g. San Francisco, CA">
                    @error('headquarters_location')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Industry --}}
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Industry</label>
                    <input type="text" name="industry" value="{{ old('industry') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 transition @error('industry') border-red-400 @enderror"
                           placeholder="e.g. Fintech, SaaS, Healthcare">
                    @error('industry')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Founded Year & Employee Count (side by side) --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Founded Year</label>
                        <input type="number" name="founded_year" value="{{ old('founded_year') }}"
                               min="1800" max="{{ date('Y') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 transition @error('founded_year') border-red-400 @enderror"
                               placeholder="{{ date('Y') }}">
                        @error('founded_year')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Company Size</label>
                        <select name="employee_count"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 transition bg-white @error('employee_count') border-red-400 @enderror">
                            <option value="">— Select size —</option>
                            @foreach(['1–10','11–50','51–200','201–500','501–1,000','1,000–5,000','5,000+'] as $size)
                                <option value="{{ $size }}" {{ old('employee_count') === $size ? 'selected' : '' }}>
                                    {{ $size }} Employees
                                </option>
                            @endforeach
                        </select>
                        @error('employee_count')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-gray-900 rounded-lg hover:bg-gray-700 transition">
                    Create Company Profile
                </button>
                <a href="{{ route('recruiter.dashboard') }}"
                   class="px-6 py-2.5 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    {{-- ──────────── RIGHT: RECRUITER CONTACT PREVIEW ──────────── --}}
    <div class="col-span-1 space-y-5">

        <div class="bg-white rounded-xl border border-gray-200 p-5 mt-6">
            <h2 class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-4">Recruiter Contact</h2>

            <div class="flex items-center gap-3 mb-4">
                <div class="w-11 h-11 rounded-full bg-gray-100 flex items-center justify-center shrink-0 overflow-hidden ring-2 ring-gray-100">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                             class="w-full h-full object-cover" alt="{{ auth()->user()->name }}">
                    @else
                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">Recruiter</p>
                </div>
            </div>

            <ul class="space-y-2.5">
                <li class="flex items-center gap-2.5 text-sm text-gray-600">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="truncate text-blue-600">{{ auth()->user()->email }}</span>
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
                @if($user->linkedin_url)
                <li class="flex items-center gap-2.5 text-sm text-gray-600">
                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    <a href="{{ $user->linkedin_url }}" target="_blank"
                       class="text-blue-600 hover:underline truncate">
                        {{ str_replace(['https://www.','https://','http://'], '', $user->linkedin_url) }}
                    </a>
                </li>
                @endif
            </ul>
        </div>

        {{-- Info banner --}}
      
       <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-center justify-between">
    <div>
        <h3 class="text-sm font-medium text-blue-900">
            Complete Your Profile
        </h3>
        <p class="text-xs text-blue-700 mt-1">
            Update your account information and profile settings.
        </p>
    </div>

    <a href="{{ route('profile.edit') }}"
       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
        Account Settings
    </a>
</div>

    </div>

</div>

<script>
function previewLogo(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        const preview = document.getElementById('logo-preview');
        preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" alt="Logo preview">`;
    };
    reader.readAsDataURL(input.files[0]);
}

function previewCover(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        const preview = document.getElementById('cover-preview');
        preview.innerHTML = `<img src="${e.target.result}" class="absolute inset-0 w-full h-full object-cover" alt="Cover preview">`;
    };
    reader.readAsDataURL(input.files[0]);
}
</script>

@endsection
