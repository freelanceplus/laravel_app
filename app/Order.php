<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'title',
        'project_type',
        'description',
        'image',
        'deadline',
        'budget',
        'files',
        'seller_files',
        'remarks',
        'buyer_id',
        'seller_id',
        'status',
    ];

//    public function getOrderId(){
//        return Order::find($this->id);
//    }
}
