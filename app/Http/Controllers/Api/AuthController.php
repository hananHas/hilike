<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\SendVerificationEmail as EmailVerificationNotification;
use App\Notifications\SendPasswordResetEmail;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\SocialLoginRequest;
use App\Http\Resources\UserRegisterResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CountryArabicResource;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Country;
use App\Models\UserDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use File;
use Validator;
use Illuminate\Support\Facades\App;
use App\Helpers\ListHelper;
use Socialite;

class AuthController extends Controller
{
    public function register_data($lang)
    {
        $countries = Country::all();
        if($lang == 'en'){
            return CountryResource::collection($countries);
        }else{
            return CountryArabicResource::collection($countries);
        }
    }

    public function register(RegisterUserRequest $request)
    {
        DB::beginTransaction();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 0,
            'verification_token' =>($request->provider == '') ?  rand(1000, 9999) : null,
            'provider' => $request->provider,
            'provider_token' => $request->provider_token,
            'device_token' => $request->device_token,
            // 'firebase_reference' => $request->firebase_reference,
        ]);

        if($request->has('profile_image') && $request->file('profile_image') != null){
            $ext = $request->file('profile_image')->getClientOriginalExtension();
            // filename to store
            $image_name = $request->input('nickname').'_'.rand().'.'.$ext;
            // upload image
            $path = public_path().'/images/users';
            $uplaod = $request->file('profile_image')->move($path,$image_name);

            $image_check = 1;
            if($image_check == 0){
                File::delete($path.'/'.$image_name);
                unset($image_name);
            }
        }

        $user_details = UserDetail::create([
            'age' => $request->dob,
            'origin_country_name' => $request->origin_country_name,
            'residence_country_name' => $request->residence_country_name,
            'origin_latitude' => $request->origin_latitude,
            'origin_longitude' => $request->origin_longitude,
            'residence_latitude' => $request->residence_latitude,
            'residence_longitude' => $request->residence_longitude,
            'gender' => $request->gender,
            'nickname' => $request->nickname,
            'user_id' => $user->id,
            'plan_id' => 1,
            'online' => 1,
            'profile_progress'=> isset($image_name) ? 35 : 30,
            'profile_image' => isset($image_name) ? $image_name : null,
            'language' => $request->language,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'last_visit' => Carbon::now(),
        ]);

        DB::commit();
        if($request->provider == ''){
            $user->notify(new EmailVerificationNotification($user));
        }
        App::setLocale($request->language);

        $chat = ListHelper::creat_user_firebase($user->id,$request->nickname,1,$request->device_token);

        return new UserRegisterResource($user);
    }

    public function verify(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        $code = $request->code;
        if($user->verification_token === $code){
            $user->verification_token = null;
            $user->email_verified_at = Carbon::now();
            $user->update();

            Auth::login($user);
            $token = $user->createToken('Api Token')->accessToken;

            $user_details = UserDetail::where('user_id',$user->id)->first();

            $chat = ListHelper::creat_thread($user->id);

            
            return response()->json([
                'status' => 'success',
                'message' => trans('messages.verified'),
                'data' => [
                    'user' => new UserResource($user_details),
                    'token' => $token,
                ]
            ]);
         

            
        }else{
            return response()->json([
                'status' => 'error',
                'message' => trans('messages.invalid_code'),
            ]);
        }
    }

    public function resend_code(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        $user->verification_token = rand(1000, 9999);
        $user->update();

        $user->notify(new EmailVerificationNotification($user));

        return response()->json([
            'status' => 'success',
            'message' => trans('messages.code_sent'),
        ],200);
         
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'provider' => null,
            'provider_token' => null,
        ];

        $credentials2 = [
            'name' => $request->email,
            'password' => $request->password,
            'provider' => null,
            'provider_token' => null,

        ];

        if (Auth::attempt($credentials) || Auth::attempt($credentials2)) {

            $user = Auth::user();

            if($user->verification_token != null){
                return response()->json(['status' => 'verify','message' => trans('messages.verify_your_email')], 401);

            }

            if ($user->isBanned()) {
                $expired_at = Carbon::parse($user->bans->sortByDesc('id')->values()[0]->expired_at);
                $expired_at = $expired_at->diffInHours(Carbon::now()).'h '.$expired_at->diff(Carbon::now())->format('%Im');
                return response()->json([
                    'status' => 'ban',
                    'message' => trans('messages.banned'),
                    'expired_at' => $expired_at
                ]);
            }elseif($user->blocked == 1){
                return response()->json([
                    'status' => 'ban',//'block',
                    'message' => trans('messages.blocked')
                ]);
            }

            $token = $user->createToken('Api Token')->accessToken;

            $fcmtoken = ListHelper::creat_device_token($user->id,$request->device_token);


            $user_details = UserDetail::where('user_id',$user->id)->first();
            $user_details->language = $request->language??$user_details->language;
            $user_details->save();

            return response()->json([
                'data' => [
                    'user' => new UserResource($user_details),
                    'token' => $token,
                ]
            ]);
        }

        return response()->json(['status' => 'error','message' => trans('messages.failed_login')], 401);
    }

    public function forgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json(['status' => 'error' ,'message' => trans('messages.email_account_not_found')]);
        }

        $token = rand(1000, 9999);
        // $url = url('/api/auth/reset/'.$token);

        $passwordReset = DB::table('password_resets')
                            ->updateOrInsert(
                                ['email' => $user->email],
                                [
                                    'email' => $user->email,
                                    'token' => $token,
                                    'created_at' => Carbon::now()
                                ]
                            );

        if ($user && $passwordReset) {
            $user->notify( new SendPasswordResetEmail($token, $user) );
        }

        return response()->json(['status' => 'success','message' => trans('messages.password_reset_link_sent')], 201);
    }
    
    public function find($token)
    {
        $passwordReset = DB::table('password_resets')->where('token', $token)->first();
        if (! $passwordReset){
            return response()->json(['status' => 'error' ,'message' => trans('messages.password_reset_token_404')]);
        }

        if (Carbon::parse($passwordReset->created_at)->addMinutes(720)->isPast()) {
            DB::table('password_resets')->where('token', $token)->delete();

            return response()->json(['status' => 'error' ,'message' => trans('messages.password_reset_token_404')], 404);
        }

        return response()->json(['status' => 'success' , 'data' => $passwordReset]);
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|confirmed',
            'token' => 'required|string'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'error'  => $validator->messages()->first(),
            ]); 
        }

        $passwordReset = DB::table('password_resets')->where('token', $request->token)->first();
        if (! $passwordReset){
            return response()->json(['status' => 'error' ,'message' => trans('messages.password_reset_token_404')], 404);
        }

        $customer = User::where('email', $passwordReset->email)->first();
        if (! $customer){
            return response()->json(['status' => 'error' ,'message' => trans('messages.email_account_not_found')], 404);
        }

        $customer->password = Hash::make($request->password);
        $customer->save();

        DB::table('password_resets')->where('token', $request->token)->delete();

        Auth::login($customer);
        $token = $customer->createToken('Api Token')->accessToken;

        $user_details = UserDetail::where('user_id',$customer->id)->first();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('messages.password_reset_successful'),
            'data' => [
                'user' => new UserResource($user_details),
                'token' => $token,
            ]
        ]);

    }

    public function logout(Request $request)
    {
        $user = Auth::user()->token();
        $user->revoke();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('messages.auth_out')
        ], 200);
    }

    public function socialLogin(SocialLoginRequest $request, $provider)
    {
        try {
            $user = Socialite::driver($provider)->userFromToken($request->get('access_token'));
        }
        catch (\GuzzleHttp\Exception\ClientException $e) {
            return response()->json([
                'status' => 'error',
                'message'   => trans('auth.failed'),
                'errors'    => json_decode($e->getResponse()->getBody()->getContents(), true)
            ], 401);
        }
        
        if($user->email){
            $customer = User::where('email', $user->email)->first();
            if($customer && $customer->provider_token == null)
            {
                return response()->json([
                    'status' => 'error',
                    'message'   => $request->get('language') == 'ar'? 'هذا الحساب مسجل مسبقا بواسطة بريد الكتروني و كلمة مرور ':'this account is registered by email and password',
                ]);
            }
        }else{
            $customer = User::where('provider_token', $request->get('access_token'))->first();
        }

        if (! $customer){
            return response()->json([
                'status' => 'not_found',
            ]);
        }

        if ($customer->isBanned()) {
            $expired_at = Carbon::parse($customer->bans->sortByDesc('id')->values()[0]->expired_at);
            $expired_at = $expired_at->diffInHours(Carbon::now()).'h '.$expired_at->diff(Carbon::now())->format('%Im');
            return response()->json([
                'status' => 'ban',
                'message' => trans('messages.banned'),
                'expired_at' => $expired_at
            ]);
        }elseif($customer->blocked == 1){
            return response()->json([
                'status' => 'ban',//'block',
                'message' => trans('messages.blocked')
            ]);
        }

        $token = $customer->createToken('Api Token')->accessToken;

        $user_details = UserDetail::where('user_id',$customer->id)->first();
        $user_details->language = $request->language??$user_details->language;
        $user_details->save();

        $fcmtoken = ListHelper::creat_device_token($customer->id,$request->device_token);

        return response()->json([
            'data' => [
                'user' => new UserResource($user_details),
                'token' => $token,
            ]
        ]);
    }

}
