<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Like;
use App\Models\UserDetail;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Helpers\ListHelper;
use DB;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Factory;

class LikesController extends Controller
{
    public function add_like($to_user)
    {
        $from_user = Auth::user()->id;
        $likes = Like::where('from_user',$from_user)->where('to_user',$to_user)->get();
        if(count($likes)==0){
            $like = new Like;
            $like->from_user = $from_user;
            $like->to_user = $to_user;
            $like->save();

            $to_user_d = User::find($to_user);
            $from_user_d = User::find($from_user);

            if($to_user_d->details->notification_likes == 1){
                $factory = (new Factory)->withServiceAccount(storage_path('firebase/hilike-79cc6-firebase-adminsdk-4tzn2-a9cfacef57.json'));
                $messaging = $factory->createMessaging();
    
                if($to_user_d->details->language == 'en'){
                    $notification = [
                        'title' => $from_user_d->details->nickname,
                        'body' => 'liked you',
                        // 'image' => $imageUrl,
                    ];
                }else{
                    $notification = [
                        'title' => $from_user_d->details->nickname,
                        'body' => 'أعجب بك',
                        // 'image' => $imageUrl,
                    ];
                }
                
                $message = CloudMessage::withTarget('token', $to_user_d->device_token)
                                        ->withNotification($notification);
    
                $messaging->send($message);
            }
            
        }

        return response()->json([
            'status' => 'success',
            'message' => trans('messages.like_added')
        ]);

    }

    public function remove_like($to_user)
    {
        $from_user = Auth::user()->id;
        $likes = Like::where('from_user',$from_user)->where('to_user',$to_user)->delete();

        return response()->json([
            'status' => 'success',
            'message' => trans('messages.like_removed')
        ]);

    }

    public function liked_you()
    {
        $user = Auth::user()->id;
      
        $likes_list = Like::where('to_user',$user)->pluck('from_user')->toArray();
        $users = UserDetail::whereIn('user_id',$likes_list)->where('visible',1)->get();

        $blocked = ListHelper::blocked_users();
        $users = $users->whereNotIn('user_id',$blocked);

        return response()->json([
            'users' => UserResource::collection($users)
        ]);
    }

    public function my_likes()
    {
        $user = Auth::user()->details;
        
        $likes_list = Like::where('from_user',$user->user_id)->pluck('to_user')->toArray();
        $users = UserDetail::select(DB::raw('*, ( 6367 * acos( cos( radians('.$user->latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$user->longitude.') ) + sin( radians('.$user->latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
        ->whereIn('user_id',$likes_list)    
        ->where('visible',1)
        ->get();

        $blocked = ListHelper::blocked_users();
        $users = $users->whereNotIn('user_id',$blocked);

        return response()->json([
            'users' => UserResource::collection($users)
        ]);
    }
}
