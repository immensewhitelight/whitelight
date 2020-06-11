<?php

use Illuminate\Support\Facades\Route;
use App\Channel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});

*/

//get the posts with axios
Route::get('/postlist','PostController@index')->name('postlist');

//get the links with axios
Route::get('/links/{id}','PostController@getLinks')->name('links');

//get the channels for the chat
Route::get('/', function () {
    $channels = Channel::orderBy('name')->get();

    return view('welcome', compact('channels'));
});

//redirect to home to solve reload of /portal/{id} error
Route::get('/portal/{any}', function () {
    
    return redirect('/');
    
})->where('any', '.*');


//redirect to home to solve reload of /portal/{id} error
Route::get('/about', function () {
    
    return redirect('/');
    
})->where('any', '.*');

//redirect to home to solve reload of /portal/{id} error
Route::get('/source', function () {
    
    return redirect('/');
    
})->where('any', '.*');

//redirect to home to solve reload of /portal/{id} error
Route::get('/donate', function () {
    
    return redirect('/');
    
})->where('any', '.*');

//send messages to the chat
Route::post('/channels/{channel}/messages','ChatController@postMessage')->name('postMessage');


