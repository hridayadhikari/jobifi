<aside class="w-64 bg-white border-r border-slate-100/80 flex flex-col overflow-y-auto justify-between py-6 shrink-0">

    {{-- Logo --}}
    <div>
        <div class="flex items-center gap-3 px-6 mb-8">
            <x-application-logo class="block h-16 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </div>

        {{-- Navigation --}}
        <nav class="px-3 space-y-0.5">
            @if (Auth::user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
               {{ request()->routeIs('seeker.dashboard')
                   ? 'bg-slate-100 text-slate-900 font-semibold'
                   : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('seeker.dashboard') ? 'text-slate-800' : 'text-slate-400' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('users.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
               {{ request()->routeIs('jobs.browse')
                   ? 'bg-slate-100 text-slate-900 font-semibold'
                   : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('jobs.browse') ? 'text-slate-800' : 'text-slate-400' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <span>User Management</span>
                </a>

                <a href="{{ route('admin.recruiters.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
               {{ request()->routeIs('jobs.saved')
                   ? 'bg-slate-100 text-slate-900 font-semibold'
                   : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('jobs.saved') ? 'text-slate-800' : 'text-slate-400' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    <span>Recruiter Management</span>
                </a>

                <a href="{{ route('categories.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
               {{ request()->routeIs('seeker.applications')
                   ? 'bg-slate-100 text-slate-900 font-semibold'
                   : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('seeker.applications') ? 'text-slate-800' : 'text-slate-400' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                    </svg>
                    <span>Category Management</span>
                </a>

                <a href="{{ route('skills.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
               {{ request()->routeIs('profile.edit')
                   ? 'bg-slate-100 text-slate-900 font-semibold'
                   : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('profile.edit') ? 'text-slate-800' : 'text-slate-400' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.745 3A23.933 23.933 0 0 0 3 12c0 3.183.62 6.22 1.745 9M19.5 3c.967 2.759 1.5 5.742 1.5 9a21.07 21.07 0 0 1-1.5 8M8.25 8.885l1.444-.89a.75.75 0 0 1 1.105.402l2.402 7.206a.75.75 0 0 0 1.104.401l1.445-.889m-8.25.75.213.09a1.687 1.687 0 0 0 2.062-.617l4.45-6.676a1.688 1.688 0 0 1 2.062-.618l.213.09" />
                    </svg>
                    <span>Skills Management</span>
                </a>


                <a href="{{ route('admin.jobs.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
    {{ request()->routeIs('admin.jobs.*')
        ? 'bg-slate-100 text-slate-900 font-semibold'
        : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('admin.jobs.*') ? 'text-slate-800' : 'text-slate-400' }}">

                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 14.15v4.072c0 .918-.716 1.678-1.633 1.722A48.658 48.658 0 0 1 12 20.25a48.655 48.655 0 0 1-6.617-.306A1.81 1.81 0 0 1 3.75 18.222V14.15M7.5 10.5h9M9 6.75h6A2.25 2.25 0 0 1 17.25 9v1.5H6.75V9A2.25 2.25 0 0 1 9 6.75Z" />

                    </svg>

                    <span>Job Management</span>
                </a>

                <a href="{{ route('admin.logs.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
    {{ request()->routeIs('admin.logs.*')
        ? 'bg-slate-100 text-slate-900 font-semibold'
        : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-[18px] h-[18px] shrink-0
        {{ request()->routeIs('admin.logs.*') ? 'text-slate-700' : 'text-slate-400' }}">

                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                    <span>Activity Logs</span>
                </a>
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
               text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-[18px] h-[18px] shrink-0 text-slate-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                    <span>Reports</span>
                </a>
            @elseif(Auth::user()->role == 'seeker')
                <a href="{{ route('seeker.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
               {{ request()->routeIs('admin.dashboard')
                   ? 'bg-slate-100 text-slate-900 font-semibold'
                   : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('seeker.dashboard') ? 'text-slate-800' : 'text-slate-400' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('seeker.profile.show') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
   {{ request()->routeIs('seeker.profile.*')
       ? 'bg-slate-100 text-slate-900 font-semibold'
       : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('seeker.profile.*') ? 'text-slate-800' : 'text-slate-400' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>

                    <span>Profile</span>
                </a>

                <a href="{{ route('seeker.jobs.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
   {{ request()->routeIs('jobs.*')
       ? 'bg-slate-100 text-slate-900 font-semibold'
       : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('jobs.*') ? 'text-slate-800' : 'text-slate-400' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 6a7.5 7.5 0 1 0 0 15 7.5 7.5 0 0 0 0-15Zm0 0 7.5-1.5M21 3l-4.5 4.5" />
                    </svg>

                    <span>Job Listings</span>
                </a>

                <a href="{{ route('seeker.saved-jobs.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
   {{ request()->routeIs('saved.jobs')
       ? 'bg-slate-100 text-slate-900 font-semibold'
       : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('saved.jobs') ? 'text-slate-800' : 'text-slate-400' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.25 3.75H6.75A2.25 2.25 0 0 0 4.5 6v14.25l7.5-4.5 7.5 4.5V6a2.25 2.25 0 0 0-2.25-2.25Z" />
                    </svg>

                    <span>Saved Jobs</span>
                </a>

                <a href="{{ route('seeker.applications.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
   {{ request()->routeIs('applications.*')
       ? 'bg-slate-100 text-slate-900 font-semibold'
       : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('applications.*') ? 'text-slate-800' : 'text-slate-400' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L6 12Zm0 0h7.5" />
                    </svg>

                    <span>My Applications</span>
                </a>
            @elseif(Auth::user()->role == 'recruiter')
                <a href="{{ route('recruiter.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
               {{ request()->routeIs('recruiter.dashboard')
                   ? 'bg-slate-100 text-slate-900 font-semibold'
                   : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('recruiter.dashboard') ? 'text-slate-800' : 'text-slate-400' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('recruiter.profile.show') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
   {{ request()->routeIs('recruiter.profile.*')
       ? 'bg-slate-100 text-slate-900 font-semibold'
       : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('recruiter.profile.*') ? 'text-slate-800' : 'text-slate-400' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 21h16.5M4.5 3.75h15a.75.75 0 01.75.75V21H3.75V4.5a.75.75 0 01.75-.75ZM9 21V9h6v12" />
                    </svg>

                    <span>Company Profile</span>
                </a>
                <a href="{{ route('recruiter.jobs.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
   {{ request()->routeIs('saved.jobs')
       ? 'bg-slate-100 text-slate-900 font-semibold'
       : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('company.jobs.*') ? 'text-slate-800' : 'text-slate-400' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 14.15v4.072a2.25 2.25 0 01-2.244 2.25H5.994a2.25 2.25 0 01-2.244-2.25V14.15M16.5 20.25V6.75A2.25 2.25 0 0014.25 4.5h-4.5A2.25 2.25 0 007.5 6.75v13.5M9.75 4.5h4.5" />
                    </svg>

                    <span>Manage Jobs</span>
                </a>
                <a href="{{ route('recruiter.applicants.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
   {{ request()->routeIs('saved.jobs')
       ? 'bg-slate-100 text-slate-900 font-semibold'
       : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('company.applicants*') ? 'text-slate-800' : 'text-slate-400' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a8.94 8.94 0 00-6-2.22 8.94 8.94 0 00-6 2.22M15 7.5a3 3 0 11-6 0 3 3 0 016 0Zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0Zm-16.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0Z" />
                    </svg>
                    <span>Applicants</span>
                </a>
            @endif
        </nav>
    </div>

    {{-- Logout --}}
    <div class="px-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-500 hover:text-slate-800 hover:bg-slate-50 transition-all duration-150 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-[18px] h-[18px] shrink-0 text-slate-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>

</aside>
