<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'receiver',
        'receiver_id',
        'order_id',
        'message',
    ];
}
