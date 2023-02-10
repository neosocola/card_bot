<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'telegram_id', 'telegram_firstname', 'telegram_lastname',
    ];

    public function cardrequest ()
    {
        return $this->hasOne(CardRequest::class);
    }
}
