@extends('layouts.user')

@section('title', 'Edit Profil')

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
                <div class="flex items-center gap-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center animate-glow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-white">
                            Edit <span class="text-gradient">Profile</span>
                        </h1>
                        <p class="text-emerald-400/80 text-lg mt-2">Update your personal information and preferences</p>
                    </div>
                </div>
            </div>

            {{-- Success Notification --}}
            @if(session('success'))
                <div class="glass rounded-2xl p-4 mb-8 border border-emerald-500/30 bg-emerald-500/10">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-emerald-400 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Error Notification --}}
            @if($errors->any())
                <div class="glass rounded-2xl p-4 mb-8 border border-red-500/30 bg-red-500/10">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-red-500/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-400" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-red-400 font-medium">Please fix the following errors:</p>
                            <ul class="text-red-400/80 text-sm mt-1 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div
                class="glass-dark rounded-3xl border border-emerald-500/20 shadow-xl shadow-emerald-500/10 overflow-hidden">
                {{-- Form Section --}}
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="p-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            {{-- Left Column - Personal Information --}}
                            <div class="space-y-6">
                                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Personal Information
                                </h3>

                                {{-- Name --}}
                                <div class="space-y-2">
                                    <label for="name" class="block text-sm font-medium text-emerald-400">Full Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white 
                                               placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 
                                               focus:border-transparent transition-all duration-300">
                                    @error('name')
                                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="space-y-2">
                                    <label for="email" class="block text-sm font-medium text-emerald-400">Email
                                        Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                        required class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white 
                                               placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 
                                               focus:border-transparent transition-all duration-300">
                                    @error('email')
                                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Age --}}
                                <div class="space-y-2">
                                    <label for="age" class="block text-sm font-medium text-gray-300">Age</label>
                                    <input type="number" name="age" id="age" value="{{ old('age', $user->age) }}" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white 
                                               placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 
                                               focus:border-transparent transition-all duration-300" min="10" max="100">
                                    @error('age')
                                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Right Column - Physical Information --}}
                            <div class="space-y-6">
                                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                    Physical Stats
                                </h3>

                                {{-- Gender --}}
                                <div class="space-y-2">
                                    <label for="gender" class="block text-sm font-medium text-gray-300">Gender</label>
                                    <select name="gender" id="gender" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white 
                                               focus:outline-none focus:ring-2 focus:ring-emerald-500 
                                               focus:border-transparent transition-all duration-300">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>
                                            Male</option>
                                        <option value="female"
                                            {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('gender')
                                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Height --}}
                                <div class="space-y-2">
                                    <label for="height" class="block text-sm font-medium text-gray-300">Height (cm)</label>
                                    <input type="number" name="height" id="height"
                                        value="{{ old('height', $user->height) }}" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white 
                                               placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 
                                               focus:border-transparent transition-all duration-300" min="100" max="250"
                                        step="0.1">
                                    @error('height')
                                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Weight --}}
                                <div class="space-y-2">
                                    <label for="weight" class="block text-sm font-medium text-gray-300">Weight (kg)</label>
                                    <input type="number" name="weight" id="weight"
                                        value="{{ old('weight', $user->weight) }}" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white 
                                               placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 
                                               focus:border-transparent transition-all duration-300" min="30" max="300"
                                        step="0.1">
                                    @error('weight')
                                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Avatar Upload Section --}}
                        <div class="mt-8 pt-8 border-t border-gray-700/50">
                            <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Profile Picture
                            </h3>

                            <div class="flex flex-col md:flex-row items-center gap-8">
                                {{-- Current Avatar --}}
                                <div class="text-center">
                                    <div class="relative inline-block group">
                                        <img id="avatarPreview"
                                            src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}"
                                            alt="Current Avatar"
                                            class="w-32 h-32 object-cover rounded-2xl border-4 border-emerald-500/30 shadow-2xl shadow-emerald-500/20 transition-all duration-300 group-hover:border-emerald-500/60 cursor-pointer">

                                        {{-- Upload Overlay --}}
                                        <div class="absolute inset-0 bg-black/50 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer"
                                            onclick="document.getElementById('avatar').click()">
                                            <div class="text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-8 w-8 text-white mx-auto mb-1" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span class="text-white text-sm font-medium">Change Photo</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-400 text-sm mt-3">Click on the photo to change</p>
                                </div>

                                {{-- Upload Controls --}}
                                <div class="flex-1">
                                    <div class="space-y-4">
                                        <div>
                                            <label for="avatar" class="block text-sm font-medium text-gray-300 mb-2">Upload
                                                New Photo</label>
                                            <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden"
                                                onchange="previewImage(event)">
                                            <div class="flex items-center gap-4">
                                                <button type="button" onclick="document.getElementById('avatar').click()"
                                                    class="px-6 py-3 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 rounded-xl hover:bg-emerald-500/30 transition-all duration-300 font-medium">
                                                    Choose File
                                                </button>
                                                <span id="fileName" class="text-gray-400 text-sm">No file chosen</span>
                                            </div>
                                            <p class="text-gray-500 text-xs mt-2">Supported formats: JPG, PNG, GIF. Max
                                                size: 2MB</p>
                                            @error('avatar')
                                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div
                            class="mt-8 pt-6 border-t border-gray-700/50 flex flex-col sm:flex-row gap-4 justify-between items-center">
                            <a href="{{ route('user.profile.index') }}"
                                class="group flex items-center justify-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-gray-400 hover:text-white transition-all duration-300 border border-gray-600 hover:bg-gray-700/50 w-full sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to Profile
                            </a>
                            <button type="submit"
                                class="group flex items-center justify-center gap-2 px-8 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25 w-full sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .text-gradient {
            background: linear-gradient(135deg, #10b981 0%, #34d399 50%, #6ee7b7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass {
            background: rgba(10, 10, 10, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .glass-dark {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .animate-glow {
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
            }

            to {
                box-shadow: 0 0 20px rgba(16, 185, 129, 0.6), 0 0 30px rgba(16, 185, 129, 0.4);
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('avatarPreview');
            const fileName = document.getElementById('fileName');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(file);
                fileName.textContent = file.name;
            }
        }

        // Show file browser when clicking on avatar
        document.getElementById('avatarPreview')?.addEventListener('click', function () {
            document.getElementById('avatar').click();
        });

        // Update file name when file is selected
        document.getElementById('avatar')?.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                document.getElementById('fileName').textContent = this.files[0].name;
            }
        });
    </script>
@endsection