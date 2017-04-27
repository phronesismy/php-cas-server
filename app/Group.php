<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Group extends Model
{
    use RevisionableTrait, SoftDeletes;

    protected $attributes = [
        'status' => 'active'
    ];

    protected $fillable = [
        'name', 'display_name', 'description'
    ];

    protected $revisionCreationsEnabled = true;

    public function histories()
    {
        return $this->morphMany(UserHistory::class, 'actionable');
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

        static::saving(function($group) {
            $group->name = str_slug($group->name);
        });
    }
}
