<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\PlanPackage;
use App\Models\Subscription;
use App\Models\UserDetail;
use App\Models\SettingText;
use App\Http\Resources\PlansResource;
use Auth;
use Carbon\Carbon;

class PlansController extends Controller
{
    public function index()
    {
        $plans = Plan::with('packages')->get();
        $user_id = Auth::user()->id;
        if(Subscription::where('user_id',$user_id)->count() == 0){
            $free_trial = SettingText::where('key','free_trial')->first()->value;
        }else{
            $free_trial = 0;
        }
        return response()->json([
            'plans' => PlansResource::collection($plans),
            'free_trial' => $free_trial
        ]);
    }

    public function free_trial($plan_id)
    {
        $user_id = Auth::user()->id;
        $subscription = Subscription::where('user_id',$user_id)
                                    ->where('subscriptable_type','App\Models\plan')
                                    ->where('subscriptable_id',$plan_id)
                                    ->where('is_trial',1)
                                    ->get();

        if(count($subscription) == 0){
            $sub = new Subscription;
            $sub->user_id = $user_id;
            $sub->subscriptable_type = 'App\Models\plan';
            $sub->subscriptable_id = $plan_id;
            $sub->price = 0;
            $sub->is_trial = 1;
            $sub->ends_at = Carbon::now()->addDays(1);
            $sub->save();

            $user = UserDetail::where('user_id',$user_id)->first();
            $user->plan_id = $plan_id;
            $user->update();

            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
