@extends('layouts.trainer')

@section('title', 'Edit Nutrition Plan')@section('content')<div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center animate-glow">
                            <span class="text-2xl">✏️</span>
                        </div>
                        <div>
                            <h1 class="text-3xl sm:text-4xl font-black text-white">
                                Edit <span class="text-gradient">Nutrition Plan</span>
                            </h1>
                            <p class="text-emerald-400/80 text-lg mt-2">Update nutrition plan for {{ $member->name }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('trainer.programs.nutrition.index', $member->id) }}"
                           class="group flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-gray-400 hover:text-white transition-all duration-300 border border-gray-600 hover:bg-gray-700/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Nutrition
                        </a>
                    </div>
                </div>
            </div>

            {{-- Toast Notification --}}
            @if ($errors->any())
                <div class="mb-6 glass rounded-2xl p-4 border border-red-500/20 animate-pop-in">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-red-500/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-red-400 font-medium mb-2">Please fix the following errors:</p>
                            <ul class="text-red-400/80 text-sm list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Edit Form --}}
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10">
                <form action="{{ route('trainer.programs.nutrition.update', ['memberId' => $member->id, 'planId' => $nutritionPlan->id]) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Meal Name --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-emerald-400 mb-2">
                                Meal Name <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="meal_name" value="{{ old('meal_name', $nutritionPlan->meal_name) }}" required
                                   placeholder="e.g., Chicken Breast with Brown Rice, Protein Shake"
                                   class="w-full px-4 py-3 bg-white border border-emerald-500/20 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300">
                        </div>

                        {{-- Day of Week --}}
                        <div>
                            <label class="block text-sm font-medium text-emerald-400 mb-2">
                                Day of Week <span class="text-red-400">*</span>
                            </label>
                            <select name="day_of_week" required
                                    class="w-full px-4 py-3 bg-white border border-emerald-500/20 rounded-xl text-black focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300">
                                <option value="">Select Day</option>
                                @foreach($days as $day)
                                    <option value="{{ $day }}" {{ old('day_of_week', $nutritionPlan->day_of_week) == $day ? 'selected' : '' }}>
                                        {{ $day }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Meal Type --}}
                        <div>
                            <label class="block text-sm font-medium text-emerald-400 mb-2">
                                Meal Type <span class="text-red-400">*</span>
                            </label>
                            <select name="type" required
                                    class="w-full px-4 py-3 bg-white border border-emerald-500/20 rounded-xl text-black focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300">
                                <option value="">Select Type</option>
                                @foreach($types as $type)
                                    <option value="{{ $type }}" {{ old('type', $nutritionPlan->type) == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Nutrition Information --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        {{-- Calories --}}
                        <div>
                            <label class="block text-sm font-medium text-emerald-400 mb-2">
                                Calories <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="calories" value="{{ old('calories', $nutritionPlan->calories) }}" required min="0"
                                       placeholder="0"
                                       class="w-full px-4 py-3 bg-white border border-emerald-500/20 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300">
                                <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">kcal</span>
                            </div>
                        </div>

                        {{-- Protein --}}
                        <div>
                            <label class="block text-sm font-medium text-emerald-400 mb-2">
                                Protein <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="protein" value="{{ old('protein', $nutritionPlan->protein) }}" required min="0" step="0.1"
                                       placeholder="0.0"
                                       class="w-full px-4 py-3 bg-white border border-emerald-500/20 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300">
                                <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">g</span>
                            </div>
                        </div>

                        {{-- Carbs --}}
                        <div>
                            <label class="block text-sm font-medium text-emerald-400 mb-2">
                                Carbohydrates <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="carbs" value="{{ old('carbs', $nutritionPlan->carbs) }}" required min="0" step="0.1"
                                       placeholder="0.0"
                                       class="w-full px-4 py-3 bg-white border border-emerald-500/20 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300">
                                <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">g</span>
                            </div>
                        </div>

                        {{-- Fat --}}
                        <div>
                            <label class="block text-sm font-medium text-emerald-400 mb-2">
                                Fat <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="fat" value="{{ old('fat', $nutritionPlan->fat) }}" required min="0" step="0.1"
                                       placeholder="0.0"
                                       class="w-full px-4 py-3 bg-white border border-emerald-500/20 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300">
                                <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">g</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Water Intake --}}
                        <div>
                            <label class="block text-sm font-medium text-emerald-400 mb-2">
                                Water Intake (Optional)
                            </label>
                            <div class="relative">
                                <input type="number" name="water_intake" value="{{ old('water_intake', $nutritionPlan->water_intake) }}" min="0" step="0.1"
                                       placeholder="0.0"
                                       class="w-full px-4 py-3 bg-white border border-emerald-500/20 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300">
                                <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">L</span>
                            </div>
                        </div>

                        {{-- Hydrogen Level --}}
                        <div>
                            <label class="block text-sm font-medium text-emerald-400 mb-2">
                                Hydrogen Level (Optional)
                            </label>
                            <div class="relative">
                                <input type="number" name="hydrogen_level" value="{{ old('hydrogen_level', $nutritionPlan->hydrogen_level) }}" min="0" step="0.1"
                                       placeholder="0.0"
                                       class="w-full px-4 py-3 bg-white border border-emerald-500/20 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300">
                                <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">pH</span>
                            </div>
                        </div>
                    </div>

                    {{-- Target Fitness --}}
                    <div>
                        <label class="block text-sm font-medium text-emerald-400 mb-2">
                            Target Fitness Goal
                        </label>
                        <select name="target_fitness"
                                class="w-full px-4 py-3 bg-white border border-emerald-500/20 rounded-xl text-black focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300">
                            <option value="">Select Fitness Goal (Optional)</option>
                            @foreach($targetFitnessOptions as $option)
                                <option value="{{ $option }}" {{ old('target_fitness', $nutritionPlan->target_fitness) == $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-emerald-500/20">
                        <button type="submit"
                                class="flex-1 flex items-center justify-center gap-2 px-6 py-4 rounded-xl text-base font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Update Nutrition Plan
                        </button>
                        <a href="{{ route('trainer.programs.nutrition.index', $member->id) }}"
                           class="flex-1 flex items-center justify-center gap-2 px-6 py-4 rounded-xl text-base font-bold text-gray-400 hover:text-white transition-all duration-300 border border-gray-600 hover:bg-gray-700/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </a>
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

        .glass-dark {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .animate-glow {
            animation: glow 2s ease-in-out infinite alternate;
        }

        .animate-pop-in {
            animation: popIn 0.3s ease-out forwards;
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
            }
            to {
                box-shadow: 0 0 20px rgba(16, 185, 129, 0.6), 0 0 30px rgba(16, 185, 129, 0.4);
            }
        }

        @keyframes popIn {
            0% { transform: scale(0.95); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
@endsection