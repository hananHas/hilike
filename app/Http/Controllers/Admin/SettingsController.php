<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingText;
use Validator;
use File;

class SettingsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:settings-management');
    }

    public function onboarding()
    {
        $onboarding = SettingText::where('key','like','onboarding%')->get();
        return view('admin.settings.onboarding', compact('onboarding'));
    }

    public function edit_onboarding($id)
    {
        $onboarding = SettingText::find($id);
        $screen_en = json_decode($onboarding->value);
        $screen_ar = json_decode($onboarding->ar_value);   
        return view('admin.settings.edit_onboarding', compact('screen_en','screen_ar','onboarding'));
    }

    public function update_onboarding(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:190',
            'ar_title' => 'required|max:190',
            'description' => 'required',
            'ar_description' => 'required',
            'image' => 'file|mimes:jpeg,jpg,png',
        ],
        [
            'ar_title.required' => 'The Arabic title field is required.',
            'ar_description.required' => 'The Arabic description field is required.'
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('errors',$validator->messages())->withInput();
        }

        $onboarding = SettingText::find($id);
        $screen = json_decode($onboarding->value);

        if($request->has('image') && $request->file('image') != null){
            if($screen){
                $image_path = public_path()."/images/onboarding/".$screen->image;  // Value is not URL but directory file path
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $ext = $request->file('image')->getClientOriginalExtension();
            // filename to store
            $image_name ='onboarding_'.rand().'.'.$ext;
            // upload image
            $path = public_path().'/images/onboarding';
            $uplaod = $request->file('image')->move($path,$image_name);
        }else{
            $image_name = $screen->image;
        }

        $onboarding_en = [];
        $onboarding_en['title'] = $request->title;
        $onboarding_en['description'] = $request->description;
        $onboarding_en['image'] = $image_name;

        $onboarding_ar = [];
        $onboarding_ar['title'] = $request->ar_title;
        $onboarding_ar['description'] = $request->ar_description;
        $onboarding_ar['image'] = $image_name;

        $onboarding_en = json_encode($onboarding_en);
        $onboarding_ar = json_encode($onboarding_ar);

        
        $onboarding->value = $onboarding_en;
        $onboarding->ar_value = $onboarding_ar;
        $onboarding->update();


        return redirect()->route('onboarding.index')->with('success', 'Updated successfully');
    }

    public function about_us()
    {
        $about = SettingText::where('key','about_us')->first();
        return view('admin.settings.about_us',compact('about'));
    }

    public function update_about_us(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'ar_value' => 'required',
        ],
        [
            'value.required' => 'The English text field is required.',
            'ar_value.required' => 'The Arabic text field is required.'
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('errors',$validator->messages())->withInput();
        }
        $about = SettingText::where('key','about_us')->first();
        $about->value = $request->value;
        $about->ar_value = $request->ar_value;
        $about->update();
        return redirect()->back()->with('success', 'Updated successfully');
        
    }

    public function usage_policy()
    {
        $usage_policy = SettingText::where('key','usage_policy')->first();
        return view('admin.settings.usage_policy',compact('usage_policy'));
    }

    public function update_usage_policy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'ar_value' => 'required',
        ],
        [
            'value.required' => 'The English text field is required.',
            'ar_value.required' => 'The Arabic text field is required.'
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('errors',$validator->messages())->withInput();
        }
        $usage_policy = SettingText::where('key','usage_policy')->first();
        $usage_policy->value = $request->value;
        $usage_policy->ar_value = $request->ar_value;
        $usage_policy->update();
        return redirect()->back()->with('success', 'Updated successfully');
        
    }

    public function privacy_policy()
    {
        $privacy_policy = SettingText::where('key','privacy_policy')->first();
        return view('admin.settings.privacy_policy',compact('privacy_policy'));
    }

    public function update_privacy_policy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'ar_value' => 'required',
        ],
        [
            'value.required' => 'The English text field is required.',
            'ar_value.required' => 'The Arabic text field is required.'
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('errors',$validator->messages())->withInput();
        }
        $privacy_policy = SettingText::where('key','privacy_policy')->first();
        $privacy_policy->value = $request->value;
        $privacy_policy->ar_value = $request->ar_value;
        $privacy_policy->update();
        return redirect()->back()->with('success', 'Updated successfully');
        
    }
}
