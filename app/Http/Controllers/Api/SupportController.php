<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\Chat;
use App\Models\ChatCategory;
use App\Http\Resources\ChatCatResource;

class SupportController extends Controller
{
    public function contact_message(Request $request)
    {
        $message = new ContactMessage;
        $message->user_id = $request->user_id == 0 ? null : $request->user_id;
        $message->message = $request->message;
        $message->subject = $request->subject;
        $message->save();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function choose_chat_cat($cat_id,$thread_id)
    {
        $chat = Chat::where('thread_id',$thread_id)->first();
        $chat->chat_category_id = $cat_id;
        $chat->update();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function get_support_categories()
    {
        $cats = ChatCategory::all();
        
        return response()->json([
            'categories' => ChatCatResource::collection($cats)
        ]);
       
    }

    public function upload_chat_image(Request $request)
    {
        $ext = $request->file('image')->getClientOriginalExtension();
        // filename to store
        $img_rand = rand();
        $image_name = $img_rand.'.'.$ext;
        // upload image
        $path = public_path().'/images/support';
        $uplaod = $request->file('image')->move($path,$image_name);

        return response()->json([
            'image' => url('/images/support/'.$image_name),
            'name' => $img_rand,
        ]);
    }
}
