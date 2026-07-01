@extends('master_index')

@section('title', 'Recruiter Management')

@section('content')

    <div class="p-8 min-h-screen bg-[#f8f9fa]">

        {{-- Header & Search Row --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-6">

            {{-- Titles --}}
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 uppercase tracking-tight">
                    Recruiter Management
                </h1>
                <p class="text-[11px] font-semibold text-gray-500 mt-1 uppercase tracking-wider">
                    Manage all registered recruiters and their companies.
                </p>
            </div>

            {{-- Minimalist Search --}}
            <div class="w-full md:w-auto">
                <form method="GET" action="{{ route('admin.recruiters.index') }}">
                    <div class="relative">
                        <ion-icon name="search-outline"
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">
                        </ion-icon>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..."
                            class="w-full md:w-72 pl-10 pr-4 py-2 border border-gray-200 rounded bg-white text-sm text-slate-700 shadow-sm focus:outline-none focus:border-gray-300 focus:ring-0">
                    </div>
                    {{-- Removed the explicit Search button to match the minimalist input-only style of the image --}}
                </form>
            </div>

        </div>

        {{-- Table Container --}}
        <div class="bg-white border border-gray-200 rounded-sm shadow-sm overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-6 py-5 text-left text-[11px] font-bold uppercase tracking-widest text-gray-400">
                                Recruiter
                            </th>
                            <th class="px-6 py-5 text-left text-[11px] font-bold uppercase tracking-widest text-gray-400">
                                Company
                            </th>
                            <th class="px-6 py-5 text-left text-[11px] font-bold uppercase tracking-widest text-gray-400">
                                Email
                            </th>
                            <th class="px-6 py-5 text-left text-[11px] font-bold uppercase tracking-widest text-gray-400">
                                Status
                            </th>
                            <th class="px-6 py-5 text-right text-[11px] font-bold uppercase tracking-widest text-gray-400">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($recruiters as $recruiter)
                            <tr class="hover:bg-slate-50/50 transition">

                                {{-- Recruiter Profile --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        {{-- Square outline avatar to match image --}}
                                        <div
                                            class="w-10 h-10 border border-gray-200 rounded flex items-center justify-center bg-gray-50/50">
                                            @if ($recruiter->profile_photo)
                                                <img src="{{ asset('storage/' . $recruiter->profile_photo) }}"
                                                    class="w-full h-full object-cover object-top"
                                                    alt="{{ $recruiter->name }}">
                                            @else
                                                {{-- Placeholder icon avatar --}}
                                                <div class="w-full h-full flex items-center justify-center bg-indigo-100">
                                                    <span
                                                        class="text-2xl font-bold text-indigo-500">{{ strtoupper(substr($recruiter->name, 0, 1)) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-900">
                                                {{ $recruiter->name }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-0.5">
                                                ID #{{ $recruiter->id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Company (Styled as a bold role equivalent) --}}
                                <td class="px-6 py-4">
                                    <span class="text-xs font-bold text-slate-800 uppercase tracking-wide">
                                        {{ $recruiter->company->name ?? 'No Company' }}
                                    </span>
                                </td>

                                {{-- Email --}}
                                <td class="px-6 py-4">
                                    <span class="text-xs font-semibold text-gray-500">
                                        {{ $recruiter->email }}
                                    </span>
                                </td>

                                {{-- Status Badges (High Contrast) --}}
                                <td class="px-6 py-4">
                                    @if ($recruiter->is_active)
                                        <span
                                            class="inline-block bg-black text-white text-[10px] font-bold px-2 py-1 rounded-sm uppercase tracking-widest">
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-block bg-gray-200 text-slate-600 text-[10px] font-bold px-2 py-1 rounded-sm uppercase tracking-widest border border-gray-300">
                                            Suspended
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions (Minimalist Text Links) --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-6">

                                        {{-- View Company --}}
                                        <a href="{{ $recruiter->company ? route('admin.recruiters.company', encryptId($recruiter->id)) : 'javascript:void(0);' }}"
                                            class="text-[11px] font-bold uppercase tracking-wider transition {{ $recruiter->company ? 'text-slate-700 hover:text-black' : 'text-slate-400 no-company' }}">
                                            View Company
                                        </a>

                                        @if ($recruiter->is_active)
                                            {{-- Suspend --}}
                                            <form action="{{ route('admin.recruiters.suspend', $recruiter) }}"
                                                method="POST" class="inline m-0 p-0">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded text-[11px] font-bold uppercase tracking-wider transition">
                                                    Suspend
                                                </button>
                                            </form>
                                        @else
                                            {{-- Activate --}}
                                            <form action="{{ route('admin.recruiters.activate', $recruiter) }}"
                                                method="POST" class="inline m-0 p-0">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white rounded text-[11px] font-bold uppercase tracking-wider transition">
                                                    Activate
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <ion-icon name="people-outline" class="text-5xl text-gray-300">
                                    </ion-icon>
                                    <p class="mt-4 text-sm font-semibold uppercase tracking-wider text-gray-400">
                                        No recruiters found
                                    </p>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- Pagination --}}
        @if ($recruiters->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $recruiters->links() }}
            </div>
        @endif

    </div>

@endsection
