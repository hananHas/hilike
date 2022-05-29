<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\SocialType;
use App\Helpers\ListHelper;
use DB;
use App\Models\UserDetail;

class SocialTypesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:filters-management');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $social_types = SocialType::all();
        return view('admin.social_types.index', compact('social_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.social_types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:190',
            'ar_name' => 'required|max:190',
        ],
        [
            'ar_name.required' => 'The Arabic name field is required.'
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('errors',$validator->messages())->withInput();
        }

        $SocialType = SocialType::create(['name' => $request->name]);

        $translate = ListHelper::translate($request->ar_name,$SocialType);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $social_type = SocialType::find($id);
        return view('admin.social_types.edit', compact('social_type'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:190',
            'ar_name' => 'required|max:190',
        ],
        [
            'ar_name.required' => 'The Arabic name field is required.'
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('errors',$validator->messages())->withInput();
        }

        $social_type = SocialType::find($id);
        $social_type->name = $request->name;
        $social_type->update();

        $translate = ListHelper::translate($request->ar_name,$social_type);

        return redirect()->back()->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $social_type = SocialType::find($id);
        $social_type->translate()->delete();
        $user_details = UserDetail::where('social_type_id',$id)->update(['social_type_id' => null , 'profile_progress' =>  DB::raw('profile_progress - 5')]);
      
        $social_type->delete();

       return redirect()->back()->with('success', 'Deleted successfully');
    }
}
