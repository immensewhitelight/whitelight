<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {

        return response()->json([

            'users' => \App\User::latest()->get()

        ], Response::HTTP_OK);
        
    }

}
