<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\User;
use App\UserFriend;

class FriendsController extends Controller
{
    public function __construct(){
        //$this->middleware('auth')->only(['index','store', 'update']);
        $this->middleware('auth');
    }
    
    public function index(){

        $page = Input::get('page', 1);
        $paginate = 10;
        $friends = $this->search()->orderBy('id','desc');
        $num_of_friends = $friends->count();
        $friends = $friends->simplePaginate($paginate)->appends(request()->except('page'));
        $showing_leftover = ($num_of_friends < $page*$paginate) ? $num_of_friends : $page*$paginate;
        $showing_friends = ($paginate*($page -1)+1)."-".$showing_leftover;

        return view('friends.index',[
                "friends" => $friends,
                'showing_friends' => $showing_friends,
                'num_of_friends' => $num_of_friends,
            ]);
    }

    public function store(){
    	$validated_attributes = request()->validate([
            'user_id' => ['required', 'integer'],
    	]);

    	$hasFriend = auth()->user()->hasFriend($validated_attributes['user_id']);

    	if(!$hasFriend){
    		$request_attributes['user_id'] = $validated_attributes['user_id'];
	    	$request_attributes['friend_id'] = auth()->user()->id;
	    	$request_attributes['status'] = "request";

	        UserFriend::create($request_attributes);

	        $self_attributes['user_id'] = auth()->user()->id;
	        $self_attributes['friend_id'] = $validated_attributes['user_id'];
	        $self_attributes['status'] = "rejected";

	        UserFriend::create($self_attributes);
    	}else{
    		$other_person_request = UserFriend::where('friend_id', auth()->user()->id)->where('user_id', $validated_attributes['user_id'])->get()->first();

    		$attributes['status'] = "request";
    		$other_person_request->update($attributes);
    	}

        return redirect('/friends');
    }

    public function show($id){

        abort_if(!auth()->user()->areFriends($id),403);
    	
        $user = User::select('id','name','email','type')->where('id',$id)->get()->first();
        $offers = $user->offers;
        $threads = $user->threads;
        $lists = auth()->user()->lists;
    	return view('friends.show',[
                "user" => $user,
                "offers" => $offers,
                "threads" => $threads,
                "lists" => $lists,
            ])->render();
    }

    public function destroy($id){

    	$friend = UserFriend::where('id', $id)->get()->first();

        $friend->delete();

        $attributes['user_id'] = $friend->friend_id;
    	$attributes['friend_id'] = $friend->user_id;

    	$friend = UserFriend::where('user_id', $attributes['user_id'])->where('friend_id', $attributes['friend_id'])->get()->first();
        $friend->delete();
    }

    public function update($id)
    {
    	$request = UserFriend::where('id', $id)->get()->first();

        $validated_attributes = request()->validate([
            'status' => ['required', 'min:3', 'max:255', 'in:rejected,approved'],
    	]);

    	$request->update($validated_attributes);

        if($validated_attributes['status'] == "approved"){
        	$other_user_request = UserFriend::where('user_id', $request->friend_id)->where('friend_id', $request->user_id)->get()->first();
        	$other_user_request->update($validated_attributes);

        }
        //return redirect('/forum');
    }

    public function search(){
        $friends = auth()->user()->friends()->with('friend');

        if(isset(request()->name)){
            $friends->whereHas('friend', function($query){ 
                        $query->where('name', 'like', '%'.request()->name.'%');
                   });
        }

        return $friends;
    }
}
