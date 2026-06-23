@extends('master_index')

@section('title', 'Activity Logs')

@section('content')

    <div class="p-8">

        {{-- Top Bar: Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 uppercase tracking-tight">
                    Activity Logs
                </h1>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mt-1">
                    Track all recruiter and admin activities across the platform.
                </p>
            </div>
        </div>

        {{-- Table Container --}}
        <div class="bg-white border border-gray-200 rounded-sm overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse">

                    {{-- Table Header --}}
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">User</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Role</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Action</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Description</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Date & Time</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-100">

                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50/50 transition">

                                {{-- User --}}
                                <td class="px-6 py-4 font-bold text-slate-900 text-sm">
                                    {{ $log->user->name }}
                                </td>

                                {{-- Role Badges --}}
                                <td class="px-6 py-4">
                                    @if ($log->user->role === 'admin')
                                        <span class="inline-block px-2 py-1 bg-red-100 text-red-700 text-[10px] font-bold uppercase tracking-wider rounded-sm">
                                            Admin
                                        </span>
                                    @elseif($log->user->role === 'recruiter')
                                        <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 text-[10px] font-bold uppercase tracking-wider rounded-sm">
                                            Recruiter
                                        </span>
                                    @else
                                        <span class="inline-block px-2 py-1 bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wider rounded-sm">
                                            Seeker
                                        </span>
                                    @endif
                                </td>

                                {{-- Action --}}
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-800 text-xs uppercase tracking-wide">
                                        {{ $log->action }}
                                    </span>
                                </td>

                                {{-- Description --}}
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $log->description }}
                                </td>

                                {{-- Date & Time --}}
                                <td class="px-6 py-4">
                                    <span class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-0.5">
                                        {{ $log->created_at->format('M d, Y') }}
                                    </span>
                                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                        {{ $log->created_at->format('h:i A') }}
                                    </span>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <ion-icon name="list-outline" class="text-5xl text-gray-200 mb-3"></ion-icon>
                                    <p class="text-sm font-medium text-gray-400 uppercase tracking-wide">
                                        No activity logs found.
                                    </p>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- Pagination --}}
        @if ($logs->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $logs->links() }}
            </div>
        @endif

    </div>

@endsection