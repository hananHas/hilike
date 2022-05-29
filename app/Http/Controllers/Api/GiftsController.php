<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gift;
use App\Models\Coin;
use App\Models\UserGift;
use App\Models\GiftCategory;
use App\Models\PurchaseCoin;
use App\Http\Resources\GiftCategoryResource;
use App\Http\Resources\AllGiftsResource;
use App\Http\Resources\AllCoinsResource;
use Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class GiftsController extends Controller
{
    public function gifts_with_categories()
    {
        $categories = GiftCategory::with('gifts')->get();
        return response()->json([
            'categories' => GiftCategoryResource::collection($categories),
        ]);
    }

    public function get_gift($id)
    {
        $gift = Gift::find($id);
        return response()->json([
            'gift' => new AllGiftsResource($gift),
        ]);
    }

    public function get_coins()
    {
        $coins = Coin::all();
        return response()->json([
            'coins' => AllCoinsResource::collection($coins),
        ]);
    }

    public function get_balance()
    {
        $balance = auth()->user()->details->balance;
        return response()->json([
            'balance' => $balance,
        ]);
    }

    public function coin_payment_form($coin_id,$method)
    {
        $user = auth()->user()->id;

        if($method == 'apple' || $method == 'google'){
            return response()->json([
                'url' => route('coin.form', ['user' => $user , 'coin_id' => $coin_id ])
            ]);
        }else{
            $user = User::find($user);
            $coin = Coin::find($coin_id);

            $subs = new PurchaseCoin;
            $subs->user_id = $user->id;
            $subs->coin_id = $coin_id;
            $subs->price = $coin->price;
            $subs->payment_method = 'myfatoorah';
            $subs->save();
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL',
                'accept' => 'application/json'
            ])->asForm()->post('https://apitest.myfatoorah.com/v2/ExecutePayment',[
                'InvoiceValue' => $coin->price,
                'CustomerName' => $user->name,
                // 'CustomerEmail' => $user->email,
                'PaymentMethodId' => 2,
                "DisplayCurrencyIso" => "USD",
                "CallBackUrl" => url('/success/payment/'.$coin->coins.'/'.$user->id.'?method=myfatoorah&purchase_id='.$subs->id),
                "ErrorUrl" => url('/error/payment?method=myfatoorah&purchase_id='.$subs->id),
            ]);

            return response()->json([
                'url' => $response->object()->Data->PaymentURL
            ]);
        }
    }

    public function send_gift($gift_id,$user_id)
    {
        $gift = Gift::find($gift_id);   
        
        $user_gift = new UserGift;
        $user_gift->from_user = Auth::user()->id;
        $user_gift->to_user = $user_id;
        $user_gift->gift_id = $gift_id;
        $user_gift->save();

        $user =  Auth::user()->details;
        $user->balance = $user->balance - $gift->price;
        $user->update();

        return response()->json([
            'status' => 'success'
        ]);
}
}
