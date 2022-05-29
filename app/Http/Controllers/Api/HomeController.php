<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SettingText;
use App\Models\Like;
use App\Models\Plan;
use App\Models\PlanPackage;
use App\Models\UserDetail;
use App\Models\Subscription;
use App\Models\Block;
use App\Helpers\ListHelper;
use Carbon\Carbon;
use Auth;
use App\Http\Resources\UserResource;
use App\Http\Resources\OnboardingResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Google\Cloud\Firestore\FirestoreClient;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user()->details;
        //update location
        if(request()->has('lat') && request()->has('long') && $user->location == 1){
            $user->latitude = request()->lat != 0 ?request()->lat : $user->residence_latitude;
            $user->longitude = request()->long != 0 ?request()->lat : $user->residence_longitude;
            $user->save();
        }
        $users = ListHelper::nearby_users($user);
        //hide blocked users
        $blocked = ListHelper::blocked_users();
        $users = $users->whereNotIn('user_id',$blocked);

        $vip = $users->where('plan_id',3)->take(40);
        $vip = count($vip) < 20 ? $vip->random(count($vip)) : $vip->random(20);

        $special_people = $users->where('plan_id',2)->where('profile_progress','>',70)->where('last_visit','>=',Carbon::now()->subWeek()->toDateTimeString())->take(40);
        $special_people = count($special_people) < 6 ? $special_people->random(count($special_people)) : $special_people->random(6);

        $interested_in = $users->whereIn('plan_id',[1,2])->take(40);
        $interested_in = count($interested_in) < 6 ? $interested_in->random(count($interested_in)) : $interested_in->random(6);

        $new_people = $users->where('created_at','>',Carbon::now()->subWeek())->take(6);

        $likes_list = Like::where('to_user',$user->user_id)->pluck('from_user')->toArray();
        $liked_users = $users->whereIn('user_id',$likes_list);

        return response()->json([
            'vip' => UserResource::collection($vip),
            'special_people' => UserResource::collection($special_people),
            'interested_in' => UserResource::collection($interested_in),
            'new_people' => UserResource::collection($new_people),
            'profile_progress' => $user->profile_progress,
            'liked_you' => UserResource::collection($liked_users)
            
        ]);
    }

    public function onboarding($lang)
    {   
        if($lang == 'en'){
            $onboarding1 = SettingText::where('key','onboarding1')->first()->value;
            $onboarding2 = SettingText::where('key','onboarding2')->first()->value;
            $onboarding3 = SettingText::where('key','onboarding3')->first()->value;
            $onboarding4 = SettingText::where('key','onboarding4')->first()->value;
        }else{
            $onboarding1 = SettingText::where('key','onboarding1')->first()->ar_value;
            $onboarding2 = SettingText::where('key','onboarding2')->first()->ar_value;
            $onboarding3 = SettingText::where('key','onboarding3')->first()->ar_value;
            $onboarding4 = SettingText::where('key','onboarding4')->first()->ar_value;
        }

        
        return response()->json([
            new OnboardingResource(json_decode($onboarding1)),
            new OnboardingResource(json_decode($onboarding2)),
            new OnboardingResource(json_decode($onboarding3)),
            new OnboardingResource(json_decode($onboarding4)),
        
        ]);
    }

    public function privacy_policy()
    {
        $privacy_policy = SettingText::where('key','privacy_policy')->first()->value;
        return response()->json([
            'privacy_policy' =>  $privacy_policy,
        ]);
    }

    public function see_all_vip()
    {
        $user = Auth::user()->details;
        $users = ListHelper::nearby_users($user);
        //hide blocked users
        $blocked = ListHelper::blocked_users();
        $users = $users->whereNotIn('user_id',$blocked);

        $vip = $users->where('plan_id',3);

        return response()->json([
            'vip' => UserResource::collection($vip)
        ]);
    }

    public function see_all_special_people()
    {
        $user = Auth::user()->details;
        $users = ListHelper::nearby_users($user);
        //hide blocked users
        $blocked = ListHelper::blocked_users();
        $users = $users->whereNotIn('user_id',$blocked);

        $special_people = $users->where('plan_id',2)->where('profile_progress','>',70)->where('last_visit','>=',Carbon::now()->subWeek()->toDateTimeString());

        return response()->json([
            'special_people' => UserResource::collection($special_people)
        ]);
    }

    public function see_all_new_people()
    {
        $user = Auth::user()->details;
        $users = ListHelper::nearby_users($user);
        //hide blocked users
        $blocked = ListHelper::blocked_users();
        $users = $users->whereNotIn('user_id',$blocked);

        $new_people = $users->where('created_at','>',Carbon::now()->subWeek());

        return response()->json([
            'new_people' => UserResource::collection($new_people)
        ]);
    }

    public function about_us()
    {
        $about_us = SettingText::where('key','about_us')->first()->value;
        return response()->json([
            'about_us' =>  $about_us,
        ]);
    }

    public function usage_policy()
    {
        $usage_policy = SettingText::where('key','usage_policy')->first()->value;
        return response()->json([
            'usage_policy' =>  $usage_policy,
        ]);
    }

    public function plan_payment_form($plan_id,$method)
    {
        $user = auth()->user()->id;
        
        if(request()->has('package_id'))
        {
            $package_id = request()->package_id;
        }else{
            $package_id = 0;
        }

        if($method == 'apple' || $method == 'google'){
            return response()->json([
                'url' => route('plan.form', ['user' => $user , 'plan_id' => $plan_id ,'package_id' => $package_id])
            ]);    
        }else{
            if(request()->has('package_id')){

                $item = PlanPackage::find(request()->package_id);
                $item_type = 'package';

            }else{
                $item = Plan::find($plan_id);
                $item_type = 'plan';
            }
            $user = User::find($user);
            $user_plan = UserDetail::where('user_id',$user->id)->first()->plan_id;

            if($item_type == 'plan' && $user_plan == $item->id){
                $subs = Subscription::where('user_id',$user->id)->orderBy('id','Desc')->first();
                if($subs){
                    if($subs->status == 1){
                        $end = Carbon::parse($subs->ends_at)->addMonth(); 
                    }
                }
                
            }elseif($item_type == 'package' && $user_plan == $item->plan_id){
                $subs = Subscription::where('user_id',$user->id)->orderBy('id','Desc')->first();
                if($subs){
                    if($subs->status == 1){
                        $end = Carbon::parse($subs->ends_at)->addMonths($item->months); 
                    }
                }
                
            }
            $subs = new Subscription;
            $subs->user_id = $user->id;
            $subs->subscriptable_type = $item_type == 'plan' ? 'App\Models\Plan' : 'App\Models\PlanPackage';
            $subs->subscriptable_id = $item->id;
            $subs->price = $item->price;
            $subs->payment_method = 'myfatoorah';
            $subs->ends_at = isset($end) ? $end : ( $item_type == 'plan' ? Carbon::now()->addMonth() : Carbon::now()->addMonths($item->months) );
            $subs->save();
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL',
                'accept' => 'application/json'
            ])->asForm()->post('https://apitest.myfatoorah.com/v2/ExecutePayment',[
                'InvoiceValue' => $item->price,
                'CustomerName' => $user->name,
                // 'CustomerEmail' => $user->email,
                'PaymentMethodId' => 2,
                "DisplayCurrencyIso" => "USD",
                "CallBackUrl" => url('/success/payment/plan/'.$plan_id.'/'.$user->id.'?method=myfatoorah&sub_id='.$subs->id),
                "ErrorUrl" => url('/error/payment?method=myfatoorah&sub_id='.$subs->id),
            ]);

            return response()->json([
                'url' => $response->object()->Data->PaymentURL
            ]);
        }

        
    }

    public function get_users_data(Request $request)
    {
        // return $request->users;
        $users = User::whereIn('id',$request->users)->with('details')->get();
        // return $users;
        return response()->json([
            'users' => UserResource::collection($users->pluck('details'))
        ]);
    }

    public function share_app($type)
    {
        $link = SettingText::where('key',$type)->first()->value;
        return response()->json([
            'link' => $link
        ]);
    }

    public function edit_notifications()
    {
        $user = Auth::user()->details;
        return response()->json([
            'messages' => $user->notification_messages,
            'likes' => $user->notification_likes,
            'nearby' => $user->notification_nearby
        ]);
    }

    public function change_notification_status($type)
    {
        $user = Auth::user()->details;
        if($type == 'messages'){
            $user->notification_messages = $user->notification_messages == 0 ? 1 : 0;

            $firestore = new FirestoreClient([
                'projectId' => 'hilike-79cc6',
            ]);
            $UserRef = $firestore->collection('users')->document($user->user_id);
            $UserRef->update([
                ['path' => 'notification_on', 'value' => $user->notification_messages]
            ]);
    
        }elseif($type == 'likes'){
            $user->notification_likes = $user->notification_likes == 0 ? 1 : 0;
        }elseif($type == 'nearby'){
            $user->notification_nearby = $user->notification_nearby == 0 ? 1 : 0;
        }

        
        $user->update();
        return response()->json([
            'status' => 'success',
        ]);
    }
    
}
