<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    protected $fillable = [
        'action', 'actionable_id', 'actionable_type', 'remarks', 'ip_address', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function actionable()
    {
        return $this->morphTo();
    }
}
