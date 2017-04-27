<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class ServiceUrl extends Model
{
    use RevisionableTrait, SoftDeletes;

    protected $fillable = [
        'url'
    ];

    protected $revisionCreationsEnabled = true;

    public function histories()
    {
        return $this->morphMany(UserHistory::class, 'actionable');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
