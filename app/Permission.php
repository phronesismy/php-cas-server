<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Permission extends Model
{
    use RevisionableTrait, SoftDeletes;

    protected $fillable = [
        'group', 'name', 'description'
    ];

    protected $revisionCreationsEnabled = true;

    public function histories()
    {
        return $this->morphMany(UserHistory::class, 'actionable');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public static function options($label='name')
    {
        return static::pluck($label, 'id')->toArray();
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($permission) {
            $permission->group = explode(':', $permission->name)[0];
        });
    }
}
