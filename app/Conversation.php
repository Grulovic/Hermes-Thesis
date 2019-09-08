<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
	protected $guarded = [

    ];
    
   public function messages(){
        return $this->hasMany(Message::class, 'conversation_id');
   }

   public function creator(){
        return $this->belongsTo(User::class, 'user_id');
   }

   public function participants(){      
        return $this->hasMany(Participant::class, 'conversation_id');
   }

   public function addMessage($message){
        $this->messages()->create($message);
    }

    public function addParticipant($id){
        $this->user()->create($id);
    }
}
