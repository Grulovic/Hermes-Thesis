<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferListItem extends Model
{
	protected $table = 'offer_list_items';
	protected $primaryKey = 'id';

    protected $guarded = [

    ];

    public function list(){
        return $this->belongsTo(OfferList::class, 'list_id');
    }

    public function offer(){
        return $this->belongsTo(Offer::class, 'offer_id');
    }
}
