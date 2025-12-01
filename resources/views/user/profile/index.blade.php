@extends('layouts.user')

@section('content')
    <div class="min-h-screen py-4 md:py-8">
        <div class="max-w-4xl mx-auto px-3 sm:px-4 lg:px-8">

            {{-- Header Section --}}
            <div
                class="glass-dark rounded-2xl md:rounded-3xl p-4 md:p-8 border border-emerald-500/20 shadow-lg md:shadow-2xl shadow-emerald-500/10 mb-6 md:mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-start gap-4 md:gap-6">
                    <div class="flex items-center gap-3 md:gap-4">
                        <div
                            class="w-10 h-10 md:w-14 md:h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl md:rounded-2xl flex items-center justify-center animate-glow">
                            <span class="text-xl md:text-2xl">👤</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-white leading-tight">
                                Profile <span class="text-gradient">Information</span>
                            </h1>
                            <p class="text-emerald-400/80 text-sm md:text-lg mt-1 md:mt-2">Manage your personal information
                                and account settings</p>
                        </div>
                    </div>
                    <div class="text-left lg:text-right w-full lg:w-auto mt-4 lg:mt-0">
                        <div class="text-emerald-400 font-bold text-xs md:text-sm uppercase tracking-wider mb-1 md:mb-2">
                            Account Status</div>
                        <p class="text-white font-semibold text-sm md:text-base">Active • Member since
                            {{ $user->created_at->format('M Y') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Success Notification --}}
            @if(session('success'))
                <div
                    class="glass rounded-xl md:rounded-2xl p-3 md:p-4 mb-6 md:mb-8 border border-emerald-500/30 bg-emerald-500/10">
                    <div class="flex items-center gap-2 md:gap-3">
                        <div
                            class="w-6 h-6 md:w-8 md:h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4 text-emerald-400"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-emerald-400 font-medium text-sm md:text-base">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="glass rounded-xl md:rounded-2xl p-3 md:p-4 mb-6 md:mb-8 border border-red-500/30 bg-red-500/10">
                    <div class="flex items-start gap-2 md:gap-3">
                        <div
                            class="w-6 h-6 md:w-8 md:h-8 bg-red-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4 text-red-400"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-red-400 font-medium text-sm md:text-base">Please fix the following errors:</p>
                            <ul class="text-red-400/80 text-xs md:text-sm mt-1 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="flex items-start gap-1">
                                        <span class="mt-1">•</span>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
                {{-- Left Column - Profile Picture --}}
                <div class="lg:col-span-1">
                    <div
                        class="glass-dark rounded-2xl md:rounded-3xl p-4 md:p-6 border border-emerald-500/20 shadow-lg md:shadow-xl shadow-emerald-500/10">
                        <div class="text-center">
                            {{-- Profile Picture with Upload --}}
                            <div class="relative inline-block group">
                                <div class="relative">
                                    <img id="avatarPreview"
                                        src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('aset/icon-user.jpg') }}"
                                        alt="Profile Photo"
                                        class="w-24 h-24 md:w-32 md:h-32 object-cover rounded-xl md:rounded-2xl border-4 border-emerald-500/30 shadow-lg md:shadow-2xl shadow-emerald-500/20 transition-all duration-300 group-hover:border-emerald-500/60 cursor-pointer">

                                    {{-- Upload Overlay --}}
                                    <div class="absolute inset-0 bg-black/50 rounded-xl md:rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer"
                                        onclick="document.getElementById('avatarInput').click()">
                                        <div class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-6 w-6 md:h-8 md:w-8 text-white mx-auto mb-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="text-white text-xs md:text-sm font-medium">Change Photo</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Hidden File Input --}}
                                <form id="avatarForm" action="{{ route('user.profile.avatar.update') }}" method="POST"
                                    enctype="multipart/form-data" class="hidden">
                                    @csrf
                                    @method('PUT')
                                    <input type="file" name="avatar" id="avatarInput" accept="image/*"
                                        onchange="previewImage(event)">
                                </form>

                                <div class="absolute -bottom-1 -right-1 md:-bottom-2 md:-right-2 w-6 h-6 md:w-8 md:h-8 bg-emerald-500 rounded-full flex items-center justify-center border-2 border-gray-900 cursor-pointer"
                                    onclick="document.getElementById('avatarInput').click()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4 text-white"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>

                            {{-- User Info --}}
                            <h3 class="font-serif text-xl md:text-2xl font-black text-white mt-3 md:mt-4 truncate">
                                {{ $user->name }}
                            </h3>
                            <p class="text-emerald-400/80 text-xs md:text-sm mt-1 truncate">{{ $user->email }}</p>

                            {{-- Member Badge --}}
                            <div class="mt-2 md:mt-3">
                                <span
                                    class="bg-emerald-500/10 text-emerald-400 text-xs font-bold px-2 md:px-3 py-1 rounded-full border border-emerald-500/20">
                                    {{ $user->trainer_id ? 'Premium Member' : 'Basic Member' }}
                                </span>
                            </div>

                            {{-- Avatar Upload Progress --}}
                            <div id="uploadProgress" class="mt-3 md:mt-4 hidden">
                                <div class="flex items-center justify-center gap-2 md:gap-3">
                                    <div
                                        class="w-5 h-5 md:w-6 md:h-6 border-2 border-emerald-500 border-t-transparent rounded-full animate-spin">
                                    </div>
                                    <span class="text-emerald-400 text-xs md:text-sm">Uploading...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Stats --}}
                    <div
                        class="glass-dark rounded-2xl md:rounded-3xl p-4 md:p-6 border border-emerald-500/20 shadow-lg md:shadow-xl shadow-emerald-500/10 mt-4 md:mt-6">
                        <h4 class="text-base md:text-lg font-black text-white mb-3 md:mb-4 text-center">Quick Stats</h4>
                        <div class="space-y-2 md:space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-emerald-400/80 text-xs md:text-sm">Joined</span>
                                <span
                                    class="text-white font-semibold text-xs md:text-sm">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-emerald-400/80 text-xs md:text-sm">Last Updated</span>
                                <span
                                    class="text-white font-semibold text-xs md:text-sm">{{ $user->updated_at->diffForHumans() }}</span>
                            </div>
                            @if($user->trainer_id)
                                <div class="flex justify-between items-center">
                                    <span class="text-emerald-400/80 text-xs md:text-sm">Trainer</span>
                                    <span class="text-white font-semibold text-xs md:text-sm">Active</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Right Column - Profile Information --}}
                <div class="lg:col-span-2">
                    <div
                        class="glass-dark rounded-2xl md:rounded-3xl border border-emerald-500/20 shadow-lg md:shadow-xl shadow-emerald-500/10 overflow-hidden">
                        {{-- Section Header --}}
                        <div class="px-4 md:px-6 py-3 md:py-4 border-b border-emerald-500/20 bg-gray-900/50">
                            <h2 class="text-lg md:text-xl font-black text-white flex items-center gap-2 md:gap-3">
                                <span class="text-gradient">Personal Information</span>
                            </h2>
                        </div>

                        {{-- Profile Details --}}
                        <div class="p-4 md:p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                                {{-- Age --}}
                                <div
                                    class="glass rounded-lg md:rounded-xl p-3 md:p-4 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group">
                                    <div class="flex items-center justify-between">
                                        <div class="min-w-0">
                                            <p class="text-emerald-400/80 text-xs md:text-sm font-medium mb-1">Age</p>
                                            <p class="text-white text-lg md:text-xl font-bold truncate">
                                                {{ $user->age ?? 'Not set' }}
                                            </p>
                                        </div>
                                        <div
                                            class="w-8 h-8 md:w-10 md:h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300 flex-shrink-0 ml-2">
                                            <span class="text-emerald-400 text-base md:text-lg">🎂</span>
                                        </div>
                                    </div>
                                    <p class="text-emerald-400/60 text-xs mt-1 md:mt-2">Years old</p>
                                </div>

                                {{-- Gender --}}
                                <div
                                    class="glass rounded-lg md:rounded-xl p-3 md:p-4 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group">
                                    <div class="flex items-center justify-between">
                                        <div class="min-w-0">
                                            <p class="text-emerald-400/80 text-xs md:text-sm font-medium mb-1">Gender</p>
                                            <p class="text-white text-lg md:text-xl font-bold truncate">
                                                @if($user->gender == 'male')
                                                    Male
                                                @elseif($user->gender == 'female')
                                                    Female
                                                @else
                                                    Not set
                                                @endif
                                            </p>
                                        </div>
                                        <div
                                            class="w-8 h-8 md:w-10 md:h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300 flex-shrink-0 ml-2">
                                            <span class="text-emerald-400 text-base md:text-lg">
                                                @if($user->gender == 'male') 👨 @elseif($user->gender == 'female') 👩 @else
                                                ❓ @endif
                                            </span>
                                        </div>
                                    </div>
                                    <p class="text-emerald-400/60 text-xs mt-1 md:mt-2">Biological sex</p>
                                </div>

                                {{-- Height --}}
                                <div
                                    class="glass rounded-lg md:rounded-xl p-3 md:p-4 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group">
                                    <div class="flex items-center justify-between">
                                        <div class="min-w-0">
                                            <p class="text-emerald-400/80 text-xs md:text-sm font-medium mb-1">Height</p>
                                            <p class="text-white text-lg md:text-xl font-bold truncate">
                                                {{ $user->height ? $user->height . ' cm' : 'Not set' }}
                                            </p>
                                        </div>
                                        <div
                                            class="w-8 h-8 md:w-10 md:h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300 flex-shrink-0 ml-2">
                                            <span class="text-emerald-400 text-base md:text-lg">📏</span>
                                        </div>
                                    </div>
                                    <p class="text-emerald-400/60 text-xs mt-1 md:mt-2">Centimeters</p>
                                </div>

                                {{-- Weight --}}
                                <div
                                    class="glass rounded-lg md:rounded-xl p-3 md:p-4 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group">
                                    <div class="flex items-center justify-between">
                                        <div class="min-w-0">
                                            <p class="text-emerald-400/80 text-xs md:text-sm font-medium mb-1">Weight</p>
                                            <p class="text-white text-lg md:text-xl font-bold truncate">
                                                {{ $user->weight ? $user->weight . ' kg' : 'Not set' }}
                                            </p>
                                        </div>
                                        <div
                                            class="w-8 h-8 md:w-10 md:h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300 flex-shrink-0 ml-2">
                                            <span class="text-emerald-400 text-base md:text-lg">⚖️</span>
                                        </div>
                                    </div>
                                    <p class="text-emerald-400/60 text-xs mt-1 md:mt-2">Kilograms</p>
                                </div>
                            </div>

                            {{-- BMI Calculation (if height and weight are set) --}}
                            @if($user->height && $user->weight)
                                @php
                                    $heightInMeters = $user->height / 100;
                                    $bmi = $user->weight / ($heightInMeters * $heightInMeters);
                                    $bmiCategory = '';
                                    $bmiColor = 'text-emerald-400';

                                    if ($bmi < 18.5) {
                                        $bmiCategory = 'Underweight';
                                        $bmiColor = 'text-blue-400';
                                    } elseif ($bmi >= 18.5 && $bmi < 25) {
                                        $bmiCategory = 'Normal weight';
                                        $bmiColor = 'text-emerald-400';
                                    } elseif ($bmi >= 25 && $bmi < 30) {
                                        $bmiCategory = 'Overweight';
                                        $bmiColor = 'text-amber-400';
                                    } else {
                                        $bmiCategory = 'Obesity';
                                        $bmiColor = 'text-red-400';
                                    }
                                @endphp

                                <div
                                    class="mt-4 md:mt-6 glass rounded-lg md:rounded-xl p-3 md:p-4 border border-emerald-500/20 bg-emerald-500/5">
                                    <div class="flex items-center justify-between">
                                        <div class="min-w-0">
                                            <p class="text-emerald-400/80 text-xs md:text-sm font-medium mb-1">Body Mass Index
                                                (BMI)</p>
                                            <p class="text-white text-xl md:text-2xl font-bold">{{ number_format($bmi, 1) }}</p>
                                            <p class="{{ $bmiColor }} text-xs md:text-sm font-medium mt-1">{{ $bmiCategory }}
                                            </p>
                                        </div>
                                        <div class="text-right flex-shrink-0 ml-2">
                                            <div
                                                class="w-10 h-10 md:w-12 md:h-12 bg-emerald-500/10 rounded-lg md:rounded-xl flex items-center justify-center border border-emerald-500/20">
                                                <span class="text-emerald-400 text-base md:text-lg">💪</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-emerald-400/60 text-xs mt-1 md:mt-2">Based on your height and weight</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Fitness Profile Section --}}
                    @if($user->fitnessProfile)
                        <div
                            class="mt-4 md:mt-6 glass-dark rounded-2xl md:rounded-3xl border border-emerald-500/20 shadow-lg md:shadow-xl shadow-emerald-500/10 overflow-hidden">
                            <div class="px-4 md:px-6 py-3 md:py-4 border-b border-emerald-500/20 bg-gray-900/50">
                                <h2 class="text-lg md:text-xl font-black text-white flex items-center gap-2 md:gap-3">
                                    <span class="text-gradient">Fitness Profile</span>
                                </h2>
                            </div>

                            <div class="p-4 md:p-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                                    {{-- Activity Level --}}
                                    <div
                                        class="glass rounded-lg md:rounded-xl p-3 md:p-4 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group">
                                        <div class="flex items-center justify-between">
                                            <div class="min-w-0">
                                                <p class="text-emerald-400/80 text-xs md:text-sm font-medium mb-1">Activity
                                                    Level</p>
                                                <p class="text-white text-lg md:text-xl font-bold capitalize truncate">
                                                    {{ $user->fitnessProfile->activity_level ?? 'Not set' }}
                                                </p>
                                            </div>
                                            <div
                                                class="w-8 h-8 md:w-10 md:h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300 flex-shrink-0 ml-2">
                                                <span class="text-emerald-400 text-base md:text-lg">🏃‍♂️</span>
                                            </div>
                                        </div>
                                        <p class="text-emerald-400/60 text-xs mt-1 md:mt-2">Daily activity intensity</p>
                                    </div>

                                    {{-- Daily Calorie Target --}}
                                    <div
                                        class="glass rounded-lg md:rounded-xl p-3 md:p-4 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group">
                                        <div class="flex items-center justify-between">
                                            <div class="min-w-0">
                                                <p class="text-emerald-400/80 text-xs md:text-sm font-medium mb-1">Daily
                                                    Calories</p>
                                                <p class="text-white text-lg md:text-xl font-bold truncate">
                                                    {{ $user->fitnessProfile->daily_calorie_target ? $user->fitnessProfile->daily_calorie_target . ' kcal' : 'Not set' }}
                                                </p>
                                            </div>
                                            <div
                                                class="w-8 h-8 md:w-10 md:h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300 flex-shrink-0 ml-2">
                                                <span class="text-emerald-400 text-base md:text-lg">🔥</span>
                                            </div>
                                        </div>
                                        <p class="text-emerald-400/60 text-xs mt-1 md:mt-2">Daily calorie target</p>
                                    </div>

                                    {{-- Activity Description --}}
                                    <div
                                        class="glass rounded-lg md:rounded-xl p-3 md:p-4 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group sm:col-span-2">
                                        <div class="flex items-center justify-between">
                                            <div class="min-w-0 flex-1">
                                                <p class="text-emerald-400/80 text-xs md:text-sm font-medium mb-1">Activity
                                                    Description</p>
                                                <p class="text-white text-base md:text-lg font-bold line-clamp-2">
                                                    {{ $user->fitnessProfile->activity_description ?? 'Not set' }}
                                                </p>
                                            </div>
                                            <div
                                                class="w-8 h-8 md:w-10 md:h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300 flex-shrink-0 ml-2">
                                                <span class="text-emerald-400 text-base md:text-lg">📝</span>
                                            </div>
                                        </div>
                                        <p class="text-emerald-400/60 text-xs mt-1 md:mt-2">Description of daily activities</p>
                                    </div>

                                    {{-- Preferred Muscle Groups --}}
                                    @if($user->fitnessProfile->preferred_muscle_groups)
                                        <div
                                            class="glass rounded-lg md:rounded-xl p-3 md:p-4 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group sm:col-span-2">
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-emerald-400/80 text-xs md:text-sm font-medium mb-1">Preferred
                                                        Muscle Groups</p>
                                                    <div class="flex flex-wrap gap-1 md:gap-2 mt-1 md:mt-2">
                                                        @foreach(json_decode($user->fitnessProfile->preferred_muscle_groups) as $muscle)
                                                            <span
                                                                class="bg-emerald-500/10 text-emerald-400 text-xs font-bold px-2 md:px-3 py-1 rounded-full border border-emerald-500/20 truncate max-w-[120px]">
                                                                {{ ucfirst($muscle) }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div
                                                    class="w-8 h-8 md:w-10 md:h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300 flex-shrink-0 ml-2">
                                                    <span class="text-emerald-400 text-base md:text-lg">💪</span>
                                                </div>
                                            </div>
                                            <p class="text-emerald-400/60 text-xs mt-1 md:mt-2">Muscle groups to focus on</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div
                            class="mt-4 md:mt-6 glass-dark rounded-2xl md:rounded-3xl border border-amber-500/20 shadow-lg md:shadow-xl shadow-amber-500/10 overflow-hidden">
                            <div class="p-4 md:p-6 text-center">
                                <div
                                    class="w-12 h-12 md:w-16 md:h-16 bg-amber-500/10 rounded-xl md:rounded-2xl flex items-center justify-center mx-auto mb-3 md:mb-4 border border-amber-500/20">
                                    <span class="text-xl md:text-2xl">💪</span>
                                </div>
                                <h3 class="text-base md:text-lg font-black text-white mb-1 md:mb-2">Complete Your Fitness
                                    Profile</h3>
                                <p class="text-amber-400/80 text-sm md:text-base mb-3 md:mb-4">Tell us more about your fitness
                                    goals and preferences to get personalized recommendations.</p>
                                <a href="{{ route('user.profile.edit') }}"
                                    class="inline-flex items-center justify-center gap-2 px-4 md:px-6 py-2 md:py-3 rounded-lg md:rounded-xl text-xs md:text-sm font-bold text-white bg-gradient-to-r from-amber-500 to-amber-700 hover:from-amber-600 hover:to-amber-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-amber-500/25 w-full sm:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    Set Up Fitness Profile
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="mt-4 md:mt-6 flex flex-col sm:flex-row gap-3 justify-end">
                        <a href="{{ route('user.profile.password.edit') }}"
                            class="group flex items-center justify-center gap-2 px-4 md:px-6 py-2 md:py-3 rounded-lg md:rounded-xl text-xs md:text-sm font-bold text-emerald-400 hover:text-white transition-all duration-300 border border-emerald-500/30 hover:bg-emerald-500/10 w-full sm:w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Change Password
                        </a>
                        <a href="{{ route('user.profile.edit') }}"
                            class="group flex items-center justify-center gap-2 px-4 md:px-6 py-2 md:py-3 rounded-lg md:rounded-xl text-xs md:text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25 w-full sm:w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit Profile
                        </a>
                    </div>
                </div>
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

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
            }

            to {
                box-shadow: 0 0 20px rgba(16, 185, 129, 0.6), 0 0 30px rgba(16, 185, 129, 0.4);
            }
        }

        /* Responsive improvements for very small screens */
        @media (max-width: 360px) {
            .max-w-\[120px\] {
                max-width: 100px;
            }
        }
    </style>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('avatarPreview');
            const progress = document.getElementById('uploadProgress');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);

                // Show progress and submit form
                progress.classList.remove('hidden');
                document.getElementById('avatarForm').submit();
            }
        }

        // Auto-submit form when file is selected
        document.getElementById('avatarInput')?.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                document.getElementById('uploadProgress').classList.remove('hidden');
                document.getElementById('avatarForm').submit();
            }
        });

        // Show file browser when clicking on avatar
        document.getElementById('avatarPreview')?.addEventListener('click', function () {
            document.getElementById('avatarInput').click();
        });
    </script>
@endsection