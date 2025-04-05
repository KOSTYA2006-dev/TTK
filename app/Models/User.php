<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'login',
        'full_name',
        'password',
        'role',
        'is_blocked'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public static function register(array $data): User
    {
        return self::create([
            'login' => $data['login'],
            'full_name' => $data['full_name'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);
    }

    public function hasRole($roles)
    {
        if ($roles === null) {
            return false;
        }

        if (is_string($roles)) {
            return $this->role === $roles;
        }
        
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }
        
        return false;
    }

    public function hasAnyRole(array $roles): bool
    {
        if (empty($roles)) {
            return false;
        }
        return in_array($this->role, $roles);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id');
    }

    public function responsibleTasks()
    {
        return $this->hasMany(Task::class, 'responsible_id');
    }
}
