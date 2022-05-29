<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Block;
use App\Models\UserDetail;
use App\Http\Resources\UserResource;

class BlocksController extends Controller
{
    public function add_block($to_user)
    {
        $from_user = Auth::user()->id;
        $likes = Block::where('from_user',$from_user)->where('to_user',$to_user)->get();
        if(count($likes)==0){
            $like = new Block;
            $like->from_user = $from_user;
            $like->to_user = $to_user;
            $like->save();
        }

        return response()->json([
            'message' => trans('messages.block_added')
        ]);

    }

    public function remove_block($to_user)
    {
        $from_user = Auth::user()->id;
        $likes = Block::where('from_user',$from_user)->where('to_user',$to_user)->delete();

        return response()->json([
            'message' => trans('messages.block_removed')
        ]);

    }

    public function my_blocks()
    {
        $user = Auth::user()->id;
        $blocks_list = Block::where('from_user',$user)->pluck('to_user')->toArray();
        $users = UserDetail::whereIn('user_id',$blocks_list)->get();
        return response()->json([
            'users' => UserResource::collection($users)
        ]);
    }
}
