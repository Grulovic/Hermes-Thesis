<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $guarded = [

    ];
    
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function page(){
        return $this->belongsTo(User::class, 'item_id');
    }

    public function offer(){
        return $this->belongsTo(Offer::class, 'item_id');
    }

    public function thread(){
        return $this->belongsTo(Thread::class, 'item_id');
    }
}
