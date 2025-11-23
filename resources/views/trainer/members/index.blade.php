@extends('layouts.trainer')

@section('title', 'Daftar Member')

@section('content')
    <div class="min-h-screen py-4 md:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">

            {{-- Header Section --}}
            <div
                class="glass-dark rounded-2xl md:rounded-3xl p-4 md:p-8 border border-emerald-500/20 shadow-lg md:shadow-2xl shadow-emerald-500/10 mb-6 md:mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-start gap-4 md:gap-6">
                    <div class="flex items-center gap-3 md:gap-4">
                        <div
                            class="w-10 h-10 md:w-14 md:h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl md:rounded-2xl flex items-center justify-center animate-glow">
                            <span class="text-xl md:text-2xl">👥</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-white leading-tight">
                                My <span class="text-gradient">Members</span>
                            </h1>
                            <p class="text-emerald-400/80 text-sm md:text-lg mt-1 md:mt-2">Manage and track your members'
                                progress in real-time</p>
                        </div>
                    </div>
                    <div class="text-left lg:text-right w-full lg:w-auto mt-4 lg:mt-0">
                        <div class="text-emerald-400 font-bold text-xs md:text-sm uppercase tracking-wider mb-1 md:mb-2">
                            Live Status</div>
                        <p class="text-white font-semibold text-sm md:text-base">
                            <span
                                id="active-count">{{ $members->where('real_time_status.is_active', true)->count() }}</span>
                            active /
                            <span id="total-count">{{ $members->count() }}</span> total
                        </p>
                    </div>
                </div>
            </div>

            {{-- Real-time Status Section --}}
            <div
                class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/30 bg-gradient-to-r from-emerald-500/10 to-emerald-600/5 mb-6 md:mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3 md:gap-4">
                        <div
                            class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl md:rounded-2xl flex items-center justify-center flex-shrink-0">
                            <span class="text-white text-lg md:text-xl">🔄</span>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-lg md:text-xl font-black text-white truncate">Real-time Member Monitoring</h3>
                            <p class="text-emerald-400 text-sm md:text-base">Live updates on member status and subscription
                                periods</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2 md:gap-3 w-full sm:w-auto">
                        <form action="{{ route('trainer.members.check-status') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 md:px-6 py-2 md:py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-lg md:rounded-xl transition-all duration-300 hover-glow text-sm md:text-base text-center">
                                🔍 Check All Status
                            </button>
                        </form>
                        <div class="flex items-center gap-2 text-emerald-400 text-sm">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span id="last-update-time">Updated: {{ now()->format('H:i:s') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notifications --}}
            @if(session('success'))
                <div
                    class="glass-dark rounded-xl md:rounded-2xl p-4 md:p-6 border border-green-500/30 bg-green-500/10 mb-6 md:mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center">
                            <span class="text-green-400">✓</span>
                        </div>
                        <p class="text-green-400 text-sm md:text-base">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div
                    class="glass-dark rounded-xl md:rounded-2xl p-4 md:p-6 border border-red-500/30 bg-red-500/10 mb-6 md:mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-red-500/20 rounded-lg flex items-center justify-center">
                            <span class="text-red-400">⚠</span>
                        </div>
                        <p class="text-red-400 text-sm md:text-base">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div
                    class="glass-dark rounded-xl md:rounded-2xl p-4 md:p-6 border border-blue-500/30 bg-blue-500/10 mb-6 md:mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <span class="text-blue-400">ℹ</span>
                        </div>
                        <p class="text-blue-400 text-sm md:text-base">{{ session('info') }}</p>
                    </div>
                </div>
            @endif

            {{-- 🌐 Members Grid --}}
            @if($members->isEmpty())
                <div class="glass-dark rounded-2xl md:rounded-3xl p-6 md:p-12 text-center border border-emerald-500/20">
                    <div
                        class="w-16 h-16 md:w-24 md:h-24 bg-emerald-500/10 rounded-2xl md:rounded-3xl flex items-center justify-center mx-auto mb-4 md:mb-6 border border-emerald-500/20">
                        <span class="text-2xl md:text-4xl">👥</span>
                    </div>
                    <h3 class="text-xl md:text-2xl font-black text-white mb-2 md:mb-3">No Members Yet</h3>
                    <p class="text-emerald-400/80 text-sm md:text-lg mb-4 md:mb-6 max-w-md mx-auto">
                        You don't have any members under your guidance yet. Members will appear here once they subscribe to your
                        training program.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('trainer.profile.edit') }}"
                            class="inline-flex items-center justify-center gap-2 px-4 md:px-6 py-2 md:py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-lg md:rounded-xl transition-all duration-300 hover-glow text-sm md:text-base">
                            ✨ Improve Your Profile
                        </a>
                        <a href="{{ route('trainer.communication.chat.index') }}"
                            class="inline-flex items-center justify-center gap-2 px-4 md:px-6 py-2 md:py-3 bg-dark-700 hover:bg-dark-600 text-white font-semibold rounded-lg md:rounded-xl border border-emerald-500/30 hover:border-emerald-400 transition-all duration-300 text-sm md:text-base">
                            💬 Check Messages
                        </a>
                    </div>
                </div>
            @else
                {{-- Stats Overview --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3 md:gap-4 mb-6 md:mb-8">
                    <div class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-emerald-500/20 text-center">
                        <div class="text-2xl md:text-3xl font-black text-white mb-1">{{ $members->count() }}</div>
                        <div class="text-emerald-400 text-xs md:text-sm font-medium">Total Members</div>
                    </div>
                    <div class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-green-500/20 text-center">
                        <div class="text-2xl md:text-3xl font-black text-white mb-1">
                            {{ $members->where('real_time_status.is_active', true)->count() }}</div>
                        <div class="text-green-400 text-xs md:text-sm font-medium">Active</div>
                    </div>
                    <div class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-yellow-500/20 text-center">
                        <div class="text-2xl md:text-3xl font-black text-white mb-1">
                            {{ $members->where('real_time_status.status', 'expiring_soon')->count() }}</div>
                        <div class="text-yellow-400 text-xs md:text-sm font-medium">Expiring Soon</div>
                    </div>
                    <div class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-red-500/20 text-center">
                        <div class="text-2xl md:text-3xl font-black text-white mb-1">
                            {{ $members->where('real_time_status.is_expired', true)->count() }}</div>
                        <div class="text-red-400 text-xs md:text-sm font-medium">Expired</div>
                    </div>
                </div>

                {{-- Members Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
                    @foreach($members as $member)
                        @php
                            $premiumAccess = $member->latest_premium_access;
                            $realTimeStatus = $member->real_time_status;
                        @endphp

                        <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border
                                    @if($realTimeStatus['color'] === 'green') border-emerald-500/20 hover:border-emerald-500/40
                                    @elseif($realTimeStatus['color'] === 'yellow') border-yellow-500/20 hover:border-yellow-500/40
                                    @else border-red-500/20 hover:border-red-500/40 @endif
                                    transition-all duration-300 group hover-glow relative">

                            {{-- Status Badge --}}
                            <div class="absolute -top-2 -right-2">
                                <span class="status-badge px-2 py-1 text-xs font-medium rounded-full border
                                            @if($realTimeStatus['color'] === 'green') bg-green-500/20 text-green-400 border-green-500/30
                                            @elseif($realTimeStatus['color'] === 'yellow') bg-yellow-500/20 text-yellow-400 border-yellow-500/30
                                            @else bg-red-500/20 text-red-400 border-red-500/30 @endif"
                                    data-member-id="{{ $member->id }}">
                                    {{ $realTimeStatus['label'] }}
                                </span>
                            </div>

                            {{-- Member Header --}}
                            <div class="flex items-center gap-3 md:gap-4 mb-3 md:mb-4">
                                @if($member->avatar)
                                    <img src="{{ asset($member->avatar) }}" alt="{{ $member->name }}" class="w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl object-cover border-2
                                                        @if($realTimeStatus['color'] === 'green') border-emerald-500/30 group-hover:border-emerald-500/50
                                                        @elseif($realTimeStatus['color'] === 'yellow') border-yellow-500/30 group-hover:border-yellow-500/50
                                                        @else border-red-500/30 group-hover:border-red-500/50 @endif
                                                        transition-all duration-300 flex-shrink-0">
                                @else
                                    <div
                                        class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br
                                                    @if($realTimeStatus['color'] === 'green') from-emerald-500 to-emerald-700
                                                    @elseif($realTimeStatus['color'] === 'yellow') from-yellow-500 to-yellow-700
                                                    @else from-red-500 to-red-700 @endif
                                                    rounded-xl md:rounded-2xl flex items-center justify-center text-white text-lg md:text-xl font-bold flex-shrink-0">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-white font-bold text-base md:text-lg truncate">{{ $member->name }}</h3>
                                    <p class="text-gray-400 text-xs md:text-sm truncate">{{ $member->email }}</p>
                                    <div class="flex items-center gap-1 mt-1">
                                        <span class="text-emerald-400 text-xs">📊</span>
                                        <span class="text-gray-400 text-xs">{{ $member->progress_logs_count }} logs</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Subscription Info --}}
                            <div class="space-y-2 md:space-y-3 mb-3 md:mb-4">
                                @if($premiumAccess)
                                    <div class="flex items-center justify-between text-xs md:text-sm">
                                        <span class="text-gray-400">Joined:</span>
                                        <span
                                            class="text-white font-medium">{{ \Carbon\Carbon::parse($premiumAccess->start_date)->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs md:text-sm">
                                        <span class="text-gray-400">Expires:</span>
                                        <span
                                            class="text-white font-medium">{{ \Carbon\Carbon::parse($premiumAccess->end_date)->format('d M Y') }}</span>
                                    </div>
                                @else
                                    <div class="text-center py-2">
                                        <span class="text-red-400 text-xs">No active subscription</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Countdown Timer --}}
                            @if($premiumAccess && !$realTimeStatus['is_expired'])
                                <div class="countdown-timer bg-dark-800/50 rounded-lg md:rounded-xl p-2 md:p-3 border
                                                @if($realTimeStatus['color'] === 'green') border-emerald-500/20
                                                @elseif($realTimeStatus['color'] === 'yellow') border-yellow-500/20
                                                @else border-red-500/20 @endif
                                                mb-3 md:mb-4" data-end-date="{{ $premiumAccess->end_date }}"
                                    data-member-id="{{ $member->id }}">
                                    <div class="text-center">
                                        <div class="text-white font-mono text-sm md:text-base mb-1">
                                            <span class="countdown-days">{{ $realTimeStatus['days_remaining'] }}</span>d
                                            <span class="countdown-hours">{{ $realTimeStatus['hours_remaining'] }}</span>h
                                            <span class="countdown-minutes">{{ $realTimeStatus['minutes_remaining'] }}</span>m
                                        </div>
                                        <div class="text-gray-400 text-xs">remaining</div>
                                    </div>
                                </div>
                            @endif

                            {{-- Action Buttons --}}
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('trainer.members.show', $member->id) }}"
                                    class="flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white text-center py-2 px-3 md:px-4 rounded-lg md:rounded-xl font-semibold transition-all duration-300 hover-glow text-xs md:text-sm">
                                    <span>👁️</span>
                                    View Details
                                </a>
                                @if($realTimeStatus['is_expired'])
                                    <form action="{{ route('trainer.members.remove', $member->id) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full flex items-center justify-center gap-2 bg-red-500/20 hover:bg-red-500/30 border border-red-500/30 hover:border-red-400 text-red-400 hover:text-red-300 py-2 px-3 md:px-4 rounded-lg md:rounded-xl font-semibold transition-all duration-300 text-xs md:text-sm"
                                            onclick="return confirm('Remove {{ $member->name }} from your member list?')">
                                            <span>🗑️</span>
                                            Remove
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Summary Section --}}
                <div class="glass-dark rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/20 mb-6 md:mb-8">
                    <h3 class="text-lg md:text-xl font-black text-white mb-3 md:mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
                        <a href="{{ route('trainer.communication.chat.index') }}"
                            class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-emerald-500/20 hover:border-emerald-500/40 transition-all duration-300 hover-glow text-center group">
                            <div
                                class="w-8 h-8 md:w-10 md:h-10 bg-emerald-500/20 rounded-lg md:rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform duration-300">
                                <span class="text-emerald-400 text-lg">💬</span>
                            </div>
                            <div class="text-white font-semibold text-sm md:text-base">Chat</div>
                            <div class="text-emerald-400 text-xs">Message Members</div>
                        </a>

                        <a href="{{ route('trainer.programs.index') }}"
                            class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-blue-500/20 hover:border-blue-500/40 transition-all duration-300 hover-glow text-center group">
                            <div
                                class="w-8 h-8 md:w-10 md:h-10 bg-blue-500/20 rounded-lg md:rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform duration-300">
                                <span class="text-blue-400 text-lg">📋</span>
                            </div>
                            <div class="text-white font-semibold text-sm md:text-base">Programs</div>
                            <div class="text-blue-400 text-xs">Manage Plans</div>
                        </a>

                        <a href="{{ route('trainer.programs.index', ['memberId' => $members->first()->id ?? 0]) }}"
                            class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-purple-500/20 hover:border-purple-500/40 transition-all duration-300 hover-glow text-center group">
                            <div
                                class="w-8 h-8 md:w-10 md:h-10 bg-purple-500/20 rounded-lg md:rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform duration-300">
                                <span class="text-purple-400 text-lg">🍎</span>
                            </div>
                            <div class="text-white font-semibold text-sm md:text-base">Nutrition</div>
                            <div class="text-purple-400 text-xs">Meal Plans</div>
                        </a>

                        <a href="{{ route('trainer.quality.feedback.index') }}"
                            class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-yellow-500/20 hover:border-yellow-500/40 transition-all duration-300 hover-glow text-center group">
                            <div
                                class="w-8 h-8 md:w-10 md:h-10 bg-yellow-500/20 rounded-lg md:rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform duration-300">
                                <span class="text-yellow-400 text-lg">⭐</span>
                            </div>
                            <div class="text-white font-semibold text-sm md:text-base">Feedback</div>
                            <div class="text-yellow-400 text-xs">View Ratings</div>
                        </a>
                    </div>
                </div>
            @endif

            {{-- Features Section --}}
            <div class="glass-dark rounded-xl md:rounded-2xl p-6 md:p-8 border border-emerald-500/20">
                <h2 class="text-2xl md:text-3xl font-black text-white text-center mb-6 md:mb-8">Member Management Features
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                    <div class="text-center">
                        <div
                            class="w-12 h-12 md:w-16 md:h-16 bg-emerald-500/10 rounded-xl md:rounded-2xl flex items-center justify-center mx-auto mb-3 md:mb-4 border border-emerald-500/20">
                            <span class="text-xl md:text-2xl">📊</span>
                        </div>
                        <h3 class="text-lg md:text-xl font-black text-white mb-1 md:mb-2">Progress Tracking</h3>
                        <p class="text-gray-400 text-sm md:text-base">Monitor member progress with detailed analytics and
                            real-time updates on their fitness journey.</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-12 h-12 md:w-16 md:h-16 bg-emerald-500/10 rounded-xl md:rounded-2xl flex items-center justify-center mx-auto mb-3 md:mb-4 border border-emerald-500/20">
                            <span class="text-xl md:text-2xl">💬</span>
                        </div>
                        <h3 class="text-lg md:text-xl font-black text-white mb-1 md:mb-2">Direct Communication</h3>
                        <p class="text-gray-400 text-sm md:text-base">Chat directly with members, provide instant feedback,
                            and keep them motivated throughout their program.</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-12 h-12 md:w-16 md:h-16 bg-emerald-500/10 rounded-xl md:rounded-2xl flex items-center justify-center mx-auto mb-3 md:mb-4 border border-emerald-500/20">
                            <span class="text-xl md:text-2xl">🔄</span>
                        </div>
                        <h3 class="text-lg md:text-xl font-black text-white mb-1 md:mb-2">Auto Management</h3>
                        <p class="text-gray-400 text-sm md:text-base">Automatic status updates and expiration tracking to
                            keep your member list organized and up-to-date.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Function to update countdown timers
            function updateCountdownTimers() {
                const timers = document.querySelectorAll('.countdown-timer');

                timers.forEach(timer => {
                    const endDate = new Date(timer.dataset.endDate + 'T23:59:59').getTime();
                    const now = new Date().getTime();
                    const distance = endDate - now;

                    if (distance < 0) {
                        // Timer has expired
                        timer.innerHTML = `
                            <div class="text-center">
                                <div class="text-red-400 font-mono text-sm md:text-base mb-1">EXPIRED</div>
                                <div class="text-red-400 text-xs">subscription ended</div>
                            </div>
                        `;

                        // Update status badge
                        const memberId = timer.dataset.memberId;
                        const statusBadge = document.querySelector(`.status-badge[data-member-id="${memberId}"]`);
                        if (statusBadge) {
                            statusBadge.className = 'status-badge px-2 py-1 text-xs font-medium rounded-full bg-red-500/20 text-red-400 border border-red-500/30';
                            statusBadge.textContent = 'Expired';
                        }

                        // Show remove button if not already shown
                        const memberCard = document.querySelector(`.member-row[data-member-id="${memberId}"]`);
                        // Note: We'll rely on the server-side condition for remove button
                    } else {
                        // Calculate time remaining
                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

                        // Update timer display
                        const daysElement = timer.querySelector('.countdown-days');
                        const hoursElement = timer.querySelector('.countdown-hours');
                        const minutesElement = timer.querySelector('.countdown-minutes');

                        if (daysElement) daysElement.textContent = days;
                        if (hoursElement) hoursElement.textContent = hours;
                        if (minutesElement) minutesElement.textContent = minutes;

                        // Update status badge if needed
                        const memberId = timer.dataset.memberId;
                        const statusBadge = document.querySelector(`.status-badge[data-member-id="${memberId}"]`);

                        if (statusBadge) {
                            if (days <= 7 && days > 0) {
                                statusBadge.className = 'status-badge px-2 py-1 text-xs font-medium rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30';
                                statusBadge.textContent = 'Expiring Soon';
                            } else if (days === 0) {
                                statusBadge.className = 'status-badge px-2 py-1 text-xs font-medium rounded-full bg-red-500/20 text-red-400 border border-red-500/30';
                                statusBadge.textContent = 'Last Day';
                            } else if (days > 7) {
                                statusBadge.className = 'status-badge px-2 py-1 text-xs font-medium rounded-full bg-green-500/20 text-green-400 border border-green-500/30';
                                statusBadge.textContent = 'Active';
                            }
                        }
                    }
                });

                // Update last update time
                document.getElementById('last-update-time').textContent = `Updated: ${new Date().toLocaleTimeString()}`;
            }

            // Update timers immediately
            updateCountdownTimers();

            // Update timers every minute
            setInterval(updateCountdownTimers, 60000);

            // Real-time status updates via AJAX (every 5 minutes)
            setInterval(function () {
                const memberCards = document.querySelectorAll('.member-row');

                memberCards.forEach(card => {
                    const memberId = card.dataset.memberId;

                    fetch(`/trainer/members/${memberId}/real-time-status`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                        },
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update counters
                                document.getElementById('active-count').textContent =
                                    document.querySelectorAll('.status-badge:contains("Active")').length;
                                document.getElementById('total-count').textContent =
                                    document.querySelectorAll('.member-row').length;
                            }
                        })
                        .catch(error => console.error('Error fetching real-time status:', error));
                });
            }, 300000); // 5 minutes

            // Add visual feedback for real-time updates
            const statsCards = document.querySelectorAll('.glass');
            setInterval(() => {
                statsCards.forEach(card => {
                    card.classList.add('ring-1', 'ring-emerald-500/20');
                    setTimeout(() => {
                        card.classList.remove('ring-1', 'ring-emerald-500/20');
                    }, 1000);
                });
            }, 60000); // Visual pulse every minute
        });
    </script>

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
            box-shadow: 0 0 25px rgba(16, 185, 129, 0.3);
            transform: translateY(-2px);
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

        /* Custom scrollbar improvements */
        .countdown-timer {
            font-family: 'Courier New', monospace;
        }

        .status-badge {
            transition: all 0.3s ease;
        }

        /* Responsive improvements */
        @media (max-width: 360px) {
            .grid-cols-1 {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection
