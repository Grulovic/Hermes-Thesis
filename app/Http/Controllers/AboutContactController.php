<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutContactController extends Controller
{
    public function index(){
    	return view('about_contact.index',[
                "title" => "This is about / contact page",
            ]);
    }
}
