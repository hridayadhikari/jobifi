@extends('master_index')

@section('title', 'Job Postings')

@section('content')

    <div class="p-8">

        {{-- Top Bar: Header & Actions (Fixed in place) --}}
        <div class="flex flex-col md:flex-row justify-between items-start mb-8 gap-4">

            {{-- Page Title --}}
            <div>
                <h1 class="text-3xl font-bold text-slate-900 uppercase tracking-tight">
                    Job Postings
                </h1>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mt-1">
                    Manage your active, closed, and draft job listings.
                </p>
            </div>

            {{-- Filter & Add Button --}}
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                
                {{-- Status Filter --}}
                <form method="GET" class="relative w-full sm:w-48">
                    <ion-icon name="filter-outline" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none"></ion-icon>
                    
                    <select name="status" onchange="this.form.submit()"
                        class="w-full pl-10 pr-8 py-2 text-sm border border-gray-200 rounded-md focus:ring-1 focus:ring-black focus:border-black outline-none transition cursor-pointer appearance-none bg-white">
                        <option value="">All Statuses</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    
                    <ion-icon name="chevron-down-outline" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></ion-icon>
                </form>

                {{-- Post New Job Button --}}
                <a href="{{ route('recruiter.jobs.create') }}"
                    class="flex items-center justify-center gap-2 px-4 py-2 bg-black hover:bg-gray-800 text-white rounded-md text-xs font-bold uppercase tracking-wider transition whitespace-nowrap">
                    <ion-icon name="add-outline" class="text-lg"></ion-icon>
                    Post New Job
                </a>

            </div>

        </div>

        {{-- Table Container --}}
        <div class="bg-white border border-gray-200 rounded-sm overflow-hidden">

            {{-- Scrollable Wrapper --}}
            <div class="overflow-x-auto overflow-y-auto max-h-[calc(100vh-16rem)] relative">
                <table class="w-full text-left border-collapse">

                    {{-- Sticky Table Header --}}
                    <thead class="sticky top-0 z-10 bg-white shadow-[0_1px_0_0_#f3f4f6]">
                        <tr>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400 bg-white">Job Title</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400 bg-white">Type</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400 bg-white">Applicants</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400 bg-white">Status</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400 bg-white">Posted</th>
                            <th class="px-6 py-5 text-right text-xs font-bold uppercase tracking-widest text-gray-400 bg-white">Actions</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($jobs as $job)
                            @php
                                $status = $job->status ?? ($job->is_active ? 'active' : 'draft');
                                $status = strtolower($status);
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition">

                                {{-- Job Title --}}
                                <td class="px-6 py-4 font-bold text-slate-900 text-sm">
                                    {{ $job->title }}
                                </td>

                                {{-- Type Badge --}}
                                <td class="px-6 py-4">
                                    <span class="inline-block px-2 py-1 bg-slate-100 text-slate-600 border border-slate-200 text-[10px] font-bold uppercase tracking-wider rounded-sm">
                                        {{ ucwords(str_replace('-', ' ', $job->type)) }}
                                    </span>
                                </td>

                                {{-- Applicants --}}
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-slate-700">
                                        {{ $job->applications_count ?? $job->applications()->count() }}
                                    </span>
                                </td>

                                {{-- Status Badge --}}
                                <td class="px-6 py-4">
                                    @if ($status === 'active')
                                        <span class="inline-block px-2 py-1 bg-black text-white text-[10px] font-bold uppercase tracking-wider rounded-sm">
                                            Active
                                        </span>
                                    @elseif($status === 'closed')
                                        <span class="inline-block px-2 py-1 bg-gray-100 text-gray-500 border border-gray-200 text-[10px] font-bold uppercase tracking-wider rounded-sm">
                                            Closed
                                        </span>
                                    @else
                                        <span class="inline-block px-2 py-1 bg-gray-200 text-gray-600 text-[10px] font-bold uppercase tracking-wider rounded-sm">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                {{-- Posted On (Relative) --}}
                                <td class="px-6 py-4">
                                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">
                                        {{ $job->created_at->diffForHumans() }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-4">
                                        
                                        <a href="{{ route('recruiter.jobs.edit', $job->id) }}"
                                            class="text-xs font-bold text-slate-800 hover:text-black hover:underline uppercase tracking-wider transition">
                                            Edit
                                        </a>
                                        
                                        <a href="{{ route('recruiter.jobs.applicants', $job->id) }}"
                                            class="text-xs font-bold text-slate-800 hover:text-black hover:underline uppercase tracking-wider transition">
                                            Applicants
                                        </a>

                                        <form action="{{ route('recruiter.jobs.destroy', $job->id) }}" method="POST" class="m-0 p-0 inline-flex items-center">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="delete-btn text-gray-400 hover:text-red-500 transition"
                                                data-name="{{ $job->title }} job posting">
                                                <ion-icon name="trash-outline" class="text-lg"></ion-icon>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <ion-icon name="briefcase-outline" class="text-5xl text-gray-200 mb-3"></ion-icon>
                                    <p class="text-sm font-medium text-gray-400 uppercase tracking-wide">
                                        No jobs posted yet.
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">Start by creating your first job posting.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($jobs->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $jobs->links() }}
            </div>
        @endif

    </div>

@endsection