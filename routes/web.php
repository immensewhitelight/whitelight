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

//send messages to the chat
Route::post('/channels/{channel}/messages','ChatController@postMessage')->name('postMessage')->middleware('whitelist');

//get the posts with axios
Route::get('/postlist','PostController@index')->name('postlist');

//get the links with axios
Route::get('/links/{id}','PostController@getPost')->name('links');

//get the videos with axios
Route::get('/videolist','VideoController@index')->name('videolist');

//get the vlinks with axios
Route::get('/vlinks/{id}','VideoController@getVideo')->name('vlinks');

//get the vids with axios
Route::get('/vidlist','VidController@index')->name('vidlist');

//get the assorteds with axios
Route::get('/assortedlist','AssortedController@index')->name('assortedlist');

//get the vlinks with axios
Route::get('/alinks/{id}','AssortedController@getAssorted')->name('alinks');


//get the channels for the chat
Route::get('/', function () {
    $channels = Channel::orderBy('name')->get();

    return view('welcome', compact('channels'));
});

//redirect to home to solve reload error
Route::get('/portal/{any}', function () {
    
    return redirect('/');
    
})->where('any', '.*');

//redirect to home to solve reload error
Route::get('/about', function () {
    
    return redirect('/');
    
})->where('any', '.*');

//redirect to home to solve reload error
Route::get('/vportal/{any}', function () {
    
    return redirect('/');
    
})->where('any', '.*');

//redirect to home to solve reload error
Route::get('/aportal/{any}', function () {
    
    return redirect('/');
    
})->where('any', '.*');

//redirect to home to solve reload error
Route::get('/source', function () {
    
    return redirect('/');
    
})->where('any', '.*');

//redirect to home to solve reload error
Route::get('/donate', function () {
    
    return redirect('/');
    
})->where('any', '.*');

