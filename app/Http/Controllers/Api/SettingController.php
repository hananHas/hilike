<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use Auth;
use Hash;

class SettingController extends Controller
{
    public function enable_location($value)
    {
        $user = auth()->user()->details;
        if($value == 'on'){
            $user->location = 1;
            $user->update();
        }else{
            $user->location = 0;
            $user->update();
        }

        return response()->json([
            'status' => 'success',
            'message' => trans('messages.updated_successfully')

        ]);
    }

    public function show_account($value)
    {
        $user = auth()->user()->details;
        if($value == 'on'){
            $user->visible = 1;
            $user->update();
        }else{
            $user->visible = 0;
            $user->update();
        }

        return response()->json([
            'status' => 'success',
            'message' => trans('messages.updated_successfully')

        ]);
    }

    public function switch_language($value)
    {
        $user = auth()->user()->details;
        $user->language = $value;
        $user->update();
       
        return response()->json([
            'status' => 'success',
            'message' => trans('messages.updated_successfully'),
            'language' => $user->language

        ]);
    }

    public function change_password(ChangePasswordRequest $request)
    {
        if(Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->current_password/*, 'name' => $request->username*/]))
        {
            $user = auth()->user();
            $user->password = Hash::make($request->new_password);
            $user->save();
            
            return response()->json([
            'status' => 'success',
            'message' => trans('messages.updated_successfully'),
            ]);
        }

        return response()->json([
            'status' => 'error',
            'error' => trans('messages.failed_login'),
        ]);
    }
}
