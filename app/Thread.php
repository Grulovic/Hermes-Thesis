<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
	protected $table = 'threads';
	protected $primaryKey = 'id';

    protected $guarded = [

    ];

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    public function addReply($reply){
        
        $this->replies()->create($reply);

    }

    public function inFavorite(){
        $favorite = Favorite::where('user_id',auth()->user()->id)->where('item_id', $this->id)->where('type','thread')->first();
        
        if ($favorite==null) {
           return false;
        }else{
            return true;
        }
    }
}
