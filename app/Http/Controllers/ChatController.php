<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Message;
use App\Channel;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Log;
use App\Events\TestEvent;

class ChatController extends Controller
{
   public function getMessages($channel) {
		
  
    
	}
	
	
	public function postMessage($channel) {
		
		$validatedData = $request->validate([
        'message' => 'max:555|regex:/(^([a-zA-z]+)(\d+)?$)/u',
        ]);
	
		//Sends to Redis only
		$message = [
        'channel_id' => $channel,
        'username' => request('username'),
        'message' => request('message'),
		];
		
		
		// Dispatch an event. Will be broadcasted over Redis.
		event(new MessageSent($channel, $message));
		
		return $message;
        
	}
	
}
