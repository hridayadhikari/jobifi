@extends('master_index')

@section('title', 'Notifications')

@section('content')

    <div class="bg-[#f8f9fa] min-h-screen font-sans py-12 px-6">
        <div class="max-w-[1000px] mx-auto">

            {{-- Page Header --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
                <div>
                    <h1 class="text-[28px] font-extrabold text-[#0a192f] tracking-tight leading-none mb-2 uppercase">
                        Notifications
                    </h1>
                    <p class="text-[13px] text-gray-500">
                        {{ $unreadCount }} unread notification{{ $unreadCount != 1 ? 's' : '' }}
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <button
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-slate-900 text-[11px] font-bold uppercase tracking-widest hover:border-black transition duration-200 shadow-sm">
                        <ion-icon name="checkmark-outline" class="text-sm"></ion-icon>
                        Mark All Read
                    </button>
                    <button id="clearAll"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-slate-900 text-[11px] font-bold uppercase tracking-widest hover:border-black hover:text-red-600 transition duration-200 shadow-sm">
                        <ion-icon name="trash-outline" class="text-sm"></ion-icon>
                        Clear All
                    </button>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="border-b border-gray-200 mb-6 overflow-x-auto hide-scrollbar">
                <nav class="flex gap-8 min-w-max">
                    <a href="{{ route('notifications.index') }}"
                        class="flex items-center gap-2 border-b-2 {{ request('filter') != 'unread' ? 'border-black text-black' : 'border-transparent text-gray-400' }} pb-4 text-[11px] font-bold uppercase tracking-widest">

                        All

                        <span class="bg-black text-white text-[9px] px-1.5 py-0.5 rounded-full">
                            {{ auth()->user()->notifications()->count() }}
                        </span>

                    </a>
                    <a href="{{ route('notifications.index', ['filter' => 'unread']) }}"
                        class="flex items-center gap-2 border-b-2 {{ request('filter') == 'unread' ? 'border-black text-black' : 'border-transparent text-gray-400' }} pb-4 text-[11px] font-bold uppercase tracking-widest">

                        Unread

                        <span class="bg-gray-100 text-gray-500 text-[9px] px-1.5 py-0.5 rounded-full">
                            {{ $unreadCount }}
                        </span>

                    </a>
                </nav>
            </div>

            {{-- Notification List --}}
            <div class="bg-white border border-gray-200 shadow-sm divide-y divide-gray-50">
          
                @forelse($notifications as $notification)
                 
                    @php

                        $type = $notification->data['type'] ?? 'default';

                        $icon = match ($type) {
                            'application' => 'briefcase-outline',
                            'interview' => 'chatbubble-outline',
                            'alert' => 'alert-circle-outline',
                            'reminder' => 'time-outline',
                            'job' => 'sparkles-outline',

                            default => 'notifications-outline',
                        };

                    @endphp

                    <div
                        class="flex items-start gap-5 p-6 hover:bg-gray-50/50 transition relative {{ $notification->read_at ? 'bg-gray-50/30' : 'bg-white' }} group cursor-pointer">

                        @if (!$notification->read_at)
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 w-2 h-2 bg-black rounded-full"></div>
                        @endif

                        <div
                            class="w-10 h-10 rounded border border-gray-200 bg-gray-50 flex items-center justify-center shrink-0 ml-2">

                            <ion-icon name="{{ $icon }}"
                                class="text-lg {{ $notification->read_at ? 'text-gray-400' : 'text-gray-500' }}">
                            </ion-icon>

                        </div>

                        <div class="flex-1">

                            <div class="flex items-center gap-3 mb-1">

                                <h4
                                    class="text-[14px] font-bold {{ $notification->read_at ? 'text-gray-600' : 'text-slate-900' }}">

                                    {{ $notification->data['title'] }}

                                </h4>

                                <span
                                    class="border border-gray-200 text-gray-400 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest rounded-sm">

                                    {{ ucfirst($type) }}

                                </span>

                            </div>

                            <p class="text-[13px] {{ $notification->read_at ? 'text-gray-400' : 'text-gray-500' }} mb-2">

                                {{ $notification->data['message'] }}

                            </p>

                            <span
                                class="text-[10px] font-bold {{ $notification->read_at ? 'text-gray-300' : 'text-gray-400' }} uppercase tracking-[0.15em]">

                                {{ $notification->created_at->diffForHumans() }}

                            </span>

                        </div>

                    </div>

                @empty

                    <div class="py-16 text-center">

                        <ion-icon name="notifications-off-outline" class="text-6xl text-gray-300">
                        </ion-icon>

                        <p class="mt-4 text-gray-400">

                            No notifications found.

                        </p>

                    </div>
                @endforelse
            </div>
            {{-- Footer Details --}}
            {{-- Footer --}}
            <div class="mt-8 flex flex-col items-center gap-4">

                {{ $notifications->links() }}

            </div>

        </div>
    </div>

@endsection
