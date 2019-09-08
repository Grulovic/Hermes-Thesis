<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Order;

class RequestsController extends Controller
{
    public function __construct(){
        //$this->middleware('auth')->only(['index','store', 'update']);
        $this->middleware('auth');
    }

    public function index(){
        
        $page = Input::get('page', 1);
        $paginate = 20;
        // $requests = auth()->user()->orders();
        $requests = $this->search();
        $num_of_requests = $requests->count();
        $requests = $requests->orderBy('id','desc')->simplePaginate($paginate)->appends(request()->except('page'));
        $showing_leftover = ($num_of_requests < $page*$paginate) ? $num_of_requests : $page*$paginate;
        $showing_requests = ($paginate*($page -1)+1)."-".$showing_leftover;

        $show_request = Input::get('show');
        $request = null;
        $total_price = null;
        if($show_request!=null){
            $request= Order::where('id',$show_request)->get()->first();

            if($request!=null){
                abort_if(auth()->user()->id != $request->offers_user_id,403);    
            }else{
                abort(404);
            }

            $total_price = 0;
            foreach ($request->order_offers as $offer) {
                $total_price += $offer->order_price * $offer->qty;
            }
        }

        return view('requests.index',[
            'requests' => $requests,
            'showing_requests' => $showing_requests,
            'num_of_requests' => $num_of_requests,
            'show_request' => $request,
            'total_price' => $total_price,
        ]);

    }

    public function show(Order $request){
        abort_if(auth()->user()->id != $request->offers_user_id,403);    
        
        $total_price = 0;
        foreach ($request->order_offers as $offer) {
            $total_price += $offer->order_price * $offer->qty;
        }
        return view('requests.show', compact('request','total_price'));
    }

    public function edit(Order $request){
        abort_if(auth()->user()->id != $request->offers_user_id,403);    

        // return view('requests.edit', compact('request'));
    }

    public function update(Order $request){
        abort_if(auth()->user()->id != $request->offers_user_id,403);            
    	
		if (request()->status){
            $request->update(request()->validate([
                'status' => ['required','min:4', 'max:10', 'in:hold,processing,complete,closed,ordered,canceled'],
            ]));
        }

        if (request()->shipping_date || request()->delivery_date){
        
            $request->details->update(request()->validate([
                'shipping_date' => ['nullable','date','after_or_equal:today'],
                'delivery_date' => ['nullable','date','after_or_equal:shipping_date'],
            ]));
        }

        //return redirect("/requests/$request->id");
        return $request->id;
    }

    public function search(){
        // return dd(request()->name);
        // return dd(request()->statuses);
        // return dd(request()->payments);
        $requests = Order::where('offers_user_id',auth()->user()->id)->with('details','order_offers.offer','offers_user', 'user');
        $compiled = "";

        if(isset(request()->payments)){
            $requests->whereHas('details', function ($query) {
                $query->whereIn('payment', request()->payments);
            });
        }
        if(isset(request()->statuses)){
            $requests->whereIn('status', request()->statuses);
        }

        if(isset(request()->name)){
            $requests->where(function($query){
                    $query->where( function( $query ){
                    $query->whereHas('user', function ($query) {
                        $query->where('name', 'like', '%' . request()->name . '%');
                    })->orWhereHas('order_offers.offer', function ($query) {
                        $query->where('name', 'like', '%' . request()->name . '%');
                    });
                });
            });
        }

        // foreach ($requests->get() as $request) {
        //     $compiled .= view('requests.request')->with('request', $request)->render();
        // }

        // return $compiled;

        return $requests;
    }
}
