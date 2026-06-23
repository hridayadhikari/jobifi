@extends('master_index')

@section('title', 'Application Details')

@section('content')

<div class="bg-[#f8f9fa] min-h-screen font-sans py-16 px-6 flex justify-center">

    <div class="w-full max-w-[800px]">

        {{-- Top Navigation --}}

        <a href="{{ route('seeker.applications.index') }}" class="inline-flex items-center gap-2 text-[13px] font-bold text-gray-400 hover:text-black uppercase tracking-wider transition mb-10">
            <ion-icon name="arrow-back-outline" class="text-lg"></ion-icon>
            Back to Applications
        </a>

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
            
            <div>
                <h1 class="text-[32px] font-extrabold text-[#0a192f] tracking-tight leading-tight">
                   {{ $application->job->title ?? 'N/A'}}
                </h1>
                <div class="flex items-center gap-2 text-[15px] text-gray-500 mt-2">
                    <span class="font-semibold text-slate-700">{{ $application->job->location }}</span>
                    <span>&middot;</span>
                    <span>Applied on {{ $application->created_at->format('M d, Y') }}</span>
                </div>
            </div>

            {{-- High-Contrast Status Badge --}}
            <span class="inline-block border-2 border-black px-4 py-1.5 text-[12px] font-bold text-black uppercase tracking-[0.1em]">
               {{$application->status}}
            </span>

        </div>

        {{-- Application Materials Container --}}
        <div class="bg-white border border-gray-200 shadow-sm p-10 md:p-12 mb-8">
            
            <h2 class="text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-8 border-b border-gray-100 pb-4">
                Submitted Materials
            </h2>

            {{-- Submitted Resume Card --}}
            <div class="mb-12 p-5 border border-gray-200 rounded-lg flex items-center justify-between bg-gray-50/50 group hover:border-gray-300 transition duration-200">
                <div class="flex items-center gap-5">
                    <div class="w-12 h-12 bg-white border border-gray-200 rounded flex items-center justify-center shadow-sm">
                        <ion-icon name="document-text-outline" class="text-2xl text-gray-400"></ion-icon>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-1">
                            Resume
                        </p>
                        <p class="text-[15px] font-bold text-slate-800">
                         {{ $profile->resume_original_name ?? 'resume.pdf' }}
                        </p>
                    </div>
                </div>
                <a href="{{ asset('storage/' . $application->resume_path)}}" target="_blank" class="text-[13px] font-bold text-black border-b border-black pb-0.5 hover:text-gray-500 hover:border-gray-500 transition duration-200">
                    View File
                </a>
            </div>

            {{-- Cover Letter Content --}}
            <div>
                <h3 class="text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-5">
                    Cover Letter
                </h3>
                
                <div class="whitespace-pre-line text-[15px] text-slate-700 leading-relaxed space-y-6">
                    <p>
                    {{$application->cover_letter}}
                    </p>
                </div>
            </div>

        </div>

        {{-- Footer Actions --}}
        <div class="flex flex-col-reverse md:flex-row justify-between items-center gap-6 mt-8">
            
            {{-- Destructive Action --}}
            <button class="text-[13px] font-bold text-red-500 hover:text-red-700 uppercase tracking-wider transition">
                Withdraw Application
            </button>
@dd()
            {{-- Primary Action --}}
            <button class="w-full md:w-auto px-8 py-3 bg-black border-2 border-black text-white text-[14px] font-bold hover:bg-[#1a1a1a] transition duration-200 shadow-sm">
                Contact Recruiter
            </button>

        </div>

    </div>

</div>

@endsection