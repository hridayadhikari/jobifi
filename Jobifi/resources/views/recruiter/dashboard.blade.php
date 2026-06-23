
@extends('master_index')

@section('title', 'Recruiter Dashboard')

@section('content')

<div class="space-y-6">

    @if (!auth()->user()->is_active)

        <div class="bg-red-50 border border-red-200 rounded-xl p-6">

            <div class="flex items-start gap-3">

                <ion-icon
                    name="warning-outline"
                    class="text-3xl text-red-500">
                </ion-icon>

                <div>

                    <h2 class="text-xl font-bold text-red-700">
                        Account Suspended
                    </h2>

                    <p class="mt-2 text-red-600">
                        Your recruiter account has been suspended by an administrator.
                    </p>

                    <p class="mt-2 text-red-600">
                        You can view your existing information but cannot create,
                        edit, or manage jobs until your account is reactivated.
                    </p>

                </div>

            </div>

        </div>

    @endif

    <div class="bg-white rounded-xl shadow p-6">

        <h1 class="text-3xl font-bold text-gray-800">
            Welcome Back, {{ Auth::user()->name }} 👋
        </h1>

        <p class="text-gray-500 mt-2">
            Manage your jobs and company profile from your dashboard.
        </p>

    </div>

</div>

@endsection

