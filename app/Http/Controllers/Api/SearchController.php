<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Religion;
use App\Models\Job;
use App\Models\SocialType;
use App\Models\MarriageType;
use App\Models\UserDetail;
use App\Models\SkinColor;
use App\Models\Body;
use App\Models\Education;
use App\Models\Like;
use Carbon\Carbon;
use Auth;
use App\Helpers\ListHelper;
use App\Http\Resources\UserResource;
use DB;
class SearchController extends Controller
{
    public function search_filters()
    {
        $age_min = UserDetail::max('dob');
        $age_min = Carbon::parse($age_min)->age;
        $age_max = UserDetail::min('dob');
        $age_max = Carbon::parse($age_max)->age;

        $countries = Country::select('id','country_name')->get();
        $religions = Religion::select('id','name')->get();
        $social_types = SocialType::select('id','name')->get();
        $marriage_types = MarriageType::select('id','name')->get();
        $education = Education::select('id','name')->get();
        $children = UserDetail::select('children')->distinct('children')->pluck('children')->toArray();
        $height = UserDetail::select('height')->distinct('height')->pluck('height')->toArray();
        $skin_colors = SkinColor::select('id','name')->get();
        $body_shapes = Body::select('id','name')->get();

        return response()->json([
            'data' => [
                'age' =>[
                    'min' => $age_min,
                    'max' => $age_max,
                ],
                'countries' => $countries,
                'religions' => $religions,
                'social_types' => $social_types,
                'marriage_types' => $marriage_types,
                'education' => $education,
                'children' => $children,
                'height' => $height,
                'skin_colors' => $skin_colors,
                'body_shapes' => $body_shapes
            ]
        ]);
    }

    public function filtering(Request $request)
    {
        $user = Auth::user()->details;
        $query = UserDetail::where('gender',$user->wanted_gender)
        // ->orderBy('online','DESC')
        ->orderBy('last_visit','DESC')
        ->get();

        $blocked = ListHelper::blocked_users();
        $query = $query->whereNotIn('user_id',$blocked);

        if($request->has('min_age') && $request->has('max_age')){
            $min = $request->min_age;
            $max = $request->max_age;
            
            $query = $query->whereBetween('dob',[now()->subYears($max) , now()->subYears($min)] );
        }

        if($request->has('origin_country_id')){
            
            $query = $query->where('origin_country_id',$request->origin_country_id);
        }

        if($request->has('residence_country_id')){
            
            $query = $query->where('residence_country_id',$request->residence_country_id);
        }

        if($request->has('religion_id')){
            
            $query = $query->where('religion_id',$request->religion_id);
        }

        if($request->has('social_type_id')){
            
            $query = $query->where('social_type_id',$request->social_type_id);
        }

        if($request->has('marriage_type_id')){
            
            $query = $query->where('marriage_type_id',$request->marriage_type_id);
        }

        if($request->has('education_id')){
            
            $query = $query->where('education_id',$request->education_id);
        }

        if($request->has('job')){
            
            $query = $query->where('job',$request->children);
        }

        if($request->has('children')){
            
            $query = $query->where('children',$request->children);
        }

        if($request->has('smoking')){
            
            $query = $query->where('smoking',$request->smoking);
        }

        if($request->has('language')){
            
            $query = $query->where('language',$request->language);
        }

        if($request->has('height')){
            
            $query = $query->where('height',$request->height);
        }

        if($request->has('skin_color_id')){
            
            $query = $query->where('skin_color_id',$request->skin_color_id);
        }

        if($request->has('body_id')){
            
            $query = $query->where('body_id',$request->body_id);
        }

        $vip = $query->where('plan_id',3);

        $search_feeds = $query->where('plan_id','!=',3);

        return response()->json([
            'data' => [
                'vip' => UserResource::collection($vip),
                'search_feeds' => UserResource::collection($search_feeds),
            ]
        ]);
    }

