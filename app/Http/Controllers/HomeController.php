<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Offer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        if($user->type == "c"){

            $categories = $this->categories();

            // array_multisort($categories, SORT_DESC);

            // dd($categories);
            if(isset($categories[0]['id'])){
                $most_ordered_category = $categories[0]['id'];
            }else{
                $most_ordered_category = mt_rand(1, 99);
            }

            // dd($categories);
            // dd($most_ordered_category);

            // $recommendations = Offer::where('category_id', $most_ordered_category)->take(5)->get();
            $recommendations = Offer::where('category_id', $most_ordered_category)->get();
            // dd($offers);

            $lists = $user->lists;

            return view('home',[
                // 'categories'=> $categories,
                'recommendations'=> $recommendations,
                'lists'=> $lists,
                // ''=> ,
            ]);

        }else{
            // dd($this->offers());
            // dd($this->month_orders());
            // dd($this->customers());

            return view('home',[
                
            ]);
        }


    }

    public function categories(){
        $user = auth()->user();
        
        $categories = array();
            foreach ($user->orders as $key => $order) {
                foreach ($order->order_offers as $key => $order_offer) {
                    $category = $order_offer->offer->category;

                    if(isset($categories[$category->id])){
                        $categories[$category->id]['count'] = $categories[$category->id]['count'] + 1;
                    }else{
                        $categories[$category->id]['id'] = $category->id;
                        $categories[$category->id]['name'] = $category->name;
                        $categories[$category->id]['count'] = 1;
                    }

                }
            }
            // arsort($categories);

            $count  = array_column($categories, 'count');

            array_multisort($count, SORT_DESC, $categories);


        return $categories;
    }



    public function chart_names(){
        $categories = $this->categories();

        $category_names = array();
        foreach ($categories as $key => $category) {
            array_push($category_names, $categories[$key]['name']);
        }    

        return response()->json($category_names);
        // return $category_names;
    }

    public function chart_counts(){
        $categories = $this->categories();

        $category_counts = array();
        foreach ($categories as $key => $category) {
            array_push($category_counts, $categories[$key]['count']);
    
        }

        return response()->json($category_counts);
        // return $category_counts;
    }



    public function customers(){
        $user = auth()->user();

        $customers = array();


        foreach ($user->requests as $key => $request) {
            $customer = $request->user;

            if(isset($customers[$customer->id])){
                $customers[$customer->id]['count'] = $customers[$customer->id]['count'] + 1;

            }else{
                $customers[$customer->id]['id'] = $customer->id;
                $customers[$customer->id]['name'] = $customer->name;
                $customers[$customer->id]['count'] = 1;
            }
        }

        $count  = array_column($customers, 'count');

        array_multisort($count, SORT_DESC, $customers);

        return $customers;
    }

    public function offers(){
        $user = auth()->user();

        $offers = array();


        foreach ($user->requests as $key => $request) {

            foreach ($request->order_offers as $key => $order_offer) {
                $offer = $order_offer->offer;

                if(isset($offers[$offer->id])){
                    $offers[$offer->id]['qty'] = $offers[$offer->id]['qty'] + $order_offer->qty;
                    $offers[$offer->id]['count'] = $offers[$offer->id]['count'] + 1;

                }else{
                    $offers[$offer->id]['id'] = $offer->id;
                    $offers[$offer->id]['name'] = $offer->name;
                    $offers[$offer->id]['price'] = $offer->price;
                    $offers[$offer->id]['count'] = 1;
                    $offers[$offer->id]['qty'] = $order_offer->qty;
                }

            }
        }

        foreach ($offers as $key => $offer) {
            $offers[$key]['revenue'] = $offers[$key]['price']*$offers[$key]['qty'];
        }

        $count  = array_column($offers, 'count');

        array_multisort($count, SORT_DESC, $offers);

        return $offers;
    }

    public function chart_customers(){
        $customers = $this->customers();

        $customer_names = array();
        foreach ($customers as $key => $customer) {
            array_push($customer_names, $customers[$key]['name']);
        }    

        return response()->json($customer_names);
        // return $category_names;
    }

    public function chart_orders(){
        $customers = $this->customers();

        $customer_orders = array();
        foreach ($customers as $key => $customer) {
            array_push($customer_orders, $customers[$key]['count']);
        }    

        return response()->json($customer_orders);
        // return $category_names;
    }

    public function chart_offers(){
        $offers = $this->offers();

        $offer_names = array();
        foreach ($offers as $key => $offer) {
            array_push($offer_names, $offers[$key]['name']);
        }    

        return response()->json($offer_names);
    }
    public function chart_offers_qtys(){
        $offers = $this->offers();

        $offer_qtys = array();
        foreach ($offers as $key => $offer) {
            array_push($offer_qtys, $offers[$key]['qty']);
        }    

        return response()->json($offer_qtys);
    }

    public function month_orders(){
        $user = auth()->user();

        $month_orders =[
            'Jan' => 0,
            'Feb' => 0,
            'Mar' => 0,
            'Apr' => 0,
            'May' => 0,
            'Jun' => 0,
            'Jul' => 0,
            'Aug' => 0,
            'Sep' => 0,
            'Oct' => 0,
            'Nov' => 0,
            'Dec' => 0
        ];

        foreach ($user->requests as $key => $request) {
            $month = date("M",strtotime($request->created_at));


            foreach ($request->order_offers as $key => $order_offer) {
                $month_orders[$month] = $month_orders[$month] + 1;
            }
        }

        return $month_orders;

    }

    public function chart_months(){
        $months = $this->month_orders();

        $month_names = array();
        foreach ($months as $key => $month) {
            array_push($month_names, $key);
        }    

        return response()->json($month_names);
    }

    public function chart_months_orders(){
        $months = $this->month_orders();

        $months_orders = array();
        foreach ($months as $key => $month) {
            array_push($months_orders, $month);
        }    

        return response()->json($months_orders);
    }

}
