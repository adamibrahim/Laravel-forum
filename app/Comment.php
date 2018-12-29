<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body', 'user_id',
    ];


    /**
     * The user of this comment.
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * The thread of this comment.
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function thread()
    {
        return $this->belongsTo('App\Thread');
    }
}
