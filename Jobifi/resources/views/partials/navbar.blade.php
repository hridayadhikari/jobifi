<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<header class="bg-white border-b h-20 px-8 flex items-center justify-between">

    <!-- Search -->
    <div class="w-96">

    </div>

    <!-- Right Side -->
    <div class="flex items-center gap-6">

        {{-- Notification Wrapper (Place in Navbar) --}}
        <div class="relative"> {{-- Removed 'group' --}}

            {{-- Bell Icon Trigger --}}
            <button id="notificationButton" class="relative p-2 text-slate-900 hover:text-black transition">
                <ion-icon name="notifications-outline" class="text-2xl"></ion-icon>

                {{-- Unread Indicator --}}
                @if (auth()->user()->unreadNotifications()->count() > 0)
                    <span id="notificationBadge"
                        class="notification-count absolute top-1 right-1.5 flex items-center justify-center min-w-[16px] h-[16px] px-1 bg-black text-white text-[9px] font-bold leading-none rounded-full border-2 border-white shadow-sm">
                        {{ auth()->user()->unreadNotifications()->count() }}
                    </span>
                @endif
            </button>

            {{-- Dropdown Panel --}}
            {{-- Removed 'group-hover:block' and added id="notificationDropdown" --}}
            <div id="notificationDropdown"
                class="absolute right-0 top-full mt-2 w-[380px] bg-white border border-gray-200 shadow-lg hidden z-50">

                {{-- Header --}}
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        <ion-icon name="notifications-outline" class="text-lg text-slate-900"></ion-icon>
                        <h3 class="text-[11px] font-bold text-slate-900 uppercase tracking-[0.1em]">
                            Notifications
                        </h3>
                        @if (auth()->user()->unreadNotifications()->count() > 0)
                            <span id="notificationBadge"
                                class="notification-count flex items-center justify-center min-w-[16px] h-[16px] px-1 bg-black text-white text-[9px] font-bold leading-none rounded-full border-2 border-white shadow-sm">
                                {{ auth()->user()->unreadNotifications()->count() }}
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        <button id="markAllRead"
                            class="text-[10px] font-bold text-gray-400 hover:text-black uppercase tracking-widest transition flex items-center gap-1">
                            <ion-icon name="checkmark-outline" class="text-sm"></ion-icon>
                            Mark All Read
                        </button>
                        <button id="closeNotificationDropdown" class="text-gray-400 hover:text-black transition">
                            <ion-icon name="close-outline" class="text-lg"></ion-icon>
                        </button>
                    </div>
                </div>

                {{-- Notification List --}}
                <div id="notificationList"
                    class="max-h-[360px] overflow-y-auto divide-y divide-gray-50 custom-scrollbar">
                    
                </div>

                {{-- Footer --}}
                <div class="border-t border-gray-100">
                    <a href="{{route('notifications.index')}}"
                        class="block w-full text-center py-4 text-[10px] font-bold text-gray-400 hover:text-black uppercase tracking-[0.15em] transition bg-gray-50/50 hover:bg-gray-50">
                        View All Notifications
                    </a>
                </div>

            </div>
        </div>

        <!-- Profile Dropdown -->
        <div id="profile-dropdown" class="relative">

            <!-- Profile Button -->
            <button id="profile-button" type="button"
                class="flex items-center gap-3 focus:outline-none cursor-pointer">

                @if (Auth::user()->profile_photo)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                        class="w-12 h-12 rounded-full object-cover border" alt="Profile">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                        class="w-12 h-12 rounded-full border" alt="Avatar">
                @endif

                <div class="text-left hidden md:block">

                    <div class="font-semibold text-gray-800">
                        {{ Auth::user()->name }}
                    </div>

                    <div class="text-sm text-gray-500">
                        {{ ucfirst(Auth::user()->role) }}
                    </div>

                </div>

                <!-- Dropdown Arrow -->
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>

            </button>

            <!-- Dropdown Menu -->
            <div id="profile-menu"
                class="absolute right-0 mt-3 w-52 bg-white rounded-xl shadow-lg border z-50 overflow-hidden hidden">
                <div class="px-4 py-3 border-b">
                    <div class="font-medium text-gray-800">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-2 px-4 py-3 text-gray-700 hover:bg-gray-100 transition">
                    <ion-icon name="person-circle-outline" class="text-lg"></ion-icon>
                    <span>Profile</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-2 text-left px-4 py-3 text-red-600 hover:bg-red-50 transition">
                        <ion-icon name="log-out-outline"></ion-icon>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileButton = document.getElementById('profile-button');
        const profileMenu = document.getElementById('profile-menu');
        const profileDropdown = document.getElementById('profile-dropdown');

        // Toggle menu on button click
        profileButton.addEventListener('click', function(e) {
            e.stopPropagation();
            profileMenu.classList.toggle('hidden');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!profileDropdown.contains(e.target)) {
                profileMenu.classList.add('hidden');
            }
        });
    });
</script>
