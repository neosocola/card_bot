<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'chat_id', 'action'
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
