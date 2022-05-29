<?php
namespace App\Helpers;

use App\Models\UserDetail;
use App\Models\User;
use App\Models\Block;
use App\Models\Translate;
use App\Models\Chat;
use DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Http;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\FirestoreClient;
use DateTime;

class ListHelper
{
    public static function nearby_users($user)
    {   
        if($user->location == 1){
            $users = UserDetail::select(DB::raw('*, ( 6367 * acos( cos( radians('.$user->latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$user->longitude.') ) + sin( radians('.$user->latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
            ->where('gender',$user->wanted_gender)
            ->where('visible',1)
            ->orderBy('distance')
            ->orderBy('last_visit','DESC')
            ->get();
        }else{
            $users = UserDetail::where('gender',$user->wanted_gender)
            ->where('visible',1)
            ->orderBy('last_visit','DESC')
            ->get();
        }
        

        return $users;
    }

    public static function blocked_users()
    {
        $blocked = Block::where(function($q) {
            $q->where('from_user', Auth::user()->id)
              ->orWhere('to_user', Auth::user()->id);
        })
        ->get();
        $from = $blocked->pluck('from_user')->toArray();
        $to = $blocked->pluck('to_user')->toArray();

        $data = array_unique(array_merge($from,$to));

        return $data;
    }


    public static function translate($name,$model)
    {
        if(isset($model->translate)){
            $model->translate()->update([
                'name' => $name
            ]);
        }else{
            $model->translate()->create([
                'name' => $name
            ]);
        }

    }


    public static function creat_thread($user_id)
    {
        $thread_id = 'admin'.$user_id;
        $chat = Chat::create([ 'second_user' => $user_id , 'thread_id' => $thread_id]);

        $firestore = new FirestoreClient([
            'projectId' => 'hilike-79cc6',
        ]);

        $firestore->collection('chatThreads')->document($thread_id)->set([]);
        
        $chatsColl = $firestore->collection('chatThreads/'.$thread_id.'/messages')->newDocument();
        $data = [
            'created_at' => new Timestamp(new DateTime()),
            'gift_id' => 0,
            'is_gift' => false,
            'messagedoc' => 'chatThreads/'.$thread_id.'/messages'.'/'.$chatsColl->id(),
            'sender_id' => 0,
            'status' => 'sent',
            'text' => 'Welcome to our app',
        ];
        $chatsColl->set($data);
        // $chatsColl = $firestore->collection('chatThreads/'.$thread_id.'/messages')->add($data);

       

    }

    public static function creat_user_firebase($user_id,$nickname,$plan_id,$device_token)
    {
        $thread_id = 'admin'.$user_id;

        $firestore = new FirestoreClient([
            'projectId' => 'hilike-79cc6',
        ]);

        $data2 = [
            'fcmToken' => $device_token,
            'nickName' => $nickname,
            'image' => '',
            'plan_id' => $plan_id,
            'notification_on' => 1,
            'messages_count' => 0
        ];

        $usersColl = $firestore->collection('users')->document($user_id)->set($data2);

    }

    public static function creat_device_token($user_id,$device_token)
    {
        $firestore = new FirestoreClient([
            'projectId' => 'hilike-79cc6',
        ]);
        $UserRef = $firestore->collection('users')->document($user_id);
        $UserRef->update([
            ['path' => 'fcmToken', 'value' => $device_token]
        ]);

        $user = User::find($user_id);
        $user->device_token = $device_token;
        $user->update();
    }

    
}