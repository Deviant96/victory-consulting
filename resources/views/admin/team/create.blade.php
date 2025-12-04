@extends('admin.layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.team.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to Team Members
    </a>
</div>

<div class="bg-white rounded-xl shadow p-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Add Team Member</h1>

    <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data" x-data="expertiseManager()">
        @csrf

        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Position *</label>
            <input type="text" name="position" id="position" value="{{ old('position') }}" required placeholder="e.g., Senior Consultant" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('position') border-red-500 @enderror">
            @error('position')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
            <textarea name="bio" id="bio" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('bio') border-red-500 @enderror">{{ old('bio') }}</textarea>
            @error('bio')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Photo</label>
            <input type="file" name="photo" id="photo" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('photo') border-red-500 @enderror">
            @error('photo')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-sm mt-1">Recommended: Square image, at least 400x400px</p>
        </div>

        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
            @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="linkedin" class="block text-sm font-medium text-gray-700 mb-2">LinkedIn URL</label>
            <input type="url" name="linkedin" id="linkedin" value="{{ old('linkedin') }}" placeholder="https://linkedin.com/in/..." class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('linkedin') border-red-500 @enderror">
            @error('linkedin')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Expertise Areas</label>
            <div class="space-y-3">
                <template x-for="(skill, index) in skills" :key="index">
                    <div class="flex gap-2">
                        <input type="text" :name="'expertise[' + index + ']'" x-model="skills[index]" placeholder="e.g., Business Strategy" class="flex-1 px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                        <button type="button" @click="removeSkill(index)" class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition">
                            Remove
                        </button>
                    </div>
                </template>
            </div>
            <button type="button" @click="addSkill()" class="mt-3 px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition">
                Add Expertise Area
            </button>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                Create Team Member
            </button>
            <a href="{{ route('admin.team.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
function expertiseManager() {
    return {
        skills: [''],
        addSkill() {
            this.skills.push('');
        },
        removeSkill(index) {
            this.skills.splice(index, 1);
            if (this.skills.length === 0) {
                this.skills = [''];
            }
        }
    }
}
</script>
@endsection
