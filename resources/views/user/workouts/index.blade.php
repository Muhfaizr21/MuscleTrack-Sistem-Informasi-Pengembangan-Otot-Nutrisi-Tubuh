@extends('layouts.user')

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center animate-glow">
                            <span class="text-2xl">🏋️</span>
                        </div>
                        <div>
                            <h1 class="text-3xl sm:text-4xl font-black text-white">
                                My <span class="text-gradient">Workout Plans</span>
                            </h1>
                            <p class="text-emerald-400/80 text-lg mt-2">Personalized training programs tailored for your fitness journey</p>
                        </div>
                    </div>
                    <a href="{{ route('user.workouts.create') }}"
                        class="group relative px-8 py-4 rounded-2xl text-base font-black text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25 flex items-center gap-3">
                        <span class="text-xl">+</span>
                        Add New Workout
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- 🧮 Info BMI --}}
            @if(isset($bmi) && $bmi)
                <div class="glass-dark rounded-3xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10 mb-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-4 mb-3">
                                <p class="text-lg font-semibold text-white">
                                    <span class="font-bold">Your BMI:</span> {{ number_format($bmi, 1) }}
                                    (<span class="capitalize font-medium text-emerald-400">{{ $bmiCategory }}</span>)
                                </p>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                    {{ strtoupper($bmiCategory) }}
                                </span>
                            </div>
                            <p class="text-emerald-400/80 text-sm mb-4">
                                Workout recommendations below are customized for your body condition
                            </p>

                            <div class="space-y-3">
                                @switch($bmiCategory)
                                    @case('underweight')
                                        <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                                            <div class="w-6 h-6 bg-emerald-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                                <span class="text-emerald-400 text-sm">•</span>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium">Focus on compound exercises</p>
                                                <p class="text-emerald-400/70 text-sm">Bench press, squat, deadlift to build muscle mass</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                                            <div class="w-6 h-6 bg-emerald-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                                <span class="text-emerald-400 text-sm">•</span>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium">Combine with calorie surplus & high protein</p>
                                                <p class="text-emerald-400/70 text-sm">Minimum 1.6g/kg body weight protein intake</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                                            <div class="w-6 h-6 bg-emerald-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                                <span class="text-emerald-400 text-sm">•</span>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium">Prioritize sleep for optimal recovery</p>
                                                <p class="text-emerald-400/70 text-sm">7-9 hours of quality sleep nightly</p>
                                            </div>
                                        </div>
                                        @break

                                    @case('normal')
                                        <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                                            <div class="w-6 h-6 bg-emerald-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                                <span class="text-emerald-400 text-sm">•</span>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium">Maintain balanced training pattern</p>
                                                <p class="text-emerald-400/70 text-sm">3-4x/week full-body or upper/lower split</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                                            <div class="w-6 h-6 bg-emerald-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                                <span class="text-emerald-400 text-sm">•</span>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium">Ensure adequate protein & hydration</p>
                                                <p class="text-emerald-400/70 text-sm">Proper nutrition for sustained performance</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                                            <div class="w-6 h-6 bg-emerald-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                                <span class="text-emerald-400 text-sm">•</span>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium">Use progressive overload</p>
                                                <p class="text-emerald-400/70 text-sm">Gradually increase intensity for continuous improvement</p>
                                            </div>
                                        </div>
                                        @break

                                    @case('overweight')
                                        <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                                            <div class="w-6 h-6 bg-emerald-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                                <span class="text-emerald-400 text-sm">•</span>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium">Focus on HIIT and circuit training</p>
                                                <p class="text-emerald-400/70 text-sm">Full-body movements for calorie burning</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                                            <div class="w-6 h-6 bg-emerald-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                                <span class="text-emerald-400 text-sm">•</span>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium">Combine with mild calorie deficit</p>
                                                <p class="text-emerald-400/70 text-sm">High fiber intake for satiety</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                                            <div class="w-6 h-6 bg-emerald-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                                <span class="text-emerald-400 text-sm">•</span>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium">Maintain workout consistency</p>
                                                <p class="text-emerald-400/70 text-sm">4-5 times per week minimum</p>
                                            </div>
                                        </div>
                                        @break

                                    @case('obese')
                                        <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                                            <div class="w-6 h-6 bg-emerald-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                                <span class="text-emerald-400 text-sm">•</span>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium">Start with low-impact exercises</p>
                                                <p class="text-emerald-400/70 text-sm">Brisk walking, stationary bike, or swimming</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                                            <div class="w-6 h-6 bg-emerald-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                                <span class="text-emerald-400 text-sm">•</span>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium">Focus on consistency & balanced nutrition</p>
                                                <p class="text-emerald-400/70 text-sm">Low saturated fat intake</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                                            <div class="w-6 h-6 bg-emerald-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                                <span class="text-emerald-400 text-sm">•</span>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium">Regular progress evaluation</p>
                                                <p class="text-emerald-400/70 text-sm">Bi-weekly assessment with trainer or system</p>
                                            </div>
                                        </div>
                                        @break

                                    @default
                                        <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                                            <div class="w-6 h-6 bg-emerald-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                                <span class="text-emerald-400 text-sm">•</span>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium">No BMI data available</p>
                                                <p class="text-emerald-400/70 text-sm">Please update your weight and height in your profile</p>
                                            </div>
                                        </div>
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ✅ Notifikasi Sukses --}}
            @if(session('success'))
                <div class="glass rounded-2xl p-4 mb-6 border border-emerald-500/30 bg-emerald-500/10">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-emerald-400 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Workout Plans --}}
            @if($workouts->count() > 0)
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    @foreach($workouts as $workout)
                        @php
                            $sourceLabel = 'Sistem Otomatis';
                            $sourceClass = 'text-emerald-400';
                            if ($workout->recommended_by === 'trainer' && $workout->trainer_id) {
                                $trainerName = $workout->trainer->name ?? 'Trainer Tidak Dikenal';
                                $sourceLabel = 'Trainer: ' . $trainerName;
                                $sourceClass = 'text-blue-400';
                            } elseif (in_array($workout->recommended_by, ['admin', 'system']) || $workout->recommended_by === null) {
                                $sourceLabel = 'Admin / Sistem';
                                $sourceClass = 'text-emerald-400';
                            }
                            $userSchedule = $schedules->firstWhere('workout_plan_id', $workout->id);
                        @endphp

                        <div class="glass rounded-2xl p-6 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group hover-glow">
                            {{-- Judul & Status --}}
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-black text-white group-hover:text-emerald-100 transition-colors">{{ $workout->title }}</h3>
                                    <div class="flex items-center gap-3 mt-2">
                                        <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            {{ ucfirst($workout->difficulty_level ?? 'beginner') }}
                                        </span>
                                        <span class="flex items-center gap-1 text-xs text-emerald-400/80">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $workout->duration_minutes ?? 30 }} menit
                                        </span>
                                    </div>
                                </div>
                                <span class="bg-gradient-to-r from-emerald-600/20 to-emerald-600/20 text-emerald-400 text-xs font-bold px-3 py-1.5 rounded-full border border-emerald-500/20">
                                    {{ ucfirst($workout->status ?? 'active') }}
                                </span>
                            </div>

                            {{-- Deskripsi --}}
                            <p class="text-emerald-400/80 text-sm leading-relaxed mb-4">
                                {{ $workout->description ?? 'Personal training guide from system or trainer.' }}
                            </p>

                            {{-- Info Pembuat --}}
                            <div class="flex items-center gap-2 text-xs mb-5">
                                <div class="bg-emerald-500/10 p-1.5 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 {{ $sourceClass }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                    </svg>
                                </div>
                                <span class="{{ $sourceClass }}">Created by <span class="font-semibold">{{ $sourceLabel }}</span></span>
                            </div>

                            {{-- Jadwal Workout User --}}
                            <div class="glass-dark rounded-xl p-4 border border-emerald-500/20 mb-4">
                                @if($userSchedule)
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div>
                                            <div class="flex items-center gap-2 text-sm text-emerald-400 mb-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="font-bold text-white">
                                                    {{ \Carbon\Carbon::parse($userSchedule->scheduled_date)->translatedFormat('l, d F Y') }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs text-emerald-400/80">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($userSchedule->scheduled_time)->format('H:i') }}
                                                <span class="ml-2">Status: 
                                                    <span class="font-bold text-emerald-400">
                                                        {{ ucfirst($userSchedule->status ?? 'pending') }}
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex gap-3">
                                            <a href="{{ route('user.workouts.edit', $userSchedule->id) }}"
                                               class="text-emerald-400 text-sm font-bold hover:text-white transition-colors flex items-center gap-1 px-3 py-1.5 rounded-lg bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/20 hover:border-emerald-500/30">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                                Edit
                                            </a>

                                            <form action="{{ route('user.workouts.destroy', $userSchedule->id) }}" method="POST"
                                                  onsubmit="return confirm('Delete this workout schedule?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 text-sm font-bold hover:text-red-300 transition-colors flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 hover:border-red-500/30">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div class="text-sm text-emerald-400/80 italic">No workout schedule yet.</div>
                                        <a href="{{ route('user.workouts.create', ['workout_id' => $workout->id]) }}"
                                           class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-bold hover:from-emerald-600 hover:to-emerald-800 transition-all shadow-md shadow-emerald-500/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                            Set Schedule
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- Tombol Lihat Detail --}}
                            <div class="flex justify-end">
                                <a href="{{ route('user.workouts.show', $workout->id) }}"
                                   class="inline-flex items-center gap-2 text-sm font-bold text-emerald-400 hover:text-white transition-colors group">
                                    View Details
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <div
                        class="w-24 h-24 bg-emerald-500/10 rounded-3xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                        <span class="text-4xl">💪</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">No Workout Plans Yet</h3>
                    <p class="text-emerald-400/80 mb-6">Trainer or system will add workouts according to your condition</p>
                    <a href="{{ route('user.workouts.create') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300">
                        <span>Create Your First Workout</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </a>
                </div>
            @endif
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

        .hover-glow:hover {
            box-shadow: 0 0 25px rgba(16, 185, 129, 0.4);
            transition: all 0.3s ease;
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