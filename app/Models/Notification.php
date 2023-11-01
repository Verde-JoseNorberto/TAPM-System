<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $primaryKay = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'notify_id', 
        'type',
        'data',
        'link',
    ];

    /**
     * The belongs to Relationship
     *
     * @var array
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function notifications()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function notified()
    {
        return $this->hasMany(User::class, 'notify_id');
    }

}
