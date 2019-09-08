<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Conversation;
use App\Participant;
use App\Message;

class ConversationsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        // $messages= Message::all();

        // foreach ($messages as $key => $message) {

        //     $message->update(['text' => decrypt($message->text)]);
        // }


        $page = Input::get('page', 1);
        $paginate = 15;
        // $offers = Offer::paginate($paginate);
        $participations = $this->search();

        $num_of_participations = $participations->count();
        $participations = $participations->simplePaginate($paginate)->appends(request()->except('page'));
        $showing_leftover = ($num_of_participations < $page*$paginate) ? $num_of_participations : $page*$paginate;
        $showing_participations = ($paginate*($page -1)+1)."-".$showing_leftover;

        $show_conversation = Input::get('show');
        $conversation = null;
        $participants = null;
        $messages = null;

        if($show_conversation!=null){
            $conversation= Conversation::where('id',$show_conversation)->get()->first();
            $participants = Participant::where('conversation_id', $show_conversation)->get();

            $user_in_conversation = false;

            foreach ($participants as $key => $participant) {
                if($participant->user_id == auth()->user()->id){
                    $user_in_conversation = true;
                }
            }

            if(!$user_in_conversation){
                abort(403);
            }
            
            $messages = array();

            foreach ($conversation->messages as $key => $message) {
                if($key == 0 ){
                    // $previous = $message->user_id;
                    $previous = null;
                }

                array_push($messages, $message);
                $messages[$key]['previous_user_id'] = $previous;

                $previous = $message->user_id;
            }
        }


        return view('conversations.index',[
            'participations' => $participations,
            'showing_participations' => $showing_participations,
            'num_of_participations' => $num_of_participations,
            'conversation' => $conversation,
            'participants' => $participants,
            'messages' => $messages,
        ]);
    }

    // public function create($id=null)
    // {
    //     if($id){
    //         //dd("here: $id");    
    //         $conversation_attributes['user_id'] = auth()->user()->id;
    //         // $conversation_attributes['type'] = "direct";
    //         Conversation::create($conversation_attributes);

    //         $attributes['user_id'] = $id;
    //         $conversation_id = Conversation::latest()->first()->id;    
    //         $attributes['conversation_id'] = $conversation_id;    
    
    //         Participant::create($attributes);

    //         $attributes['user_id'] = auth()->user()->id;
    //         Participant::create($attributes);

    //         return redirect("/conversations/$conversation_id");
    //     }else{
    //         return view('conversations.create');
    //     }
    // }
    public function messageUser($user_id){
        
        $conversation_attributes['user_id'] = auth()->user()->id;
        $conversation = Conversation::create($conversation_attributes);

        $attributes['user_id'] = $user_id;
        $attributes['conversation_id'] = $conversation->id;    
        
        Participant::create($attributes);

        $attributes['user_id'] = auth()->user()->id;
        Participant::create($attributes);

        return $conversation->id;
    }

    public function create()
    {
        return view('conversations.create')->render();
    }

    public function store()
    {

        $participants = $this->validateUsers();
        
        if(isset(request()->name)){
            $validated_name = request()->validate([
                'name' => ['min:3', 'max:25'],
            ]);
            $conversation_attributes['name'] = $validated_name['name'];
        }

        if(sizeof($participants) != 0){
            $conversation_attributes['user_id'] = auth()->user()->id;

            array_push($participants, auth()->user()->id);

            Conversation::create($conversation_attributes);

            foreach ($participants as $user_id) {
                $attributes['user_id'] = $user_id;    
                $attributes['conversation_id'] = Conversation::latest()->first()->id;    
                
                Participant::create($attributes);
            }
            
        }

        //return redirect('/conversations');
    }

    public function show($id)
    {   

        // abort(403);

        //return view('conversations.create')->render();
        $conversation= Conversation::where('id',$id)->get()->first();
        $participants = Participant::where('conversation_id', $id)->get();

        $user_in_conversation = false;

        foreach ($participants as $key => $participant) {
            if($participant->user_id == auth()->user()->id){
                $user_in_conversation = true;
            }
        }

        if(!$user_in_conversation){
            abort(403);
        }

        $messages = array();

        foreach ($conversation->messages as $key => $message) {
            if($key == 0 ){
                // $previous = $message->user_id;
                $previous = null;
            }

            array_push($messages, $message);
            $messages[$key]['previous_user_id'] = $previous;

            $previous = $message->user_id;
        }


        $compiled = view('conversations.show')
                    ->with('conversation', $conversation)
                    ->with('participants',$participants)
                    ->with('messages', $messages)
                    ->render();

        return $compiled;
        //return view('conversations.show', compact('conversation'));
    }

    public function edit($id)
    {
        $participants = Participant::where('conversation_id', $id)->get();
        $compiled = view('conversations.edit')->with('participants', $participants)->render();
        
        return $compiled;
    }


    public function update()
    {
        //return redirect('/conversations');
    }

    public function destroy(Conversation $conversation)
    {

        $participants = Participant::where('conversation_id', $conversation->id);
        $participants->delete();

        $messages = Message::where('conversation_id', $conversation->id);

        $messages->delete();

        $conversation->delete();

        // return redirect('/conversations');
    }
    
    public function validateUsers(){

        
        ////error when entering null values
        
        $conversation_users = Input::get('participants');

        // array_filter($conversation_users);
        // dd($conversation_users);

        foreach ($conversation_users as $key => $user_id) {
            
            $exists = auth()->user()->where('id', $user_id)->count();

            if ( $exists == 0) {
                // $error = \Illuminate\Validation\ValidationException::withMessages([
                //    'field_name_1' => ["The user doesn't exist!"],
                // ]);
                // throw $error;

                unset($conversation_users[$key]);
            }else if( auth()->user()->id == $user_id ){
                // $error = \Illuminate\Validation\ValidationException::withMessages([
                //    'field_name_1' => ["You cant add yourself!"],
                // ]);
                // throw $error;
                
                unset($conversation_users[$key]);
            }
        }

        $unique_conversation_users = array_unique($conversation_users);

        return $unique_conversation_users;
        
    }

    public function edit_search(){
        // $search_results = auth()->user()->friends()->with('user')->where('status','approved')->where('name', 'like', '%' . request()->name . '%')->get();

        // // dd($friends->get());
        // $search_results = array();
        // foreach ($friends as $key => $friend) {
        //     // dd($friend->user);
        //     array_push($search_results, $friend->user);
        // }
        // // dd($search_results);

        $search_results = User::where('name', 'like', '%' . request()->name . '%')->take(5)->get();

        // dd($search_results);

        $compiled = view('conversations.edit_search')->with('search_results', $search_results)->render();
        return $compiled;
    }

    public function create_search(){
        $search_results = User::where('name', 'like', '%' . request()->name . '%')->take(5)->get();
        $compiled = view('conversations.create_search')->with('search_results', $search_results)->render();
        return $compiled;
    }

    public function search(){
        $participations = auth()->user()->participations()->with('conversation','user','conversation.participants');

        if(isset(request()->search)){
            $participations->whereHas('conversation', function ($query) {
                    $query->where('name', 'like', '%' . request()->search . '%')->orWhereHas('participants', function ($query) {
                            $query->whereHas('user', function ($query) {
                            $query->where('name', 'like', '%' . request()->search . '%')->orWhere('email', 'like', '%' . request()->search . '%');    
                        });    

                        });    
                });
            // $participations->whereHas('conversation.participants.user', function($query){ 
            //     dd($query);
            //         $query->where('name', 'like', '%' . request()->name . '%');
            // });
        }

        return $participations;
    }
}
