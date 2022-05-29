<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Cache;
use Carbon\Carbon;
use App\Models\UserDetail;

class LastUserActivity
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
        if(Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(1);
            Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
            $user_details = UserDetail::where('user_id',Auth::user()->id)->update(['last_visit' => Carbon::now()->toDateTimeString()]);
           
        }
        return $next($request);
    }
}
