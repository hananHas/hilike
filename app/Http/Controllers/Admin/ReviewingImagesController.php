<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserDetail;
use App\Models\UserImage;
use Google\Cloud\Firestore\FirestoreClient;

class ReviewingImagesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:preview-images');
    }

    public function profile_images_list ()
    {
        $images = UserDetail::where('profile_image','!=',null)->where('confirmed_image',null)->get();
        return view('admin.images.profile_images_list ',compact('images'));
    }

    public function other_images_list ()
    {
        $images = UserImage::where('confirmed',null)->get();
        return view('admin.images.other_images_list ',compact('images'));
    }

    public function accept_or_reject($image,$type,$id)
    {
        if($image == 'profile'){
            $user = UserDetail::find($id);
            $user->confirmed_image = $type == 'accept' ? 1 : 0;
            $user->update();

            if($type == 'accept'){
                $firestore = new FirestoreClient([
                    'projectId' => 'hilike-79cc6',
                ]);
                $UserRef = $firestore->collection('users')->document($user->user_id);
                $UserRef->update([
                    ['path' => 'image', 'value' => url('images/users/'.$user->profile_image)]
                ]);
            }
        }else{
            $user = UserImage::find($id);
            $user->confirmed = $type == 'accept' ? 1 : 0;
            $user->update();
        }

        return $type;
    }
    
}
