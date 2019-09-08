<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Reply;

class ForumRepliesController extends Controller
{
    public function __construct(){
        //$this->middleware('auth')->only(['index','store', 'update']);
        $this->middleware('auth');
    }
    
    public function store($id){

    	$thread = Thread::where('id', $id)->get()->first();

    	$validated_attributes = request()->validate(['text' => 'required']);
    	$validated_attributes['user_id'] = auth()->id();

    	$thread->addReply($validated_attributes);

     //    $reply= Reply::orderBy('id','desc')->get()->first();
     //    $compiled = view('forum.reply')->with('reply', $reply)->render();
    	// return $compiled;
    }

    public function destroy($id)
    {

        $reply = Reply::where('id', $id);
        
        $reply->delete();

        //return back();
    }

    public function get($id){

        $reply= Reply::where('thread_id',$id)->orderBy('id','desc')->get()->first();

        $compiled = view('forum.reply')->with('reply', $reply)->render();

        $reply_id = $reply->id;

     //    return $compiled;
        return response()->json([
            'reply_id'=>  $reply_id,
            'reply_html' => $compiled
        ]);
    }
}
