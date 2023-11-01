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
        'group_project_id', 
        'parent_id',
        'title',
        'file',
        'description'
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

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class)->whereNull('parent_id');
    }
}
