<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;


use App\User;
use App\UserDetails;
use App\Reply;


class UsersController extends Controller
{
    public function __construct(){
        //$this->middleware('auth')->only(['index','store', 'update']);
        $this->middleware('auth');
    }

    public function index()
    {
        $users = $this->search();

        $page = Input::get('page', 1);
        $paginate = 20;
        // $users = $users->orderBy('id','desc');
        $num_of_users = $users->count();
        $users = $users->orderBy('id','desc')->paginate($paginate)->appends(request()->except('page'));
        $showing_leftover = ($num_of_users < $page*$paginate) ? $num_of_users : $page*$paginate;
        $showing_users = ($paginate*($page -1)+1)."-".$showing_leftover;

        return view('users.index',[
            'users' => $users,
            'showing_users' => $showing_users,
            'num_of_users' => $num_of_users,
        ]);
    }

    public function create()
    {
        return redirect("/users");
    }

    public function store(Request $request)
    {
        //
    }

    // public function show($id)
    // {
    //     $user = User::select('id','name','email','type')->where('id',$id)->get()->first();

    //     return view('users.show', compact('user'));
    // }

    public function edit(User $user)
    {
        abort_if(auth()->user()->id != $user->id,403);    

        return view('users.edit',[
            'user' => $user,
        ]);
    }

    public function update(User $user)
    {
        abort_if(auth()->user()->id != $user->id,403);    

        
        if(request()->name){
            $user->update([
                'name' => request()->name,
            ]);
        }

        if(request()->description){
            $user->details->update([
                'description' => request()->description,
            ]);
        }

        if(request()->file('image')){
            $user_details = UserDetails::where('user_id', $user->id);
            $user_details_object = $user_details->latest()->first();

            if( $user_details_object->file_name != null){
                $image_path = public_path().'/uploads/'.$user_details_object->file_name;
                unlink($image_path);
            }

            $image = request()->image;
            
            // $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            Storage::disk('public')->put($image->getFilename().'.'.$extension,  File::get($image));

            $image_attribures['mime'] = $image->getClientMimeType();
            $image_attribures['original_file_name'] = $image->getClientOriginalName();
            $image_attribures['file_name'] = $image->getFilename().'.'.$extension;

            // dd($image_attribures);
            $user_details->update($image_attribures);
            
        }

        if(request()->email){
            $user->update([
                'email' => request()->email,
            ]);
        }

        if(request()->password){
            if(request()->password == request()->password_confirmation){
                $user->update([
                    'password' => Hash::make(request()->password),
                ]);    
            }else{
                return view('users.edit',[
                    'user' => $user,
                ])->withErrors(new \Illuminate\Support\MessageBag(['Passwords not matching...']));
            }
        }

        return redirect("/users/$user->id/edit");
    }

    public function destroy_avatar(User $user){

        // $user_details = UserDetails::where('user_id', $id);
        
        abort_if(auth()->user()->id != $user->id,403);    


        $image_path = public_path().'/uploads/'.$user->details->file_name;
        unlink($image_path);

        $image_attribures['mime'] = "";
        $image_attribures['original_file_name'] = "";
        $image_attribures['file_name'] = "";

        // dd($image_attribures);
        $user->details->update($image_attribures);
    }

    public function destroy($id)
    {
        //
    }
    
    public function show($id){
        $user = User::select('id','name','email','type')->where('id',$id)->get()->first();
        
        $compiled = view('users.show')->with('user', $user)->render();

        return $compiled;
    }

    public function showfull($id){
        $user = User::select('id','name','email','type')->where('id',$id)->get()->first();

        
            // $imageURL = public_path().'/uploads/'.$user->details->file_name;

            // $palletSize=[2,1];
            // $img = imagecreatefromjpeg($imageURL);
            // $imgSizes=getimagesize($imageURL);
            // $resizedImg=imagecreatetruecolor($palletSize[0],$palletSize[1]);
            // imagecopyresized($resizedImg, $img , 0, 0 , 0, 0, $palletSize[0], $palletSize[1], $imgSizes[0], $imgSizes[1]);

            // imagedestroy($img);

            // $colors=[];

            // for($i=0;$i<$palletSize[1];$i++)
            //     for($j=0;$j<$palletSize[0];$j++)
            //         $colors[]= dechex(imagecolorat($resizedImg,$j,$i));

            // imagedestroy($resizedImg);

            // //REMOVE DUPLICATES
            // $colors = array_unique($colors);


        if($user->type == "b"){
        $offers = $user->offers;
        // return view('users.showfull', compact('user', 'offers', 'threads', 'colors'));
        return view('users.showfull', compact('user', 'offers'));
        }
        else{
            // abort_if(!auth()->user()->areFriends($id),403);
            
            $offers = $user->offers;
            $threads = $user->threads;
            $lists = auth()->user()->lists;
            return view('users.showfull', compact('user', 'offers','threads','lists'));
        }

    }

    public function search(){
        $users = User::select('id','name','email','type')->with('details');

        if(isset(request()->types)){
            $users->whereIn('type', request()->types);
        }

        if(isset(request()->name)){
            $users->where('name', 'like', '%'.request()->name.'%')->orWhere('email', 'like', '%'.request()->name.'%');
        }

        return $users;
    }
}