@extends('layouts.user')

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
                <div class="flex items-center gap-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center">
                        <span class="text-2xl">✏️</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-white">
                            Edit <span class="text-gradient">Nutrition Menu</span>
                        </h1>
                        <p class="text-emerald-400/80 text-lg mt-2">Update your meal information</p>
                    </div>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="glass rounded-2xl p-4 mb-6 border border-emerald-500/30 bg-emerald-500/10">
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

            @if ($errors->any())
                <div class="glass rounded-2xl p-4 mb-6 border border-red-500/30 bg-red-500/10">
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
                            <p class="text-red-400 font-medium">Please check the form for errors:</p>
                            <ul class="text-red-400/80 text-sm mt-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Update Form --}}
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-6">
                <form action="{{ route('user.nutrition.update', $nutrition->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Meal Name --}}
                    <div>
                        <label class="block text-lg font-bold text-emerald-400 mb-3">Meal Name</label>
                        <input type="text" name="meal_name" value="{{ old('meal_name', $nutrition->meal_name) }}"
                            class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white placeholder-emerald-400/50 transition-all duration-300"
                            placeholder="e.g., Grilled Chicken with Brown Rice" required>
                    </div>

                    {{-- Nutrition Information --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Calories --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">Calories (kcal)</label>
                            <input type="number" step="1" name="calories"
                                value="{{ old('calories', $nutrition->calories) }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white placeholder-emerald-400/50 transition-all duration-300"
                                required>
                        </div>

                        {{-- Protein --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">Protein (g)</label>
                            <input type="number" step="0.1" name="protein" value="{{ old('protein', $nutrition->protein) }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white placeholder-emerald-400/50 transition-all duration-300"
                                required>
                        </div>

                        {{-- Carbs --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">Carbs (g)</label>
                            <input type="number" step="0.1" name="carbs" value="{{ old('carbs', $nutrition->carbs) }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white placeholder-emerald-400/50 transition-all duration-300"
                                required>
                        </div>

                        {{-- Fat --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">Fat (g)</label>
                            <input type="number" step="0.1" name="fat" value="{{ old('fat', $nutrition->fat) }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white placeholder-emerald-400/50 transition-all duration-300"
                                required>
                        </div>
                    </div>

                    {{-- Water & Hydrogen --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Water Intake --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">Water Intake (ml)</label>
                            <input type="number" step="50" name="water_intake"
                                value="{{ old('water_intake', $nutrition->water_intake) }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white placeholder-emerald-400/50 transition-all duration-300">
                            <p class="text-emerald-400/70 text-xs mt-1">Optional - track water consumption</p>
                        </div>

                        {{-- Hydrogen Level --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">Hydrogen Level (pH)</label>
                            <input type="number" step="0.1" min="0" max="14" name="hydrogen_level"
                                value="{{ old('hydrogen_level', $nutrition->hydrogen_level) }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white placeholder-emerald-400/50 transition-all duration-300">
                            <p class="text-emerald-400/70 text-xs mt-1">Optional - water pH level</p>
                        </div>
                    </div>

                    {{-- Day and Type --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Day of Week --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">Day of Week</label>
                            <select name="day_of_week"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white transition-all duration-300"
                                required>
                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                    <option value="{{ $day }}"
                                        {{ old('day_of_week', $nutrition->day_of_week) == $day ? 'selected' : '' }}>
                                        {{ $day }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Meal Type --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">Meal Type</label>
                            <select name="type"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white transition-all duration-300">
                                <option value="">Select Type</option>
                                <option value="breakfast"
                                    {{ old('type', $nutrition->type) == 'breakfast' ? 'selected' : '' }}>Breakfast</option>
                                <option value="lunch" {{ old('type', $nutrition->type) == 'lunch' ? 'selected' : '' }}>Lunch
                                </option>
                                <option value="dinner" {{ old('type', $nutrition->type) == 'dinner' ? 'selected' : '' }}>
                                    Dinner</option>
                                <option value="snack" {{ old('type', $nutrition->type) == 'snack' ? 'selected' : '' }}>Snack
                                </option>
                            </select>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-between items-center pt-6">
                        <a href="{{ route('user.nutrition.index') }}"
                            class="px-6 py-3 rounded-xl text-sm font-bold text-emerald-400 hover:text-white hover:bg-emerald-500/10 transition-all duration-300 border border-emerald-500/30 hover:border-emerald-500/50">
                            ← Back to Nutrition
                        </a>

                        <button type="submit"
                            class="px-8 py-3 rounded-xl text-base font-black text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25">
                            Update Meal
                        </button>
                    </div>
                </form>
            </div>

            {{-- Delete Form --}}
            <div class="glass-dark rounded-3xl p-8 border border-red-500/20 shadow-2xl shadow-red-500/10">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center border border-red-500/20">
                        <span class="text-xl">🗑️</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Delete This Meal</h3>
                        <p class="text-red-400/80">This action cannot be undone</p>
                    </div>
                </div>

                <form action="{{ route('user.nutrition.destroy', $nutrition->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this meal? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full px-6 py-3 rounded-xl text-sm font-bold text-white bg-red-500/10 hover:bg-red-500/20 border border-red-500/30 hover:border-red-500/50 transition-all duration-300">
                        Delete Meal Permanently
                    </button>
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
    </style>
@endsection