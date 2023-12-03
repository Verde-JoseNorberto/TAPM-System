<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory,  SoftDeletes, Notifiable;

    protected $table = 'projects';
    protected $primaryKay = 'id';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 
        'task_id', 
        'subtask_id', 
        'parent_id',
        'description',
        'file',
    ];

    /**
     * The belongs to Relationship
     *
     * @var array
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tasks()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
    public function subtasks()
    {
        return $this->belongsTo(Subtask::class, 'subtask_id', 'id');
    }
    
    /**
     * The has Many Relationship
     *
     * @var array
     */

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class)->whereNull('parent_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'members', 'group_project_id', 'user_id');
    }
}
