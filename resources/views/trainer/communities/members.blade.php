@extends('layouts.trainer')

@section('title', 'Community Members - ' . $community->name)

@section('styles')
    <style>
        .members-container {
            background: rgba(17, 25, 21, 0.8);
            backdrop-filter: blur(15px) saturate(180%);
            border: 1px solid rgba(0, 255, 170, 0.25);
            border-radius: 20px;
            padding: 2rem;
        }

        .member-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .member-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(0, 255, 170, 0.3);
            transform: translateY(-2px);
        }

        .role-badge {
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .role-admin {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .role-moderator {
            background: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
        }

        .role-member {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
        }

        .role-pending {
            background: rgba(234, 179, 8, 0.2);
            color: #eab308;
        }

        .action-btn {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .btn-promote {
            background: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
            border-color: rgba(59, 130, 246, 0.4);
        }

        .btn-promote:hover {
            background: rgba(59, 130, 246, 0.3);
            border-color: rgba(59, 130, 246, 0.6);
        }

        .btn-demote {
            background: rgba(107, 114, 128, 0.2);
            color: #9CA3AF;
            border-color: rgba(107, 114, 128, 0.4);
        }

        .btn-demote:hover {
            background: rgba(107, 114, 128, 0.3);
            border-color: rgba(107, 114, 128, 0.6);
        }

        .btn-remove {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border-color: rgba(239, 68, 68, 0.4);
        }

        .btn-remove:hover {
            background: rgba(239, 68, 68, 0.3);
            border-color: rgba(239, 68, 68, 0.6);
        }

        .btn-approve {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
            border-color: rgba(34, 197, 94, 0.4);
        }

        .btn-approve:hover {
            background: rgba(34, 197, 94, 0.3);
            border-color: rgba(34, 197, 94, 0.6);
        }

        .btn-reject {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border-color: rgba(239, 68, 68, 0.4);
        }

        .btn-reject:hover {
            background: rgba(239, 68, 68, 0.3);
            border-color: rgba(239, 68, 68, 0.6);
        }

        .section-title {
            color: #e5e7eb;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(0, 255, 170, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #6B7280;
        }

        .empty-state-icon {
            width: 64px;
            height: 64px;
            background: rgba(17, 25, 21, 0.6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            border: 2px dashed rgba(0, 255, 170, 0.3);
        }
    </style>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('trainer.communities.show', $community->slug) }}"
                class="inline-flex items-center text-emerald-400 hover:text-emerald-300 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Back to Community
            </a>
        </div>

        <div class="members-container">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white">Community Members</h1>
                    <p class="text-gray-400">Manage members of {{ $community->name }}</p>
                </div>
                <div class="text-sm text-gray-400">
                    Total: {{ $members->count() }} members
                    @if($pendingMembers->count() > 0)
                        • <span class="text-yellow-400">{{ $pendingMembers->count() }} pending</span>
                    @endif
                </div>
            </div>

            <!-- Pending Members (for private communities) -->
            @if($pendingMembers->count() > 0 && !$community->is_public)
                <div class="mb-8">
                    <h2 class="section-title">Pending Approval</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($pendingMembers as $member)
                            <div class="member-card">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                                            @if($member->user->avatar)
                                                <img src="{{ asset('storage/' . $member->user->avatar) }}"
                                                    alt="{{ $member->user->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div
                                                    class="w-full h-full bg-gradient-to-br from-emerald-neon to-emerald-deep flex items-center justify-center text-white font-bold">
                                                    {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="font-medium text-white">{{ $member->user->name }}</h3>
                                            <p class="text-gray-400 text-xs">{{ $member->user->email }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="role-badge role-pending">Pending</span>
                                        <form
                                            action="{{ route('user.communities.members.approve', [$community->slug, $member->user->id]) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="action-btn btn-approve" title="Approve">
                                                Approve
                                            </button>
                                        </form>
                                        <form
                                            action="{{ route('user.communities.members.reject', [$community->slug, $member->user->id]) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="action-btn btn-reject" title="Reject">
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

            <!-- Members List -->
            <div>
                <h2 class="section-title">Community Members</h2>
                @if($members->count() > 0)
                    <div class="space-y-4">
                        @foreach($members as $member)
                            <div class="member-card">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <div class="flex items-center gap-3 flex-1">
                                        <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0">
                                            @if($member->user->avatar)
                                                <img src="{{ asset('storage/' . $member->user->avatar) }}"
                                                    alt="{{ $member->user->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div
                                                    class="w-full h-full bg-gradient-to-br from-emerald-neon to-emerald-deep flex items-center justify-center text-white font-bold">
                                                    {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <h3 class="font-semibold text-white">{{ $member->user->name }}</h3>
                                                <span class="role-badge role-{{ $member->role }}">
                                                    {{ $member->role }}
                                                </span>
                                            </div>
                                            <p class="text-gray-400 text-sm">{{ $member->user->email }}</p>
                                            <p class="text-gray-500 text-xs mt-1">
                                                Joined {{ $member->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Action Buttons (for admins only) -->
                                    @if(auth()->user()->id === $community->created_by && $member->user->id !== auth()->user()->id)
                                        <div class="flex flex-wrap gap-2">
                                            @if($member->role === 'member')
                                                <form
                                                    action="{{ route('trainer.communities.members.role', [$community->slug, $member->user->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="role" value="moderator">
                                                    <button type="submit" class="action-btn btn-promote">
                                                        Promote to Moderator
                                                    </button>
                                                </form>
                                            @endif

                                            @if($member->role === 'moderator')
                                                <form
                                                    action="{{ route('trainer.communities.members.role', [$community->slug, $member->user->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="role" value="member">
                                                    <button type="submit" class="action-btn btn-demote">
                                                        Demote to Member
                                                    </button>
                                                </form>
                                            @endif

                                            @if($member->role !== 'admin')
                                                <form
                                                    action="{{ route('trainer.communities.members.remove', [$community->slug, $member->user->id]) }}"
                                                    method="POST" onsubmit="return confirm('Are you sure you want to remove this member?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn btn-remove">
                                                        Remove
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-400 mb-2">No Members</h3>
                        <p class="text-gray-500">This community doesn't have any members yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection