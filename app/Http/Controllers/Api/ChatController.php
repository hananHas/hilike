<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use Auth;
use Validator;
use App\Http\Resources\ChatResource;
use App\Http\Resources\AdminChatResource;
use Google\Cloud\Firestore\FirestoreClient;
use Cache;

class ChatController extends Controller
{
    public function check_for_thread($first_id)
    {
        $second_id = Auth::user()->id;
        $chat = Chat::where('first_user',$first_id)->where('second_user',$second_id)->get();
        $chat2 = Chat::where('first_user',$second_id)->where('second_user',$first_id)->get();
        if(count($chat)>0 || count($chat2)>0){
            if(count($chat)>0){
                $thread = $chat->first();
            }else{
                $thread = $chat2->first();
            }

            return response()->json([
                'thread_exists' => true,
                'thread' => $thread->thread_id,
            ]);
        }else{
            $thread = null;

            return response()->json([
                'thread_exists' => false,
                'thread' => $thread,
            ]);
        }

    }

    public function create_thread(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_user' => 'required',
            'second_user' => 'required',
            'thread_id' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'error'  => $validator->messages()->first(),
            ]); 
        }

        if(Chat::where('thread_id',$request->thread_id)->count()==0){
            $chat = Chat::create(['first_user' => $request->first_user , 'second_user' => $request->second_user , 'thread_id' => $request->thread_id]);

            $firestore = new FirestoreClient([
                'projectId' => 'hilike-79cc6',
            ]);
            
            $firestore->collection('chatThreads')->document($request->thread_id)->set([]);
    
        }
        
        return response()->json([
            'status' => 'success',
        ]);
    }

    public function get_user_threads()
    {
        $user_id = Auth::user()->id;
        $chats = Chat::where('first_user',$user_id)->orWhere('second_user',$user_id)->where('thread_id','not like','s%')->where('thread_id','not like','admin%')->get();
        $admin_chat = Chat::where('second_user',$user_id)->where('thread_id','like','admin%')->first();
        if($admin_chat){
            $admin_chat = new AdminChatResource($admin_chat);
            $all_chats = ChatResource::collection($chats)->push($admin_chat);
            return response()->json([
                'chats' => $all_chats,
                'notification' => Auth::user()->details->notification_messages,
                'count' => count($all_chats)
            ]);
        }else{
            return response()->json([
                'chats' => ChatResource::collection($chats),
                'notification' => Auth::user()->details->notification_messages,
                'count' => count($chats)

            ]);
        }
        // return $chats;

       

    }

    public function search_chats($query)
    {
        $chats = $this->get_user_threads();
        $new_chats = collect($chats->getData()->chats);
        // ->where('nickname','like','%'.$query.'%');
        $res = $new_chats->filter(function ($item) use ($query) {
            return false !== stripos($item->nickname, $query);
        });

        return response()->json([
            'chats' => $res->values()
        ]);

        
    }
   
    public function is_online($id)
    {
        return response()->json([
            'online' => Cache::has('user-is-online-' . $id) ? 1 : 0,
        ]);
    }
    
}
