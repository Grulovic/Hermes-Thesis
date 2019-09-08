<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $appends = ['conversations'];

    protected $fillable = [
        'name', 'email', 'password', 'type'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function offers(){
        return $this->hasMany(Offer::class, 'user_id')->orderBy('created_at', 'desc');
    }

    public function participations() {
     return $this->hasMany(Participant::class, 'user_id')->orderBy('created_at', 'desc');
    }

    public function messages(){
     return $this->hasMany(Message::class , 'user_id');   
    }

    public function threads(){
        return $this->hasMany(Thread::class, 'user_id')->orderBy('created_at', 'desc');
    }

    public function replies(){
        return $this->hasMany(Reply::class, 'user_id');
    }

    public function orders(){
        return $this->hasMany(Order::class, 'user_id')->orderBy('created_at', 'desc');
    }

    public function requests(){
        return $this->hasMany(Order::class, 'offers_user_id')->orderBy('created_at', 'desc');
    }

    public function hasReview($id){
        $matchThese = ['user_id' => $this->id, 'offer_id' => $id];
        
        $review = Review::where($matchThese)->first();

        if($review==null){
            return true;
        }else{
            return false;
        }
    }
    
    public function hasFriend($id){
        $friend = UserFriend::where(['user_id' => $this->id, 'friend_id' => $id])->first();

        if($friend==null){
            return false;
        }else{
            return true;
        }
    }
    public function areFriends($id){
        $friend = UserFriend::where(['user_id' => $this->id, 'friend_id' => $id])->where('status','approved')->first();

        if($friend==null){
            return false;
        }else{
            return $friend->id;
            // return true;
        }
    }

    public function favorites(){
        return $this->hasMany(Favorite::class, 'user_id');
    }

    public function lists(){
        return $this->hasMany(OfferList::class, 'user_id');
    }

    public function friends(){
        return $this->hasMany(UserFriend::class, 'user_id');
    }

    public function details(){
        return $this->hasOne(UserDetails::class, 'user_id');
    }

    public function inFavorite(){
        $favorite = Favorite::where('user_id',auth()->user()->id)->where('item_id', $this->id)->where('type','page')->first();
        
        if ($favorite==null) {
           return false;
        }else{
            return true;
        }
    }
}
