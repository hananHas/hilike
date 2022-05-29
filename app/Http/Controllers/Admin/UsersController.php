<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserImage;
use App\Models\Religion;
use App\Models\Country;
use App\Models\SocialType;
use App\Models\MarriageType;
use App\Models\Education;
use App\Models\Job;
use App\Models\SkinColor;
use App\Models\Body;
use App\Models\Subscription;
use App\Models\PurchaseCoin;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use DB;
use Hash;
use App\Helpers\ListHelper;
use Illuminate\Database\Eloquent\Builder;

class UsersController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:users-management');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->has('plan')){
            $plan = request()->plan;
            return view('admin.users.index',compact('plan'));

        }elseif(request()->has('type')){
            $type = request()->type;
            return view('admin.users.index',compact('type'));
        }
        elseif(request()->has('country')){
            $country = request()->country;
            return view('admin.users.index',compact('country'));
        }
        else{
            return view('admin.users.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $religions = Religion::all();
        $countries = Country::all();
        $social_types = SocialType::all();
        $marriage_types = MarriageType::all();
        $educations = Education::all();
        $jobs = Job::all();
        $skin_colors = SkinColor::all();
        $bodies = Body::all();

        return view('admin.users.create',compact('religions','countries','social_types','marriage_types'
        ,'educations','jobs','skin_colors','bodies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:190',
            'email' => 'required|email|unique:users|max:190',
            'gender' => 'required',
            'nickname' => 'required|max:190',
            'password' => 'required|max:190|confirmed',
            'age' => 'required',
            'origin_country_name' => 'required',
            'residence_country_name' => 'required',
            'profile_image' => 'image',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('error',$validator->messages()->first())->withInput();
        }

        DB::beginTransaction();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 0,
            'verification_token' => null,
        ]);

        if($request->has('profile_image') && $request->file('profile_image') != null){
            $ext = $request->file('profile_image')->getClientOriginalExtension();
            // filename to store
            $image_name = $request->input('nickname').'_'.rand().'.'.$ext;
            // upload image
            $path = public_path().'/images/users';
            $uplaod = $request->file('profile_image')->move($path,$image_name);
            $requestData['profile_image'] = $image_name;
        }
        $requestData['user_id'] = $user->id;
        $requestData['plan_id'] = 1;
        $requestData['online'] = 0;
        $requestData['latitude'] = 0;
        $requestData['longitude'] = 0;
        $requestData['profile_progress'] = 0;

        if($request->has('other_images') && $request->file('other_images') != null){
            foreach($request->file('other_images') as $image)
            $ext = $image->getClientOriginalExtension();
            // filename to store
            $new_image_name = $request->input('nickname').'_'.rand().'.'.$ext;
            // upload image
            $path = public_path().'/images/users';
            $uplaod = $image->move($path,$new_image_name);
            $new_image = UserImage::create([
                'user_id'=>$user->id , 'image' => $new_image_name
            ]);
        }

        $details = UserDetail::create($requestData);
        DB::commit();

        return redirect()->back()->with('success', 'Added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $user_images = UserImage::where('user_id',$id)->get();
        $last_subscription = Subscription::where('user_id',$id)->orderBy('created_at','DESC')->first();
        $subscriptions = Subscription::where('user_id',$id)->orderBy('created_at','DESC')->sum('price');
        $coins = PurchaseCoin::where('user_id',$id)->orderBy('created_at','DESC')->sum('price');
        $total_incomes = $subscriptions + $coins;
        
        return view('admin.users.show',compact('user','user_images','last_subscription','subscriptions','coins','total_incomes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        
        $user = User::find($id);
        $user->bans()->create([
            'expired_at' => Carbon::now()->addDays($request->days),
        ]);
        
        return redirect()->back()->with('success', 'Banned successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_data()
    {
        if(request()->has('plan')){
            $users = User::where('type',0)->whereHas('details', function (Builder $query) {
                $query->where('plan_id', request()->plan);
            })->with('details')->get();
            
        }elseif(request()->has('type')){
            if(request()->type == 'new'){
                $users = User::where('type',0)->where('created_at','>',Carbon::now()->subDays(7))->with('details')->get();
            }
            if(request()->type == 'online'){
                $users = User::where('type',0)->whereHas('details', function (Builder $query) {
                    $query->where('last_visit','>=',Carbon::now()->subMinutes(1)->toDateTimeString());
                })->with('details')->get();
            }
        }elseif(request()->has('country')){
            $users = User::where('type',0)->whereHas('details', function (Builder $query) {
                $query->where('residence_country_name', request()->country);
            })->with('details')->get();
        }
        else{
            $users = User::where('type',0)->orderBy('id','Desc')->with('details')->get();
        }
        // return $users;
        return Datatables::of($users)->addColumn('actions', function ($user) {
            if($user->blocked == 0){
                return '<a href="'.route('users.show',$user->id).'" class="btn btn-info btn-sm"><i class="fas fa-file"></i> View</a>
                <a href='.url('block_user/'.$user->id).' class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Block</a><br>
                <a style="margin-top: 3px;" href="'.route('users.subscriptions',$user->id).'" class="btn btn-info btn-sm"><i class="fas fa-file"></i> Subscriptions</a>
                <a style="margin-top: 3px;" href="'.route('users.coins',$user->id).'" class="btn btn-warning btn-sm"><i class="fas fa-file"></i> Coins</a>';
            
            }else{
                return '<a href="'.route('users.show',$user->id).'" class="btn btn-info btn-sm"><i class="fas fa-file"></i> View</a>
                <a href='.url('block_user/'.$user->id).' class="btn btn-info btn-sm"><i class="fas fa-trash"></i> Unblock</a>';
            }
            
        })->editColumn('created_at', function ($user) {
            return Carbon::parse($user->created_at)->toDateTimeString();
        })
        ->rawColumns([
            'actions'
        ])->make(true);
    }

    public function block_user($id)
    {
        $user = User::find($id);
        if($user->blocked == 0)
        {
            $user->blocked = 1;
            $user->save();
            return redirect()->back()->with('success', 'Blocked successfully');
        }else{
            $user->blocked = 0;
            $user->save();
            return redirect()->back()->with('success', 'Unblocked successfully');

        }
    }

    public function revoke($id)
    {
        $user = User::find($id);
        $user->unban();
        
        return redirect()->back()->with('success', 'User Revoke successfully');
    }

    public function user_subscriptions($id)
    {
        $subscriptions = Subscription::where('user_id',$id)->orderBy('created_at','DESC')->get();
        return view('admin.users.subscriptions',compact('subscriptions'));
    }

    public function user_coins($id)
    {
        $coins = PurchaseCoin::where('user_id',$id)->orderBy('created_at','DESC')->get();
        return view('admin.users.coins',compact('coins'));
    }

}
