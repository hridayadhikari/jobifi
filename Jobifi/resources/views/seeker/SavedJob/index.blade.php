@extends('master_index')

@section('title', 'Saved Jobs')

@section('content')

    <div class="p-8">

        {{-- Top Bar: Header & Actions --}}
        <div class="flex flex-col md:flex-row justify-between items-start mb-8 gap-4">

            {{-- Page Title --}}
            <div>
                <h1 class="text-3xl font-bold text-slate-900 uppercase tracking-tight">
                    Saved Jobs
                </h1>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mt-1">
                    Manage your bookmarked opportunities and apply when you're ready.
                </p>
            </div>

            {{-- Browse Jobs Button (Moved to top for quick access) --}}
            <div class="w-full md:w-auto">
                <a href="{{ route('seeker.jobs.index') }}"
                    class="flex items-center justify-center gap-2 px-4 py-2 bg-black hover:bg-gray-800 text-white rounded-md text-xs font-bold uppercase tracking-wider transition whitespace-nowrap">
                    <ion-icon name="search-outline" class="text-lg"></ion-icon>
                    Browse Jobs
                </a>
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
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Category & Type</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Location & Salary</th>
                            <th class="px-6 py-5 text-right text-xs font-bold uppercase tracking-widest text-gray-400">Actions</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-100">
                        @forelse($savedJobs as $job)
                            <tr class="hover:bg-gray-50/50 transition">

                                {{-- Job Title --}}
                                <td class="px-6 py-4 font-bold text-slate-900 text-sm">
                                    {{ $job->title }}
                                </td>

                                {{-- Company --}}
                                <td class="px-6 py-4 text-sm font-medium text-slate-700">
                                    {{ $job->company->name }}
                                </td>

                                {{-- Category & Type --}}
                                <td class="px-6 py-4">
                                    <span class="block text-xs font-bold text-slate-800 uppercase tracking-wide mb-1.5">
                                        {{ $job->category->name }}
                                    </span>
                                    <span class="inline-block px-2 py-1 bg-slate-100 text-slate-600 border border-slate-200 text-[10px] font-bold uppercase tracking-wider rounded-sm">
                                        {{ ucwords(str_replace('-', ' ', $job->type)) }}
                                    </span>
                                </td>

                                {{-- Location & Salary --}}
                                <td class="px-6 py-4">
                                    <span class="flex items-center gap-1 text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">
                                        <ion-icon name="location-outline" class="text-sm"></ion-icon>
                                        {{ $job->location }}
                                    </span>
                                    @if ($job->salary_range)
                                        <span class="flex items-center gap-1 text-[10px] font-bold text-green-600 uppercase tracking-wider">
                                            <ion-icon name="cash-outline" class="text-sm"></ion-icon>
                                            {{ $job->salary_range }}
                                        </span>
                                    @else
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                            Salary not disclosed
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-4">
                                        
                                        <a href="{{ route('seeker.jobs.show', encryptId($job->id)) }}"
                                            class="text-xs font-bold text-slate-800 hover:text-black hover:underline uppercase tracking-wider transition">
                                            View Job
                                        </a>

                                        <form action="{{ route('seeker.jobs.save', $job) }}" method="POST" class="m-0 p-0 inline-flex items-center">
                                            @csrf
                                            <button type="submit"
                                                class="text-gray-400 hover:text-red-500 transition" title="Remove Job">
                                                <ion-icon name="trash-outline" class="text-lg"></ion-icon>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <ion-icon name="bookmark-outline" class="text-5xl text-gray-200 mb-3"></ion-icon>
                                    <p class="text-sm font-medium text-gray-400 uppercase tracking-wide">
                                        No Saved Jobs
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        Start saving jobs to keep track of opportunities you're interested in.
                                    </p>
                                    <a href="{{ route('seeker.jobs.index') }}"
                                        class="inline-flex items-center gap-2 mt-6 px-4 py-2 bg-black text-white rounded-md text-xs font-bold uppercase tracking-wider hover:bg-gray-800 transition">
                                        <ion-icon name="search-outline" class="text-lg"></ion-icon>
                                        Browse Jobs
                                    </a>
                                </td>
                            </tr>

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($savedJobs->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $savedJobs->links() }}
            </div>
        @endif

    </div>

@endsection