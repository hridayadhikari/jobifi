@extends('master_index')

@section('title', 'Category Management')

@section('content')

    <div class="p-8">

        {{-- Top Bar: Header & Actions (Fixed in place) --}}
        <div class="flex flex-col md:flex-row justify-between items-start mb-8 gap-4">

            {{-- Page Title --}}
            <div>
                <h1 class="text-3xl font-bold text-slate-900 uppercase tracking-tight">
                    Category Management
                </h1>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mt-1">
                    Create and organize job categories for the platform.
                </p>
            </div>

            {{-- Add Category Button --}}
            <div class="w-full md:w-auto">
                <button type="button" onclick="openModal('categoryModal')"
                    class="flex w-full md:w-auto items-center justify-center gap-2 px-4 py-2 bg-black hover:bg-gray-800 text-white rounded-md text-xs font-bold uppercase tracking-wider transition whitespace-nowrap">
                    <ion-icon name="add-outline" class="text-lg"></ion-icon>
                    Add Category
                </button>
            </div>

        </div>

        {{-- Table Container --}}
        <div class="bg-white border border-gray-200 rounded-sm overflow-hidden">

            {{-- Scrollable Wrapper --}}
            <div class="overflow-x-auto overflow-y-auto max-h-[calc(100vh-16rem)] relative">
                <table class="w-full text-left border-collapse">

                    {{-- Sticky Table Header --}}
                    <thead class="sticky top-0 z-10 bg-white shadow-[0_1px_0_0_#f3f4f6]">
                        <tr>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400 bg-white">Category Name</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400 bg-white">Total Jobs</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400 bg-white">Status</th>
                            <th class="px-6 py-5 text-right text-xs font-bold uppercase tracking-widest text-gray-400 bg-white">Actions</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-100">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50/50 transition">

                                {{-- Name --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <ion-icon name="folder-outline" class="text-lg text-gray-400"></ion-icon>
                                        <span class="font-bold text-slate-900 text-sm">
                                            {{ $category->name }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Job Count --}}
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-slate-700">
                                        {{ $category->jobs_count ?? 0 }} Jobs
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    @if ($category->is_active)
                                        <span class="inline-block px-2 py-1 bg-black text-white text-[10px] font-bold uppercase tracking-wider rounded-sm">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-block px-2 py-1 bg-gray-200 text-gray-600 text-[10px] font-bold uppercase tracking-wider rounded-sm">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-4">
                                        
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="m-0 p-0 inline-flex items-center">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="delete-btn text-gray-400 hover:text-red-500 transition"
                                                data-name="{{ $category->name }} category">
                                                <ion-icon name="trash-outline" class="text-lg"></ion-icon>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <ion-icon name="layers-outline" class="text-5xl text-gray-200 mb-3"></ion-icon>
                                    <p class="text-sm font-medium text-gray-400 uppercase tracking-wide">
                                        No categories found.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    {{-- Add Category Modal --}}
    <div id="categoryModal" data-modal class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity">

        <div class="bg-white w-full max-w-md mx-4 rounded-sm shadow-2xl overflow-hidden">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <h3 class="text-lg font-bold text-slate-900 uppercase tracking-tight">
                    Add New Category
                </h3>
                <button type="button" onclick="closeModal('categoryModal')" class="text-gray-400 hover:text-red-500 transition">
                    <ion-icon name="close-outline" class="text-2xl"></ion-icon>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">
                            Category Name
                        </label>
                        <input type="text" name="name" placeholder="e.g. Engineering" required
                            class="w-full px-4 py-2 text-sm border border-gray-200 rounded-md focus:ring-1 focus:ring-black focus:border-black outline-none transition bg-white">

                        @error('name')
                            <p class="mt-2 text-xs font-semibold text-red-500 uppercase tracking-wide">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Modal Actions --}}
                    <div class="flex justify-end gap-3 mt-8">
                        <button type="button" onclick="closeModal('categoryModal')"
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-xs font-bold uppercase tracking-wider transition">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 bg-black hover:bg-gray-800 text-white rounded-md text-xs font-bold uppercase tracking-wider transition">
                            Save Category
                        </button>
                    </div>

                </form>
            </div>

        </div>

    </div>

@endsection