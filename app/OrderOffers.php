<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderOffers extends Model
{	
	protected $guarded = [

    ];
    
    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function offer(){
        return $this->belongsTo(Offer::class, 'offer_id');
    }

    public function orderNum(){
        return $this->orders()->where('status','complete')->count();
    }
}
