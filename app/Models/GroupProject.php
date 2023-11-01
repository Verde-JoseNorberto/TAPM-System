<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupProject extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $table = 'group_projects';
    protected $primaryKay = 'id';
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'subject',
        'section',
        'team',
        'advisor'
    ];

    /**
     * The has Many Relationship
     *
     * @var array
     */
    public function projects()
    {
        return $this->hasMany(Project::class)->whereNull('parent_id');
    }
    public function tasks()
    {
        return $this->hasMany(Task::class)->whereNull('parent_id');
    }

    /**
     * The has Many Relationship with permission
     *
     * @var array
     */
    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
