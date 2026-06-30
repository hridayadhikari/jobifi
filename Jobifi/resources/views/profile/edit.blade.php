@extends('master_index')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Profile Photo Card --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex items-center gap-5">

                    {{-- Form handles submission of the cropped data --}}
                    <form id="photo-upload-form"
                          method="POST"
                          action="{{ route('profile.update') }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="name"  value="{{ auth()->user()->name }}">
                        <input type="hidden" name="email" value="{{ auth()->user()->email }}">

                        {{-- Hidden file input --}}
                        <input
                            type="file"
                            id="profile_photo_input"
                            name="profile_photo"
                            accept="image/jpg,image/jpeg,image/png"
                            class="hidden"
                        >

                        {{-- Avatar wrapper — triggers the generic crop modal --}}
                        <div
                            id="avatar-container"
                            class="relative w-16 h-16 cursor-pointer group"
                            onclick="openCropModal('profile_photo_input', 'avatar', 'avatar-container')"
                            title="Click to change photo"
                        >
                            {{-- The profile image --}}
                            @if(auth()->user()->profile_photo)
                                <img
                                    id="profile-avatar"
                                    src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                    alt="Profile Photo"
                                    class="w-16 h-16 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-600"
                                >
                            @else
                                <img
                                    id="profile-avatar"
                                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=64&background=6366f1&color=fff"
                                    alt="Profile Photo"
                                    class="w-16 h-16 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-600"
                                >
                            @endif

                            {{-- Hover overlay --}}
                            <div class="absolute inset-0 rounded-full bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex flex-col items-center justify-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 7h4l2-2h6l2 2h4v12H3V7zm9 10a4 4 0 100-8 4 4 0 000 8z"/>
                                </svg>
                                <span class="text-white text-[10px] font-medium leading-none">Change</span>
                            </div>
                        </div>
                    </form>

                    {{-- Name & email --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ auth()->user()->name }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ auth()->user()->email }}
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Click the photo to update it</p>
                    </div>
                </div>
            </div>

            {{-- Profile Information --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Password --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

    {{-- Page-specific crop callback (modal HTML + JS lives in your crop-modal partial) --}}
    <script>
        window.onCropConfirmed = function (target, dataUrl) {
            if (target === 'avatar') {
                // 1. Update the UI
                document.getElementById('profile-avatar').src = dataUrl;
                
                // 2. Inject the Base64 data into the form
                let form = document.getElementById('photo-upload-form');
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