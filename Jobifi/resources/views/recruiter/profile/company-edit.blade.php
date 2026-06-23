@extends('master_index')
@section('title', 'Edit Company Profile')

@section('content')

{{-- Header --}}
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="page-heading">Edit Company Profile</h1>
        <p class="page-subheading">Update your company information.</p>
    </div>
    <a href="{{ route('recruiter.profile.show') }}"
       class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Profile
    </a>
</div>

<div class="grid grid-cols-3 gap-6">

    {{-- ──────────── LEFT: FORM ──────────── --}}
    <div class="col-span-2">
        <form method="POST" action="{{ route('recruiter.profile.company.update') }}"
              enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            {{-- Company Logo --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="card-heading">Company Logo</h2>
                <div class="flex items-center gap-5">
                    <div id="recruiter-logo-container"
                         class="w-20 h-20 rounded-xl border border-gray-200 bg-gray-50 flex items-center justify-center overflow-hidden shrink-0 shadow-sm">
                        @if($user->company->logo_path)
                            <img id="logo-preview-img" src="{{ asset('storage/' . $user->company->logo_path) }}"
                                 class="w-full h-full object-cover" alt="{{ $user->company->name }}">
                        @else
                            <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <button type="button" onclick="openCropModal('logo', 'logo', 'recruiter-logo-container')"
                               class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            {{ $user->company->logo_path ? 'Change Logo' : 'Upload Logo' }}
                        </button>
                        <input type="file" id="logo" name="logo" accept="image/png,image/jpg,image/jpeg,image/webp"
                               class="hidden">
                        <p class="text-xs text-gray-400 mt-1.5">PNG, JPG, WEBP · Max 2 MB</p>
                        @error('logo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Company Cover Photo --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="card-heading">Company Cover Photo</h2>
                <div class="space-y-4">
                    <div id="recruiter-cover-container" class="relative overflow-hidden rounded-xl border border-gray-200 bg-gray-50 h-40 flex items-center justify-center">
                        @if($user->company->cover_photo)
                            <img id="cover-preview-img" src="{{ asset('storage/' . $user->company->cover_photo) }}"
                                 class="absolute inset-0 w-full h-full object-cover" alt="Company Cover">
                        @else
                            <img id="cover-preview-img" src="" class="absolute inset-0 w-full h-full object-cover hidden" alt="Company Cover">
                            <span id="cover-placeholder" class="text-sm text-gray-400">No cover photo uploaded yet.</span>
                        @endif
                    </div>
                    <div>
                        <button type="button" onclick="openCropModal('cover', 'cover', 'recruiter-cover-container')"
                               class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            {{ $user->company->cover_photo ? 'Change Cover Photo' : 'Upload Cover Photo' }}
                        </button>
                        <input type="file" id="cover" name="cover_photo" accept="image/png,image/jpg,image/jpeg,image/webp"
                               class="hidden">
                        <p class="text-xs text-gray-400 mt-1.5">PNG, JPG, WEBP · Max 4 MB</p>
                        @error('cover_photo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Company Information --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
                <h2 class="card-heading">Company Information</h2>

                
                {{-- Name --}}
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">
                        Company Name <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="name"
                           value="{{ old('name', $user->company->name) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 transition @error('name') border-red-400 @enderror"
                           placeholder="e.g. Stripe Inc.">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">About the Company</label>
                    <textarea name="description" rows="5"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 transition resize-y @error('description') border-red-400 @enderror"
                              placeholder="Describe your company, mission, and culture…">{{ old('description', $user->company->description) }}</textarea>
                    @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Website --}}
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Website URL</label>
                    <input type="url" name="website"
                           value="{{ old('website', $user->company->website) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 transition @error('website') border-red-400 @enderror"
                           placeholder="https://yourcompany.com">
                    @error('website')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- HQ Location --}}
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Headquarters Location</label>
                    <input type="text" name="headquarters_location"
                           value="{{ old('headquarters_location', $user->company->headquarters_location) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 transition @error('headquarters_location') border-red-400 @enderror"
                           placeholder="e.g. San Francisco, CA">
                    @error('headquarters_location')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Industry --}}
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Industry</label>
                    <input type="text" name="industry"
                           value="{{ old('industry', $user->company->industry) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 transition @error('industry') border-red-400 @enderror"
                           placeholder="e.g. Fintech, SaaS, Healthcare">
                    @error('industry')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Founded Year & Employee Count (side by side) --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Founded Year</label>
                        <input type="number" name="founded_year"
                               value="{{ old('founded_year', $user->company->founded_year) }}"
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
                                <option value="{{ $size }}"
                                    {{ old('employee_count', $user->company->employee_count) === $size ? 'selected' : '' }}>
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
                <button type="submit" class="btn-primary-lg">
                    Save Changes
                </button>
                <a href="{{ route('recruiter.profile.show') }}" class="btn-secondary-lg">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    {{-- ──────────── RIGHT: RECRUITER CONTACT PREVIEW ──────────── --}}
    <div class="col-span-1 space-y-5">

        {{-- Recruiter Contact (read-only) --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 mt-6">
            <h2 class="card-heading">Recruiter Contact</h2>
        

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
                    <p class="text-xs text-gray-500">{{ $user->designation ?? 'Recruiter' }}</p>
                </div>
            </div>

            <ul class="space-y-2.5">
                <li class="flex items-center gap-2.5 text-sm text-gray-600">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="truncate text-blue-600">{{ $user->email }}</span>
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

{{-- ══════════════ CROP MODAL ══════════════ --}}
<div id="crop-modal"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden"
     style="background: rgba(0,0,0,0.65); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col"
         style="max-height: 90vh;">
        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 id="crop-modal-title" class="text-sm font-semibold text-gray-900">Crop Image</h3>
                    <p class="text-xs text-gray-400">Drag to reposition · Scroll to zoom</p>
                </div>
            </div>
            <button id="crop-cancel-btn" type="button"
                    class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Crop Area --}}
        <div class="flex-1 overflow-hidden bg-gray-950 flex items-center justify-center"
             style="min-height: 300px; max-height: 55vh;">
            <img id="crop-image" src="" alt="Crop" style="max-width:100%; display:block;">
        </div>

        {{-- Controls --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{-- Zoom / Rotate toolbar --}}
            <div class="flex items-center justify-center gap-2 mb-4">
                <button type="button" onclick="cropperInstance.zoom(-0.1)"
                        class="p-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 transition text-gray-600" title="Zoom out">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"/>
                    </svg>
                </button>
                <button type="button" onclick="cropperInstance.zoom(0.1)"
                        class="p-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 transition text-gray-600" title="Zoom in">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                    </svg>
                </button>
                <button type="button" onclick="cropperInstance.rotate(-90)"
                        class="p-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 transition text-gray-600" title="Rotate left">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </button>
                <button type="button" onclick="cropperInstance.rotate(90)"
                        class="p-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 transition text-gray-600" title="Rotate right">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 4v5h-.582M4.644 11A8.001 8.001 0 0119.418 9M19.418 9H15m-11 11v-5h.581m0 0a8.003 8.003 0 0015.357-2M4.581 15H9"/>
                    </svg>
                </button>
                <button type="button" onclick="cropperInstance.reset()"
                        class="p-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 transition text-gray-600" title="Reset">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </button>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-3">
                <button id="crop-confirm-btn" type="button"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-gray-900 rounded-lg hover:bg-gray-700 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Apply Crop
                </button>
                <button id="crop-cancel-btn2" type="button"
                        class="px-4 py-2.5 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Page-specific crop callback (modal HTML + JS lives in partials/crop-modal) --}}
<script>
window.onCropConfirmed = function (target, dataUrl) {
    if (target === 'logo') {
        var logoContainer = document.getElementById('recruiter-logo-container');
        var existing      = document.getElementById('logo-preview-img');
        if (existing) {
            existing.src = dataUrl;
        } else {
            logoContainer.innerHTML = '<img id="logo-preview-img" src="' + dataUrl + '" class="w-full h-full object-cover" alt="Logo preview">';
        }
        closeCropModal();
    } else {
        var coverImg    = document.getElementById('cover-preview-img');
        var placeholder = document.getElementById('cover-placeholder');
        coverImg.src = dataUrl;
        coverImg.classList.remove('hidden');
        if (placeholder) placeholder.style.display = 'none';
        closeCropModal();
    }
};
</script>

@endsection

