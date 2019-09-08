<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offer;
use App\Review;

class OfferReviewsController extends Controller
{
    public function __construct(){
        //$this->middleware('auth')->only(['index','store', 'update']);
        $this->middleware('auth');
    }
    
    public function store($id){
    	
    	
        $offer = Offer::where('id', $id)->get()->first();

    	$validated_attributes = request()->validate([
            'rating' => ['required','integer','between:1,5'],
            'description' => ['required','min:3', 'max:255'],
        ]);
    	$validated_attributes['user_id'] = auth()->id();
        $validated_attributes['offer_id'] = $offer->id;

    	$offer->addReview($validated_attributes);

    	return back();
    }

    public function destroy($id)
    {
    	
        $review = Review::where('id', $id);
        
        $review->delete();

        return back();
    }
}
