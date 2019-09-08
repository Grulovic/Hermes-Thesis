<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conversation;
use App\Participant;

class ConversationsParticipantsController extends Controller
{
    public function __construct(){
        //$this->middleware('auth')->only(['index','store', 'update']);
        $this->middleware('auth');
    }
    
    public function destroy($id)
    {
        $participant = Participant::where('id', $id)->get()->first();
        

        $validated_attributes = array();
        $validated_attributes['text'] = "  Left conversation or got removed!  ";
        $validated_attributes['conversation_id'] = $participant->conversation_id;
        $validated_attributes['user_id'] = $participant->user_id;
        
        $conversation = Conversation::where('id', $participant->conversation_id)->get()->first();
        $conversation->addMessage($validated_attributes);

        $participant = Participant::where('id', $id);
        $participant->delete();
        //return back();
    }

    public function store($conversation_id){
        


    	$conversation = Conversation::where('id', $conversation_id)->get()->first();
        
        //$user_id = request()->user_id;

    	$attributes = request()->validate(['user_id' => ['required','integer']]);
    	$attributes['conversation_id'] = $conversation_id;

        $validate = $this->validateUser($conversation_id, $attributes['user_id']);
        // if($validate == true){ return "true"; }else{ return "false"; }

    	if($validate){
    		$participant = Participant::create($attributes);
    	}

        $validated_attributes = array();
        $validated_attributes['text'] = "  Joined the conversation!  ";
        $validated_attributes['conversation_id'] = $participant->conversation_id;
        $validated_attributes['user_id'] = $participant->user_id;
        
        $conversation = Conversation::where('id', $participant->conversation_id)->get()->first();
        $conversation->addMessage($validated_attributes);
        // $participant = Participant::all()->latest()->get();
        // $compiled = view('conversations.participant')->with('participant', $participant)->render();

        // return $compiled;
     //    return back();

    	
    }

    public function validateUser($conversation_id, $user_id){

        
        $user_exists = auth()->user()->where('id', $user_id)->count();

        if ( $user_exists == 0) {
            // $error = \Illuminate\Validation\ValidationException::withMessages([
            //    'field_name_1' => ["The user doesn't exist!"],
            // ]);
            // throw $error;
        	return false;
        }
        
        $already = Participant::where(['conversation_id' => $conversation_id, 'user_id' => $user_id])->get()->count();


        if ($already == 1) {
            // $error = \Illuminate\Validation\ValidationException::withMessages([
            //    'field_name_1' => ["The user is already in the conversation!"],
            // ]);
            // throw $error;
 			return false;
		}

		return true;        
    }

}
