<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Article $article)
    {
        return $user->id === $article->user_id || $user->hasRole('admin');
    }

    public function delete(User $user, Article $article)
    {
        return $user->id === $article->user_id || $user->hasRole('admin');
    }

    public function restore(User $user, Article $article)
    {
        return $user->hasRole('admin');
    }
} 