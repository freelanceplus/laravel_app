<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Person;

class Seller extends Model
{
    protected $fillable = ['varified', 'account_balance', 'user_id'];

    public function isVerified()
    {
        if ($this->varified == 1) {
            return true;
        }
        return false;
    }

    public function getPerson()
    {
        return Person::find($this->user_id);
    }
}
