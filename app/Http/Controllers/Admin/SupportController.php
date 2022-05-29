<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\ContactMessage;
use App\Http\Resources\SupportChatResource;
use Google\Cloud\Firestore\FirestoreClient;

class SupportController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:chat-support');
    }

    public function page()
    {
        return view('admin.support.chats');
    }

    public function get_chat($thread_id)
    {
        $chat = Chat::where('thread_id',$thread_id)->first();

        return new SupportChatResource($chat);
        
    }

    public function contact()
    {
        $messages = ContactMessage::orderBy('id','Desc')->get();
        return view('admin.support.contact', compact('messages'));

    }
}
