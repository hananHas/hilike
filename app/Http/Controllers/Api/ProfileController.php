<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserDetail;
use App\Models\UserImage;
use App\Models\UserGift;
use App\Models\Gift;
use App\Http\Resources\UserResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\AttrResource;
use App\Http\Resources\ArabicAttrResource;
use App\Http\Resources\GiftResource;
use App\Http\Resources\AllGiftsResource;
use App\Http\Resources\MyUserResource;
use App\Http\Resources\ProfileImagesResource;
use DB;
use App\Models\Country;
use App\Models\Like;
use App\Models\Religion;
use App\Models\Job;
use App\Models\SocialType;
use App\Models\MarriageType;
use App\Models\SkinColor;
use App\Models\Body;
use App\Models\Education;
use App\Models\SettingText;
use File;
use App\Helpers\ListHelper;
use Validator;
use App\Models\Report;
use Illuminate\Support\Facades\App;

class ProfileController extends Controller
{
    public function user_profile($id)
    {
        $c_user = auth()->user()->details;
        $user = UserDetail::where('user_id',$id)
        ->select(DB::raw('*, ( 6367 * acos( cos( radians('.$c_user->latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$c_user->longitude.') ) + sin( radians('.$c_user->latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
        ->first();

        $images = UserImage::where('user_id',$id)->where('confirmed',1)->get();

        $is_liked = Like::where('from_user',$c_user->user_id)->where('to_user',$id)->count();

        return response()->json([
            'main_data' => new UserResource($user),
            'images' => ImageResource::collection($images),
            'other_info' => new ProfileResource($user),
            'is_liked' => $is_liked == 0 ? 0 : 1 
        ]);
    }

    public function user_images($id)
    {   
        $profile_image = UserDetail::where('user_id',$id)->first()->profile_image;
        $images = UserImage::where('user_id',$id)->where('confirmed',1)->get();

        return response()->json([
            'profile_image' => url("images/users/{$profile_image}"),
            'images' => ImageResource::collection($images),
        ]);
    }

    public function my_profile()
    {
        $user = auth()->user();
        $details = $user->details;
        $images = UserImage::where('user_id',$user->id)->get();
        $gifts = UserGift::where('to_user',$user->id)->pluck('gift_id');
        $gifts = Gift::whereIn('id',$gifts)->limit(12)->get();

        return response()->json([
            'main_data' => new MyUserResource($details),
            'balance' => $details->balance,
            'gifts' => AllGiftsResource::collection($gifts),
            'images' => ProfileImagesResource::collection($images),
            'other_info' => new ProfileResource($details),
            'profile_progress' => $details->profile_progress,
            'is_social' => $user->provider_token != null ? 1 : 0,
            'notification' => $user->details->notification_messages,
        ]);
    }

    public function my_received_gifts()
    {
        $user = auth()->user();
        $gifts = UserGift::where('to_user',$user->id)->with('gift','user.details')->get();
        // return $gifts;

        return response()->json([
            'gifts' => GiftResource::collection($gifts),
        ]);
    }


    public function edit_profile()
    {
        $user = auth()->user();
        $details = $user->details;
        $images = UserImage::where('user_id',$user->id)->get();

        if($details->language == 'en'){
            $religions = Religion::select('id','name')->get();
            $jobs = Job::select('id','name')->get();
            $social_types = SocialType::select('id','name')->get();
            $marriage_types = MarriageType::select('id','name')->get();
            $education = Education::select('id','name')->get();
            $skin_colors = SkinColor::select('id','name')->get();
            $body_shapes = Body::select('id','name')->get();

            return response()->json([
                'main_data' => new UserResource($details),
                'profile_progress' => $details->profile_progress,
                'images' => ProfileImagesResource::collection($images),
                'other_info' => new ProfileResource($details),
                'religions' => AttrResource::collection($religions),
                'jobs' => $jobs,
                'social_types' => $social_types,
                'marriage_types' => $marriage_types,
                'education' => $education,
                'skin_colors' => $skin_colors,
                'body_shapes' => $body_shapes
               
            ]);
        }
        else{
            $religions = Religion::select('id','name')->with('translate')->get();
            $jobs = Job::select('id','name')->with('translate')->get();
            $social_types = SocialType::select('id','name')->with('translate')->get();
            $marriage_types = MarriageType::select('id','name')->with('translate')->get();
            $education = Education::select('id','name')->with('translate')->get();
            $skin_colors = SkinColor::select('id','name')->with('translate')->get();
            $body_shapes = Body::select('id','name')->with('translate')->get();

            return response()->json([
                'main_data' => new UserResource($details),
                'profile_progress' => $details->profile_progress,
                'images' => ProfileImagesResource::collection($images),
                'other_info' => new ProfileResource($details),
                'religions' => ArabicAttrResource::collection($religions),
                'jobs' => ArabicAttrResource::collection($jobs),
                'social_types' => ArabicAttrResource::collection($social_types),
                'marriage_types' => ArabicAttrResource::collection($marriage_types),
                'education' => ArabicAttrResource::collection($education),
                'skin_colors' => ArabicAttrResource::collection($skin_colors),
                'body_shapes' => ArabicAttrResource::collection($body_shapes)
               
            ]);
        }
        
        
        
    }

    public function update_profile(Request $request)
    {
        $user = auth()->user()->details;
        $requestData = $request->all();
        if($request->has('profile_image') && $request->file('profile_image') != null){

            $image_path = public_path()."/images/users/".$user->profile_image;  // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $ext = $request->file('profile_image')->getClientOriginalExtension();
            // filename to store
            $image_name = $request->input('nickname').'_'.rand().'.'.$ext;
            // upload image
            $path = public_path().'/images/users';
            $uplaod = $request->file('profile_image')->move($path,$image_name);
            
            $requestData['profile_image'] = $image_name;
            $requestData['confirmed_image'] = null;
            

        }

        if($request->has('other_images') && $request->other_images != null){
            foreach($request->other_images as $i => $image){
                $ext = $image->getClientOriginalExtension();
                // filename to store
                $image_name = $request->input('nickname').$i.'_'.rand().'.'.$ext;
                // upload image
                $path = public_path().'/images/users';
                $uplaod = $image->move($path,$image_name);
                
                $new_image = UserImage::create([
                    'image' => $image_name,
                    'user_id' => $user->user_id
                ]);
                
            }
        }
        unset($requestData['other_images']);

        if($request->has('looking_for')){
            $requestData['confirmed_looking_for'] = null;
        }
        if($request->has('about')){
            $requestData['confirmed_about'] = null;
        }
        if($request->has('nickname')){
            $requestData['confirmed_nickname'] = null;
        }
        $details = UserDetail::where('id', $user->id)->update($requestData);
        if(isset($requestData['language'])){
            App::setLocale($requestData['language']);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => trans('messages.updated_successfully')
           
        ]);
    }

    public function delete_image($id)
    {
        $image = UserImage::find($id);
        $image_path = public_path()."/images/users/".$image->image;  // Value is not URL but directory file path
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $image->delete();

        return response()->json([
            'status' => 'success',
            'message' => trans('messages.deleted_successfully')
           
        ]);
    }

    public function get_report_reasons()
    {
        $report_reasons = SettingText::where('key','report_reasons')->first()->value;
        return response()->json([
            'report_reasons' =>  (explode("!!",$report_reasons)),
        ]);
    }

    public function report_user(Request $request)
    {
        $requestData = $request->all();

        $validator = Validator::make($requestData, [
            'to_user' => 'required',
            'reason' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
            'status' => 'error',
            'message' => $validator->messages()->first(),
            ]); 
        }

        $requestData['from_user'] = auth()->user()->id;
        $report = Report::create($requestData);

        return response()->json([
            'status' => 'success',
            'message' => trans('messages.reported_successfully')
        ]);
    }
}
