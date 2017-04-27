<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Service extends Model
{
    use RevisionableTrait, SoftDeletes;

    protected $attributes = [
        'status' => 'active'
    ];

    protected $fillable = [
        'name', 'status'
    ];

    protected $revisionCreationsEnabled = true;

    public function histories()
    {
        return $this->morphMany(UserHistory::class, 'actionable');
    }

    public function urls()
    {
        return $this->hasMany(ServiceUrl::class);
    }

    public static function options($label='name')
    {
        return static::pluck($label, 'id')->toArray();
    }
}
