@extends('master_index')

@section('title', 'Edit Job')

@section('content')

    <div class="max-w-6xl mx-auto p-6">

        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 uppercase">
                Edit Job Posting
            </h1>
            <p class="text-sm text-gray-500 uppercase mt-2">
                Update the job details and required skills for this role.
            </p>
        </div>

        <form action="{{ route('recruiter.jobs.update', $job->id) }}" method="POST">
            @csrf
            @method('PATCH')

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <strong class="font-semibold">Please fix the following errors:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

                <div class="border-b border-gray-200 px-8 py-6">
                    <h2 class="text-2xl font-bold uppercase">
                        Job Details
                    </h2>
                </div>

                <div class="p-8">

                    <div class="mb-8">
                        <label class="block text-xs font-bold tracking-wider text-gray-400 uppercase mb-2">
                            Job Title
                        </label>
                        <input type="text" name="title" value="{{ old('title', $job->title) }}"
                            placeholder="e.g. Senior Frontend Developer"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:border-black focus:ring-0"
                            required>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-xs font-bold tracking-wider text-gray-400 uppercase mb-2">
                                Job Category
                            </label>
                            <select name="category_id"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:border-black focus:ring-0"
                                required>
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $job->category_id) == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold tracking-wider text-gray-400 uppercase mb-2">
                                Employment Type
                            </label>
                            <select name="type"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:border-black focus:ring-0"
                                required>
                                <option value="full-time" @selected(old('type', $job->type) === 'full-time')>Full-time</option>
                                <option value="part-time" @selected(old('type', $job->type) === 'part-time')>Part-time</option>
                                <option value="contract" @selected(old('type', $job->type) === 'contract')>Contract</option>
                                <option value="internship" @selected(old('type', $job->type) === 'internship')>Internship</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-xs font-bold tracking-wider text-gray-400 uppercase mb-2">
                                Location
                            </label>
                            <input type="text" name="location" value="{{ old('location', $job->location) }}"
                                placeholder="Remote / New York, NY"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:border-black focus:ring-0"
                                required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold tracking-wider text-gray-400 uppercase mb-2">
                                Salary Range
                            </label>
                            <input type="text" name="salary_range" value="{{ old('salary_range', $job->salary_range) }}"
                                placeholder="₹6L - ₹10L"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:border-black focus:ring-0">
                        </div>
                    </div>

                    <div class="mb-8">

                        <label class="block text-xs font-bold tracking-wider text-gray-400 uppercase mb-3">
                            Required Skills
                        </label>

                        <div id="selectedSkillsContainer"
                            class="border border-gray-300 rounded-lg p-3 min-h-[60px] flex flex-wrap gap-2 mb-4">
                        </div>

                        <div class="border border-gray-300 rounded-lg p-4 max-h-56 overflow-y-auto">
                            <div class="flex flex-wrap gap-2">
                                @foreach ($skills as $skill)
                                    <span
                                        class="skill-pill cursor-pointer px-3 py-1 rounded-full border border-gray-300 text-sm hover:border-black transition"
                                        data-id="{{ $skill->id }}" data-name="{{ $skill->name }}">
                                        {{ $skill->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div id="hiddenSkills">
                            @foreach (old('skill_ids', $job->skills->pluck('id')->toArray()) as $skillId)
                                <input type="hidden" name="skill_ids[]" value="{{ $skillId }}">
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-10">
                        <label class="block text-xs font-bold tracking-wider text-gray-400 uppercase mb-2">
                            Job Description
                        </label>
                        <textarea name="description" rows="8" placeholder="Describe the role, requirements and benefits..."
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:border-black focus:ring-0" required>{{ old('description', $job->description) }}</textarea>
                    </div>

                    <div class="border-t border-gray-200 pt-6 flex justify-end gap-3">
                        <a href="{{ route('recruiter.jobs.index') }}"
                            class="px-6 py-3 border border-black font-semibold hover:bg-gray-100 transition">
                            Discard
                        </a>
                        <button type="submit"
                            class="px-8 py-3 bg-black text-white font-semibold hover:bg-gray-800 transition">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const pills = document.querySelectorAll('.skill-pill');
            const selectedContainer = document.getElementById('selectedSkillsContainer');
            const hiddenContainer = document.getElementById('hiddenSkills');

            let selectedSkills = @json(old('skill_ids', $job->skills->pluck('id')->toArray()));

            pills.forEach(pill => {
                pill.addEventListener('click', () => {
                    const skillId = Number(pill.dataset.id);

                    if (selectedSkills.includes(skillId)) {
                        selectedSkills = selectedSkills.filter(id => id !== skillId);
                    } else {
                        selectedSkills.push(skillId);
                    }

                    renderSkills();
                });
            });

            function renderSkills() {
                selectedContainer.innerHTML = '';
                hiddenContainer.innerHTML = '';

                pills.forEach(pill => {
                    const skillId = Number(pill.dataset.id);
                    const isSelected = selectedSkills.includes(skillId);

                    pill.classList.toggle('bg-black', isSelected);
                    pill.classList.toggle('text-white', isSelected);
                    pill.classList.toggle('border-black', isSelected);

                    pill.classList.toggle('bg-white', !isSelected);
                    pill.classList.toggle('text-gray-700', !isSelected);
                });

                selectedSkills.forEach(id => {
                    const pill = document.querySelector(`.skill-pill[data-id="${id}"]`);
                    if (!pill) return;

                    const skillName = pill.dataset.name;
                    const badge = document.createElement('span');
                    badge.className = 'px-3 py-1 rounded-full border border-gray-300 bg-gray-100 text-sm';
                    badge.innerHTML = `${skillName} <span class="ml-2 text-gray-400">×</span>`;
                    selectedContainer.appendChild(badge);

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'skill_ids[]';
                    input.value = id;
                    hiddenContainer.appendChild(input);
                });
            }

            renderSkills();
        });
    </script>

@endsection
