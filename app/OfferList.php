<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferList extends Model
{
	protected $table = 'offer_lists';
	protected $primaryKey = 'id';

    protected $guarded = [

    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

	public function items(){
        return $this->hasMany(OfferListItem::class, 'list_id');
    }    

    public function addItem($item){
        $this->items()->create($item);
    }
}
