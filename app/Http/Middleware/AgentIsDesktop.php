<?php

namespace App\Http\Middleware;

use Closure;
use Agent;

class AgentIsDesktop
{
	protected $except = [
        //
		'incompatible',
    ];
    public function handle($request, Closure $next)
    {
    	
        if ( Agent::isDesktop() && !in_array($request->path(), $this->except)) 
        {
            return redirect()->guest(url('incompatible') ); 
        }
        
        return $next($request);
    }

}

