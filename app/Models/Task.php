<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'status_id',
        'title',
        'description',
        'priority',
        'deadline'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }

    public function recommendations()
    {
        return $this->hasMany(AiRecommendation::class);
    }
}