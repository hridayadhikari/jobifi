@extends('master_index')

@section('title', 'Apply for Senior Product Designer')

@section('content')

    {{-- Main Page Wrapper --}}
    <div class="bg-[#f8f9fa] min-h-screen font-sans text-slate-900 flex justify-center py-16 relative">

        <div class="w-full max-w-[800px] px-6">

            {{-- Header Section --}}
            <div class="mb-10">
                <h1 class="text-[32px] font-extrabold text-[#0a192f] tracking-tight leading-tight">
                    Apply for {{ $job->title }}
                </h1>
                <p class="text-[17px] text-gray-500 mt-1">
                    at {{ $job->location }}
                </p>
            </div>

            {{-- Form Container --}}
            <div class="bg-white border border-gray-200 shadow-sm p-12">

                @if ($errors->any())
                    <div class="mb-8 p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('seeker.jobs.apply', $job) }}" method="POST" enctype="multipart/form-data"
                    x-data="{ replacing: false, fileName: null }">

                    @csrf

                    {{-- Upload Resume Section --}}
                    <div class="mb-10">
                        <label class="block text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-4">
                            Resume
                        </label>

                        {{-- Carries the profile's existing resume path. Distinct name from the
                             file input on purpose, so the two never collide in the request. --}}
                        @if ($profile && $profile->resume_path)
                            <input type="hidden" name="existing_resume_path" value="{{ $profile->resume_path }}">
                        @endif

                        {{-- Existing resume pill: shown by default, hidden once the user picks a new file --}}
                        @if ($profile && $profile->resume_path)
                            <div x-show="!replacing"
                                class="mb-4 p-4 border border-gray-200 rounded-lg flex items-center justify-between bg-gray-50/50">

                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 bg-white border border-gray-200 rounded shadow-sm flex items-center justify-center">
                                        <ion-icon name="document-text-outline" class="text-xl text-gray-400"></ion-icon>
                                    </div>

                                    <div>
                                        <p class="text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-0.5">
                                            Using resume from your profile
                                        </p>
                                        <p class="text-[14px] font-semibold text-slate-800">
                                            {{ $profile->resume_original_name ?? 'resume.pdf' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <a href="{{ asset('storage/' . $profile->resume_path) }}" target="_blank"
                                        class="text-[12px] font-bold text-black border-b border-black pb-0.5 hover:text-gray-500 hover:border-gray-500 transition duration-200">
                                        View
                                    </a>
                                    <button type="button" @click="replacing = true"
                                        class="text-[12px] font-bold text-black border-b border-black pb-0.5 hover:text-gray-500 hover:border-gray-500 transition duration-200">
                                        Replace
                                    </button>
                                </div>
                            </div>
                        @endif

                        {{-- Dropzone: hidden by default if a profile resume exists, shown once "Replace" is clicked.
                             If there's no profile resume at all, this is the only option and shows immediately. --}}
                        <div x-show="{{ $profile && $profile->resume_path ? 'replacing' : 'true' }}"
                            class="relative border-2 border-dashed border-gray-200 rounded-lg p-10 flex flex-col items-center justify-center hover:bg-gray-50/50 transition duration-200 group">

                            <template x-if="!fileName">
                                <div class="flex flex-col items-center">
                                    <ion-icon name="briefcase-outline"
                                        class="text-4xl text-gray-300 mb-4 group-hover:text-gray-400 transition"></ion-icon>
                                    <p class="text-[15px] font-medium text-slate-800">
                                        Click to upload or drag and drop
                                    </p>
                                    <p class="text-[13px] text-gray-400 mt-1.5">
                                        PDF, DOC (Max 5MB)
                                    </p>
                                </div>
                            </template>

                            <template x-if="fileName">
                                <div class="flex flex-col items-center">
                                    <ion-icon name="document-text-outline"
                                        class="text-4xl text-gray-400 mb-4"></ion-icon>
                                    <p class="text-[15px] font-medium text-slate-800" x-text="fileName"></p>
                                </div>
                            </template>

                            {{-- File input always named "resume", separate from "existing_resume_path" --}}
                            <input type="file" name="resume"
                                @change="fileName = $event.target.files[0]?.name ?? null"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".pdf,.doc,.docx" />
                        </div>

                        @if ($profile && $profile->resume_path)
                            <button type="button" x-show="replacing"
                                @click="replacing = false; fileName = null"
                                class="mt-3 text-[12px] font-bold text-gray-400 hover:text-gray-600 transition">
                                Cancel, use profile resume instead
                            </button>
                        @endif
                    </div>

                    {{-- Cover Letter Section --}}
                    <div class="mb-12">
                        <label class="block text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-4">
                            Cover Letter (Optional)
                        </label>
                        <textarea name="cover_letter" rows="7"
                            class="w-full border border-gray-200 rounded-lg p-4 text-[15px] text-slate-700 placeholder-gray-400 focus:outline-none focus:border-gray-300 focus:ring-0 resize-y"
                            placeholder="Tell us why you're a good fit...">{{ old('cover_letter') }}</textarea>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex justify-end items-center gap-4 mt-8">
                    <a class="btn px-8 py-3 bg-white border-2 border-black text-black text-[14px] font-bold hover:bg-gray-50 transition duration-200" href="{{route('seeker.jobs.show',$job)}}"> Cancel</a>
                        
                        <button type="submit"
                            class="px-8 py-3 bg-black border-2 border-black text-white text-[14px] font-bold hover:bg-[#1a1a1a] transition duration-200">
                            Submit Application
                        </button>
                    </div>

                </form>

            </div>

        </div>

        {{-- Floating Help Button --}}
        <button
            class="fixed bottom-8 right-8 w-12 h-12 bg-[#111] text-white rounded-full flex items-center justify-center shadow-lg hover:bg-black transition duration-200 z-50">
            <span class="text-xl font-medium font-serif leading-none mt-1">?</span>
        </button>

    </div>

@endsection