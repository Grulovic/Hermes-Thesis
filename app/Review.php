<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
	protected $primaryKey = 'id';

    protected $guarded = [

    ];

    public function user(){
    	return $this->belongsTo(User::class, 'user_id');
    }
}
