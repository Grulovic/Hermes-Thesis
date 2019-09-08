<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offer;
use App\User;

class SessionController extends Controller
{
    public function __construct(){
        //$this->middleware('auth')->only(['index','store', 'update']);
        $this->middleware('auth');
    }
    
    public function set_cart(){
    	// request()->session()->forget('cart');
    	// return "deleted";
    	// return "adding offer to session cart: " . request()->offer_id;

    	$validated = request()->validate([
            'offer_id' => ['required','integer'],
        ]);

    	$offer_object = Offer::where('id', $validated['offer_id'])->get()->first();
    	
    	if($offer_object==null){
    		return "offer which is being added to session cart doesnt exist";
    	}

    	$cart_items = request()->session()->get('cart');

    	// return "_".$cart_items."_";

    	if($cart_items==""){
    		request()->session()->push('cart', $validated['offer_id']);
    	}else{
    		$exist = false;

    		foreach ( $cart_items as $cart_item) {
	    		if($cart_item == $offer_object->id){
	    			$exist = true;
	    		}
	    	}
	    	
	    	if(!$exist){
	    		request()->session()->push('cart', $validated['offer_id']);
	    	}	
    	}
    	// return request()->session()->get('cart');
        

        $cart_offers = Offer::whereIn('id', request()->session()->get('cart'))->get();
        $cart_users_ids = Offer::select('user_id')->distinct('user_id')->whereIn('id', request()->session()->get('cart'))->get()->toArray();
        $cart_users = array();
        foreach ($cart_users_ids as $user_id) {
            array_push($cart_users, User::where('id',$user_id['user_id'])->first());
        }

        return view('offers.cart',[
            'cart_offers' => $cart_offers,
            'cart_users' => $cart_users,
        ])->render();
    }

    public function remove_cart(){
        $cart_items = request()->session()->get('cart');

        foreach ($cart_items as $key => $item) {
            if($item == request()->offer_id){
                request()->session()->forget('cart.'.$key);
            }
        }
    }

    public function clear_cart(){
        request()->session()->forget('cart');
    }

    public function clear_compare(){
        request()->session()->forget('compare');
    }

    public function set_compare(){
        // request()->session()->forget('compare');
        // return "deleted";
        // return "adding offer to session compare: " . request()->offer_id;

        $validated = request()->validate([
            'offer_id' => ['required','integer'],
        ]);

        $offer_object = Offer::where('id', $validated['offer_id'])->get()->first();
        
        if($offer_object==null){
            return "offer which is being added to session compare doesnt exist";
        }

        $compare_items = request()->session()->get('compare');

        // return "_".$compare_items."_";

        if($compare_items==""){
            request()->session()->push('compare', $validated['offer_id']);
        }else{
            $exist = false;

            foreach ( $compare_items as $compare_item) {
                if($compare_item == $offer_object->id){
                    $exist = true;
                }
            }
            
            if(!$exist){
                request()->session()->push('compare', $validated['offer_id']);
            }   
        }
        
        $compare_offers = Offer::whereIn('id', request()->session()->get('compare'))->get();

        return view('offers.compare',[
            'compare_offers' => $compare_offers,
        ])->render();
        // return request()->session()->get('compare');
    }

    public function remove_compare(){
        $compare_items = request()->session()->get('compare');

        foreach ($compare_items as $key => $item) {
            if($item == request()->offer_id){
                request()->session()->forget('compare.'.$key);
            }
        }
    }
}
