@extends('layouts.user')

@section('title', 'Edit Community')

@section('styles')
    <style>
        /* ... existing styles ... */

        .permission-alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .permission-alert svg {
            width: 3rem;
            height: 3rem;
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Permission Check -->
        @if(!$community->isAdmin(auth()->id()))
            <div class="permission-alert">
                <svg class="text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z">
                    </path>
                </svg>
                <h3 class="text-xl font-semibold text-red-300 mb-2">Access Denied</h3>
                <p class="text-red-200 mb-4">You don't have permission to edit this community.</p>
                <a href="{{ route('user.communities.show', $community->slug) }}"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                    Back to Community
                </a>
            </div>
        @else
            <div class="form-card">
                <div class="flex items-center gap-3 mb-6">
                    <a href="{{ route('user.communities.show', $community->slug) }}"
                        class="text-emerald-400 hover:text-emerald-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Edit Community</h1>
                        <p class="text-emerald-400 text-sm mt-1">Admin Access</p>
                    </div>
                </div>

                <form action="{{ route('user.communities.update', $community->slug) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Community Name -->
                    <div class="mb-6">
                        <label for="name" class="form-label">Community Name</label>
                        <input type="text" id="name" name="name" class="form-input" placeholder="Enter community name"
                            value="{{ old('name', $community->name) }}" required>
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" rows="4" class="form-input"
                            placeholder="Describe your community..."
                            required>{{ old('description', $community->description) }}</textarea>
                        @error('description')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Privacy Setting -->
                    <div class="mb-6">
                        <label class="form-label">Privacy Setting</label>
                        <div class="flex gap-6">
                            <label class="flex items-center radio-label">
                                <input type="radio" name="is_public" value="1"
                                    {{ old('is_public', $community->is_public) ? 'checked' : '' }} class="mr-3">
                                <div>
                                    <div class="font-medium">Public</div>
                                    <div class="text-sm text-gray-400">Anyone can join</div>
                                </div>
                            </label>
                            <label class="flex items-center radio-label">
                                <input type="radio" name="is_public" value="0"
                                    {{ !old('is_public', $community->is_public) ? 'checked' : '' }} class="mr-3">
                                <div>
                                    <div class="font-medium">Private</div>
                                    <div class="text-sm text-gray-400">Approval required</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Current Images -->
                    @if($community->image || $community->cover_image)
                        <div class="mb-6">
                            <label class="form-label">Current Images</label>
                            <div class="current-images">
                                <div class="image-container">
                                    @if($community->image)
                                        <div class="image-item">
                                            <p class="text-gray-300 text-sm mb-2">Current Avatar</p>
                                            <img src="{{ $community->image_url }}" alt="Current avatar" class="current-image">
                                            <div class="remove-checkbox">
                                                <label class="flex items-center text-sm text-gray-300">
                                                    <input type="checkbox" name="remove_image" value="1" class="mr-2">
                                                    Remove avatar
                                                </label>
                                            </div>
                                        </div>
                                    @endif

                                    @if($community->cover_image)
                                        <div class="image-item">
                                            <p class="text-gray-300 text-sm mb-2">Current Cover</p>
                                            <img src="{{ $community->cover_image_url }}" alt="Current cover" class="current-image">
                                            <div class="remove-checkbox">
                                                <label class="flex items-center text-sm text-gray-300">
                                                    <input type="checkbox" name="remove_cover_image" value="1" class="mr-2">
                                                    Remove cover
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Community Avatar -->
                    <div class="mb-6">
                        <label class="form-label">Community Avatar</label>
                        <div class="image-upload" onclick="document.getElementById('image').click()">
                            <svg class="w-12 h-12 text-emerald-400 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <p class="text-gray-300 font-medium">Click to upload new community avatar</p>
                            <p class="text-gray-400 text-sm mt-1">Recommended: 200x200px</p>
                            <input type="file" id="image" name="image" accept="image/*" class="hidden"
                                onchange="previewImage(this, 'avatar-preview')">
                        </div>
                        <img id="avatar-preview" class="image-preview hidden">
                        @error('image')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cover Image -->
                    <div class="mb-6">
                        <label class="form-label">Cover Image</label>
                        <div class="image-upload" onclick="document.getElementById('cover_image').click()">
                            <svg class="w-12 h-12 text-emerald-400 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <p class="text-gray-300 font-medium">Click to upload new cover image</p>
                            <p class="text-gray-400 text-sm mt-1">Recommended: 1200x300px</p>
                            <input type="file" id="cover_image" name="cover_image" accept="image/*" class="hidden"
                                onchange="previewImage(this, 'cover-preview')">
                        </div>
                        <img id="cover-preview" class="image-preview hidden">
                        @error('cover_image')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4">
                        <a href="{{ route('user.communities.show', $community->slug) }}"
                            class="flex-1 btn-cancel font-semibold py-3 px-6 rounded-xl text-center">
                            Cancel
                        </a>
                        <button type="submit" class="flex-1 btn-premium py-3 px-6 rounded-xl font-semibold">
                            Update Community
                        </button>
                    </div>
                </form>

                <!-- Danger Zone -->
                @if($community->created_by === auth()->id())
                    <div class="mt-8 pt-6 border-t border-red-400/20">
                        <h3 class="text-lg font-semibold text-red-400 mb-4">Danger Zone</h3>
                        <div class="bg-red-900/20 border border-red-400/30 rounded-xl p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium text-red-300">Delete Community</h4>
                                    <p class="text-sm text-red-200/70 mt-1">
                                        Once you delete a community, there is no going back. Please be certain.
                                    </p>
                                </div>
                                <form action="{{ route('user.communities.destroy', $community->slug) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this community? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                        Delete Community
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }

                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection