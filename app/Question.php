<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable=['question','options','answer','skill_id'];
    public function skill()
    {
        return $this->hasOne('App\Skill');
    }
}
