@extends('master_index')

@section('title', $job->title)

@section('content')

    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- Header --}}
        <div class="bg-white border border-gray-200 rounded-xl p-8 mb-8">

            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">

                <div class="flex gap-6">

                    <div class="w-24 h-24 rounded-xl border bg-gray-50 flex items-center justify-center">

                        <ion-icon name="business-outline" class="text-5xl text-gray-400">
                        </ion-icon>

                    </div>

                    <div>

                        <h1 class="text-4xl font-bold text-slate-900">
                            {{ $job->title }}
                        </h1>

                        <div class="flex flex-wrap items-center gap-4 mt-4 text-gray-500">

                            <span class="font-medium text-slate-700">
                                {{ $job->company->name }}
                            </span>

                            <span>•</span>

                            <span class="flex items-center gap-1">
                                <ion-icon name="location-outline"></ion-icon>
                                {{ $job->location }}
                            </span>

                            <span>•</span>

                            <span class="flex items-center gap-1">
                                <ion-icon name="time-outline"></ion-icon>
                                Posted {{ $job->created_at->diffForHumans() }}
                            </span>

                        </div>

                    </div>

                </div>

                <div class="flex gap-3">

                    <form action="{{ route('seeker.jobs.save', $job) }}" method="POST">
                        @csrf

                        <button type="submit"
                            class="border-2 border-black px-6 py-3 font-medium rounded-lg hover:bg-gray-100 transition">

                            <div class="flex items-center gap-2">

                                <ion-icon name="{{ $isSaved ? 'bookmark' : 'bookmark-outline' }}">
                                </ion-icon>

                                {{ $isSaved ? 'Saved' : 'Save' }}

                            </div>

                        </button>

                    </form>

                    <button class="bg-black text-white px-8 py-3 rounded-lg font-medium hover:bg-slate-800 transition">

                        Apply Now

                    </button>

                </div>

            </div>

        </div>

        {{-- Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left Content --}}
            <div class="lg:col-span-2">

                <div class="bg-white border border-gray-200 rounded-xl p-8">

                    <h2 class="text-3xl font-bold text-slate-900 mb-6">
                        About the Job
                    </h2>

                    <div class="prose max-w-none text-gray-600 leading-8">

                        {!! nl2br(e($job->description)) !!}

                    </div>

                </div>

            </div>

            {{-- Sidebar --}}
            <div>

                {{-- Overview --}}
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-6">

                    <div class="px-6 py-5 border-b border-gray-200">

                        <h3 class="font-bold uppercase tracking-wide">
                            Job Overview
                        </h3>

                    </div>

                    <div class="p-6 space-y-5">

                        <div class="flex justify-between">

                            <span class="text-gray-500">
                                Salary Range
                            </span>

                            <span class="font-semibold text-green-600">
                            <ion-icon name="cash-outline"></ion-icon>
                                {{ $job->salary_range ?? 'Not Disclosed' }}
                            </span>

                        </div>

                        <div class="flex justify-between">

                            <span class="text-gray-500">
                                Employment Type
                            </span>

                            <span class="px-3 py-1 rounded-full text-xs bg-slate-100 font-medium">

                                {{ strtoupper($job->type) }}

                            </span>

                        </div>

                        <div class="flex justify-between">

                            <span class="text-gray-500">
                                Category
                            </span>

                            <span class="font-semibold">
                                {{ $job->category->name }}
                            </span>

                        </div>

                        <div class="flex justify-between">

                            <span class="text-gray-500">
                                Posted
                            </span>

                            <span class="font-semibold">
                                {{ $job->created_at->format('d M Y') }}
                            </span>

                        </div>

                    </div>

                </div>

                {{-- Skills --}}
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

                    <div class="px-6 py-5 border-b border-gray-200">

                        <h3 class="font-bold uppercase tracking-wide">
                            Skills Required
                        </h3>

                    </div>

                    <div class="p-6">

                        <div class="flex flex-wrap gap-3">

                            @forelse($job->skills as $skill)
                                <span class="px-4 py-2 bg-slate-100 text-slate-700 rounded-full text-sm font-medium">

                                    {{ $skill->name }}

                                </span>

                            @empty

                                <span class="text-gray-500">
                                    No skills specified
                                </span>
                            @endforelse

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
