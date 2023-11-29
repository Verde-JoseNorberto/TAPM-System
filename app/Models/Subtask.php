<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subtask extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $table = 'subtasks';
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
        'assign_id',
        'parent_id',
        'title',
        'content',
        'start_date',
        'due_date',
        'status',
        'priority',
        'updated_by',
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

    public function assign()
    {
        return $this->belongsTo(User::class, 'assign_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function maintask()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

}