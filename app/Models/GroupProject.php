<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupProject extends Model
{
    use HasFactory;

    protected $table = 'group_projects';
    protected $primaryKay = 'id';

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
     * The belongs to Relationship
     *
     * @var array
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
}
