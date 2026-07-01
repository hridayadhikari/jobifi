@extends('master_index')


@section('title', 'Create Jobs')

@section('content')

<div class="max-w-6xl mx-auto p-6">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="page-heading">
            Post New Job
        </h1>
        <p class="page-subheading mt-1">
            Fill in the details below to reach thousands of potential candidates.
        </p>
    </div>

    <form action="{{ route('recruiter.jobs.store') }}" method="POST">
        @csrf

        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

            {{-- Card Header --}}
            <div class="border-b border-gray-200 px-8 py-5">
                <h2 class="card-heading mb-0">Job Details</h2>
            </div>

            <div class="p-8">

                {{-- Job Title --}}
                <div class="mb-6">
                    <label class="field-label">Job Title</label>
                    <input
                        type="text"
                        name="title"
                        placeholder="e.g. Senior Frontend Developer"
                        class="form-input"
                        required
                    >
                </div>

                {{-- Category + Type --}}
                <div class="grid md:grid-cols-2 gap-6 mb-6">

                    <div>
                        <label class="field-label">Job Category</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="field-label">Employment Type</label>
                        <select name="type" class="form-select" required>
                            <option value="full-time">Full-time</option>
                            <option value="part-time">Part-time</option>
                            <option value="contract">Contract</option>
                            <option value="internship">Internship</option>
                        </select>
                    </div>

                </div>

                {{-- Location + Salary --}}
                <div class="grid md:grid-cols-2 gap-6 mb-6">

                    <div>
                        <label class="field-label">Location</label>
                        <input type="text" name="location" placeholder="Remote / New York, NY"
                            class="form-input" required>
                    </div>

                    <div>
                        <label class="field-label">Salary Range</label>
                        <input type="text" name="salary_range" placeholder="₹6L - ₹10L"
                            class="form-input">
                    </div>

                </div>

                {{-- Skills --}}
                <div class="mb-6">
                    <label class="field-label">Required Skills</label>
                    <div id="selectedSkillsContainer"
                        class="border border-gray-300 rounded-lg p-3 min-h-[48px] flex flex-wrap gap-2 mb-3">
                    </div>
                    <div class="border border-gray-300 rounded-lg p-4 max-h-56 overflow-y-auto">
                        <div class="flex flex-wrap gap-2">
                            @foreach($skills as $skill)
                                <span
                                    class="skill-pill cursor-pointer px-3 py-1 rounded-full border border-gray-300 text-sm hover:border-gray-900 transition"
                                    data-id="{{ $skill->id }}"
                                    data-name="{{ $skill->name }}"
                                >
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div id="hiddenSkills"></div>
                </div>

                {{-- Description --}}
                <div class="mb-8">
                    <label class="field-label">Job Description</label>
                    <textarea
                        name="description"
                        rows="8"
                        placeholder="Describe the role, requirements and benefits..."
                        class="form-input"
                        required
                    ></textarea>
                </div>

                {{-- Footer --}}
                <div class="border-t border-gray-200 pt-6 flex justify-end gap-3">
                    <a href="{{ route('recruiter.jobs.index') }}" class="btn-secondary-lg">
                        Discard
                    </a>
                    <button type="submit" class="btn-primary-lg">
                        Publish Job Posting
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

    let selectedSkills = [];

    pills.forEach(pill => {

        pill.addEventListener('click', () => {

            const skillId = Number(pill.dataset.id);
            const skillName = pill.dataset.name;

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

        selectedSkills.forEach(id => {

            const pill = document.querySelector(
                `.skill-pill[data-id="${id}"]`
            );

            const skillName = pill.dataset.name;

            const badge = document.createElement('span');

            badge.className =
                'px-3 py-1 rounded-full border border-gray-300 bg-gray-100 text-sm';

            badge.innerHTML =
                `${skillName} <span class="ml-2 text-gray-400">×</span>`;

            selectedContainer.appendChild(badge);

            const input = document.createElement('input');

            input.type = 'hidden';
            input.name = 'skill_ids[]';
            input.value = id;

            hiddenContainer.appendChild(input);

        });

    }

});

</script>

@endsection