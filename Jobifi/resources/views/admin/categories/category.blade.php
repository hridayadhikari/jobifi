@extends('master_index')


@section('title', 'Category Management')


@section('content')
    <div class="p-6">


        {{-- Header --}}
        <div class="mb-8">
            <h3 class="text-3xl font-bold uppercase text-gray-900">
                Category Management
            </h3>

            <p class="text-gray-500 uppercase text-sm mt-1">
                Create and organize job categories for the platform.
            </p>
        </div>
       


        @if (session('error'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Add Category Card --}}
            <div class="lg:col-span-1">

                <div class="bg-white border border-gray-200">

                    <div class="border-b border-gray-200 px-6 py-5">
                        <h4 class="font-bold text-xl uppercase">
                            Add New Category
                        </h4>
                    </div>

                    <div class="p-6">

                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf

                            <div>
                                <label class="block text-xs font-bold tracking-wider text-gray-400 uppercase mb-2">
                                    Category Name
                                </label>

                                <input type="text" name="name" placeholder="e.g. Engineering"
                                    class="w-full border border-gray-300 px-4 py-3 focus:ring-0 focus:border-black"
                                    required>
                            </div>

                            <button type="submit"
                                class="mt-5 w-full bg-black text-white py-3 font-bold uppercase hover:bg-gray-800 transition">
                                + Add Category
                            </button>

                        </form>

                    </div>

                </div>

            </div>

            {{-- Categories Table --}}
            <div class="lg:col-span-2">

                <div class="bg-white border border-gray-200">

                    <div class="border-b border-gray-200 px-6 py-5">
                        <h4 class="font-bold text-xl uppercase">
                            All Categories
                        </h4>
                    </div>

                    <div class="p-6 overflow-x-auto">

                        <table class="w-full">

                            <thead>
                                <tr class="border-b border-gray-200">

                                    <th class="text-left py-4 uppercase text-xs tracking-wider text-gray-400">
                                        Category Name
                                    </th>

                                    <th class="text-left py-4 uppercase text-xs tracking-wider text-gray-400">
                                        Total Jobs
                                    </th>

                                    <th class="text-left py-4 uppercase text-xs tracking-wider text-gray-400">
                                        Status
                                    </th>

                                    <th class="text-left py-4 uppercase text-xs tracking-wider text-gray-400">
                                        Actions
                                    </th>

                                </tr>
                            </thead>

                            <tbody>

                                @forelse($categories as $category)
                                    <tr class="border-b border-gray-100">

                                        {{-- Name --}}
                                        <td class="py-6">

                                            <div class="flex items-center gap-3">

                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-300"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 7h.01M7 3h5l9 9-9 9-9-9V3h4z" />
                                                </svg>

                                                <span class="font-semibold uppercase">
                                                    {{ $category->name }}
                                                </span>

                                            </div>

                                        </td>

                                        {{-- Job Count --}}
                                        <td class="py-6 font-semibold text-gray-600">
                                            {{ $category->jobs_count ?? 0 }} Jobs
                                        </td>

                                        {{-- Status --}}
                                        <td class="py-6">

                                            @if ($category->is_active)
                                                <span class="bg-black text-white px-4 py-1 text-sm font-semibold">
                                                    Active
                                                </span>
                                            @else
                                                <span class="border border-gray-400 px-4 py-1 text-sm">
                                                    Inactive
                                                </span>
                                            @endif

                                        </td>

                                        {{-- Actions --}}
                                        <td class="py-6">

                                            <div class="flex items-center gap-2">


                                                {{-- Delete --}}
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="delete-btn px-3 py-2 border border-red-300 text-red-600 hover:bg-red-50"
                                                        data-name="{{ $category->name }} category">

                                                        ✕
                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="4" class="text-center py-10 text-gray-500">
                                            No categories found.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
