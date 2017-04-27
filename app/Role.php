<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Role extends Model
{
    use RevisionableTrait, SoftDeletes;

    protected $fillable = [
        'name', 'display_name', 'description'
    ];

    protected $revisionCreationsEnabled = true;

    public function histories()
    {
        return $this->morphMany(UserHistory::class, 'actionable');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public static function options($label='display_name')
    {
        return static::pluck($label, 'id')->toArray();
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function($role) {
            $role->name = str_slug($role->name);
        });
    }
}
