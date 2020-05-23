<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Post;

class PostController extends Controller
{
    public function index() {

   // $posts = Post::all();
    
   // return view('spa', ['posts' => $posts]);
   
   return response()->json([

            'posts' => \App\Post::latest()->get()

        ], Response::HTTP_OK);
    
}

	public function getLinks($id) {
		
			return response()->json([

            'post' => \App\Post::find($id)

        ], Response::HTTP_OK);
		      
}

}