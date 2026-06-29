@extends('master_index')

@section('title', 'Review Candidate')

@section('content')

    <div class="bg-[#f8f9fa] min-h-screen font-sans py-12 px-6">

        <div class="max-w-[1100px] mx-auto">

            {{-- Back Button --}}
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center gap-2 text-[13px] font-bold text-gray-400 hover:text-black uppercase tracking-wider transition mb-8">
                <ion-icon name="arrow-back-outline" class="text-lg"></ion-icon>
                Back to Applicants
            </a>

            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">

                <div class="flex items-center gap-5">

                    <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-100 border border-gray-200">
                        <a href="{{ route('recruiter.seeker.show', $application->user) }}">
                            @if ($application->user->profile_photo)
                                <img src="{{ asset('storage/' . $application->user->profile_photo) }}"
                                    alt="{{ $application->user->name }}" class="w-full h-full object-cover">
                            @endif

                    </div>

                    <div>
                        <h1 class="text-[24px] font-extrabold text-[#0a192f] tracking-tight leading-none mb-1.5">
                            {{ $application->user->name }}
                        </h1>

                        <p class="text-[14px] text-gray-500">
                            Applied for
                            <span class="font-bold text-slate-800">
                                {{ $application->job->title }}
                            </span>
                            &middot;
                            {{ $application->created_at->diffForHumans() }}
                        </p>
                    </div>
                    </a>
                </div>

                {{-- Status Update --}}
                <form action="{{ route('recruiter.applicants.update-status', $application) }}" method="POST"
                    class="flex items-center gap-3 w-full md:w-auto">

                    @csrf
                    @method('PATCH')

                    <div class="relative">

                        <select name="status" id="status"
                            class="appearance-none bg-white border border-gray-200 px-4 py-2.5 pr-10 text-[13px] font-medium text-slate-700 focus:outline-none">

                            <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="reviewed" {{ $application->status == 'reviewed' ? 'selected' : '' }}>
                                Reviewed
                            </option>

                            <option value="shortlisted" {{ $application->status == 'shortlisted' ? 'selected' : '' }}>
                                Shortlisted
                            </option>

                            <option value="interview_scheduled"
                                {{ $application->status == 'interview_scheduled' ? 'selected' : '' }}>
                                Interview Scheduled
                            </option>

                            <option value="selected" {{ $application->status == 'selected' ? 'selected' : '' }}>
                                Selected
                            </option>

                            <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>
                                Rejected
                            </option>

                            <option value="withdrawn" {{ $application->status == 'withdrawn' ? 'selected' : '' }}>
                                Withdrawn
                            </option>

                        </select>

                        <ion-icon name="chevron-down-outline"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">
                        </ion-icon>

                    </div>

                    <button type="submit"
                        class="bg-black text-white text-[13px] font-bold px-6 py-2.5 hover:bg-[#1a1a1a] transition">
                        Update Status
                    </button>

                </form>

            </div>

            {{-- Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left Side --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Cover Letter --}}
                    <div class="bg-white border border-gray-200 shadow-sm">

                        <div class="px-6 py-4 border-b border-gray-100">
                            <h2 class="text-[11px] font-bold text-[#0a192f] uppercase tracking-[0.1em]">
                                Cover Letter
                            </h2>
                        </div>

                        <div class="p-6">
                            <p class="whitespace-pre-line text-[14px] text-slate-700 leading-relaxed">
                                {{ $application->cover_letter ?? 'No cover letter provided.' }}
                            </p>
                        </div>

                    </div>

                    {{-- Resume --}}
                    <div class="bg-white border border-gray-200 shadow-sm">

                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">

                            <h2 class="text-[11px] font-bold text-[#0a192f] uppercase tracking-[0.1em]">
                                Resume
                            </h2>

                            @if ($application->resume_path)
                                <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank"
                                    class="text-[12px] font-bold text-black">
                                    View Resume
                                </a>
                            @endif

                        </div>

                        <div class="p-6">

                            <div
                                class="border-2 border-dashed border-gray-200 rounded-lg h-[300px] flex flex-col items-center justify-center bg-gray-50">

                                <ion-icon name="document-text-outline" class="text-6xl text-gray-300 mb-4">
                                </ion-icon>

                                <p class="text-[14px] font-medium text-gray-400">
                                    Resume Available
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Right Side --}}
                <div class="lg:col-span-1 space-y-8">

                    {{-- Candidate Info --}}
                    <div class="bg-white border border-gray-200 shadow-sm">

                        <div class="px-6 py-4 border-b border-gray-100">
                            <h2 class="text-[11px] font-bold text-[#0a192f] uppercase tracking-[0.1em]">
                                Candidate Info
                            </h2>
                        </div>

                        <div class="p-6 space-y-6">

                            <div>
                                <p class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-1">
                                    Email
                                </p>

                                <p class="text-[14px] text-slate-900 font-medium">
                                    {{ $application->user->email }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-1">
                                    Phone
                                </p>

                                <p class="text-[14px] text-slate-900 font-medium">
                                    {{ $application->user->seekerProfile->phone ?? 'Not Provided' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-1">
                                    Location
                                </p>

                                <p class="text-[14px] text-slate-900 font-medium">
                                    {{ $application->user->seekerProfile->address ?? 'Not Provided' }}
                                </p>
                            </div>

                        </div>

                    </div>

                    {{-- Timeline --}}
                    <div class="bg-white border border-gray-200 shadow-sm">

                        <div class="px-6 py-4 border-b border-gray-100">
                            <h2 class="text-[11px] font-bold text-[#0a192f] uppercase tracking-[0.1em]">
                                Application Timeline
                            </h2>
                        </div>

                        <div class="p-6">

                            <div class="relative pl-5 border-l-2 border-gray-100 space-y-6">

                                <div class="relative">

                                    <div class="absolute -left-[25px] top-1.5 w-2 h-2 rounded-full bg-gray-300">
                                    </div>

                                    <p class="text-[13px] font-bold text-slate-900">
                                        Application Submitted
                                    </p>

                                    <p class="text-[11px] text-gray-500">
                                        {{ $application->created_at->format('d M Y') }}
                                    </p>

                                </div>

                                <div class="relative">

                                    <div class="absolute -left-[25px] top-1.5 w-2 h-2 rounded-full bg-gray-300">
                                    </div>

                                    <p class="text-[13px] font-bold text-slate-900">
                                        Current Status:
                                        {{ ucfirst(strtolower($application->status)) }}
                                    </p>

                                    <p class="text-[11px] text-gray-500">
                                        Updated:
                                        {{ $application->updated_at->format('d M Y') }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        <div id="interviewModal"
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden items-center justify-center z-50 p-4">

            <div class="bg-white border border-gray-200 shadow-2xl w-full max-w-lg rounded-sm overflow-hidden">

                {{-- Modal Header --}}
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h2 class="text-[20px] font-extrabold text-[#0a192f] tracking-tight">
                        Schedule Interview
                    </h2>
                    {{-- Optional Close Icon (if you want an X at the top right) --}}
                    <button type="button" id="closeModalIcon"
                        class="text-gray-400 hover:text-black transition duration-200">
                        <ion-icon name="close-outline" class="text-2xl"></ion-icon>
                    </button>
                </div>

                {{-- Modal Body / Form --}}

                <form method="POST" id="interviewForm" class="p-8"
                    action="{{ route('recruiter.applications.schedule', $application) }}">

                    @csrf
                    <div class="mb-6">
                        <label class="block text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-2.5">
                            Interview Date & Time
                        </label>
                        <input type="datetime-local" name="interview_at"
                            class="w-full bg-white border border-gray-200 px-4 py-3 text-[14px] text-slate-700 focus:outline-none focus:border-black focus:ring-0 transition duration-200">
                    </div>

                    <div class="mb-6">
                        <label class="block text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-2.5">
                            Meeting Link
                        </label>
                        <input type="url" name="meeting_link" placeholder="e.g., https://meet.google.com/..."
                            class="w-full bg-white border border-gray-200 px-4 py-3 text-[14px] text-slate-700 placeholder-gray-400 focus:outline-none focus:border-black focus:ring-0 transition duration-200">
                    </div>

                    <div class="mb-8">
                        <label class="block text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-2.5">
                            Notes
                        </label>
                        <textarea name="notes" rows="4" placeholder="Instructions or agenda for the candidate..."
                            class="w-full bg-white border border-gray-200 px-4 py-3 text-[14px] text-slate-700 placeholder-gray-400 focus:outline-none focus:border-black focus:ring-0 transition duration-200 resize-y"></textarea>
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end items-center gap-4 pt-2">
                        <button type="button" id="closeModal"
                            class="px-6 py-2.5 bg-white border-2 border-black text-black text-[13px] font-bold hover:bg-gray-50 transition duration-200">
                            Cancel
                        </button>

                        <button type="submit"
                            class="px-6 py-2.5 bg-black border-2 border-black text-white text-[13px] font-bold hover:bg-[#1a1a1a] transition duration-200 shadow-sm">
                            Schedule
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
    <script>
        const status = document.getElementById('status');

        status.addEventListener('change', function() {

            if (this.value === 'interview_scheduled') {

                document.getElementById('interviewModal')
                    .classList.remove('hidden');

                document.getElementById('interviewModal')
                    .classList.add('flex');
            }

        });
        document.getElementById('closeModal')
            .addEventListener('click', function() {

                document.getElementById('interviewModal')
                    .classList.add('hidden');

                document.getElementById('interviewModal')
                    .classList.remove('flex');
            });
    </script>
@endsection
