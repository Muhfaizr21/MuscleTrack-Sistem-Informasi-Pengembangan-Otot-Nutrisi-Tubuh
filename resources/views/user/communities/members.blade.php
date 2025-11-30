@extends('layouts.user')

@section('title', 'Manage Members - ' . $community->name)

@section('styles')
    <style>
        .management-card {
            background: rgba(17, 25, 21, 0.8);
            backdrop-filter: blur(15px) saturate(180%);
            border: 1px solid rgba(0, 255, 170, 0.25);
            border-radius: 20px;
            padding: 1.5rem;
        }

        .member-card {
            background: rgba(10, 15, 13, 0.6);
            border: 1px solid rgba(0, 255, 170, 0.2);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .member-card:hover {
            border-color: rgba(0, 255, 170, 0.4);
            background: rgba(0, 255, 170, 0.05);
        }

        .badge-admin {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-moderator {
            background: linear-gradient(135deg, #d97706, #b45309);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-member {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-pending {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-promote {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .btn-promote:hover {
            background: rgba(34, 197, 94, 0.3);
            border-color: rgba(34, 197, 94, 0.5);
        }

        .btn-demote {
            background: rgba(245, 158, 11, 0.2);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .btn-demote:hover {
            background: rgba(245, 158, 11, 0.3);
            border-color: rgba(245, 158, 11, 0.5);
        }

        .btn-remove {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-remove:hover {
            background: rgba(239, 68, 68, 0.3);
            border-color: rgba(239, 68, 68, 0.5);
        }

        .btn-approve {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .btn-approve:hover {
            background: rgba(34, 197, 94, 0.3);
            border-color: rgba(34, 197, 94, 0.5);
        }

        .btn-reject {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-reject:hover {
            background: rgba(239, 68, 68, 0.3);
            border-color: rgba(239, 68, 68, 0.5);
        }

        .btn-transfer {
            background: rgba(168, 85, 247, 0.2);
            color: #a855f7;
            border: 1px solid rgba(168, 85, 247, 0.3);
        }

        .btn-transfer:hover {
            background: rgba(168, 85, 247, 0.3);
            border-color: rgba(168, 85, 247, 0.5);
        }

        .section-title {
            color: #00ff9d;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(0, 255, 170, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
            color: #9ca3af;
        }

        .empty-state svg {
            width: 3rem;
            height: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(0, 255, 170, 0.3);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(10, 15, 13, 0.6);
            border: 1px solid rgba(0, 255, 170, 0.2);
            border-radius: 12px;
            padding: 1.25rem;
            text-align: center;
        }

        .stat-number {
            font-size: 1.75rem;
            font-weight: bold;
            color: #00ff9d;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #9ca3af;
            font-size: 0.875rem;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 640px) {
            .management-card {
                padding: 1.25rem;
                border-radius: 16px;
                margin: 0 0.5rem;
            }

            .member-card {
                padding: 1rem;
            }

            .user-avatar {
                width: 40px;
                height: 40px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
                margin-bottom: 1.5rem;
            }

            .stat-card {
                padding: 1rem;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .action-btn {
                padding: 0.4rem 0.75rem;
                font-size: 0.8rem;
            }

            .section-title {
                font-size: 1.125rem;
            }
        }

        @media (max-width: 480px) {
            .management-card {
                padding: 1rem;
            }

            .member-card {
                padding: 0.75rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .user-avatar {
                width: 35px;
                height: 35px;
            }

            .action-btn {
                padding: 0.35rem 0.6rem;
                font-size: 0.75rem;
            }
        }

        /* Tablet Styles */
        @media (min-width: 641px) and (max-width: 1024px) {
            .management-card {
                padding: 1.75rem;
            }

            .stats-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* Desktop Styles */
        @media (min-width: 1025px) {
            .management-card {
                padding: 2rem;
            }
        }

        /* Member Card Layout Responsiveness */
        @media (max-width: 768px) {
            .member-card .flex.items-center.justify-between {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .member-card .flex.items-center.gap-4 {
                width: 100%;
            }

            .member-card .flex.items-center.gap-2 {
                width: 100%;
                justify-content: flex-start;
                flex-wrap: wrap;
                gap: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .member-card .flex.items-center.gap-4 {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .member-card .flex.items-center.gap-3 {
                flex-wrap: wrap;
                gap: 0.5rem;
            }
        }

        /* Header Responsiveness */
        @media (max-width: 640px) {
            .flex.items-center.justify-between {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .flex.items-center.gap-4 {
                width: 100%;
            }

            .text-right {
                text-align: left;
                width: 100%;
            }
        }

        /* Permissions Guide Responsiveness */
        @media (max-width: 768px) {
            .grid.grid-cols-1.md\:grid-cols-3 {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .mt-8.p-4 {
                margin-top: 1.5rem;
                padding: 1rem;
            }
        }

        /* Button Group Responsiveness */
        @media (max-width: 640px) {
            .flex.items-center.gap-2 {
                flex-wrap: wrap;
            }

            .action-btn {
                margin-bottom: 0.25rem;
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

            .text-xs {
                font-size: 0.7rem;
            }
        }

        /* Empty State Responsiveness */
        @media (max-width: 480px) {
            .empty-state {
                padding: 1.5rem 1rem;
            }

            .empty-state svg {
                width: 2.5rem;
                height: 2.5rem;
            }
        }

        /* Touch-friendly Improvements */
        @media (max-width: 768px) {
            .action-btn {
                min-height: 36px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .user-avatar {
                flex-shrink: 0;
            }
        }

        /* Container Responsiveness */
        @media (max-width: 640px) {
            .max-w-6xl {
                max-width: 100%;
                padding: 0 0.5rem;
            }
        }

        /* Stats Grid Small Screen Optimization */
        @media (max-width: 380px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-6">
        <div class="management-card">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 sm:mb-8">
                <div class="flex items-center gap-3 sm:gap-4">
                    <a href="{{ route('user.communities.show', $community->slug) }}"
                        class="text-emerald-400 hover:text-emerald-300 transition-colors flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-white">Manage Members</h1>
                        <p class="text-gray-400 text-sm sm:text-base">{{ $community->name }}</p>
                    </div>
                </div>
                <div class="text-left sm:text-right">
                    <div class="text-sm text-gray-400">Your Role:
                        <span class="font-semibold text-emerald-400 capitalize">
                            {{ $community->getMemberRole(auth()->id()) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $members->where('status', 'approved')->count() }}</div>
                    <div class="stat-label">Total Members</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $members->where('role', 'admin')->count() }}</div>
                    <div class="stat-label">Admins</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $members->where('role', 'moderator')->count() }}</div>
                    <div class="stat-label">Moderators</div>
                </div>
                @if($pendingMembers->count() > 0)
                    <div class="stat-card">
                        <div class="stat-number text-yellow-400">{{ $pendingMembers->count() }}</div>
                        <div class="stat-label">Pending Requests</div>
                    </div>
                @endif
            </div>

            <!-- Pending Membership Requests -->
            @if($pendingMembers->count() > 0)
                <div class="mb-6 sm:mb-8">
                    <h2 class="section-title">Pending Membership Requests</h2>
                    <div class="space-y-3 sm:space-y-4">
                        @foreach($pendingMembers as $member)
                            <div class="member-card">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
                                    <div class="flex items-center gap-3 sm:gap-4 flex-1">
                                        <img src="{{ $member->user->image ?? asset('images/default-avatar.png') }}"
                                            alt="{{ $member->user->name }}" class="user-avatar">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3 mb-1">
                                                <h3 class="font-semibold text-white text-sm sm:text-base truncate">
                                                    {{ $member->user->name }}</h3>
                                                <span class="badge-pending text-xs">Pending</span>
                                            </div>
                                            <p class="text-gray-400 text-xs sm:text-sm">Requested to join</p>
                                            <p class="text-gray-500 text-xs">{{ $member->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <form
                                            action="{{ route('user.communities.members.approve', [$community->slug, $member->user->id]) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="action-btn btn-approve"
                                                onclick="return confirm('Approve {{ $member->user->name }}\'s join request?')">
                                                Approve
                                            </button>
                                        </form>
                                        <form
                                            action="{{ route('user.communities.members.reject', [$community->slug, $member->user->id]) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="action-btn btn-reject"
                                                onclick="return confirm('Reject {{ $member->user->name }}\'s join request?')">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Approved Members -->
            <div>
                <h2 class="section-title">Community Members</h2>

                @if($members->where('status', 'approved')->count() > 0)
                    <div class="space-y-3 sm:space-y-4">
                        @foreach($members->where('status', 'approved') as $member)
                            <div class="member-card">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
                                    <div class="flex items-center gap-3 sm:gap-4 flex-1 min-w-0">
                                        <img src="{{ $member->user->image ?? asset('images/default-avatar.png') }}"
                                            alt="{{ $member->user->name }}" class="user-avatar">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3 mb-1">
                                                <h3 class="font-semibold text-white text-sm sm:text-base truncate">
                                                    {{ $member->user->name }}</h3>
                                                <div class="flex items-center gap-1 sm:gap-2 flex-wrap">
                                                    @if($member->user->id === $community->created_by)
                                                        <span class="badge-admin text-xs">Creator</span>
                                                    @else
                                                        <span class="{{ $member->getRoleBadgeClass() }} text-xs">
                                                            {{ $member->getRoleDisplayName() }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="text-gray-400 text-xs sm:text-sm truncate">
                                                Joined {{ $member->joined_at->diffForHumans() }}
                                                @if($member->approved_by && $member->approved_at)
                                                    • Approved {{ $member->approved_at->diffForHumans() }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex items-center gap-2 flex-wrap">
                                        @if($member->user->id !== auth()->id())
                                            <!-- Promote/Demote Actions -->
                                            @if($community->getMemberRole(auth()->id()) === 'admin')
                                                @if($member->role === 'member' && $member->user->id !== $community->created_by)
                                                    <form
                                                        action="{{ route('user.communities.members.promote', [$community->slug, $member->user->id]) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="action-btn btn-promote"
                                                            onclick="return confirm('Promote {{ $member->user->name }} to moderator?')">
                                                            Promote
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($member->role === 'moderator' && $member->user->id !== $community->created_by)
                                                    <form
                                                        action="{{ route('user.communities.members.demote', [$community->slug, $member->user->id]) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="action-btn btn-demote"
                                                            onclick="return confirm('Demote {{ $member->user->name }} to member?')">
                                                            Demote
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Transfer Ownership (Only for non-creator admins/moderators) -->
                                                @if($member->user->id !== $community->created_by && $member->role !== 'admin' && auth()->user()->id === $community->created_by)
                                                    <form
                                                        action="{{ route('user.communities.transfer-ownership', [$community->slug, $member->user->id]) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="action-btn btn-transfer"
                                                            onclick="return confirm('Transfer ownership to {{ $member->user->name }}? This action cannot be undone.')">
                                                            Transfer
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif

                                            <!-- Remove Member -->
                                            @if($member->role !== 'admin' || ($community->getMemberRole(auth()->id()) === 'admin' && $member->user->id !== $community->created_by))
                                                <form
                                                    action="{{ route('user.communities.members.remove', [$community->slug, $member->user->id]) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn btn-remove"
                                                        onclick="return confirm('Remove {{ $member->user->name }} from the community?')">
                                                        Remove
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="text-gray-400 text-xs sm:text-sm">You</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-300 mb-2">No Members Yet</h3>
                        <p class="text-gray-400 text-sm sm:text-base">This community doesn't have any members yet.</p>
                    </div>
                @endif
            </div>

            <!-- Permissions Info -->
            <div class="mt-6 sm:mt-8 p-3 sm:p-4 bg-blue-900/20 border border-blue-400/30 rounded-xl">
                <h4 class="font-semibold text-blue-300 text-sm sm:text-base mb-2">Permissions Guide</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 text-xs sm:text-sm text-blue-200">
                    <div class="flex items-center gap-2">
                        <span class="badge-admin inline-block flex-shrink-0">Admin</span>
                        <span>Full management access</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="badge-moderator inline-block flex-shrink-0">Moderator</span>
                        <span>Can manage members & content</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="badge-member inline-block flex-shrink-0">Member</span>
                        <span>Can participate in community</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Confirmation for all actions
        document.addEventListener('DOMContentLoaded', function () {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                const button = form.querySelector('button[type="submit"]');
                if (button && !button.hasAttribute('onclick')) {
                    button.addEventListener('click', function (e) {
                        if (!confirm('Are you sure you want to perform this action?')) {
                            e.preventDefault();
                        }
                    });
                }
            });
        });
    </script>
@endsection