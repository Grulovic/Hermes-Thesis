<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
	protected $guarded = [

    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}
