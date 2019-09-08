<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $guarded = [

    ];

    public function order_offers(){
        return $this->hasMany(OrderOffers::class, 'order_id');
    }

    public function offers_user(){
        return $this->belongsTo(User::class, 'offers_user_id');
    }

    public function details(){
        return $this->hasOne(OrderDetails::class, 'order_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
