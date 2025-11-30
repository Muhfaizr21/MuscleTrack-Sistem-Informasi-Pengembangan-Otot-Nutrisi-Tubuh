@extends('layouts.user')

@section('title', 'Create Community')

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
                /* Better for mobile input */
            }

            .image-upload {
                padding: 1.25rem;
            }

            .image-preview {
                max-height: 150px;
            }

            .btn-cancel,
            .btn-premium {
                font-size: 14px;
                padding: 12px 16px;
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

            .image-upload svg {
                width: 10px;
                height: 10px;
            }

            .image-preview {
                max-height: 120px;
            }
        }

        /* Tablet Styles */
        @media (min-width: 641px) and (max-width: 1024px) {
            .form-card {
                padding: 1.75rem;
            }
        }

        /* Desktop Styles */
        @media (min-width: 1025px) {
            .form-card {
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
        }

        /* Typography Responsiveness */
        @media (max-width: 640px) {
            h1.text-2xl {
                font-size: 1.5rem;
            }

            .text-sm {
                font-size: 0.75rem;
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
        }
    </style>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto px-3 sm:px-4 lg:px-6">
        <div class="form-card">
            <div class="flex items-center gap-3 mb-4 sm:mb-6">
                <a href="{{ route('user.communities.index') }}"
                    class="text-emerald-400 hover:text-emerald-300 transition-colors flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-xl sm:text-2xl font-bold text-white">Create New Community</h1>
            </div>

            <form action="{{ route('user.communities.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Community Name -->
                <div class="mb-4 sm:mb-6">
                    <label for="name" class="form-label">Community Name</label>
                    <input type="text" id="name" name="name" class="form-input" placeholder="Enter community name"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4 sm:mb-6">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="4" class="form-input"
                        placeholder="Describe your community..." required>{{ old('description') }}</textarea>
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
                            <input type="radio" name="is_public" value="1" {{ old('is_public', true) ? 'checked' : '' }}
                                class="mr-3 w-4 h-4 sm:w-auto sm:h-auto">
                            <div>
                                <div class="font-medium text-sm sm:text-base">Public</div>
                                <div class="text-xs sm:text-sm text-gray-400">Anyone can join</div>
                            </div>
                        </label>
                        <label
                            class="flex items-center radio-label p-3 sm:p-0 rounded-lg sm:rounded-none border border-transparent sm:border-none hover:border-emerald-500/20 sm:hover:border-transparent">
                            <input type="radio" name="is_public" value="0" {{ !old('is_public', true) ? 'checked' : '' }}
                                class="mr-3 w-4 h-4 sm:w-auto sm:h-auto">
                            <div>
                                <div class="font-medium text-sm sm:text-base">Private</div>
                                <div class="text-xs sm:text-sm text-gray-400">Approval required</div>
                            </div>
                        </label>
                    </div>
                </div>

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
                        <p class="text-gray-300 font-medium text-sm sm:text-base">Click to upload community avatar</p>
                        <p class="text-gray-400 text-xs sm:text-sm mt-1">Recommended: 200x200px</p>
                        <input type="file" id="image" name="image" accept="image/*" class="hidden"
                            onchange="previewImage(this, 'avatar-preview')">
                    </div>
                    <img id="avatar-preview" class="image-preview hidden">
                </div>

                <!-- Cover Image -->
                <div class="mb-6 sm:mb-8">
                    <label class="form-label">Cover Image (Optional)</label>
                    <div class="image-upload" onclick="document.getElementById('cover_image').click()">
                        <svg class="w-8 h-8 sm:w-12 sm:h-12 text-emerald-400 mx-auto mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <p class="text-gray-300 font-medium text-sm sm:text-base">Click to upload cover image</p>
                        <p class="text-gray-400 text-xs sm:text-sm mt-1">Recommended: 1200x300px</p>
                        <input type="file" id="cover_image" name="cover_image" accept="image/*" class="hidden"
                            onchange="previewImage(this, 'cover-preview')">
                    </div>
                    <img id="cover-preview" class="image-preview hidden">
                </div>

                <!-- Submit Button -->
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                    <a href="{{ route('user.communities.index') }}"
                        class="btn-cancel font-semibold py-3 px-6 rounded-xl text-center order-2 sm:order-1">
                        Cancel
                    </a>
                    <button type="submit" class="btn-premium py-3 px-6 rounded-xl font-semibold order-1 sm:order-2">
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
            }
        });
    </script>
@endsection