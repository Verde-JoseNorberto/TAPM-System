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
        'project_title',
        'project_category',
        'project_phase',
        'year_term',
        'section',
        'due_date',
        'team',
        'advisor',
        'notes'
    ];
}
