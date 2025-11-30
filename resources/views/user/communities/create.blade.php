@extends('layouts.user')

@section('title', 'Create Community')

@section('styles')
    <style>
        .form-card {
            background: rgba(17, 25, 21, 0.8);
            backdrop-filter: blur(15px) saturate(180%);
            border: 1px solid rgba(0, 255, 170, 0.25);
            border-radius: 20px;
            padding: 2rem;
        }

        .form-input {
            background: rgba(10, 15, 13, 0.8);
            border: 1px solid rgba(0, 255, 170, 0.3);
            border-radius: 12px;
            padding: 12px 16px;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-input::placeholder {
            color: #9CA3AF;
        }

        .form-input:focus {
            background: rgba(10, 15, 13, 0.9);
            border-color: rgba(0, 255, 170, 0.6);
            box-shadow: 0 0 0 3px rgba(0, 255, 170, 0.1);
            outline: none;
            color: white;
        }

        .form-label {
            color: #e5e7eb;
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }

        .image-upload {
            border: 2px dashed rgba(0, 255, 170, 0.3);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            background: rgba(10, 15, 13, 0.5);
        }

        .image-upload:hover {
            border-color: rgba(0, 255, 170, 0.6);
            background: rgba(0, 255, 170, 0.05);
        }

        .image-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 12px;
            margin-top: 1rem;
            border: 2px solid rgba(0, 255, 170, 0.3);
        }

        .radio-label {
            color: #e5e7eb;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .radio-label:hover {
            color: #00ffcc;
        }

        input[type="radio"] {
            accent-color: #00ff9d;
        }

        .btn-cancel {
            background: rgba(75, 85, 99, 0.6);
            color: white;
            border: 1px solid rgba(75, 85, 99, 0.4);
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: rgba(75, 85, 99, 0.8);
            border-color: rgba(75, 85, 99, 0.6);
        }
    </style>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="form-card">
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('user.communities.index') }}"
                    class="text-emerald-400 hover:text-emerald-300 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-white">Create New Community</h1>
            </div>

            <form action="{{ route('user.communities.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Community Name -->
                <div class="mb-6">
                    <label for="name" class="form-label">Community Name</label>
                    <input type="text" id="name" name="name" class="form-input" placeholder="Enter community name"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="4" class="form-input"
                        placeholder="Describe your community..." required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Privacy Setting -->
                <div class="mb-6">
                    <label class="form-label">Privacy Setting</label>
                    <div class="flex gap-6">
                        <label class="flex items-center radio-label">
                            <input type="radio" name="is_public" value="1" {{ old('is_public', true) ? 'checked' : '' }}
                                class="mr-3">
                            <div>
                                <div class="font-medium">Public</div>
                                <div class="text-sm text-gray-400">Anyone can join</div>
                            </div>
                        </label>
                        <label class="flex items-center radio-label">
                            <input type="radio" name="is_public" value="0" {{ !old('is_public', true) ? 'checked' : '' }}
                                class="mr-3">
                            <div>
                                <div class="font-medium">Private</div>
                                <div class="text-sm text-gray-400">Approval required</div>
                            </div>
                        </label>
                    </div>
                </div>

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
                        <p class="text-gray-300 font-medium">Click to upload community avatar</p>
                        <p class="text-gray-400 text-sm mt-1">Recommended: 200x200px</p>
                        <input type="file" id="image" name="image" accept="image/*" class="hidden"
                            onchange="previewImage(this, 'avatar-preview')">
                    </div>
                    <img id="avatar-preview" class="image-preview hidden">
                </div>

                <!-- Cover Image -->
                <div class="mb-6">
                    <label class="form-label">Cover Image (Optional)</label>
                    <div class="image-upload" onclick="document.getElementById('cover_image').click()">
                        <svg class="w-12 h-12 text-emerald-400 mx-auto mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <p class="text-gray-300 font-medium">Click to upload cover image</p>
                        <p class="text-gray-400 text-sm mt-1">Recommended: 1200x300px</p>
                        <input type="file" id="cover_image" name="cover_image" accept="image/*" class="hidden"
                            onchange="previewImage(this, 'cover-preview')">
                    </div>
                    <img id="cover-preview" class="image-preview hidden">
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4">
                    <a href="{{ route('user.communities.index') }}"
                        class="flex-1 btn-cancel font-semibold py-3 px-6 rounded-xl text-center">
                        Cancel
                    </a>
                    <button type="submit" class="flex-1 btn-premium py-3 px-6 rounded-xl font-semibold">
                        Create Community
                    </button>
                </div>
            </form>
        </div>
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