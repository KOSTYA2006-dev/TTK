<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Task $task)
    {
        return true; // Разрешаем всем просматривать задачи
    }

    public function create(User $user)
    {
        return true; // Разрешаем всем создавать задачи
    }

    public function update(User $user, Task $task)
    {
        return true; // Разрешаем всем редактировать задачи
    }

    public function delete(User $user, Task $task)
    {
        return true; // Разрешаем всем удалять задачи
    }

    public function updateStatus(User $user, Task $task)
    {
        return true; // Разрешаем всем изменять статус задач
    }

    public function viewHistory(User $user, Task $task)
    {
        return true; // Разрешаем всем просматривать историю задач
    }
} 