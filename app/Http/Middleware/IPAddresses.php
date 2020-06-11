<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\DB;
use Closure;
use Illuminate\Support\Facades\Log;

class IPAddresses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$results = DB::table('ip_whitelist')->where('ip_address', $request->ip())->get();
		
		$exists = 0;
		
		foreach($results as $row){
			
			if ($row->ip_address == $request->ip())
			{
				$exists++;
				Log::info($exists);
			}
		}
		
		if ($exists > 0){
			return $next($request);
		} else {
			abort(403);
		}
	
		return $next($request);
    }
}


