<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Vid;


class VidController extends Controller
{
    public function index() {

        return response()->json([

            'vids' => \App\Vid::latest()->get()

        ], Response::HTTP_OK);
    
	}

	public function getVid($id) {
		
		return response()->json([

            'vid' => \App\Vid::find($id)

        ], Response::HTTP_OK);
		      
	}

}