    public function standard_filters()
    {
        $age_min = UserDetail::min('age');
        $age_max = UserDetail::max('age');

        
        return response()->json([
            'data' => [
                'age' =>[
                    'min' => $age_min,
                    'max' => $age_max,
                ],
                'distance' =>[
                    'min' => 0,
                    'max' => 100,
                ],
                'last_visit' =>[
                    'min' => 0,
                    'max' => 30,
                ],
            ]
        ]);
    }

    public function search_results(Request $request)
    {
        $offset = $request->has('offset') ? $request->offset : 0;
        $limit = $request->has('limit') ? $request->limit : 4;
        $user = Auth::user()->details;

        if($request->has('nearby') && $request->nearby == 1){
            $query = ListHelper::nearby_users($user)->where('distance','<',30);
        }elseif($request->has('liked_you')){
            $likes_list = Like::where('to_user',$user->user_id)->pluck('from_user')->toArray();
            $query = UserDetail::select(DB::raw('*, ( 6367 * acos( cos( radians('.$user->latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$user->longitude.') ) + sin( radians('.$user->latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
            ->whereIn('user_id',$likes_list)
            ->where('gender',$user->wanted_gender)
            ->where('visible',1)
            ->get();
        }
        else{
            $query = UserDetail::select(DB::raw('*, ( 6367 * acos( cos( radians('.$user->latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$user->longitude.') ) + sin( radians('.$user->latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
            ->where('gender',$user->wanted_gender)
            ->where('visible',1)
            ->get();
        }

        $blocked = ListHelper::blocked_users();
        $query = $query->whereNotIn('user_id',$blocked);

        if($request->has('q')){
            $term = $request->q;
            $query = $query->filter(function ($item) use ($term) {
                return false !== stripos($item->nickname, $term);
            });
        }

        if($request->has('online') &&  $request->online == 1){
            
            $query = $query->where('last_visit','>=',Carbon::now()->subMinutes(1)->toDateTimeString());
        }

        if($request->has('with_image') && $request->with_image == 1){
            
            $query = $query->where('profile_image','!=',null)->where('confirmed_image',1);
        }

        if($request->has('origin_country')){
            $country = $request->origin_country;
            $query = $query->filter(function ($item) use ($country) {
                return false !== stripos($item->origin_country_name, $country);
            });
        }

        if($request->has('residence_country')){
            $country1 = $request->residence_country;
            $query = $query->filter(function ($item) use ($country1) {
                return false !== stripos($item->residence_country_name, $country1);
            });
        }

        // if($request->has('same_country') && $request->same_country == 1){
        //     $query = $query->where('residence_country_name',$user->residence_country_name);
        // }

        if($request->has('min_distance') && $request->has('max_distance')){
            $query = $query->whereBetween('distance',[$request->min_distance , $request->max_distance]);
        }

        if($request->has('min_age') && $request->has('max_age')){
            $min = $request->min_age;
            $max = $request->max_age;
            
            $query = $query->whereBetween('age',[$min , $max] );
        }

        if($request->has('last_visit')){
            $last = now()->subDays($request->last_visit);
            $query = $query->where('last_visit','>',$last);
        }
        if($request->has('vip') && $request->vip == 1){
            $vip = $query->where('plan_id',3);
            return response()->json([
                'data' => [
                    'vip' => UserResource::collection($vip),
                ]
            ]);
        }else{
            $vip = $query->where('plan_id',3)->take(10);
        }
        $search_feeds = $query->where('plan_id','!=',3);
        // $search_feeds = UserResource::collection($search_feeds)->paginate(4)->appends(request()->except('page'));
        $search_feeds = UserResource::collection($search_feeds->skip($offset * $limit)->take($limit));
        return response()->json([
            'data' => [
                'vip' => UserResource::collection($vip),
                'search_feeds' => $search_feeds,
            ]
        ]);


    }

    
}
