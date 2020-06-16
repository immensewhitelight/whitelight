<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Assorted;

class AssortedController extends Controller
{
    public function index() {

        return response()->json([

            'assorteds' => \App\Assorted::latest()->get()

        ], Response::HTTP_OK);
    
	}

	public function getAssorted($id) {
		
		return response()->json([

            'assorted' => \App\Assorted::find($id)

        ], Response::HTTP_OK);
		      
	}

}
