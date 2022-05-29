<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Like;
use App\Models\Block;
use App\Models\Report;
use App\Models\UserGift;
use App\Models\UserDetail;
use App\Models\SettingText;
use App\Models\Subscription;
use App\Models\PurchaseCoin;
use DB;
use Carbon\Carbon;
use Validator;
use App\Models\PlanPackage;
use App\Models\Coin;
use App\Models\Chat;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $users = User::where('type',0)->count();
        $likes = Like::count();
        $blocks = Block::count();
        $online = UserDetail::where('last_visit','>=',Carbon::now()->subMinutes(1)->toDateTimeString())->count();
        $males = UserDetail::where('gender','male')->count();
        $females = UserDetail::where('gender','female')->count();
        $countries = DB::table('user_details')
        ->select('residence_country_name', DB::raw('count(residence_country_name) as total'))
        ->groupBy('residence_country_name')
        ->limit(20)->get();
        $gifts = UserGift::count();
        $reports = Report::count();
        $latest_members = User::OrderBy('id','Desc')->limit(8)->get();
        $new_members_count = User::whereDate('created_at',Carbon::now())->count();
        // return $countries;

        return view('admin.dashboard',compact('users','online','likes','blocks','males','females',
        'countries','gifts','reports','latest_members','new_members_count'));
        
    }

    public function users_analytics()
    {
        $total_users = User::where('type',0)->count();
        $vip = UserDetail::where('plan_id',3)->count();
        $gold = UserDetail::where('plan_id',2)->count();
        $free = UserDetail::where('plan_id',1)->count();
        $new = User::where('created_at','>=',Carbon::now()->subMonth())->count();
        $online = UserDetail::where('last_visit','>=',Carbon::now()->subMinutes(1)->toDateTimeString())->count();
        $males = UserDetail::where('gender','male')->count();
        $females = UserDetail::where('gender','female')->count();

        $under_20 = UserDetail::where('age','<',20)->count();
        $from_20_30 = UserDetail::whereBetween('age',[20 , 30])->count();
        $from_30_40 = UserDetail::whereBetween('age',[31 , 40])->count();
        $from_40_50 = UserDetail::whereBetween('age',[41 , 50])->count();
        $above_50 = UserDetail::where('age','>',50)->count();

        $months_arr = [];
        for($i=0 ; $i < 9 ;$i++)
        {
            $month = Carbon::now()->subMonths($i)->format('M');
            array_push($months_arr,$month);
        }
        $free_sum = DB::table('user_details')->where('plan_id', 1)->select(DB::raw('count(id) as total'),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
        ->groupBy('year','month')->orderBy('year','DESC')->orderBy('month','DESC')->limit(8)
        ->pluck("total")->toArray();

        if(count($free_sum) < 9){
            $free_to_add = 9-count($free_sum);
            for($i=0 ; $i<$free_to_add; $i++){
                array_push($free_sum,0);
            }
        }

        $gold_sum = DB::table('user_details')->where('plan_id', 2)->select(DB::raw('count(id) as total'),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
        ->groupBy('year','month')->orderBy('year','DESC')->orderBy('month','DESC')->limit(8)
        ->pluck("total")->toArray();

        if(count($gold_sum) < 9){
            $gold_to_add = 9-count($gold_sum);
            for($i=0 ; $i<$gold_to_add ; $i++){
                array_push($gold_sum,0);
            }
        }

        $vip_sum = DB::table('user_details')->where('plan_id', 3)->select(DB::raw('count(id) as total'),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
        ->groupBy('year','month')->orderBy('year','DESC')->orderBy('month','DESC')->limit(8)
        ->pluck("total")->toArray();

        if(count($vip_sum) < 9){
            $vip_to_add = 9-count($vip_sum);
            for($i=0 ; $i<$vip_to_add ; $i++){
                array_push($vip_sum,0);
            }
        }

        $countries = DB::table('user_details')
        ->select('residence_country_name', DB::raw('count(residence_country_name) as total'))
        ->groupBy('residence_country_name')->orderBy('total','Desc')
        ->limit(8)->get();

        // return $countries;
        $total_users = User::count();


        return view('admin.analytics.users',compact('total_users','vip','gold','free','new','online','males','females','under_20','from_20_30'
                    ,'from_30_40','from_40_50','above_50','countries','total_users','months_arr','free_sum','gold_sum','vip_sum'));
    }

    public function app_links()
    {
        $ios = SettingText::where('key','ios')->first()->value;
        $android = SettingText::where('key','android')->first()->value;
        return view('admin.links.index',compact('ios','android'));
    }

    public function update_app_links(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ios' => 'required|max:190',
            'android' => 'required|max:190',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('errors',$validator->messages())->withInput();
        }

        $ios = SettingText::where('key','ios')->update(['value' => $request->ios]);
        $android = SettingText::where('key','android')->update(['value' => $request->android]);
        return redirect()->back()->with('success', 'Updated successfully');
    }

    public function incomes_analytics()
    {
        $month_arr = [];
        $total_arr = [];
        for($i=0 ; $i < 15 ;$i++)
        {
            $month = Carbon::now()->subDays($i)->format('M');
            $day_num = Carbon::now()->subDays($i)->day;
            
            $day = $day_num.' '.$month;
            array_push($month_arr,$day);

            $total_plans = DB::table('subscriptions')->where('status',1)->where('created_at','<',Carbon::now()->subDays($i))->where('created_at','>',Carbon::now()->subDays($i+1))
            ->select(DB::raw('sum(price) as total'))->first()->total;

            $total_coins = DB::table('purchase_coins')->where('status',1)->where('created_at','<',Carbon::now()->subDays($i))->where('created_at','>',Carbon::now()->subDays($i+1))
            ->select(DB::raw('sum(price) as total'))->first()->total;
            $total_plans = $total_plans == null ? 0 : $total_plans;
            $total_coins = $total_coins == null ? 0 : $total_coins;
            $total = $total_plans + $total_coins;
            array_push($total_arr,$total );


        }

        $countries = Subscription::with('user.details:user_id,residence_country_name')->get();
        
        $countries = $countries->groupBy('user.details.residence_country_name')->map(function ($brands) {
            $data = $brands->where('status',1)->sum('price');
            return $data;
          })->sortDesc()->take(8);
        $total_users = Subscription::where('status',1)->sum('price');

        $countries1 = PurchaseCoin::with('user.details:user_id,residence_country_name')->get();
        
        $countries1 = $countries1->groupBy('user.details.residence_country_name')->map(function ($brands) {
            $data = $brands->where('status',1)->sum('price');
            return $data;
        })->sortDesc()->take(8);
        $total_users1 = PurchaseCoin::where('status',1)->sum('price');

        $general_total = $total_users1 + $total_users;
        $stripe = Subscription::where('payment_method','stripe')->where('status',1)->sum('price') + PurchaseCoin::where('payment_method','stripe')->where('status',1)->sum('price');
        $myfatoorah = Subscription::where('payment_method','myfatoorah')->where('status',1)->sum('price') + PurchaseCoin::where('payment_method','myfatoorah')->where('status',1)->sum('price');
        
        $gold = Subscription::where('subscriptable_type','App\Models\Plan')->where('subscriptable_id',2)->where('status',1)->sum('price');
        $gold_packages = PlanPackage::where('plan_id',2)->pluck('id')->toArray();
        $gold_packages_sum = Subscription::where('subscriptable_type','App\Models\PlanPackage')->whereIn('subscriptable_id',$gold_packages)->where('status',1)->sum('price');
        $gold = $gold + $gold_packages_sum;

        $vip = Subscription::where('subscriptable_type','App\Models\Plan')->where('subscriptable_id',3)->where('status',1)->sum('price');
        $vip_packages = PlanPackage::where('plan_id',3)->pluck('id')->toArray();
        $vip_packages_sum = Subscription::where('subscriptable_type','App\Models\PlanPackage')->whereIn('subscriptable_id',$vip_packages)->where('status',1)->sum('price');
        $vip = $vip + $vip_packages_sum;

        $coins = DB::table('purchase_coins')->where('status',1)->select('coin_id',DB::raw('sum(price) as total'))->groupBy('coin_id')->get();
        $coins_names = $coins->pluck('coin_id')->toArray();
        $coins_names = Coin::whereIn('id',$coins_names)->pluck('coins')->toArray();
        $coins_total = array_map( function($value) { return (int)$value; }, $coins->pluck("total")->toArray() );
        // return $coins_total;
        return view('admin.analytics.incomes',compact('month_arr','total_arr','total_users','countries',
        'countries1','total_users1','general_total','stripe','myfatoorah','gold','vip','coins_total','coins_names'));
    }

    public function interactions_analytics()
    {
        $total_chats = Chat::where('thread_id','not like','s%')->where('thread_id','not like','admin%')->count();
        $total_likes = Like::count();
        $total_gifts = UserGift::count();
        $total_Blocks = Block::count();

        $month_arr = [];
        $likes = [];
        $gifts = [];
        $blocks = [];
        $chats = [];
        for($i=0 ; $i < 7 ;$i++)
        {
            $month = Carbon::now()->subMonths($i)->format('M');
            
            array_push($month_arr,$month);

            $likes_tot = DB::table('likes')->where('created_at','<',Carbon::now()->startOfMonth()->subMonths($i-1))->where('created_at','>',Carbon::now()->startOfMonth()->subMonths($i))
            ->select(DB::raw('count(id) as total'))->first()->total;
            $gifts_tot = DB::table('user_gifts')->where('created_at','<',Carbon::now()->startOfMonth()->subMonths($i-1))->where('created_at','>',Carbon::now()->startOfMonth()->subMonths($i))
            ->select(DB::raw('count(id) as total'))->first()->total;
            $blocks_tot = DB::table('blocks')->where('created_at','<',Carbon::now()->startOfMonth()->subMonths($i-1))->where('created_at','>',Carbon::now()->startOfMonth()->subMonths($i))
            ->select(DB::raw('count(id) as total'))->first()->total;
            $chats_tot = DB::table('chats')->where('thread_id','not like','s%')->where('thread_id','not like','admin%')->where('created_at','<',Carbon::now()->startOfMonth()->subMonths($i-1))->where('created_at','>',Carbon::now()->startOfMonth()->subMonths($i))
            ->select(DB::raw('count(id) as total'))->first()->total;
            array_push($likes,$likes_tot );
            array_push($gifts,$gifts_tot );
            array_push($blocks,$blocks_tot );
            array_push($chats,$chats_tot );


        }
        
        return view('admin.analytics.interactions',compact('total_chats','total_likes','total_gifts','total_Blocks'
        ,'month_arr','likes','gifts','blocks','chats'));
    }

    public function incomes_data()
    {
        if(request()->has('type') && request()->type == 'plan'){
            $incomes = Subscription::where('status',1)->orderBy('created_at','DESC')->get();
        }elseif(request()->has('type') && request()->type == 'myfatoorah'){
            $incomes1 = Subscription::where('status',1)->where('payment_method','myfatoorah')->get();
            $incomes2 = PurchaseCoin::where('status',1)->where('payment_method','myfatoorah')->get();
            $incomes = $incomes1->merge($incomes2);
            $incomes = $incomes->sortByDesc('created_at')->values();
        }elseif(request()->has('type') && request()->type == 'stripe'){
            $incomes1 = Subscription::where('status',1)->where('payment_method','stripe')->get();
            $incomes2 = PurchaseCoin::where('status',1)->where('payment_method','stripe')->get();
            $incomes = $incomes1->merge($incomes2);
            $incomes = $incomes->sortByDesc('created_at')->values();
        }elseif(request()->has('type') && request()->type == 'coins'){
            $incomes = PurchaseCoin::where('status',1)->orderBy('created_at','DESC')->get();

        }
        else{
            $incomes1 = Subscription::where('status',1)->get();
            $incomes2 = PurchaseCoin::where('status',1)->get();
            $incomes = $incomes1->merge($incomes2);
            $incomes = $incomes->sortByDesc('created_at')->values();
        }
        return view('admin.analytics.incomes_data',compact('incomes'));
        
        
    }

    public function interactions_data()
    {
        if(request()->has('type') && request()->type == 'chats'){
            $type = 'chats';
            $interactions = Chat::where('thread_id','not like','s%')->where('thread_id','not like','admin%')->orderBy('created_at','DESC')->get();
        }elseif(request()->has('type') && request()->type == 'likes'){
            $type = 'likes';
            $interactions = Like::orderBy('created_at','DESC')->get();
        }elseif(request()->has('type') && request()->type == 'gifts'){
            $type = 'gifts';
            $interactions = USerGift::orderBy('created_at','DESC')->get();
        }elseif(request()->has('type') && request()->type == 'blocks'){
            $type = 'blocks';
            $interactions = Block::orderBy('created_at','DESC')->get();
        }
        // return $interactions;
        return view('admin.analytics.interactions_data',compact('interactions','type'));

    }
}
