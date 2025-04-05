<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'responsible_id',
        'priority',
        'status',
        'due_date',
        'images'
    ];

    protected $casts = [
        'images' => 'array',
        'due_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function histories()
    {
        return $this->hasMany(TaskHistory::class);
    }

    public static function getPriorityClasses()
    {
        return [
            'low' => 'bg-green-100 text-green-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'high' => 'bg-red-100 text-red-800'
        ];
    }

    public static function getStatusNames()
    {
        return [
            'current' => 'Текущая',
            'delayed' => 'Отложенная',
            'completed' => 'Выполненная'
        ];
    }
}
