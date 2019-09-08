<?php
////////////////////////////////////////////
//  Stefan Grulovic - Final Year Thesis
//
// Offers Controller ->
// The offers controller deals with the offer page and all of its functionalities
//
// For any more information contact: stefan.grulovic@gmail.com
//
////////////////////////////////////////////
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;

use App\Offer;
use App\OfferImage;
use App\Category;
use App\User;


class OffersController extends Controller
{
    public function __construct(){
        //checking wether the user is authorized to use this controller and its functions
        $this->middleware('auth');
    }
    
    public function index(){
        
        //getting the users cart and compare lists
        $cart = $this->get_cart();
        $compare = $this->get_compare();

        //getting the categories from the database which are displayed to the user for to choose
        $categories = Category::where('group','offers')->where('parent_id', 0)->get();

        //getting the page which the user is on
        $page = Input::get('page', 1);
        //number of items per page
        $paginate = 20;
        //getting the orders based on the search settings
        $offers = $this->search()->orderBy('id','desc');
        //number of offers found from the search
        $num_of_offers = $offers->count();
        //showing items from to indicator
        $showing_leftover = ($num_of_offers < $page*$paginate) ? $num_of_offers : $page*$paginate;
        $showing_offers = ($paginate*($page -1)+1)."-".$showing_leftover;
        //getting user lists which are set for user to add the offer to those lists
        $lists = auth()->user()->lists;

        //min and max prices for the users search
        $price_min = Offer::min('price');
        $price_max = Offer::max('price');

        //pagination of the offers and page
        $offers = $offers->paginate($paginate)->appends(request()->except('page'));


        //returning the correct view with all the neccessary data
        return view('offers.index',[
            'offers' => $offers,
            'categories' => $categories,

            'cart_offers' => $cart['offers'],
            'cart_users' => $cart['users'],
            'compare_offers' => $compare['offers'],
            
            'lists' => $lists,

            'showing_offers' => $showing_offers,
            'num_of_offers' => $num_of_offers,

            'price_min' => $price_min,
            'price_max' => $price_max,

        ]);

    }
    
    //function to take user to the creation of the offer view/page
    public function create()
    {

        // return view('offers.create'); 
        return view('offers.create',[
            'categories' => Category::all()
        ]);
    }

    
    public function store(Request $request)
    {
        
        //getting and validatin the users entries for the creatin of the offer
        $validated_attribures= $this->validateOffer();

        //getting the images user uploaded
        $images = $request->images;
        unset($validated_attribures['images']);

        //adding the user id to the validated attributes
        $validated_attribures['user_id'] = auth()->id();
        //creatng the offer with the attributes user provided
        Offer::create($validated_attribures);

        //adding the newly offer created id to the image attributes
        $image_attribures['offer_id'] = Offer::latest()->first()->id;

        //if the user provided image contintu
        if($request->file('images')){
            //and for each of those images
            foreach ($request->images as $image) {
                // $image = $request->file('image');

                //store the images
                $extension = $image->getClientOriginalExtension();
                Storage::disk('public')->put($image->getFilename().'.'.$extension,  File::get($image));

                //and add these attributes to the databse for future retrevial of image
                $image_attribures['mime'] = $image->getClientMimeType();
                $image_attribures['original_file_name'] = $image->getClientOriginalName();
                $image_attribures['file_name'] = $image->getFilename().'.'.$extension;

                // dd($image_attribures);
                OfferImage::create($image_attribures);
            }
        }

        return redirect('/offers');
    }

    //function to go the single offer view/page
    public function show(Offer $offer)
    {   
        //get users cart and compare for its use on this page
        $cart = $this->get_cart();
        $compare = $this->get_compare();
        
        //return view with neccessary data
        return view('offers.show',[
            'offer' => $offer,
            'cart_offers' => $cart['offers'],
            'cart_users' => $cart['users'],
            'compare_offers' => $compare['offers'],
        ]);
    }

    //function to go to the edit page of the offer
    public function edit(Offer $offer)
    {
        //abort if the user is not the one who crated this offer
        abort_if(auth()->user()->id != $offer->user_id,403);

        //returng the view with neccessary data
        return view('offers.edit',[
            'offer' => $offer,
            'categories' => Category::all(),
        ]);
    }

