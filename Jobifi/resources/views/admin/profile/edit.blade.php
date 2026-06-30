@extends('master_index')
@section('title', 'Account Settings')

@section('content')



{{-- Header --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Account Settings</h1>
    <p class="text-sm text-gray-500 mt-0.5">Manage your admin account details.</p>
</div>

<div class="max-w-5xl mx-auto space-y-6">

    {{-- Avatar + Name --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">

        <div class="h-32 bg-gradient-to-r from-emerald-500 via-green-500 to-teal-500"></div>

        <div class="p-8">
            <div class="flex items-center gap-6 -mt-20">

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="photo-form">
                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="name"  value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">

                    <input type="file"
                           id="photo_input"
                           name="profile_photo"
                           accept="image/jpg,image/jpeg,image/png"
                           class="hidden">

                    <div id="avatar-container" class="relative w-28 h-28 cursor-pointer group"
                         onclick="openCropModal('photo_input', 'avatar', 'avatar-container')">

                        <img id="profile-avatar"
                             src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&size=128&background=22c55e&color=fff' }}"
                             class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg" alt="Avatar">

                        <div class="absolute bottom-0 right-0 bg-emerald-600 rounded-full p-2 shadow-lg group-hover:bg-emerald-700 transition-colors">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h4l2-2h6l2 2h4v12H3V7zm9 10a4 4 0 100-8 4 4 0 000 8z"/>
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
                        Administrator
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
    window.onCropConfirmed = function (target, dataUrl) {
        if (target === 'avatar') {
            // 1. Update the UI
            document.getElementById('profile-avatar').src = dataUrl;
            
            // 2. Inject the Base64 data into the form
            let form = document.getElementById('photo-form');
            let hiddenInput = document.getElementById('cropped_avatar_data');
            
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                // The distinct name for your controller to process
                hiddenInput.name = 'cropped_profile_photo'; 
                hiddenInput.id = 'cropped_avatar_data';
                form.appendChild(hiddenInput);
            }
            
            hiddenInput.value = dataUrl;

            // 3. Close modal and submit
            if (typeof closeCropModal === 'function') {
                closeCropModal();
            }
            form.submit();
        }
    };
</script>

@endsection