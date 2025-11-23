@extends('layouts.trainer')

@section('title', 'Nutrition Analysis')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center animate-glow">
                        <span class="text-2xl">📊</span>
                    </div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-white">
                            Nutrition <span class="text-gradient">Analysis</span>
                        </h1>
                        <p class="text-emerald-400/80 text-lg mt-2">Detailed analysis for {{ $member->name }}</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('trainer.nutrition.index', $member->id) }}"
                       class="group flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-gray-400 hover:text-white transition-all duration-300 border border-gray-600 hover:bg-gray-700/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Nutrition Plans
                    </a>
                </div>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="glass-dark rounded-2xl p-6 border border-emerald-500/20 shadow-lg shadow-emerald-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-400/80 text-sm font-medium">Total Calories</p>
                        <p class="text-3xl font-black text-white mt-2">{{ number_format($totalCalories) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center">
                        <span class="text-xl">🔥</span>
                    </div>
                </div>
            </div>

            <div class="glass-dark rounded-2xl p-6 border border-blue-500/20 shadow-lg shadow-blue-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-400/80 text-sm font-medium">Average Calories</p>
                        <p class="text-3xl font-black text-white mt-2">{{ number_format($averageCalories) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                        <span class="text-xl">⚖️</span>
                    </div>
                </div>
            </div>

            <div class="glass-dark rounded-2xl p-6 border border-purple-500/20 shadow-lg shadow-purple-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-400/80 text-sm font-medium">Total Plans</p>
                        <p class="text-3xl font-black text-white mt-2">{{ $mealCount }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center">
                        <span class="text-xl">📋</span>
                    </div>
                </div>
            </div>

            <div class="glass-dark rounded-2xl p-6 border border-amber-500/20 shadow-lg shadow-amber-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-400/80 text-sm font-medium">Supplements</p>
                        <p class="text-3xl font-black text-white mt-2">{{ $supplementCount }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-500/20 rounded-xl flex items-center justify-center">
                        <span class="text-xl">💊</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            {{-- Macronutrient Distribution --}}
            <div class="glass-dark rounded-3xl p-6 border border-blue-500/20 shadow-xl shadow-blue-500/10">
                <h2 class="text-2xl font-black text-white mb-6 flex items-center gap-3">
                    <span class="text-blue-400">🥗 Macronutrient Distribution</span>
                </h2>

                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-white font-medium">Protein</span>
                            <span class="text-blue-400 font-bold">{{ $totalProtein }}g ({{ $macroDistribution['protein'] }}%)</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-3">
                            <div class="bg-blue-500 h-3 rounded-full" style="width: {{ $macroDistribution['protein'] }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-white font-medium">Carbohydrates</span>
                            <span class="text-green-400 font-bold">{{ $totalCarbs }}g ({{ $macroDistribution['carbs'] }}%)</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-3">
                            <div class="bg-green-500 h-3 rounded-full" style="width: {{ $macroDistribution['carbs'] }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-white font-medium">Fat</span>
                            <span class="text-amber-400 font-bold">{{ $totalFat }}g ({{ $macroDistribution['fat'] }}%)</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-3">
                            <div class="bg-amber-500 h-3 rounded-full" style="width: {{ $macroDistribution['fat'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Calories by Day --}}
            <div class="glass-dark rounded-3xl p-6 border border-purple-500/20 shadow-xl shadow-purple-500/10">
                <h2 class="text-2xl font-black text-white mb-6 flex items-center gap-3">
                    <span class="text-purple-400">📅 Calories by Day</span>
                </h2>

                <div class="space-y-4">
                    @php
                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                        $maxCalories = $caloriesByDay->max() ?: 1;
                    @endphp
                    @foreach($days as $day)
                        @php
                            $calories = $caloriesByDay[$day] ?? 0;
                            $percentage = ($calories / $maxCalories) * 100;
                        @endphp
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-white font-medium">
                                    @if($day == 'Monday') Senin
                                    @elseif($day == 'Tuesday') Selasa
                                    @elseif($day == 'Wednesday') Rabu
                                    @elseif($day == 'Thursday') Kamis
                                    @elseif($day == 'Friday') Jumat
                                    @elseif($day == 'Saturday') Sabtu
                                    @elseif($day == 'Sunday') Minggu
                                    @else {{ $day }}
                                    @endif
                                </span>
                                <span class="text-purple-400 font-bold">{{ number_format($calories) }} cal</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-3">
                                <div class="bg-purple-500 h-3 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Recent Nutrition Plans --}}
        <div class="glass-dark rounded-3xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10">
            <h2 class="text-2xl font-black text-white mb-6 flex items-center gap-3">
                <span class="text-emerald-400">📋 Nutrition Plans Overview</span>
            </h2>

            @if($nutritionPlans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-emerald-500/20">
                                <th class="text-left py-3 px-4 text-emerald-400 font-semibold">Meal Name</th>
                                <th class="text-left py-3 px-4 text-emerald-400 font-semibold">Day</th>
                                <th class="text-left py-3 px-4 text-emerald-400 font-semibold">Type</th>
                                <th class="text-left py-3 px-4 text-emerald-400 font-semibold">Calories</th>
                                <th class="text-left py-3 px-4 text-emerald-400 font-semibold">Protein</th>
                                <th class="text-left py-3 px-4 text-emerald-400 font-semibold">Carbs</th>
                                <th class="text-left py-3 px-4 text-emerald-400 font-semibold">Fat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nutritionPlans->take(10) as $plan)
                                <tr class="border-b border-emerald-500/10 hover:bg-emerald-500/5 transition-colors duration-200">
                                    <td class="py-3 px-4 text-white">{{ $plan->meal_name }}</td>
                                    <td class="py-3 px-4 text-gray-300">
                                        @if($plan->day_of_week == 'Monday') Senin
                                        @elseif($plan->day_of_week == 'Tuesday') Selasa
                                        @elseif($plan->day_of_week == 'Wednesday') Rabu
                                        @elseif($plan->day_of_week == 'Thursday') Kamis
                                        @elseif($plan->day_of_week == 'Friday') Jumat
                                        @elseif($plan->day_of_week == 'Saturday') Sabtu
                                        @elseif($plan->day_of_week == 'Sunday') Minggu
                                        @else {{ $plan->day_of_week }}
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-gray-300 capitalize">{{ $plan->type }}</td>
                                    <td class="py-3 px-4 text-emerald-400 font-semibold">{{ $plan->calories }}</td>
                                    <td class="py-3 px-4 text-blue-400">{{ $plan->protein }}g</td>
                                    <td class="py-3 px-4 text-green-400">{{ $plan->carbs }}g</td>
                                    <td class="py-3 px-4 text-amber-400">{{ $plan->fat }}g</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                        <span class="text-2xl">📝</span>
                    </div>
                    <p class="text-emerald-400/70">No nutrition plans created yet.</p>
                </div>
            @endif
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
