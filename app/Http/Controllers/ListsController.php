<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\OfferList;

class ListsController extends Controller
{
    public function __construct(){
        //$this->middleware('auth')->only(['index','store', 'update']);
        $this->middleware('auth');
    }
    
    public function index(){
    	$lists = $this->search();
            
        $list = null;
        $offers = null;
        if(Input::get('show')!=null){

            $list = $this->show(Offerlist::where('id',Input::get('show'))->get()->first());
            // $list = $this->show(Input::get('show'));
            $offers = array();

            foreach ($list->items as $key => $item) {
                array_push($offers, $item->offer);
                $offers[$key]['item_id'] = $item->id;
            }
        }
        return view('lists.index',[
                "lists" => $lists,
                "list" => $list,
                "offers" => $offers,
        ]);
    }

    public function show(OfferList $list){

        abort_if(auth()->user()->id != $list->user_id,403);

    	$offers = array();

    	foreach ($list->items as $key => $item) {
    		array_push($offers, $item->offer);
    		$offers[$key]['item_id'] = $item->id;
    	}

    	// dd($offers);

    	return view('lists.show',[
                "list" => $list,
                "offers" => $offers,
        ]);
    }

    public function destroy(OfferList $list){
        abort_if(auth()->user()->id != $list->user_id,403);

    	$list->delete();
        // return redirect('/lists');
    }

    public function create()
    {
        // return view('lists.create')->render();
    }

    public function store(){
    	$validated_attributes = request()->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'description' => ['required', 'min:3', 'max:255'],
    	]);
    	
    	$validated_attributes['user_id'] = auth()->user()->id;

        OfferList::create($validated_attributes);

        return redirect('/lists');

    }

    public function search(){
        $lists = auth()->user()->lists();

        if(isset(request()->name)){
            $lists->where('name', 'like', '%'.request()->name.'%');
        }

        return $lists->get();
    }
}
