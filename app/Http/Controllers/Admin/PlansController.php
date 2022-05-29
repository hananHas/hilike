<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanPackage;
use Illuminate\Http\Request;
use Validator;
use App\Models\SettingText;

class PlansController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:plans-management');
    }
    public function index(){
        $plans = Plan::all();
        return view('admin.plans.index', compact('plans'));
    
    }

    public function edit_price($id){
        $plan = Plan::find($id);
        if($id == 2){
            $free_trial = SettingText::where('key','free_trial')->first()->value;
            return view('admin.plans.edit_price', compact('plan','free_trial'));

        }
        return view('admin.plans.edit_price', compact('plan'));
    }

    public function update(Request $request,$id){

        $validator = Validator::make($request->all(), [
            'price' => 'required|numeric',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('errors',$validator->messages())->withInput();
        }

        $plan = Plan::find($id);
        $plan->price = $request->price;
        $plan->description = $request->description;
        $plan->ar_description = $request->ar_description;
        $plan->update();

        if($id ==2){
            if($request->has('free_trial'))
            $free_trial = SettingText::where('key','free_trial')->update(['value' => 1]);
            else
            $free_trial = SettingText::where('key','free_trial')->update(['value' => 0]);

        }

        return redirect()->back()->with('success', 'Updated successfully');
        
    }

    public function packages($id)
    {
        $packages = PlanPackage::where('plan_id',$id)->get();
        return view('admin.plans.packages', compact('packages','id'));
    }

    public function add_packages(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'price' => 'required|numeric',
            'months' => 'required|numeric',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('errors',$validator->messages())->withInput();
        }

        $plan = Plan::find($id);
        if($request->price > ($request->months * $plan->price))
        {
            return redirect()->back()->with('error', $request->months.' months package for '.$plan->name.' plan can\'t be more than '.$request->months * $plan->price);
        }

        $package = new PlanPackage;
        $package->price = $request->price;
        $package->months = $request->months;
        $package->plan_id = $id;
        $package->save();
    
       
        return redirect()->back()->with('success', 'Updated successfully');
    }

    public function delete_package($id)
    {
        $package = PlanPackage::find($id);
        $package->delete();
        return redirect()->back()->with('success', 'Deleted successfully');
    }
    
}
