@extends('master_index')

@section('title', 'User Management')

@section('content')

    <div class="p-8">

        {{-- Top Bar: Header & Search/Filter --}}
        <div class="flex flex-col md:flex-row justify-between items-start mb-8 gap-4">

            {{-- Page Title --}}
            <div>
                <h1 class="text-3xl font-bold text-slate-900 uppercase tracking-tight">
                    User Management
                </h1>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mt-1">
                    Manage all registered users and their roles.
                </p>
            </div>

            {{-- Combined Search & Filter Form --}}
            <div class="w-full md:w-auto">
                <form method="GET" action="{{ route('users.index') }}" class="flex flex-col gap-3">
                    
                    {{-- Search Bar --}}
                    <div class="relative w-full md:w-72">
                        <ion-icon name="search-outline" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none"></ion-icon>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..."
                            class="w-full pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-md focus:ring-1 focus:ring-black focus:border-black outline-none transition bg-white">
                        {{-- Hidden submit button so hitting 'Enter' submits the form --}}
                        <button type="submit" class="hidden"></button>
                    </div>

                    {{-- Role Filter --}}
                    <div class="relative w-full md:w-72">
                        <ion-icon name="filter-outline" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none"></ion-icon>
                        
                        <select name="role" onchange="this.form.submit();"
                            class="w-full pl-10 pr-8 py-2 text-sm border border-gray-200 rounded-md focus:ring-1 focus:ring-black focus:border-black outline-none transition cursor-pointer appearance-none bg-white">
                            <option value="" {{ request('role') == '' ? 'selected' : '' }}>All Roles</option>
                            <option value="recruiter" {{ request('role') == 'recruiter' ? 'selected' : '' }}>Recruiter</option>
                            <option value="seeker" {{ request('role') == 'seeker' ? 'selected' : '' }}>Seeker</option>
                        </select>
                        
                        {{-- Custom Dropdown Arrow --}}
                        <ion-icon name="chevron-down-outline" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></ion-icon>
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
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">User</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Role</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Status</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Joined</th>
                            <th class="px-6 py-5 text-right text-xs font-bold uppercase tracking-widest text-gray-400">
                                Actions</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50/50 transition">

                                {{-- User (Avatar, Name, Email) --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded bg-gray-100 flex items-center justify-center border border-gray-200">
                                            <ion-icon name="person-outline" class="text-gray-400"></ion-icon>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 text-sm">
                                                {{ $user->name }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $user->email }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Role --}}
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-800 text-xs uppercase tracking-wide">
                                        {{ $user->role ?? 'SEEKER' }}
                                    </span>
                                </td>

                                {{-- Status (Black Badge for Active) --}}
                                <td class="px-6 py-4">
                                    @if ($user->is_active)
                                        <span
                                            class="inline-block px-2 py-1 bg-black text-white text-[10px] font-bold uppercase tracking-wider rounded-sm">
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-block px-2 py-1 bg-gray-200 text-gray-600 text-[10px] font-bold uppercase tracking-wider rounded-sm">
                                            Suspended
                                        </span>
                                    @endif
                                </td>

                                {{-- Joined Date --}}
                                <td class="px-6 py-4">
                                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-4">

                                        @if (strtoupper($user->role) === 'RECRUITER')
                                            <a href="{{ route('recruiters.show', $user) }}"
                                                class="text-xs font-bold text-slate-800 hover:text-black hover:underline uppercase tracking-wider transition">
                                                View Profile
                                            </a>
                                        @elseif(strtoupper($user->role) === 'SEEKER')
                                            <a href="{{ route('seeker.show', $user) }}"
                                                class="text-xs font-bold text-slate-800 hover:text-black hover:underline uppercase tracking-wider transition">
                                                View Profile
                                            </a>
                                        @else
                                            {{-- Fallback for Admins or undefined roles --}}
                                            <span class="text-xs font-bold text-gray-300 uppercase tracking-wider">
                                                No Profile
                                            </span>
                                        @endif
                                        @if ($user->is_active)
                                            <form action="{{ route('users.suspend', $user) }}" method="POST"
                                                class="m-0 p-0">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded text-xs font-bold uppercase tracking-wider transition">
                                                    Suspend
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('users.activate', $user) }}" method="POST"
                                                class="m-0 p-0">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white rounded text-xs font-bold uppercase tracking-wider transition">
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
                                    <ion-icon name="people-outline" class="text-5xl text-gray-200 mb-3"></ion-icon>
                                    <p class="text-sm font-medium text-gray-400 uppercase tracking-wide">
                                        No users found
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($users->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $users->links() }}
            </div>
        @endif

    </div>

@endsection