<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Order;
use App\OrderDetails;
use App\OrderOffers;
use App\Offer;

class OrdersController extends Controller
{
    public function __construct(){
        //$this->middleware('auth')->only(['index','store', 'update']);
        $this->middleware('auth');
    }

    public function index()
    {
        $page = Input::get('page', 1);
        $paginate = 20;
        // $orders = auth()->user()->orders();
        $orders = $this->search();
        $num_of_orders = $orders->count();
        $orders = $orders->orderBy('id','desc')->simplePaginate($paginate)->appends(request()->except('page'));
        $showing_leftover = ($num_of_orders < $page*$paginate) ? $num_of_orders : $page*$paginate;
        $showing_orders = ($paginate*($page -1)+1)."-".$showing_leftover;

        $show_order = Input::get('show');
        $order = null;
        $total_price = null;
        if($show_order!=null){
            $order= Order::where('id',$show_order)->get()->first();

            if($order!=null){
                abort_if(auth()->user()->id != $order->user_id,403);    
            }else{
                abort(404);
            }
            

            $total_price = 0;
            foreach ($order->order_offers as $offer) {
                $total_price += $offer->order_price * $offer->qty;
            }
        }

        return view('orders.index',[
            'orders' => $orders,
            'showing_orders' => $showing_orders,
            'num_of_orders' => $num_of_orders,
            'show_order' => $order,
            'total_price' => $total_price,
        ]);

    }

    public function create(Offer $offer)
    {

        return view('orders.create',[
            'offer' => $offer,
        ]);
    }

    public function store(){

        $validated_form = $this->validateOrder();

        // dd($validated_form);

        $offer = Offer::where('id', $validated_form['offer_id'])->get()->first();

        $order_attributes['user_id'] = auth()->id();
        $order_attributes['offers_user_id'] = $offer->user_id;
        $order_attributes['status'] = 'ordered';
        $order = Order::create($order_attributes);

        $order_details_attributes['order_id'] = $order->id;
        $order_details_attributes['payment'] = $validated_form['payment'];
        $order_details_attributes['shipper'] = 'shipper';
        $order_details_attributes['shipping_date'] = null;
        $order_details_attributes['delivery_date'] = null;
        OrderDetails::create($order_details_attributes);

        $order_offer_attributes['order_id'] = $order->id;
        $order_offer_attributes['offer_id'] = $offer->id;
        $order_offer_attributes['qty'] = $validated_form['qty'];
        $order_offer_attributes['order_price'] = $offer->price;
        OrderOffers::create($order_offer_attributes);

        return redirect("/orders?show=".$order->id);
    }

    public function store_cart(){

        $validated_form = $this->validateOrders();
        
        $first_offer = Offer::where('id', $validated_form['offers'][0])->get()->first();

        $order_attributes['user_id'] = auth()->id();
        $order_attributes['offers_user_id'] = $first_offer->user_id;
        $order_attributes['status'] = 'ordered';
        $order = Order::create($order_attributes);

        $order_details_attributes['order_id'] = $order->id;
        $order_details_attributes['payment'] = $validated_form['payment'];
        $order_details_attributes['shipper'] = 'shipper';
        $order_details_attributes['shipping_date'] = null;
        $order_details_attributes['delivery_date'] = null;
        OrderDetails::create($order_details_attributes);

        $cart_items = request()->session()->get('cart');
        $order_offer_attributes['order_id'] = $order->id;
        for ($i=0; $i < sizeof($validated_form['offers']); $i++) {
            $offer_id = $validated_form['offers'][$i];
            $qty = $validated_form['qtys'][$i];
            
            $offer_object = Offer::where('id', $offer_id)->get()->first();

            $order_offer_attributes['offer_id'] = $offer_id;
            $order_offer_attributes['qty'] = $qty;
            $order_offer_attributes['order_price'] = $offer_object->price;
            OrderOffers::create($order_offer_attributes);   

            foreach ($cart_items as $key => $item) {
                if($item == $offer_id){
                    request()->session()->forget('cart.'.$key);
                }
            }
        }
        // return redirect("/orders");
        return $order->id;
    }

    public function show(Order $order)
    {
        abort_if(auth()->user()->id != $order->user_id,403);

        $total_price = 0;
        foreach ($order->order_offers as $offer) {
            $total_price += $offer->order_price * $offer->qty;
        }
        return view('orders.show', compact('order','total_price'));
    }

    public function edit(Order $order)
    {
        abort_if(auth()->user()->id != $order->user_id,403);    

        return view('orders.edit', compact('order'));
    }


    public function update(Order $order){

        abort_if(auth()->user()->id != $order->user_id,403);    

        $validated_form = $this->validateOrders();

        foreach ($validated_form['offers'] as $key => $order_offer_id) {
            $order_offer_qty = $validated_form['qtys'][$key];

            $order_offer = OrderOffers::where('id',$order_offer_id);

            $order_offer->update([
                'qty' => $order_offer_qty,
            ]);
        }

        $order->details->update([
            'payment' => $validated_form['payment'],
        ]);
        // return request()->qtys;

        // if (request()->qty || request()->payment){
        //     $qty_available = Offer::select('available')->where('id',$order->offer->id)->get()->first()->available;

        //     $order->details->update(request()->validate([
        //         'qty' => ['required', 'integer', "max:$qty_available", 'min:0'],
        //         'payment' => ['required','min:4', 'max:6', 'in:card,cash,paypal'],
        //     ]));
        // }

        return $order->id;
    }

    public function destroy(Order $order)
    {
        abort_if(auth()->user()->id != $order->user_id,403);    

        $order->update(['status' => 'canceled']);

        //return redirect("/orders/$order->id");
    }

    public function validateOrder(){
        $qty_available = Offer::select('available')->where('id',request()->offer_id)->get()->first()->available;

        return request()->validate([
            'offer_id' => ['required','integer'],
            'qty' => ['required', 'integer', "max:$qty_available", 'min:0'],
            'payment' => ['required', 'min:4', 'max:6', 'in:card,cash,paypal'],
        ]);
    }

    public function validateOrders(){

        return request()->validate([
            'offers.*' => ['required','integer'],
            'qtys.*' => ['required', 'integer', 'min:0'],
            'payment' => ['required', 'min:4', 'max:6', 'in:card,cash,paypal'],
        ]);
    }

    public function search(){
        // return dd(request()->name);
        // return dd(request()->statuses);
        // return dd(request()->payments);
        $orders = Order::where('user_id',auth()->user()->id)->with('details','order_offers.offer','offers_user');
        $compiled = "";

        if(isset(request()->payments)){
            $orders->whereHas('details', function ($query) {
                $query->whereIn('payment', request()->payments);
            });
        }

        if(isset(request()->statuses)){
            $orders->whereIn('status', request()->statuses);
        }

        if(isset(request()->name)){
            $orders->where(function($query){
                    $query->where( function( $query ){
                    $query->whereHas('offers_user', function ($query) {
                        $query->where('name', 'like', '%' . request()->name . '%');
                    })->orWhereHas('order_offers.offer', function ($query) {
                        $query->where('name', 'like', '%' . request()->name . '%');
                    });
                });
            });
        }
        // foreach ($orders->get() as $order) {
        //     $compiled .= view('orders.order')->with('order', $order)->render();
        // }

        // return $compiled;

        return $orders;
    }
}
