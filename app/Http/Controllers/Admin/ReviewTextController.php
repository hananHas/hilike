<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserDetail;

class ReviewTextController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:preview-texts');
    }
    public function nicknames()
    {
        $users = UserDetail::where('confirmed_nickname',null)->get();
        return view('admin.texts.nickname ',compact('users'));
    }

    public function looking_for()
    {
        $users = UserDetail::where('looking_for','!=',null)->where('confirmed_looking_for',null)->get();
        return view('admin.texts.looking_for ',compact('users'));
    }

    public function about_user()
    {
        $users = UserDetail::where('about','!=',null)->where('confirmed_about',null)->get();
        return view('admin.texts.about ',compact('users'));
    }

    public function accept($type, $id)
    {
        $user = UserDetail::find($id);
        if($type == 'nickname'){
            $user->confirmed_nickname = 1;
            $user->update();
        }elseif($type == 'looking_for'){
            $user->confirmed_looking_for = 1;
            $user->update();
        }
        elseif($type == 'about'){
            $user->confirmed_about = 1;
            $user->update();
        }
        return 'accept';
    }

    public function reject($type, $id)
    {
        $user = UserDetail::find($id);
        if($type == 'looking_for'){
            $user->looking_for =  null;
            $user->confirmed_looking_for = 0;
            $user->update();
        }elseif($type == 'about'){
            $user->about = null;
            $user->confirmed_about = 0;
            $user->update();
        }
        return 'reject';
    }

    public function update(Request $request,$type, $id)
    {
        $user = UserDetail::find($id);
        if($type == 'nickname'){
            $user->nickname =  $request->new_text;
            $user->confirmed_nickname = 1;
            $user->update();
        }
        elseif($type == 'looking_for'){
            $user->looking_for =  $request->new_text;
            $user->confirmed_looking_for = 1;
            $user->update();
        }
        elseif($type == 'about'){
            $user->about =  $request->new_text;
            $user->confirmed_about = 1;
            $user->update();
        }
        return redirect()->back()->with('success', 'Updated successfully');
    }
}
