<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $fillable=['account_balance','user_id'];

    public function getPerson(){
        return Person::find($this->user_id);
    }
}
