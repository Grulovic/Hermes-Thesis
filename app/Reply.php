<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $table = 'replies';
	protected $primaryKey = 'id';

    protected $guarded = [

    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
