<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardRequest extends Model
{
    protected $fillable = [
        'chat_id', 'card_id',
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
