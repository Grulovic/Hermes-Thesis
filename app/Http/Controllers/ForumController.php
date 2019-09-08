<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Thread;
use App\Reply;
use App\Category;

class ForumController extends Controller
{
    public function __construct(){
        //$this->middleware('auth')->only(['index','store', 'update']);
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::where('group','forum')->where('parent_id', 0)->get();


        $page = Input::get('page', 1);
        $paginate = 20;
        // $offers = Offer::paginate($paginate);
        $threads = $this->search()->orderBy('id','desc');
        $num_of_offers = $threads->count();
        $threads = $threads->simplePaginate($paginate)->appends(request()->except('page'));
        $showing_leftover = ($num_of_offers < $page*$paginate) ? $num_of_offers : $page*$paginate;
        $showing_offers = ($paginate*($page -1)+1)."-".$showing_leftover;

        $show_thread = Input::get('show');
        $form_categories = null;
        $thread = null;
        if($show_thread!=null){
            $thread = Thread::where('id', $show_thread)->get()->first();
            $form_categories = Category::where('group','forum')->get();
        }

        // dd($show_thread);

        return view('forum.index',[
            'threads' => $threads,
            'categories' => $categories,
            'showing_offers' => $showing_offers,
            'num_of_offers' => $num_of_offers,
            'show_thread' => $thread,
            'form_categories' => $form_categories,
        ]);
    }

    public function create()
    {
        $form_categories = Category::where('group','forum')->get();

        return view('forum.create',[
            'form_categories' => $form_categories,
        ]);
    }

    public function store()
    {

        $validated_attributes= $this->validateThread();

        $validated_attributes['user_id'] = auth()->id();

        $new_thread = Thread::create($validated_attributes);
        
        return $new_thread->id;
    }

    public function show($id)
    {

        $thread = Thread::where('id', $id)->get()->first();
        $form_categories = Category::where('group','forum')->get();
        
        // $this->authorize('view', $thread);
        return view('forum.show',[
            'thread' => $thread,
            'form_categories' => $form_categories,
        ]);
    }

    public function edit($id)
    {
        

        //$this->authorize('view', $project);
        $thread = Thread::where('id', $id)->get()->first();
        
        abort_if(auth()->user()->id != $thread->user_id,403);

        // return view('forum.edit', compact('thread'));
        $form_categories = Category::where('group','forum')->get();

        return view('forum.edit',[
            'thread' => $thread,
            'form_categories' => $form_categories,
        ]);
    }

    public function update($id)
    {
        $thread = Thread::where('id', $id)->get()->first();
        $validated_attributes = $this->validateThread();
        $thread->update($validated_attributes);
        //return redirect('/forum');
    }

    public function destroy($id)
    {
        $thread = Thread::where('id', $id)->get()->first();
        
        abort_if(auth()->user()->id != $thread->user_id,403);


        $thread->delete();

        $replies = Reply::where('thread_id', $id);
        $replies->delete();

        //return redirect('/forum');
    }

    public function validateThread(){
        return request()->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'category_id' => ['required','integer'],
            'description' => ['required', 'min:3', 'max:255'],
        ]);
    }

    public function search(){
        $threads = Thread::with('user','category');

        if(isset(request()->search)){
            $threads->where(function($query){
                    $query->where('name', 'like', '%'.request()->search.'%')
                    ->orWhereHas('user', function($query){ 
                        $query->where('name', 'like', '%'.request()->search.'%')->orWhere('email', 'like', '%'.request()->search.'%');
                   })
                    ->orWhereHas('category', function($query){ 
                        $query->where('name', 'like', '%'.request()->search.'%');
                   });
               });
        }

        if(isset(request()->categories)){
            $threads->whereIn('category_id', request()->categories);
        }

        if(isset(request()->show)){
            if(request()->show == "user"){
                $threads->where('user_id',auth()->user()->id);
            }
            else if(request()->show == "threads"){
                $threads->where('user_id', '!=' ,auth()->user()->id);
            }
        }
        


        // if(isset(request()->search)){
        //     $threads->where('name', $search_request)->orWhere('name', 'like', '%' . request()->search . '%');    
        // }

        // if(isset(request()->categories)){
        //     $threads->whereIn('category_id', request()->categories);
        // }
        
        // $compiled = "";
        // foreach ($threads->get() as $thread) {
        //     $compiled .= view('forum.thread')->with('thread', $thread)->render();
        // }

        // return $compiled;
        return $threads;
    }
}
