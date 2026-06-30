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

        <!-- Notification -->
        <button class="text-xl hover:scale-110 transition">
            <ion-icon name="notifications"></ion-icon>
        </button>

        <!-- Profile Dropdown -->
        <div id="profile-dropdown" class="relative">

            <!-- Profile Button -->
            <button id="profile-button" type="button" class="flex items-center gap-3 focus:outline-none cursor-pointer">

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

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-3 text-gray-700 hover:bg-gray-100 transition">
                    <ion-icon name="person-circle-outline" class="text-lg"></ion-icon>
                    <span>Profile</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 text-left px-4 py-3 text-red-600 hover:bg-red-50 transition">
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
