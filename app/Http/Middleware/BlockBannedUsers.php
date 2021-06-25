<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockBannedUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->banned_at) {
            return redirect()->route('home')->with('status', [
                'type' => 'error',
                'msg' => 'Você está banido de cadastrar e realizar modificações.'
            ]);
        }

        return $next($request);
    }
}
