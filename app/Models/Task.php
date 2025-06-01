<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'title',
        'description',
        'due_date',
        'priority',
        'status',
    ];

    protected $attributes = [
        'status' => 'to_do', // default status
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function checklistItems()
    {
        return $this->hasMany(ChecklistItem::class);
    }

    // Computed property for status badge color
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'to_do' => 'primary',
            'in_progress' => 'warning',
            'completed' => 'success',
            default => 'secondary',
        };
    }

    // Automatically log task activity
    protected static function booted()
    {
        static::created(function ($task) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'CREATED THE TASK: ' . $task->title,
                'model_name' => $task->title,
                'created_at' => now(),
            ]);
        });

        static::updated(function ($task) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'UPDATED THE TASK: ' . $task->title,
                'model_name' => $task->title,
                'created_at' => now(),
            ]);
        });

        static::deleted(function ($task) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'DELETED THE TASK: ' . $task->title,
                'model_name' => $task->title,
                'created_at' => now(),
            ]);
        });
    }
}