    //function to get data from the edit page and update in database
    public function update(Offer $offer, Request $request)
    {
        //abort if the user is not the one whi created the offer
        abort_if(auth()->user()->id != $offer->user_id,403);
        
        //validatind the attributes 
        $validated_attribures= $this->validateOffer();
        $images = $request->images;
        unset($validated_attribures['images']);

        //and updating them
        if($request->file('images')){
            foreach ($offer->images as $image) {

                $image_path = public_path().'/uploads/'.$image->file_name;
                unlink($image_path);

                $image->delete(); 
            }

            foreach ($request->images as $image) {
                // $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                Storage::disk('public')->put($image->getFilename().'.'.$extension,  File::get($image));

                $image_attribures['offer_id'] = $offer->id;
                $image_attribures['mime'] = $image->getClientMimeType();
                $image_attribures['original_file_name'] = $image->getClientOriginalName();
                $image_attribures['file_name'] = $image->getFilename().'.'.$extension;

                // dd($image_attribures);
                OfferImage::create($image_attribures);
            }
        }

        unset($validated_attribures['image']);

        $offer->update($validated_attribures);

        return redirect('/offers');
    }

    //function for removing an offer
    public function destroy(Offer $offer)
    {
        //abort if the user is not the one who created it
        abort_if(auth()->user()->id != $offer->user_id,403);

        //for each of the images of offer delete
        foreach ($offer->images as $image) {

            $image_path = public_path().'/uploads/'.$image->file_name;
            unlink($image_path);

            $image->delete(); 
        }
    
        $offer->delete();

        return redirect('/offers');
    }

    //validation of offer database columns with each with their own setting of what should be inputted there
    public function validateOffer(){
        return request()->validate([
            'name' => ['required', 'min:3', 'max:25'],
            'category_id' => ['required','integer'],
            'description' => ['required', 'min:3', 'max:255'],
            'increment' => ['required', 'min:3', 'max:255', 'in:unit,service,hour,month,year'],
            'available' => ['required','integer'],
            'price' => ['required','numeric'],
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
    }

    //function for searching and filtering the offers
    public function search(){

        //getting all the offers
        $offers = Offer::with('user','category');

        //if user has provided something written in search bar based on that find corresponding offers
        if(isset(request()->name)){
            $offers->where(function($query){
                    $query->where('name', 'like', '%'.request()->name.'%')
                    ->orWhereHas('user', function($query){ 
                        $query->where('name', 'like', '%'.request()->name.'%')->orWhere('email', 'like', '%'.request()->name.'%');
                   })->orWhereHas('category', function($query){ 
                        $query->where('name', 'like', '%'.request()->name.'%');
                   });

                   });
        }

        //if user checked some categories show the offers which are in those categories
        if(isset(request()->categories)){
            $offers->whereIn('category_id', request()->categories);
        }

        // if the user provided price range show only offers whihc fall under the range
        if(isset(request()->range)){
            $offers->where('price', '<=' ,request()->range);
        }

        //iff the user wants to see their offers or other people offers
        if(isset(request()->show)){
            if(request()->show == "user"){
                $offers->where('user_id',auth()->user()->id);
            }
            else if(request()->show == "offers"){
                $offers->where('user_id', '!=' ,auth()->user()->id);
            }
        }

        return $offers;
    }

    //function for getting the cart offers and the users information for the display
    public function get_cart(){

        if (request()->session()->has('cart')) {
            if(!empty(request()->session()->get('cart'))){
                $cart['offers'] = Offer::whereIn('id', request()->session()->get('cart'))->get();
                $cart_users_ids = Offer::select('user_id')->distinct('user_id')->whereIn('id', request()->session()->get('cart'))->get()->toArray();
                $cart['users'] = array();
                foreach ($cart_users_ids as $user_id) {
                    array_push($cart['users'], User::where('id',$user_id['user_id'])->first());
                }
            }else{
                $cart['offers'] = null;
                $cart['users'] = null;
            }
        }else{
                $cart['offers'] = null;
                $cart['users'] = null;
        }

        return $cart;
    }

    //funtion for getting all the offers from the compare list
    public function get_compare(){
        if (request()->session()->has('compare')) {
            if(!empty(request()->session()->get('compare'))){
                $compare['offers'] = Offer::whereIn('id', request()->session()->get('compare'))->get();
            }else{
                $compare['offers'] = null;
            }
        }else{
                $compare['offers'] = null;
        }

        return $compare;
    }

}