<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Task;
use App\Models\User;
use App\Policies\ArticlePolicy;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Article::class => ArticlePolicy::class,
        Task::class => TaskPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-article', function (User $user, Article $article) {
            return true; // Разрешаем всем
        });

        Gate::define('delete-article', function (User $user, Article $article) {
            return true; // Разрешаем всем
        });

        Gate::define('restore-article', function (User $user, Article $article) {
            return true; // Разрешаем всем
        });
    }
} 