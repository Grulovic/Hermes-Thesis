<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $guarded = [

    ];

    public function reviews(){
    	return $this->hasMany(Review::class, 'offer_id');
    }

    public function addReview($review){
        $this->reviews()->create($review);
    }

    public function orders(){
    	return $this->hasMany(OrderOffers::class, 'offer_id');
    }

    public function images(){
        return $this->hasMany(OfferImage::class, 'offer_id');
    }

    public function thumbnail(){
        return $this->hasOne(OfferImage::class, 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function averageRating(){
        $rating_total = 0;

        foreach($this->reviews()->get() as $review){
            $rating_total += $review->rating;
        }

        $review_num = $this->reviews()->count();
        if($review_num == 0){
            return 0;
        }else{
            $averageRating = $rating_total / $review_num;    
        }

        return $averageRating;
    }

    public function inList($id){
        $list_item = OfferListItem::where('list_id', $id)->where('offer_id',$this->id)->first();
        
        if ($list_item==null) {
           return false;
        }else{
            return true;
        }
    }

    public function inFavorite(){
        $favorite = Favorite::where('item_id', $this->id)->where('type','offer')->first();
        
        if ($favorite==null) {
           return false;
        }else{
            return true;
        }
    }
    
}
