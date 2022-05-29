<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\UserDetail;
use Google\Cloud\Firestore\FirestoreClient;

class ChatsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:chats-monitoring');
    }
    protected $database;

    public function chats()
    {
        $firestore = new FirestoreClient([
            'projectId' => 'hilike-79cc6',
        ]);
      
        $chats = Chat::where('thread_id','not like','s%')->get();
        foreach($chats as $chat){
            $chatsReference = $firestore->collection('chatThreads')->document($chat->thread_id)->collection('messages')->orderBy('created_at','DESC')->limit(1);
            $documents = $chatsReference->documents();
            foreach ($documents as $document) {
                if ($document->exists()) {
                    // $chat->document = $document->data();
                    $chat->chat_date = $document->data()['created_at'];
                } else {
                    $chat->document = $document->id(); 
                }
            }
        }
        $chats = $chats->sortByDesc('chat_date')->values();
        return view('admin.chats.index',compact('chats'));
    }

    public function get_chat($thread_id)
    {
        $firestore = new FirestoreClient([
            'projectId' => 'hilike-79cc6',
        ]);
        $chatReference = $firestore->collection('chatThreads')->document($thread_id)->collection('messages')->orderBy('created_at');
        $documents = $chatReference->documents();
        // return response()->json($documents);
        
        $users = explode("s",$thread_id);
        $f_user = UserDetail::where('user_id',$users[0])->first();
        $s_user = UserDetail::where('user_id',$users[1])->first();

        $returnHTML = view('admin.chats.view_chat')->with('documents', $documents)->with('f_user', $f_user)->with('s_user', $s_user)->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));

    }
}
