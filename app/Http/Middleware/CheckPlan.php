<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\Subscription;
use App\Models\UserDetail;
use Carbon\Carbon;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\FirestoreClient;
use DateTime;

class CheckPlan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) {
            $user_id = Auth::user()->id;
            $user_details = UserDetail::where('user_id',$user_id)->first();
            if($user_details->plan_id != 1){
                $expiresAt = Subscription::where('user_id',$user_id)->orderBy('id','Desc')->first();
                if(Carbon::parse($expiresAt->ends_at)->subDays(3) <= Carbon::now()){
                    if($expiresAt->sent_message != 1){
                        $firestore = new FirestoreClient([
                            'projectId' => 'hilike-79cc6',
                        ]);
                        $thread_id = 'admin'.$user_id;
                        $data = [
                            'created_at' => new Timestamp(new DateTime()),
                            'gift_id' => 0,
                            'is_gift' => false,
                            'messagedoc' => "",
                            'sender_id' => 0,
                            'status' => 'sent',
                            'text' => ($user_details->language == 'en'?'Your plan will be expired in ':'ستنتهي صلاحية الخطة الخاصة بك في ').Carbon::parse($expiresAt->ends_at)->toDateString().($user_details->language == 'en'?' don\'t forget to upgrade':'لا تنسى تجديدها '),
                        ];
                
                        $chatsColl = $firestore->collection('chatThreads/'.$thread_id.'/messages')->add($data);
                        $expiresAt->sent_message = 1;
                        $expiresAt->update();

                    }
                }
                if(Carbon::parse($expiresAt->ends_at) < Carbon::now()){
                    $user_details->plan_id = 1;
                    $user_details->update();
                    $firestore = new FirestoreClient([
                        'projectId' => 'hilike-79cc6',
                    ]);
                    $thread_id = 'admin'.$user_id;
                    $data = [
                        'created_at' => new Timestamp(new DateTime()),
                        'gift_id' => 0,
                        'is_gift' => false,
                        'messagedoc' => "",
                        'sender_id' => 0,
                        'status' => 'sent',
                        'text' => $user_details->language == 'en'? 'Your plan has been expired.' : 'انتهت صلاحية الخطة الخاصة بك'
                    ];
            
                    $chatsColl = $firestore->collection('chatThreads/'.$thread_id.'/messages')->add($data);
                }
            }
            
           
        }
        return $next($request);
    }
}
