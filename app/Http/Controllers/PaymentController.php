<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;
use App\Models\Coin;
use App\Models\UserDetail;
use App\Models\PlanPackage;
use App\Models\Subscription;
use App\Models\PurchaseCoin;
use \Carbon\Carbon;
use Google\Cloud\Core\Timestamp;
use DateTime;
use Illuminate\Support\Facades\Http;
use Google\Cloud\Firestore\FirestoreClient;

class PaymentController extends Controller
{
    //show form - stripe - plan
    public function show_payment_form($user_id,$plan_id,$package_id)
    {
        $user = User::find($user_id);
        $intent = $user->createSetupIntent();
        
        return view('payment.show_form', compact('plan_id' ,'package_id', 'intent','user_id'));
    }

     //pay - stripe - plan
    public function purchase(Request $request,$user_id)
    {
        if($request->package_id == 0){
            $item = Plan::find($request->plan_id);
            $item_type = 'plan';
        }else{
            $item = PlanPackage::find($request->package_id);
            $item_type = 'package';
        }
        $user = User::find($user_id);
        $paymentMethod = $request->input('payment_method');
        
        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            $user->charge($item->price * 100, $paymentMethod); 
            
            $user_plan = UserDetail::where('user_id',$user_id)->first()->plan_id;
            if($item_type == 'plan' && $user_plan == $item->id){
                $subs = Subscription::where('user_id',$user_id)->orderBy('id','Desc')->first();
                
                if($subs){
                    if($subs->status == 1){
                        $end = Carbon::parse($subs->ends_at)->addMonth(); 
                    }
                }
            }elseif($item_type == 'package' && $user_plan == $item->plan_id){
                $subs = Subscription::where('user_id',$user_id)->orderBy('id','Desc')->first();

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
            $subs->payment_method = 'stripe';
            $subs->status = 1;
            $subs->ends_at = isset($end) ? $end : ( $item_type == 'plan' ? Carbon::now()->addMonth() : Carbon::now()->addMonths($item->months) );
            $subs->save();
            


            $firestore = new FirestoreClient([
                'projectId' => 'hilike-79cc6',
            ]);
            $thread_id = 'admin'.$user_id;
            $data = [
                'created_at' => new Timestamp(new DateTime()),
                'gift_id' => 0,
                'is_gift' => false,
                'messagedoc' => "",
                'sender_id' => 0,
                'status' => 'sent',
                'text' => ($user->details->language == 'en'? 'plan upgraded successfully, It will be expire in ': 'تم تفعيل اشتراكك بنجاح, الاشتراك صالح لغاية ').Carbon::parse($subs->ends_at)->toDateString(),
            ];
    
            $chatsColl = $firestore->collection('chatThreads/'.$thread_id.'/messages')->add($data);

        } catch (\Exception $exception) {
            $subs = new Subscription;
            $subs->user_id = $user->id;
            $subs->subscriptable_type = $item_type == 'plan' ? 'App\Models\Plan' : 'App\Models\PlanPackage';
            $subs->subscriptable_id = $item->id;
            $subs->price = $item->price;
            $subs->payment_method = 'stripe';
            $subs->status = 0;
            $subs->ends_at = $item_type == 'plan' ? Carbon::now()->addMonth() : Carbon::now()->addMonths($item->months);
            $subs->save();

            return redirect()->route('payment.error');
        }

       
        return redirect()->route('plan.payment.success',['plan_id' => $request->plan_id,'user_id' => $user->id]);
    }

    //show form - stripe - coin
    public function show_coins_payment_form($user_id,$coin_id)
    {
        $user = User::find($user_id);
        $intent = $user->createSetupIntent();
        
        return view('payment.show_coins_form', compact('coin_id', 'intent','user_id'));
    }

    //pay - stripe - coin
    public function purchase_coin(Request $request,$user_id)
    {
        
        $item = Coin::find($request->coin_id);
        // $item_type = 'plan';
        
        $user = User::find($user_id);
        $paymentMethod = $request->input('payment_method');
        
        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            $user->charge($item->price * 100, $paymentMethod);  

            $subs = new PurchaseCoin;
            $subs->user_id = $user->id;
            $subs->coin_id = $request->coin_id;
            $subs->price = $item->price;
            $subs->payment_method = 'stripe';
            $subs->status = 1;
            $subs->save();


        } catch (\Exception $exception) {
            $subs = new PurchaseCoin;
            $subs->user_id = $user->id;
            $subs->coin_id = $request->coin_id;
            $subs->price = $item->price;
            $subs->payment_method = 'stripe';
            $subs->status = 0;
            $subs->save();
            return redirect()->route('payment.error');
        }

        return redirect()->route('payment.success',['coins' => $item->coins,'user_id' => $user_id]);
    }


    
    public function success_payment($coins,$user_id)
    {
        $details = UserDetail::where('user_id',$user_id)->first();
        $details->balance += $coins;
        $details->save();

        if(request()->has('method') && request()->method == 'myfatoorah'){
            $sub = PurchaseCoin::find(request()->purchase_id);
            $sub->status = 1;
            $sub->update();
        }

    }

    public function plan_success_payment($plan_id,$user_id)
    {
        $user_details = UserDetail::where('user_id',$user_id)->first();

        // $user_details = $user->details;
        $user_details->plan_id =  $plan_id;
        $user_details->update();

        if(request()->has('method') && request()->method == 'myfatoorah'){
            $sub = Subscription::find(request()->sub_id);
            $sub->status = 1;
            $sub->update();
        }
    }

    public function error_payment()
    {
        if(request()->has('method') && request()->method == 'myfatoorah' && request()->has('sub_id')){
            $sub = Subscription::find(request()->sub_id);
            $sub->status = 0;
            $sub->update();
        }

        if(request()->has('method') && request()->method == 'myfatoorah' && request()->has('purchase_id')){
            $sub = PurchaseCoin::find(request()->purchase_id);
            $sub->status = 0;
            $sub->update();
        }
    }

    public function payment_status()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL',
            'accept' => 'application/json'
        ])->asForm()->post('https://apitest.myfatoorah.com/v2/GetPaymentStatus',[
            "Key"=> "0808407888853832822184",
            "KeyType"=> "PaymentId"
        ]);

        return $response->object();
    }
     
}
