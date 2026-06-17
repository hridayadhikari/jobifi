@extends('master_index')
@section('title', 'Job Postings')

@section('content')

<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto">

        {{-- Header --}}
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 uppercase tracking-tight">Job Postings</h1>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mt-1">
                    Manage your active, closed, and draft job listings.
                </p>
            </div>
            <a href="{{ route('recruiter.jobs.create') }}"
               class="inline-flex items-center gap-2 rounded-md bg-black px-5 py-3 text-sm font-semibold text-white hover:bg-gray-800 transition-colors whitespace-nowrap">
                <span class="text-lg leading-none">+</span> POST NEW JOB
            </a>
        </div>

        {{-- Search & Filter Bar --}}
        <div class="flex items-center gap-3 mb-4">
            {{-- Search --}}
            {{-- <div class="flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm w-10 focus-within:w-64 transition-all duration-300">
                <svg class="h-4 w-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" placeholder="Search jobs…"
                       class="ml-2 w-full border-none bg-transparent text-sm text-gray-700 outline-none placeholder-gray-400" />
            </div> --}}

            {{-- Status Filter Dropdown --}}
            <div class="relative">
                <select class="appearance-none rounded-md border border-gray-300 bg-white pl-4 pr-10 py-2 text-sm text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-black cursor-pointer">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="closed">Closed</option>
                    <option value="draft">Draft</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Job List --}}
        @if($jobs->isEmpty())
            <div class="rounded-xl border border-dashed border-gray-300 bg-white p-12 text-center shadow-sm">
                <svg class="mx-auto mb-4 h-10 w-10 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6m16 0v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5m16 0H4"/>
                </svg>
                <p class="text-base font-semibold text-gray-700">No jobs posted yet.</p>
                <p class="mt-1 text-sm text-gray-400">Start by creating your first job posting.</p>
            </div>
        @else
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm divide-y divide-gray-100">
                @foreach($jobs as $job)
                    @php
                        $status = $job->status ?? ($job->is_active ? 'active' : 'draft');
                        // Normalise to lowercase string
                        $status = strtolower($status);
                    @endphp
                    <div class="flex items-center gap-4 px-6 py-5">

                        {{-- Icon --}}
                        <div class="flex-shrink-0 h-11 w-11 rounded-lg bg-gray-100 flex items-center justify-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                            </svg>
                        </div>

                        {{-- Title & Meta --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-base font-bold text-gray-900 truncate">{{ $job->title }}</p>
                            <div class="mt-1 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-gray-400 font-medium uppercase tracking-wide">
                                {{-- Applicants --}}
                                <span class="inline-flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 0 0-4-4h-1M9 20H4v-2a4 4 0 0 1 4-4h1m4-4a4 4 0 1 1-8 0 4 4 0 0 1 8 0zm6 4a3 3 0 1 0-6 0"/>
                                    </svg>
                                    {{ $job->applications_count ?? $job->applications()->count() }} Applicants
                                </span>
                                {{-- Posted --}}
                                <span class="inline-flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                                    </svg>
                                    Posted {{ $job->created_at->diffForHumans() }}
                                </span>
                                {{-- Job Type --}}
                                <span class="inline-flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657A8 8 0 1 1 6.343 5.343"/>
                                    </svg>
                                    {{ ucwords(str_replace('-', ' ', $job->type)) }}
                                </span>
                            </div>
                        </div>

                        {{-- Status Badge --}}
                        <div class="flex-shrink-0">
                            @if($status === 'active')
                                <span class="inline-block rounded px-3 py-1 text-xs font-bold uppercase tracking-widest bg-black text-white">
                                    Active
                                </span>
                            @elseif($status === 'closed')
                                <span class="inline-block rounded px-3 py-1 text-xs font-bold uppercase tracking-widest border border-gray-300 text-gray-600">
                                    Closed
                                </span>
                            @else
                                <span class="inline-block rounded px-3 py-1 text-xs font-bold uppercase tracking-widest border border-yellow-400 text-yellow-600">
                                    Draft
                                </span>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex-shrink-0 flex items-center gap-2">
                            <a href="{{ route('recruiter.jobs.edit', $job->id) }}"
                               class="rounded border border-gray-300 px-4 py-1.5 text-xs font-semibold uppercase tracking-wide text-gray-700 hover:bg-gray-50 transition-colors">
                                Edit
                            </a>
                            <a href="#"
                               class="rounded border border-gray-300 px-4 py-1.5 text-xs font-semibold uppercase tracking-wide text-gray-700 hover:bg-gray-50 transition-colors">
                                Applicants
                            </a>
                            <form action="{{ route('recruiter.jobs.destroy', $job->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="delete-btn flex items-center justify-center rounded border border-gray-200 p-2 text-gray-400 hover:border-red-300 hover:text-red-500 transition-colors"
                                        data-name="{{ $job->title }} job posting">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/>
                                    </svg>
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($jobs->hasPages())
                <div class="mt-6">
                    {{ $jobs->links() }}
                </div>
            @endif
        @endif

    </div>
</div>

@endsection