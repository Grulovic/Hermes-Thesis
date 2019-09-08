<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	protected $guarded = [

    ];
    
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function conversation(){
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    public function previous(){

        // $conversation= Conversation::where('id',$id)->get()->first();
        // $participants = Participant::where('conversation_id', $id)->get();
        // $messages = array();

        // foreach ($conversation->messages as $key => $message) {
        //     if($key == 0 ){
        //         // $previous = $message->user_id;
        //         $previous = null;
        //     }

        //     array_push($messages, $message);
        //     $messages[$key]['previous_user_id'] = $previous;

        //     $previous = $message->user_id;
        // }


    	$messages = $this->conversation()->messages()->select('id')->get();

    	$previous_message_id = 0;

    	// foreach ($messages as $key => $message) {
    	// 	if($message->user_id == $this->user_id){
    	// 		return $previous_message_id;
    	// 	}
    	// 	$previous_message_id = $message->user_id;
    	// }

        foreach ($messages as $key => $message) {
            if($key == 0 ){
                // $previous = $message->user_id;
                $previous = null;
            }

            array_push($messages, $message);
            $messages[$key]['previous_user_id'] = $previous;

            $previous = $message->user_id;
        }
    }
}
