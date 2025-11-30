<?php

namespace App\Policies;

use App\Models\PostComment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostCommentPolicy
{
    /**
     * Determine if the user can update the comment.
     */
    public function update(User $user, PostComment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine if the user can delete the comment.
     */
    public function delete(User $user, PostComment $comment): bool
    {
        return $user->id === $comment->user_id ||
            $comment->post->community->isAdmin($user->id);
    }
}
