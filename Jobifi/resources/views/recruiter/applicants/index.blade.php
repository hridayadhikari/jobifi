@extends('master_index')

@section('title', 'Applicants List')

@section('content')

    <div class="bg-[#f8f9fa] min-h-screen font-sans py-12 px-6">

        <div class="max-w-[1100px] mx-auto">

            {{-- Page Header --}}
            <h1 class="text-[32px] font-extrabold text-[#0a192f] tracking-tight mb-8">
                Applicants List
            </h1>

            {{-- Filters Section --}}
            <form action="#" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

                {{-- Name Filter --}}
                <div>
                    <input type="text" name="name" placeholder="Filter by name"
                        class="w-full bg-white border border-gray-200 px-4 py-3.5 text-[14px] text-slate-700 placeholder-gray-400 focus:outline-none focus:border-gray-400 focus:ring-0 transition">
                </div>

                {{-- Job Filter --}}
                <div>
                    <input type="text" name="job" placeholder="Filter by job"
                        class="w-full bg-white border border-gray-200 px-4 py-3.5 text-[14px] text-slate-700 placeholder-gray-400 focus:outline-none focus:border-gray-400 focus:ring-0 transition">
                </div>

                {{-- Status Filter --}}
                <div>
                    <input type="text" name="status" placeholder="Filter by status"
                        class="w-full bg-white border border-gray-200 px-4 py-3.5 text-[14px] text-slate-700 placeholder-gray-400 focus:outline-none focus:border-gray-400 focus:ring-0 transition">
                </div>

                {{-- Submit Action --}}
                <div>
                    <button type="submit"
                        class="w-full bg-black text-white font-bold px-4 py-3.5 text-[14px] hover:bg-[#1a1a1a] transition duration-200">
                        Apply Filters
                    </button>
                </div>

            </form>

            {{-- Applicants List Container --}}
            <div class="bg-white border border-gray-200 shadow-sm overflow-hidden">

                <div class="flex flex-col divide-y divide-gray-100">
                    <div class="flex flex-col divide-y divide-gray-100">

                        @forelse($applications as $application)
                            <div class="flex items-center justify-between p-6 hover:bg-gray-50/50 transition duration-200">

                                <div class="flex items-center gap-5">

                                    <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100">
                                        @if ($application->user->profile_photo)
                                            <img src="{{ asset('storage/' . $application->user->profile_photo) }}"
                                                class="w-full h-full object-cover">
                                        @endif
                                    </div>

                                    <div>
                                        <p class="text-[16px] font-bold text-slate-900">
                                            {{ $application->user->name }}
                                        </p>

                                        <p class="text-[13px] text-gray-500 mt-0.5">
                                            Applied for: {{ $application->job->title }}
                                        </p>
                                    </div>

                                </div>

                                <div class="flex items-center gap-6">

                                    <span
                                        class="inline-block bg-gray-100 text-slate-700 px-3 py-1.5 text-[12px] font-medium tracking-wide">
                                        {{ ucfirst($application->status) }}
                                    </span>

                                    <a href="{{ route('recruiter.applicants.show', $application->id) }}"
                                        class="inline-block px-6 py-2.5 bg-white border-2 border-black text-black text-[13px] font-bold hover:bg-gray-50 transition duration-200">
                                        Review
                                    </a>

                                </div>

                            </div>

                        @empty

                            <div class="p-10 text-center text-gray-500">
                                No applicants found.
                            </div>
                        @endforelse

                    </div>
                </div>

            </div>

        </div>

    @endsection
