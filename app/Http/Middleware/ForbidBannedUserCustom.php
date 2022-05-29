<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;
use App\Models\UserDetail;

class ForbidBannedUserCustom
{
    /**
     * The Guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;


    /**
     * @param \Illuminate\Contracts\Auth\Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $this->auth->user();
        $user_details = UserDetail::where('user_id',$user->id)->first();
        
        if ($user && $user->isBanned()) {
            \Session::flush();
            $expired_at = Carbon::parse($user->bans->sortByDesc('id')->values()[0]->expired_at);
            $expired_at = $expired_at->diffInHours(Carbon::now()).'h '.$expired_at->diff(Carbon::now())->format('%Im');
            return response()->json([
                'status' => 'ban',
                'message' => trans('messages.banned'),
                'expired_at' => $expired_at
            ]);
        }
        else if($user && $user->blocked)
        {
            \Session::flush();
            return response()->json([
                'status' => 'ban',
                'message' => 'You are banned for not adhering to the app`s policy Or bypassing public morals',
            ]);
        }

        return $next($request);
    }
}
