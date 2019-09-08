<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OfferList;
use App\OfferListItem;

class ListItemsController extends Controller
{
    public function __construct(){
        //$this->middleware('auth')->only(['index','store', 'update']);
        $this->middleware('auth');
    }
    
    public function store($id){
        
        $list = OfferList::where('id', $id)->get()->first();

        $validated_attributes = request()->validate([
            'offer_id' => ['required','integer'],
        ]);

        $validated_attributes['list_id'] = $list->id;

        $exists = OfferListItem::where('offer_id',$validated_attributes['offer_id'])->where('list_id',$list->id)->first();

        if($exists == null){
            $list->addItem($validated_attributes);
        }else{
            $exists->delete();
        }
        
        return back();
    }

    public function destroy($id){
        $item = OfferListItem::where('id', $id);
        
        $item->delete();

        return back();
    }
}
