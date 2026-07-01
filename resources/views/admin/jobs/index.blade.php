@extends('master_index')

@section('title', 'Job Management')

@section('content')

    <div class="p-8">

        {{-- Top Bar: Header & Search --}}
        <div class="flex flex-col md:flex-row justify-between items-start mb-8 gap-4">

            {{-- Page Title --}}
            <div>
                <h1 class="text-3xl font-bold text-slate-900 uppercase tracking-tight">
                    Job Management
                </h1>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mt-1">
                    Manage recruiter job listings and control their visibility.
                </p>
            </div>

            {{-- Combined Search Form --}}
            <div class="w-full md:w-auto">
                <form method="GET" action="{{ route('admin.jobs.index') }}" class="flex flex-col gap-3">
                    
                    <div class="flex items-center gap-2">
                        {{-- Search Bar --}}
                        <div class="relative w-full md:w-72">
                            <ion-icon name="search-outline" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none"></ion-icon>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search jobs..."
                                class="w-full pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-md focus:ring-1 focus:ring-black focus:border-black outline-none transition bg-white">
                            {{-- Hidden submit button so hitting 'Enter' submits the form --}}
                            <button type="submit" class="hidden"></button>
                        </div>

                        {{-- Clear Button --}}
                        @if (request('search'))
                            <a href="{{ route('admin.jobs.index') }}"
                                class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded border border-gray-200 text-xs font-bold uppercase tracking-wider transition">
                                Clear
                            </a>
                        @endif
                    </div>

                </form>
            </div>

        </div>

        {{-- Table Container --}}
        <div class="bg-white border border-gray-200 rounded-sm overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">

                    {{-- Table Header --}}
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Job Title</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Company</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Category</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Type</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Status</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Posted On</th>
                            <th class="px-6 py-5 text-right text-xs font-bold uppercase tracking-widest text-gray-400">Actions</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-100">
                        @forelse($jobs as $job)
                            <tr class="hover:bg-gray-50/50 transition">

                                {{-- Job Title --}}
                                <td class="px-6 py-4 font-bold text-slate-900 text-sm">
                                    {{ $job->title }}
                                </td>

                                {{-- Company --}}
                                <td class="px-6 py-4 text-sm font-medium text-gray-700">
                                    {{ $job->company->name }}
                                </td>

                                {{-- Category --}}
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $job->category->name }}
                                </td>

                                {{-- Type Badge --}}
                                <td class="px-6 py-4">
                                    <span class="inline-block px-2 py-1 bg-slate-100 text-slate-600 border border-slate-200 text-[10px] font-bold uppercase tracking-wider rounded-sm">
                                        {{ $job->type }}
                                    </span>
                                </td>

                                {{-- Status Badge --}}
                                <td class="px-6 py-4">
                                    @if ($job->is_active)
                                        <span class="inline-block px-2 py-1 bg-black text-white text-[10px] font-bold uppercase tracking-wider rounded-sm">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-block px-2 py-1 bg-gray-200 text-gray-600 text-[10px] font-bold uppercase tracking-wider rounded-sm">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                {{-- Posted On --}}
                                <td class="px-6 py-4">
                                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">
                                        {{ $job->created_at->format('M d, Y') }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('admin.jobs.toggle', $job) }}" method="POST" class="m-0 p-0 inline">
                                        @csrf
                                        @method('PATCH')

                                        @if ($job->is_active)
                                            <button type="submit"
                                                class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded text-xs font-bold uppercase tracking-wider transition">
                                                Deactivate
                                            </button>
                                        @else
                                            <button type="submit"
                                                class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white rounded text-xs font-bold uppercase tracking-wider transition">
                                                Activate
                                            </button>
                                        @endif
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <ion-icon name="briefcase-outline" class="text-5xl text-gray-200 mb-3"></ion-icon>
                                    <p class="text-sm font-medium text-gray-400 uppercase tracking-wide">
                                        No jobs found.
                                    </p>
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
                {{ $jobs->appends(request()->query())->links() }}
            </div>
        @endif

    </div>

@endsection