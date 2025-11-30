@extends('layouts.user')

@section('title', 'Manage Members - ' . $community->name)

@section('styles')
<style>
    .management-card {
        background: rgba(17, 25, 21, 0.8);
        backdrop-filter: blur(15px) saturate(180%);
        border: 1px solid rgba(0, 255, 170, 0.25);
        border-radius: 20px;
        padding: 2rem;
    }

    .member-card {
        background: rgba(10, 15, 13, 0.6);
        border: 1px solid rgba(0, 255, 170, 0.2);
        border-radius: 12px;
        padding: 1.5rem;
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
        padding: 3rem 2rem;
        color: #9ca3af;
    }

    .empty-state svg {
        width: 4rem;
        height: 4rem;
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
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: rgba(10, 15, 13, 0.6);
        border: 1px solid rgba(0, 255, 170, 0.2);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #00ff9d;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #9ca3af;
        font-size: 0.875rem;
    }
</style>
@endsection

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="management-card">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('user.communities.show', $community->slug) }}" 
                   class="text-emerald-400 hover:text-emerald-300 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-white">Manage Members</h1>
                    <p class="text-gray-400">{{ $community->name }}</p>
                </div>
            </div>
            <div class="text-right">
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
        <div class="mb-8">
            <h2 class="section-title">Pending Membership Requests</h2>
            <div class="space-y-4">
                @foreach($pendingMembers as $member)
                <div class="member-card">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <img src="{{ $member->user->image ?? asset('images/default-avatar.png') }}" 
                                 alt="{{ $member->user->name }}" 
                                 class="user-avatar">
                            <div>
                                <h3 class="font-semibold text-white">{{ $member->user->name }}</h3>
                                <p class="text-gray-400 text-sm">Requested to join</p>
                                <p class="text-gray-500 text-xs">{{ $member->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <form action="{{ route('user.communities.members.approve', [$community->slug, $member->user->id]) }}" 
                                  method="POST">
                                @csrf
                                <button type="submit" class="action-btn btn-approve" 
                                        onclick="return confirm('Approve {{ $member->user->name }}\'s join request?')">
                                    Approve
                                </button>
                            </form>
                            <form action="{{ route('user.communities.members.reject', [$community->slug, $member->user->id]) }}" 
                                  method="POST">
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
            <div class="space-y-4">
                @foreach($members->where('status', 'approved') as $member)
                <div class="member-card">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4 flex-1">
                            <img src="{{ $member->user->image ?? asset('images/default-avatar.png') }}" 
                                 alt="{{ $member->user->name }}" 
                                 class="user-avatar">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-1">
                                    <h3 class="font-semibold text-white">{{ $member->user->name }}</h3>
                                    @if($member->user->id === $community->created_by)
                                        <span class="badge-admin">Creator</span>
                                    @else
                                        <span class="{{ $member->getRoleBadgeClass() }}">
                                            {{ $member->getRoleDisplayName() }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-gray-400 text-sm">
                                    Joined {{ $member->joined_at->diffForHumans() }}
                                    @if($member->approved_by && $member->approved_at)
                                        • Approved {{ $member->approved_at->diffForHumans() }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2">
                            @if($member->user->id !== auth()->id())
                                <!-- Promote/Demote Actions -->
                                @if($community->getMemberRole(auth()->id()) === 'admin')
                                    @if($member->role === 'member' && $member->user->id !== $community->created_by)
                                        <form action="{{ route('user.communities.members.promote', [$community->slug, $member->user->id]) }}" 
                                              method="POST">
                                            @csrf
                                            <button type="submit" class="action-btn btn-promote" 
                                                    onclick="return confirm('Promote {{ $member->user->name }} to moderator?')">
                                                Promote to Moderator
                                            </button>
                                        </form>
                                    @endif

                                    @if($member->role === 'moderator' && $member->user->id !== $community->created_by)
                                        <form action="{{ route('user.communities.members.demote', [$community->slug, $member->user->id]) }}" 
                                              method="POST">
                                            @csrf
                                            <button type="submit" class="action-btn btn-demote" 
                                                    onclick="return confirm('Demote {{ $member->user->name }} to member?')">
                                                Demote to Member
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Transfer Ownership (Only for non-creator admins/moderators) -->
                                    @if($member->user->id !== $community->created_by && $member->role !== 'admin' && auth()->user()->id === $community->created_by)
                                        <form action="{{ route('user.communities.transfer-ownership', [$community->slug, $member->user->id]) }}" 
                                              method="POST">
                                            @csrf
                                            <button type="submit" class="action-btn btn-transfer" 
                                                    onclick="return confirm('Transfer ownership to {{ $member->user->name }}? This action cannot be undone.')">
                                                Transfer Ownership
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                <!-- Remove Member -->
                                @if($member->role !== 'admin' || ($community->getMemberRole(auth()->id()) === 'admin' && $member->user->id !== $community->created_by))
                                    <form action="{{ route('user.communities.members.remove', [$community->slug, $member->user->id]) }}" 
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-remove" 
                                                onclick="return confirm('Remove {{ $member->user->name }} from the community?')">
                                            Remove
                                        </button>
                                    </form>
                                @endif
                            @else
                                <span class="text-gray-400 text-sm">You</span>
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
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-300 mb-2">No Members Yet</h3>
                <p class="text-gray-400">This community doesn't have any members yet.</p>
            </div>
            @endif
        </div>

        <!-- Permissions Info -->
        <div class="mt-8 p-4 bg-blue-900/20 border border-blue-400/30 rounded-xl">
            <h4 class="font-semibold text-blue-300 mb-2">Permissions Guide</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-blue-200">
                <div>
                    <span class="badge-admin inline-block mr-2">Admin</span>
                    <span>Full management access</span>
                </div>
                <div>
                    <span class="badge-moderator inline-block mr-2">Moderator</span>
                    <span>Can manage members & content</span>
                </div>
                <div>
                    <span class="badge-member inline-block mr-2">Member</span>
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
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            const button = form.querySelector('button[type="submit"]');
            if (button && !button.hasAttribute('onclick')) {
                button.addEventListener('click', function(e) {
                    if (!confirm('Are you sure you want to perform this action?')) {
                        e.preventDefault();
                    }
                });
            }
        });
    });
</script>
@endsection