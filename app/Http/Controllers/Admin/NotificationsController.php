<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\UserDetail;
use App\Models\User;
use Validator;
use Auth;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\FirestoreClient;
use DateTime;

class NotificationsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:notifications-create');
    }
    public function notifications()
    {
        $nots = Notification::orderBy('id','Desc')->get();
        return view('admin.notifications.index', compact('nots'));
    }

    public function add_notifications()
    {
        return view('admin.notifications.create');
    }

    public function store_notifications(Request $request)
    {
        set_time_limit(300);
        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'users' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->with('errors',$validator->messages())->withInput();
        }

        if($request->users != 0){
            $users = UserDetail::where('plan_id',$request->users)->pluck('user_id');
        }else{
            $users = User::pluck('id');
        }
        
        $firestore = new FirestoreClient([
            'projectId' => 'hilike-79cc6',
        ]);
        
        $data = [
            'created_at' => new Timestamp(new DateTime()),
            'gift_id' => 0,
            'is_gift' => false,
            'messagedoc' => "",
            'sender_id' => Auth::user()->id,
            'status' => 'sent',
            'text' => $request->message,
        ];
        $users_count = count($users);
        $dd = (int) ($users_count/500);
        
        // $ss = $users_count%500;
        for($i = 0 ; $i < $dd+1 ; $i++){
            $batch = $firestore->batch();
            foreach($users->skip($i * 500)->take(500) as $user){
                $coll = $firestore->collection('chatThreads/admin'.$user.'/messages')->newDocument();
                $batch->set($coll, $data);
            }
            $batch->commit();
        }
        

        

        $notification = Notification::create(['message' => $request->message,'users' => $request->users]);

        return redirect()->back()->with('success', 'Sent successfully');

    }
}
