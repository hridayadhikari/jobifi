@extends('master_index')

@section('title', 'Activity Logs')

@section('content')

    <div class="max-w-7xl mx-auto p-6">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 uppercase">
                Activity Logs
            </h1>

            <p class="text-sm text-gray-500 uppercase mt-2">
                Track all recruiter and admin activities across the platform.
            </p>
        </div>

        {{-- Logs Table --}}
        <div class="bg-white rounded-xl border border-gray-200  overflow-hidden">

            <div class="px-6 py-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 uppercase">
                    System Activity
                </h2>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                User
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                Role
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                Action
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                Description
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                Date & Time
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $log->user->name }}
                                </td>

                                <td class="px-6 py-4">

                                    @if ($log->user->role === 'admin')
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                            Admin
                                        </span>
                                    @elseif($log->user->role === 'recruiter')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                            Recruiter
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                            Seeker
                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-800">
                                        {{ $log->action }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $log->description }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $log->created_at->format('d M Y') }}
                                    <br>
                                    {{ $log->created_at->format('h:i A') }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">

                                    No activity logs found.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
    <div class="mt-8 flex justify-center">
        {{ $logs->links() }}
    </div>


@endsection
