@extends('master_index')

@section('title', 'Job Listings')

@section('content')

    <div class="p-8">

        {{-- Search Section --}}
        <div class="mb-8">

            <form id="jobSearchForm" action="{{ route('seeker.jobs.index') }}" method="GET"
                class="flex flex-col lg:flex-row gap-4">

                <div class="relative flex-1">

                    <ion-icon name="search-outline" class="absolute left-4 top-1/2 -translate-y-1/2 text-xl text-gray-400">
                    </ion-icon>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Job title, keywords..."
                        class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-slate-200">

                </div>

                <div class="relative lg:w-64">

                    <ion-icon name="location-outline"
                        class="absolute left-4 top-1/2 -translate-y-1/2 text-xl text-gray-400">
                    </ion-icon>

                    <input type="text" name="location" value="{{ request('location') }}" placeholder="Location"
                        class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-slate-200">

                </div>

                <button type="submit" class="bg-black text-white px-8 py-4 rounded-md hover:bg-gray-800 transition">

                    Search

                </button>

            </form>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            {{-- Filters Sidebar --}}
            <div>

                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">

                    <div class="px-6 py-5 border-b border-gray-200">
                        <h2 class="card-heading mb-0">Filters</h2>
                    </div>

                    <div class="p-6">

                        {{-- Categories --}}
                        <div class="mb-8">
                            <h3 class="field-label">Category</h3>

                            <div class="space-y-3">

                                @foreach ($categories as $category)
                                    <label class="flex items-center gap-3">

                                        <input type="checkbox" name="category[]" value="{{ $category->id }}"
                                            form="jobSearchForm"
                                            onchange="document.getElementById('jobSearchForm').submit()"
                                            {{ in_array($category->id, (array) request('category', [])) ? 'checked' : '' }}>

                                        <span>{{ $category->name }}</span>

                                    </label>
                                @endforeach

                            </div>

                        </div>

                        {{-- Job Type --}}
                        <div class="mb-8">
                            <h3 class="field-label">Job Type</h3>

                            <div class="space-y-3">

                                @foreach (['full-time', 'part-time', 'contract', 'internship'] as $type)
                                    <label class="flex items-center gap-3">

                                        <input type="checkbox" name="type[]" value="{{ $type }}"
                                            form="jobSearchForm"
                                            onchange="document.getElementById('jobSearchForm').submit()"
                                            {{ in_array($type, (array) request('type', [])) ? 'checked' : '' }}>

                                        <span>{{ ucwords(str_replace('-', ' ', $type)) }}</span>

                                    </label>
                                @endforeach

                            </div>

                        </div>

                        <a href="{{ route('seeker.jobs.index') }}" class="btn-secondary w-full justify-center">
                            Clear Filters
                        </a>

                    </div>

                </div>

            </div>

            {{-- Jobs Area --}}
            <div class="lg:col-span-3">

                {{-- Top Bar --}}
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">

                    <p class="text-gray-600">
                        Showing
                        <span class="font-semibold text-black">
                            {{ $jobs->total() }}
                        </span>
                        jobs found
                    </p>

                    <div class="flex items-center gap-3 mt-4 md:mt-0">

                        <span class="text-gray-500">
                            Sort by:
                        </span>

                        <form method="GET" action="{{ route('seeker.jobs.index') }}">
                            <select name="sort" onchange="this.form.submit()"
                                class="border-none bg-transparent font-semibold focus:outline-none">

                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                            </select>
                        </form>


                    </div>

                </div>

                {{-- Job Card --}}
                @forelse($jobs as $job)

                    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-5 hover:shadow-md transition">

                        <div class="flex justify-between">

                            <div class="flex gap-5">

                                <div class="w-16 h-16 border bg-gray-50 rounded-lg flex items-center justify-center">

                                    <ion-icon name="business-outline" class="text-3xl text-gray-400">
                                    </ion-icon>

                                </div>

                                <div>

                                    <a href="{{ route('seeker.jobs.show', encryptId($job->id)) }}"
                                        class="text-2xl font-bold text-slate-900 hover:text-black">

                                        {{ $job->title }}

                                    </a>

                                    <div class="flex flex-wrap gap-5 mt-2 text-gray-500">

                                        <span class="flex items-center gap-1">
                                            <ion-icon name="business-outline"></ion-icon>
                                            {{ $job->company->name }}
                                        </span>

                                        <span class="flex items-center gap-1">
                                            <ion-icon name="location-outline"></ion-icon>
                                            {{ $job->location }}
                                        </span>

                                        <span class="flex items-center gap-1">
                                            <ion-icon name="briefcase-outline"></ion-icon>
                                            {{ ucfirst($job->type) }}
                                        </span>

                                        <span class="flex items-center gap-1">
                                            <ion-icon name="time-outline"></ion-icon>
                                            {{ $job->created_at->diffForHumans() }}
                                        </span>

                                    </div>

                                    <div class="flex flex-wrap gap-2 mt-4">

                                        @foreach ($job->skills as $skill)
                                            <span class="px-3 py-1 bg-gray-100 text-sm rounded">
                                                {{ $skill->name }}
                                            </span>
                                        @endforeach

                                    </div>

                                </div>

                            </div>

                            <div class="text-right flex flex-col justify-between">
                                <form action="{{ route('seeker.jobs.save', $job) }}" method="POST">
                                    @csrf

                                    @php
                                        $isSaved = in_array($job->id, $savedJobIds ?? []);
                                    @endphp

                                    <button type="submit" class="px-3 py-2 rounded-md  hover:bg-gray-50 transition">

                                        <div class="flex items-center gap-2">

                                            @php
                                                $isSaved = in_array($job->id, $savedJobIds);
                                            @endphp

                                            <ion-icon name="{{ $isSaved ? 'bookmark' : 'bookmark-outline' }}">
                                            </ion-icon>

                                            {{ $isSaved ? 'Saved' : 'Save' }}

                                        </div>

                                    </button>
                                </form>

                                @if ($job->salary_range)
                                    <div class="mt-3 flex items-center gap-2 text-green-600 font-medium">

                                        <ion-icon name="cash-outline"></ion-icon>

                                        <span>{{ $job->salary_range }}</span>

                                    </div>
                                @endif

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="bg-white border rounded-lg p-12 text-center">

                        <ion-icon name="briefcase-outline" class="text-6xl text-gray-300">
                        </ion-icon>

                        <h3 class="mt-4 text-xl font-semibold">
                            No Jobs Found
                        </h3>

                    </div>

                @endforelse
                {{-- Pagination Placeholder --}}
                <div class="mt-8 flex justify-center">
                    {{ $jobs->links() }}
                </div>

            </div>

        </div>

    </div>

@endsection
