<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conversation;
use App\Message;

class ConversationMessagesController extends Controller
{
    // public function store($id){

    // 	$conversation = Conversation::where('id', $id)->get()->first();

    // 	$validated_attributes = request()->validate(['text' => 'required']);
    // 	$validated_attributes['conversation_id'] = $id;
    // 	$validated_attributes['user_id'] = auth()->id();

    // 	$conversation->addMessage($validated_attributes);

    // 	return back();
    // }

    public function __construct(){
        //$this->middleware('auth')->only(['index','store', 'update']);
        $this->middleware('auth');
    }

    public function store($id){
    	//dd("con: ".$id." , user: ".auth()->user()->id." ,message: ".request()->message);
    	
    	$message = request()->message;

    	$validated_attributes = array();
		$validated_attributes['text'] = $message;
    	$validated_attributes['conversation_id'] = $id;
    	$validated_attributes['user_id'] = auth()->user()->id;
    	//dd($validated_attributes);
    	
    	$conversation = Conversation::where('id', $id)->get()->first();
    	$conversation->addMessage($validated_attributes);

    	// $message= Message::latest()->get()->first();
        $message = Message::orderBy('id','desc')->get()->first();
        $compiled = view('conversations.message')->with('message', $message)->render();

        return $compiled;
    }

    public function get($id){

    	//$message= Message::where('conversation_id',$id)->latest()->get()->first();
    	$message= Message::where('conversation_id',$id)->orderBy('id','desc')->get()->first();
        
        // $message->text = decrypt($message->text);

        $compiled = view('conversations.message')->with('message', $message)->render();

        $message_id = $message->id;

     //    return $compiled;
    	return response()->json([
    		'message_id'=>	$message_id,
    		'message_html' => $compiled
    	]);
    }

    public function destroy($id){

        $message = Message::where('id',$id)->orderBy('id','desc');

        $attributes['text'] = "  Deleted the message!  ";
        $message->update($attributes);

        $message = Message::where('id',$id)->orderBy('id','desc')->get()->first();

        return "<div class=\"alert alert-danger mt-3 w-100 text-center\"><i class=\"fas fa-comment-slash\"></i> <a href=\"/users/".$message->user->id."/show\">".$message->user->name."</a> Deleted the message!</div>";
    }
}
