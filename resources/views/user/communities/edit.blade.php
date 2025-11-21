@extends('layouts.user')

@section('title', 'Edit ' . $community->name . ' - MuscleXpert')

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="glass rounded-2xl p-8 mb-8 border border-emerald-500/20">
                <h1 class="text-3xl font-bold text-gradient mb-2">Edit Community</h1>
                <p class="text-gray-300">Update your community settings and information</p>
            </div>

            <!-- Edit Form -->
            <div class="glass rounded-2xl p-8 border border-emerald-500/20">
                <form action="{{ route('user.communities.update', $community) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Community Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-semibold text-white mb-2">Community Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $community->name) }}"
                            class="w-full px-4 py-3 bg-dark-800 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                            placeholder="Community name" required>
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-semibold text-white mb-2">Description *</label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full px-4 py-3 bg-dark-800 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                            placeholder="Community description"
                            required>{{ old('description', $community->description) }}</textarea>
                        @error('description')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Privacy Settings -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-white mb-3">Privacy Settings</label>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="radio" name="is_public" value="1"
                                    class="text-emerald-500 focus:ring-emerald-500"
                                    {{ $community->is_public ? 'checked' : '' }}>
                                <span class="ml-3 text-white">
                                    <span class="font-medium">Public Community</span>
                                    <span class="text-gray-400 text-sm block">Anyone can view and join</span>
                                </span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="is_public" value="0"
                                    class="text-emerald-500 focus:ring-emerald-500"
                                    {{ !$community->is_public ? 'checked' : '' }}>
                                <span class="ml-3 text-white">
                                    <span class="font-medium">Private Community</span>
                                    <span class="text-gray-400 text-sm block">Only approved members can join</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Current Images -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-white mb-3">Current Images</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($community->image)
                                <div>
                                    <p class="text-gray-400 text-sm mb-2">Community Image</p>
                                    <img src="{{ Storage::url($community->image) }}" alt="Current community image"
                                        class="w-20 h-20 rounded-xl object-cover">
                                </div>
                            @endif
                            @if($community->cover_image)
                                <div>
                                    <p class="text-gray-400 text-sm mb-2">Cover Image</p>
                                    <img src="{{ Storage::url($community->cover_image) }}" alt="Current cover image"
                                        class="w-full h-20 rounded-xl object-cover">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Community Image -->
                    <div class="mb-6">
                        <label for="image" class="block text-sm font-semibold text-white mb-2">Update Community
                            Image</label>
                        <input type="file" id="image" name="image" accept="image/*"
                            class="w-full px-4 py-3 bg-dark-800 border border-gray-600 rounded-xl text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-500 file:text-white hover:file:bg-emerald-600 transition-all">
                        <p class="text-gray-400 text-sm mt-1">Recommended: 500x500px, max 2MB</p>
                        @error('image')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cover Image -->
                    <div class="mb-8">
                        <label for="cover_image" class="block text-sm font-semibold text-white mb-2">Update Cover
                            Image</label>
                        <input type="file" id="cover_image" name="cover_image" accept="image/*"
                            class="w-full px-4 py-3 bg-dark-800 border border-gray-600 rounded-xl text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-500 file:text-white hover:file:bg-emerald-600 transition-all">
                        <p class="text-gray-400 text-sm mt-1">Recommended: 1500x500px, max 2MB</p>
                        @error('cover_image')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4">
                        <a href="{{ route('user.communities.show', $community) }}"
                            class="flex-1 px-6 py-3 border border-gray-600 text-gray-300 rounded-xl font-semibold text-center hover:bg-gray-800 transition-all">
                            Cancel
                        </a>
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover-glow">
                            Update Community
                        </button>
                    </div>
                </form>

                <!-- Danger Zone -->
                <div class="mt-8 pt-8 border-t border-red-500/20">
                    <h3 class="text-lg font-semibold text-red-400 mb-4">Danger Zone</h3>
                    <form action="{{ route('user.communities.destroy', $community) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this community? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500/20 text-red-400 hover:bg-red-500/30 px-6 py-3 rounded-xl font-semibold transition-all flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Delete Community
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection