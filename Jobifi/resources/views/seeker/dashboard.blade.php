@extends('master_index')

@section('title', 'Seeker Dashboard')

@section('content')

<div class="space-y-6">

```
<!-- Welcome Section -->
<div class="bg-white rounded-xl shadow p-6">
    <h1 class="text-3xl font-bold text-gray-800">
        Welcome Back, {{ Auth::user()->name }} 👋
    </h1>

    <p class="text-gray-500 mt-2">
        Find and apply for your dream job today.
    </p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-gray-500 text-sm">Applied Jobs</h3>
        <p class="text-3xl font-bold text-blue-600">12</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-gray-500 text-sm">Saved Jobs</h3>
        <p class="text-3xl font-bold text-green-600">8</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-gray-500 text-sm">Interview Invites</h3>
        <p class="text-3xl font-bold text-purple-600">3</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-gray-500 text-sm">Profile Strength</h3>
        <p class="text-3xl font-bold text-orange-600">85%</p>
    </div>

</div>

<!-- Recommended Jobs -->
<div class="bg-white rounded-xl shadow p-6">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">
            Recommended Jobs
        </h2>

        <a href="#" class="text-blue-600 hover:underline">
            View All
        </a>
    </div>

    <div class="space-y-4">

        <div class="border rounded-lg p-4">
            <h3 class="font-semibold">
                Software Developer Intern
            </h3>

            <p class="text-gray-500">
                ABC Technologies • Agartala
            </p>
        </div>

        <div class="border rounded-lg p-4">
            <h3 class="font-semibold">
                Frontend Developer
            </h3>

            <p class="text-gray-500">
                XYZ Solutions • Remote
            </p>
        </div>

    </div>

</div>

<!-- Recent Applications -->
<div class="bg-white rounded-xl shadow p-6">

    <h2 class="text-xl font-semibold mb-4">
        Recent Applications
    </h2>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead>
                <tr class="border-b">
                    <th class="text-left py-3">Job Title</th>
                    <th class="text-left py-3">Company</th>
                    <th class="text-left py-3">Status</th>
                </tr>
            </thead>

            <tbody>

                <tr class="border-b">
                    <td class="py-3">Software Engineer</td>
                    <td class="py-3">ABC Technologies</td>
                    <td class="py-3 text-yellow-600">
                        Under Review
                    </td>
                </tr>

                <tr>
                    <td class="py-3">Web Developer</td>
                    <td class="py-3">XYZ Solutions</td>
                    <td class="py-3 text-green-600">
                        Shortlisted
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>
```

</div>

@endsection
