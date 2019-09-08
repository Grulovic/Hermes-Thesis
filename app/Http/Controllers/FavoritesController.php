<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;

class FavoritesController extends Controller
{
    public function __construct(){
        //$this->middleware('auth')->only(['index','store', 'update']);
        $this->middleware('auth');
    }
    
    public function index(){
    	$favorites = auth()->user()->favorites;
    	$offers = array();
    	$threads = array();
    	$users = array();

    	foreach($favorites as $key => $favorite){
    		if($favorite->type == "offer"){
    			array_push($offers, $favorite->offer);
                $offers[sizeof($offers)-1]['favorite_id'] = $favorite->id;
    		}elseif($favorite->type == "thread"){
    			array_push($threads, $favorite->thread);
                $threads[sizeof($threads)-1]['favorite_id'] = $favorite->id;
			}elseif($favorite->type == "page"){
    			array_push($users, $favorite->page);
                $users[sizeof($users)-1]['favorite_id'] = $favorite->id;
			}
    	}
        return view('favorites.index',[
                'favorites' => $favorites,
                'offers' => $offers,
                'threads' => $threads,
                'users' => $users,
            ]);
    }

    public function store(){
        $validated_attributes = request()->validate([
            'item_id' => ['required','integer'],
            'type' => ['required', 'min:3', 'max:255', 'in:offer,page,thread'],
        ]);
        
        $validated_attributes['user_id'] = auth()->user()->id;

        $exists = Favorite::where('item_id',$validated_attributes['item_id'])->where('type',$validated_attributes['type'])->first();

        if($exists==null){
            $new_favorite = Favorite::create($validated_attributes);
        }else{
            $exists->delete();
        }

            // $new_favorite = Favorite::create($validated_attributes);
        
        
        // return $new_favorite->id;
    }

    public function destroy(Favorite $favorite){
        abort_if(auth()->user()->id != $favorite->user_id,403);

        $favorite->delete();
    }	
}