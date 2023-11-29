<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events';
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
        'description',
        'start',
        'end'
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
     public function group_project()
     {
         return $this->belongsTo(GroupProject::class);
     }
}
