<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Video;

class VideoController extends Controller
{
    public function index() {

        return response()->json([

            'videos' => \App\Video::latest()->get()

        ], Response::HTTP_OK);
    
	}

	public function getVideo($id) {
		
		return response()->json([

            'video' => \App\Video::find($id)

        ], Response::HTTP_OK);
		      
	}

}
