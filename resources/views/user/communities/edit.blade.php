@extends('layouts.user')

@section('title', 'Edit Community')

@section('styles')
    <style>
        .form-card {
            background: rgba(17, 25, 21, 0.8);
            backdrop-filter: blur(15px) saturate(180%);
            border: 1px solid rgba(0, 255, 170, 0.25);
            border-radius: 20px;
            padding: 1.5rem;
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
            font-size: 14px;
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
            font-size: 14px;
        }

        .image-upload {
            border: 2px dashed rgba(0, 255, 170, 0.3);
            border-radius: 12px;
            padding: 1.5rem;
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
            max-width: 100%;
            max-height: 200px;
            border-radius: 12px;
            margin-top: 1rem;
            border: 2px solid rgba(0, 255, 170, 0.3);
            object-fit: cover;
        }

        .current-image {
            max-width: 100%;
            max-height: 150px;
            border-radius: 8px;
            border: 2px solid rgba(0, 255, 170, 0.3);
            margin-bottom: 0.5rem;
        }

        .radio-label {
            color: #e5e7eb;
            cursor: pointer;
            transition: color 0.3s ease;
            font-size: 14px;
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
            font-size: 14px;
        }

        .btn-cancel:hover {
            background: rgba(75, 85, 99, 0.8);
            border-color: rgba(75, 85, 99, 0.6);
        }

        .permission-alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .permission-alert svg {
            width: 2.5rem;
            height: 2.5rem;
            margin-bottom: 1rem;
        }

        .current-images {
            background: rgba(10, 15, 13, 0.5);
            border: 1px solid rgba(0, 255, 170, 0.2);
            border-radius: 12px;
            padding: 1.5rem;
        }

        .image-container {
            display: grid;
            gap: 1.5rem;
        }

        .image-item {
            text-align: center;
        }

        .remove-checkbox {
            margin-top: 0.5rem;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 640px) {
            .form-card {
                padding: 1.25rem;
                border-radius: 16px;
                margin: 0 0.5rem;
            }

            .form-input {
                padding: 10px 14px;
                font-size: 16px;
            }

            .image-upload {
                padding: 1.25rem;
            }

            .image-preview,
            .current-image {
                max-height: 150px;
            }

            .btn-cancel,
            .btn-premium {
                font-size: 14px;
                padding: 12px 16px;
            }

            .permission-alert {
                padding: 1.25rem;
                margin: 0 0.5rem 1.5rem;
            }

            .permission-alert svg {
                width: 2rem;
                height: 2rem;
            }

            .current-images {
                padding: 1.25rem;
            }
        }

        @media (max-width: 480px) {
            .form-card {
                padding: 1rem;
                border-radius: 12px;
            }

            .form-input {
                padding: 8px 12px;
            }

            .image-upload {
                padding: 1rem;
            }

            .image-preview,
            .current-image {
                max-height: 120px;
            }

            .permission-alert {
                padding: 1rem;
            }

            .current-images {
                padding: 1rem;
            }
        }

        /* Tablet Styles */
        @media (min-width: 641px) and (max-width: 1024px) {
            .form-card {
                padding: 1.75rem;
            }

            .current-images {
                padding: 1.75rem;
            }
        }

        /* Desktop Styles */
        @media (min-width: 1025px) {
            .form-card {
                padding: 2rem;
            }

            .current-images {
                padding: 2rem;
            }
        }

        /* Form Layout Responsiveness */
        @media (max-width: 640px) {
            .flex.gap-4 {
                flex-direction: column;
                gap: 0.75rem;
            }

            .flex.gap-4>* {
                flex: none;
                width: 100%;
            }

            .flex.gap-6 {
                flex-direction: column;
                gap: 1rem;
            }

            /* Danger Zone responsive layout */
            .flex.items-center.justify-between {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .flex.items-center.justify-between form {
                width: 100%;
            }

            .flex.items-center.justify-between form button {
                width: 100%;
            }
        }

        /* Typography Responsiveness */
        @media (max-width: 640px) {
            h1.text-2xl {
                font-size: 1.5rem;
            }

            h3.text-lg {
                font-size: 1.125rem;
            }

            .text-sm {
                font-size: 0.75rem;
            }

            .permission-alert h3 {
                font-size: 1.25rem;
            }
        }

        /* Image Upload Responsiveness */
        @media (max-width: 480px) {
            .image-upload svg {
                width: 2rem;
                height: 2rem;
            }

            .image-upload p {
                font-size: 0.875rem;
            }

            .image-upload p.text-sm {
                font-size: 0.75rem;
            }
        }

        /* Radio Button Group Responsiveness */
        @media (max-width: 640px) {
            .radio-label {
                padding: 0.75rem;
                border: 1px solid rgba(0, 255, 170, 0.2);
                border-radius: 8px;
                margin-bottom: 0.5rem;
            }

            .radio-label:last-child {
                margin-bottom: 0;
            }
        }

        /* Back Button Responsiveness */
        @media (max-width: 480px) {
            .flex.items-center.gap-3 {
                gap: 0.75rem;
            }

            .flex.items-center.gap-3 svg {
                width: 1.25rem;
                height: 1.25rem;
            }
        }

        /* Error Message Responsiveness */
        @media (max-width: 640px) {
            .text-red-400.text-sm {
                font-size: 0.75rem;
            }
        }

        /* Container Responsiveness */
        @media (max-width: 640px) {
            .max-w-2xl {
                max-width: 100%;
                padding: 0 0.5rem;
            }
        }

        /* Current Images Grid Responsiveness */
        @media (min-width: 641px) {
            .image-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .image-container {
                grid-template-columns: 1fr;
            }
        }

        /* Danger Zone Responsiveness */
        @media (max-width: 640px) {
            .mt-8.pt-6 {
                margin-top: 1.5rem;
                padding-top: 1.5rem;
            }

            .bg-red-900\/20 {
                padding: 1rem;
            }
        }

        /* Touch-friendly improvements */
        @media (max-width: 768px) {
            .image-upload {
                min-height: 120px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .btn-cancel,
            .btn-premium {
                min-height: 48px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Make checkboxes easier to tap */
            .remove-checkbox label {
                padding: 0.5rem;
                border-radius: 6px;
                transition: background-color 0.2s ease;
            }

            .remove-checkbox label:hover {
                background: rgba(255, 255, 255, 0.05);
            }
        }

        /* Permission alert responsiveness */
        @media (max-width: 480px) {
            .permission-alert .bg-red-600 {
                width: 100%;
                padding: 0.75rem 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto px-3 sm:px-4 lg:px-6">
        <!-- Permission Check -->
        @if(!$community->isAdmin(auth()->id()))
            <div class="permission-alert">
                <svg class="text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z">
                    </path>
                </svg>
                <h3 class="text-lg sm:text-xl font-semibold text-red-300 mb-2">Access Denied</h3>
                <p class="text-red-200 text-sm sm:text-base mb-4">You don't have permission to edit this community.</p>
                <a href="{{ route('user.communities.show', $community->slug) }}"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 sm:px-6 rounded-lg transition-colors inline-block">
                    Back to Community
                </a>
            </div>
        @else
            <div class="form-card">
                <div class="flex items-center gap-3 mb-4 sm:mb-6">
                    <a href="{{ route('user.communities.show', $community->slug) }}"
                        class="text-emerald-400 hover:text-emerald-300 transition-colors flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-white">Edit Community</h1>
                        <p class="text-emerald-400 text-xs sm:text-sm mt-1">Admin Access</p>
                    </div>
                </div>

                <form action="{{ route('user.communities.update', $community->slug) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Community Name -->
                    <div class="mb-4 sm:mb-6">
                        <label for="name" class="form-label">Community Name</label>
                        <input type="text" id="name" name="name" class="form-input" placeholder="Enter community name"
                            value="{{ old('name', $community->name) }}" required>
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4 sm:mb-6">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" rows="4" class="form-input"
                            placeholder="Describe your community..."
                            required>{{ old('description', $community->description) }}</textarea>
                        @error('description')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Privacy Setting -->
                    <div class="mb-4 sm:mb-6">
                        <label class="form-label">Privacy Setting</label>
                        <div class="flex flex-col sm:flex-row sm:gap-6 gap-3">
                            <label
                                class="flex items-center radio-label p-3 sm:p-0 rounded-lg sm:rounded-none border border-transparent sm:border-none hover:border-emerald-500/20 sm:hover:border-transparent">
                                <input type="radio" name="is_public" value="1"
                                    {{ old('is_public', $community->is_public) ? 'checked' : '' }}
                                    class="mr-3 w-4 h-4 sm:w-auto sm:h-auto">
                                <div>
                                    <div class="font-medium text-sm sm:text-base">Public</div>
                                    <div class="text-xs sm:text-sm text-gray-400">Anyone can join</div>
                                </div>
                            </label>
                            <label
                                class="flex items-center radio-label p-3 sm:p-0 rounded-lg sm:rounded-none border border-transparent sm:border-none hover:border-emerald-500/20 sm:hover:border-transparent">
                                <input type="radio" name="is_public" value="0"
                                    {{ !old('is_public', $community->is_public) ? 'checked' : '' }}
                                    class="mr-3 w-4 h-4 sm:w-auto sm:h-auto">
                                <div>
                                    <div class="font-medium text-sm sm:text-base">Private</div>
                                    <div class="text-xs sm:text-sm text-gray-400">Approval required</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Current Images -->
                    @if($community->image || $community->cover_image)
                        <div class="mb-4 sm:mb-6">
                            <label class="form-label">Current Images</label>
                            <div class="current-images">
                                <div class="image-container">
                                    @if($community->image)
                                        <div class="image-item">
                                            <p class="text-gray-300 text-sm mb-2">Current Avatar</p>
                                            <img src="{{ $community->image_url }}" alt="Current avatar" class="current-image">
                                            <div class="remove-checkbox">
                                                <label
                                                    class="flex items-center text-xs sm:text-sm text-gray-300 p-2 rounded hover:bg-white/5 transition-colors">
                                                    <input type="checkbox" name="remove_image" value="1" class="mr-2 w-4 h-4">
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
                                                <label
                                                    class="flex items-center text-xs sm:text-sm text-gray-300 p-2 rounded hover:bg-white/5 transition-colors">
                                                    <input type="checkbox" name="remove_cover_image" value="1" class="mr-2 w-4 h-4">
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
                    <div class="mb-4 sm:mb-6">
                        <label class="form-label">Community Avatar</label>
                        <div class="image-upload" onclick="document.getElementById('image').click()">
                            <svg class="w-8 h-8 sm:w-12 sm:h-12 text-emerald-400 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <p class="text-gray-300 font-medium text-sm sm:text-base">Click to upload new community avatar</p>
                            <p class="text-gray-400 text-xs sm:text-sm mt-1">Recommended: 200x200px</p>
                            <input type="file" id="image" name="image" accept="image/*" class="hidden"
                                onchange="previewImage(this, 'avatar-preview')">
                        </div>
                        <img id="avatar-preview" class="image-preview hidden">
                        @error('image')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cover Image -->
                    <div class="mb-6 sm:mb-8">
                        <label class="form-label">Cover Image</label>
                        <div class="image-upload" onclick="document.getElementById('cover_image').click()">
                            <svg class="w-8 h-8 sm:w-12 sm:h-12 text-emerald-400 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <p class="text-gray-300 font-medium text-sm sm:text-base">Click to upload new cover image</p>
                            <p class="text-gray-400 text-xs sm:text-sm mt-1">Recommended: 1200x300px</p>
                            <input type="file" id="cover_image" name="cover_image" accept="image/*" class="hidden"
                                onchange="previewImage(this, 'cover-preview')">
                        </div>
                        <img id="cover-preview" class="image-preview hidden">
                        @error('cover_image')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <a href="{{ route('user.communities.show', $community->slug) }}"
                            class="btn-cancel font-semibold py-3 px-6 rounded-xl text-center order-2 sm:order-1">
                            Cancel
                        </a>
                        <button type="submit" class="btn-premium py-3 px-6 rounded-xl font-semibold order-1 sm:order-2">
                            Update Community
                        </button>
                    </div>
                </form>

                <!-- Danger Zone -->
                @if($community->created_by === auth()->id())
                    <div class="mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-red-400/20">
                        <h3 class="text-lg font-semibold text-red-400 mb-3 sm:mb-4">Danger Zone</h3>
                        <div class="bg-red-900/20 border border-red-400/30 rounded-xl p-3 sm:p-4">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
                                <div class="flex-1">
                                    <h4 class="font-medium text-red-300 text-sm sm:text-base">Delete Community</h4>
                                    <p class="text-xs sm:text-sm text-red-200/70 mt-1">
                                        Once you delete a community, there is no going back. Please be certain.
                                    </p>
                                </div>
                                <form action="{{ route('user.communities.destroy', $community->slug) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this community? This action cannot be undone.')"
                                    class="w-full sm:w-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors w-full sm:w-auto text-sm sm:text-base">
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
            } else {
                preview.classList.add('hidden');
            }
        }

        // Enhanced file input handling for mobile
        document.addEventListener('DOMContentLoaded', function () {
            const fileInputs = document.querySelectorAll('input[type="file"]');

            fileInputs.forEach(input => {
                input.addEventListener('change', function (e) {
                    const previewId = this.getAttribute('onchange').match(/'([^']+)'/)[1];
                    previewImage(this, previewId);
                });
            });

            // Add touch improvements for mobile
            if ('ontouchstart' in window) {
                const imageUploads = document.querySelectorAll('.image-upload');
                imageUploads.forEach(upload => {
                    upload.style.cursor = 'pointer';
                    upload.addEventListener('touchend', function (e) {
                        e.preventDefault();
                        const fileInput = this.querySelector('input[type="file"]');
                        if (fileInput) {
                            fileInput.click();
                        }
                    });
                });

                // Improve checkbox tapping
                const checkboxes = document.querySelectorAll('.remove-checkbox input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('touchstart', function (e) {
                        e.stopPropagation();
                    });
                });
            }
        });
    </script>
@endsection