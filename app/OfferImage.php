<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferImage extends Model
{
	protected $guarded = [

    ];
    
    public function offer(){
        return $this->belongsTo(Offer::class, 'offer_id');
    }
}
