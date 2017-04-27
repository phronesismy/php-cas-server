<?php

namespace App;

use App\Traits\Roleable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Venturecraft\Revisionable\RevisionableTrait;

class User extends Authenticatable
{
    use Notifiable, RevisionableTrait, Roleable, SoftDeletes;

    protected $attributes = [
        'status' => 'inactive'
    ];

    protected $fillable = [
        'username', 'email', 'name', 'password'
    ];

    protected $hidden = [
        'password', 'confirmation_token', 'remember_token', 'reset_password_token',
    ];

    protected $revisionCreationsEnabled = true;

    public function actions()
    {
        return $this->hasMany(UserHistory::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function histories()
    {
        return $this->morphMany(UserHistory::class, 'actionable');
    }
}
