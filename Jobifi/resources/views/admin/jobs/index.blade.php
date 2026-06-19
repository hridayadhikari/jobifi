@extends('master_index')

@section('title', 'Job Management')

@section('content')

    <div class="p-8">

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-slate-900 uppercase">
                Job Management
            </h1>

            <p class="text-gray-500 mt-2">
                Manage recruiter job listings and control their visibility.
            </p>
        </div>

        <!-- Jobs Card -->
        <div class="bg-white border border-gray-200 overflow-hidden">

            <!-- Card Header -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-semibold uppercase">
                    Available Jobs
                </h2>
            </div>

            <!-- Search Section -->
            <div class="p-6 border-b border-gray-200">

                <form method="GET" action="{{ route('admin.jobs.index') }}">

                    <div class="flex gap-4">

                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search jobs..."
                            class="flex-1 border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500">

                        <button type="submit"
                            class="bg-black text-white px-8 py-3 font-semibold hover:bg-gray-800 transition">
                            SEARCH
                        </button>

                        @if (request('search'))
                            <a href="{{ route('admin.jobs.index') }}"
                                class="bg-gray-500 text-white px-8 py-3 font-semibold hover:bg-gray-600 transition">
                                CLEAR
                            </a>
                        @endif

                    </div>

                </form>

            </div>

            <!-- Jobs Table -->
            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50 border-b border-gray-200">

                        <tr>

                            <th class="text-left px-6 py-4 uppercase text-sm font-semibold text-gray-600">
                                Job Title
                            </th>

                            <th class="text-left px-6 py-4 uppercase text-sm font-semibold text-gray-600">
                                Company
                            </th>

                            <th class="text-left px-6 py-4 uppercase text-sm font-semibold text-gray-600">
                                Category
                            </th>

                            <th class="text-left px-6 py-4 uppercase text-sm font-semibold text-gray-600">
                                Type
                            </th>

                            <th class="text-left px-6 py-4 uppercase text-sm font-semibold text-gray-600">
                                Status
                            </th>

                            <th class="text-left px-6 py-4 uppercase text-sm font-semibold text-gray-600">
                                Posted On
                            </th>

                            <th class="text-center px-6 py-4 uppercase text-sm font-semibold text-gray-600">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($jobs as $job)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">

                                <td class="px-6 py-5 font-semibold text-gray-900">
                                    {{ $job->title }}
                                </td>

                                <td class="px-6 py-5 text-gray-700">
                                    {{ $job->company->name }}
                                </td>

                                <td class="px-6 py-5 text-gray-700">
                                    {{ $job->category->name }}
                                </td>

                                <td class="px-6 py-5">

                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded-full">
                                        {{ ucfirst($job->type) }}
                                    </span>

                                </td>

                                <td class="px-6 py-5">

                                    @if ($job->is_active)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-sm rounded-full">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-700 text-sm rounded-full">
                                            Inactive
                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-5 text-gray-700">
                                    {{ $job->created_at->format('d M Y') }}
                                </td>

                                <td class="px-6 py-5 text-center">

                                    <form action="{{ route('admin.jobs.toggle', $job) }}" method="POST">

                                        @csrf
                                        @method('PATCH')

                                        @if ($job->is_active)
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 font-medium transition">
                                                Deactivate
                                            </button>
                                        @else
                                            <button type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 font-medium transition">
                                                Activate
                                            </button>
                                        @endif

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center py-12 text-gray-500">
                                    No jobs found.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <!-- Pagination -->
            <div class="p-6 border-t border-gray-200">
                {{ $jobs->appends(request()->query())->links() }}
            </div>

        </div>

    </div>

@endsection
