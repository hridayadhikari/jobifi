@extends('master_index')
@section('title', 'Recruiter Profile')

@section('content')

{{-- Header --}}
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Recruiter Profile</h1>
        <p class="text-sm text-gray-500 mt-0.5">Viewing recruiter account details.</p>
    </div>
    
  
</div>

<div class="max-w-5xl mx-auto space-y-6">

    {{-- Profile Header Card --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
        
        <div class="h-32 bg-gradient-to-r from-emerald-500 via-green-500 to-teal-500"></div>

        <div class="p-8">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 -mt-20">
                
                {{-- Avatar (Read-only) --}}
                <div class="relative w-28 h-28 shrink-0">
                    <img src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&size=128&background=22c55e&color=fff' }}"
                         class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg bg-white">
                </div>

                {{-- Name & Badge --}}
                <div class="pt-2 sm:pt-10 text-center sm:text-left">
                    <h2 class="text-3xl font-bold text-gray-900">
                        {{ $user->name }}
                    </h2>

                    <p class="text-gray-500 mt-1">
                        {{ $user->email }}
                    </p>

                    <span class="inline-flex items-center mt-3 px-4 py-1.5 bg-gradient-to-r from-emerald-500 to-green-600 text-white text-xs font-semibold rounded-full shadow-sm">
                        Recruiter
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Profile Information --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
        <h2 class="text-base font-semibold text-gray-900 mb-5">Profile Information</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-2">Name</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm text-gray-800 font-medium">
                    {{ $user->name }}
                </div>
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-2">Email Address</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm text-gray-800 font-medium">
                    {{ $user->email }}
                </div>
            </div>
        </div>
    </div>

    {{-- Company Info (Recruiter-specific) --}}
    @if($user->company)
    <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
        <h2 class="text-base font-semibold text-gray-900 mb-5">Company Affiliation</h2>
        
        <div class="flex items-center gap-4 p-5 bg-gray-50 rounded-xl border border-gray-100">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-gray-900 text-base">{{ $user->company->name }}</p>
                <div class="flex items-center mt-1 text-sm text-gray-500">
                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $user->company->headquarters_location ?? 'Location not set' }}
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection