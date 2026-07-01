@extends('master_index')
@section('title', 'Account Settings')

@section('content')

@if(session('status') === 'profile-updated')
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
     class="mb-4 flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">
    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
    Profile updated successfully.
</div>
@endif

{{-- Header --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Account Settings</h1>
    <p class="text-sm text-gray-500 mt-0.5">Manage your recruiter account details.</p>
</div>

<div class="max-w-5xl mx-auto space-y-6">


   <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">

    <div class="h-32 bg-gradient-to-r from-emerald-500 via-green-500 to-teal-500"></div>

    <div class="p-8">
        <div class="flex items-center gap-6 -mt-20">

            <form method="POST"
                  action="{{ route('profile.update') }}"
                  enctype="multipart/form-data"
                  id="photo-form">

                @csrf
                @method('PATCH')

                <input type="hidden" name="name" value="{{ $user->name }}">
                <input type="hidden" name="email" value="{{ $user->email }}">

                <input type="file"
                       id="photo_input"
                       name="profile_photo"
                       accept="image/jpg,image/jpeg,image/png"
                       class="hidden"
                       onchange="previewAndSubmit()">

                <div class="relative w-28 h-28 cursor-pointer group"
                     onclick="document.getElementById('photo_input').click()">

                    <img id="profile-avatar"
                         src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&size=128&background=22c55e&color=fff' }}"
                         class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg">

                    <div class="absolute bottom-0 right-0 bg-emerald-600 rounded-full p-2 shadow-lg">
                        <svg class="w-4 h-4 text-white"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M3 7h4l2-2h6l2 2h4v12H3V7zm9 10a4 4 0 100-8 4 4 0 000 8z"/>
                        </svg>
                    </div>
                </div>

            </form>

            <div class="pt-10">
                <h2 class="text-3xl font-bold text-gray-900">
                    {{ $user->name }}
                </h2>

                <p class="text-gray-500 mt-1">
                    {{ $user->email }}
                </p>

                <span class="inline-flex items-center mt-3 px-4 py-1.5 bg-gradient-to-r from-emerald-500 to-green-600 text-white text-xs font-semibold rounded-full">
                    Recruiter
                </span>
            </div>
        </div>
    </div>
</div>

    {{-- Update name & email --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
        <h2 class="text-base font-semibold text-gray-900 mb-5">Profile Information</h2>
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf @method('PATCH')
            <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition @error('name') border-red-400 @enderror">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition @error('email') border-red-400 @enderror">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <button type="submit"
                        class="px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-green-600 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    {{-- Company Info (Recruiter-specific) --}}
    @if($user->company)
    <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
        <h2 class="text-base font-semibold text-gray-900 mb-5">Company</h2>
        <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
            <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <p class="font-semibold text-gray-900 text-sm">{{ $user->company->name }}</p>
                <p class="text-xs text-gray-500">{{ $user->company->headquarters_location ?? 'Location not set' }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Change Password --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
       <h2 class="text-base font-semibold text-gray-900 mb-5">Change Password</h2>
        @include('profile.partials.update-password-form')
    </div>

    {{-- Danger Zone --}}
    <div class="bg-white rounded-2xl border border-red-100 p-8 shadow-sm">
        <h2 class="text-base font-semibold text-red-700 mb-1">Danger Zone</h2>
        <p class="text-sm text-gray-500 mb-4">Permanently delete your account. This action cannot be undone.</p>
        @include('profile.partials.delete-user-form')
    </div>

</div>

<script>
function previewAndSubmit() {
    const input  = document.getElementById('photo_input');
    const avatar = document.getElementById('profile-avatar');
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = (e) => { avatar.src = e.target.result; };
    reader.readAsDataURL(input.files[0]);
    document.getElementById('photo-form').submit();
}
</script>

@endsection