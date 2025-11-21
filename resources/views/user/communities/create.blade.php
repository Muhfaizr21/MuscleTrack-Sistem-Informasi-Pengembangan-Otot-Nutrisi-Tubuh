@extends('layouts.user')

@section('title', 'Create Community - MuscleXpert')

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="glass rounded-2xl p-8 mb-8 border border-emerald-500/20">
                <h1 class="text-3xl font-bold text-gradient mb-2">Create New Community</h1>
                <p class="text-gray-300">Build your own fitness community and connect with like-minded people</p>
            </div>

            <!-- Create Form -->
            <div class="glass rounded-2xl p-8 border border-emerald-500/20">
                <form action="{{ route('user.communities.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Community Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-semibold text-white mb-2">Community Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-3 bg-dark-800 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                            placeholder="e.g., Muscle Builders Club, Cardio Lovers, etc." required>
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-semibold text-white mb-2">Description *</label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full px-4 py-3 bg-dark-800 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                            placeholder="Describe your community, its purpose, and what members can expect..."
                            required>{{ old('description') }}</textarea>
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
                                    class="text-emerald-500 focus:ring-emerald-500" checked>
                                <span class="ml-3 text-white">
                                    <span class="font-medium">Public Community</span>
                                    <span class="text-gray-400 text-sm block">Anyone can view and join</span>
                                </span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="is_public" value="0"
                                    class="text-emerald-500 focus:ring-emerald-500">
                                <span class="ml-3 text-white">
                                    <span class="font-medium">Private Community</span>
                                    <span class="text-gray-400 text-sm block">Only approved members can join</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Community Image -->
                    <div class="mb-6">
                        <label for="image" class="block text-sm font-semibold text-white mb-2">Community Image</label>
                        <input type="file" id="image" name="image" accept="image/*"
                            class="w-full px-4 py-3 bg-dark-800 border border-gray-600 rounded-xl text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-500 file:text-white hover:file:bg-emerald-600 transition-all">
                        <p class="text-gray-400 text-sm mt-1">Recommended: 500x500px, max 2MB</p>
                        @error('image')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cover Image -->
                    <div class="mb-8">
                        <label for="cover_image" class="block text-sm font-semibold text-white mb-2">Cover Image</label>
                        <input type="file" id="cover_image" name="cover_image" accept="image/*"
                            class="w-full px-4 py-3 bg-dark-800 border border-gray-600 rounded-xl text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-500 file:text-white hover:file:bg-emerald-600 transition-all">
                        <p class="text-gray-400 text-sm mt-1">Recommended: 1500x500px, max 2MB</p>
                        @error('cover_image')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4">
                        <a href="{{ route('user.communities.index') }}"
                            class="flex-1 px-6 py-3 border border-gray-600 text-gray-300 rounded-xl font-semibold text-center hover:bg-gray-800 transition-all">
                            Cancel
                        </a>
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover-glow">
                            Create Community
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection