<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\SkinColor;
use App\Helpers\ListHelper;
use DB;
use App\Models\UserDetail;

class SkinColorsController extends Controller
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
        $skin_colors = SkinColor::all();
        return view('admin.skin_colors.index', compact('skin_colors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.skin_colors.create');
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

        $skin_color = SkinColor::create(['name' => $request->name]);

        $translate = ListHelper::translate($request->ar_name,$skin_color);

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
        $skin_color = SkinColor::find($id);
        return view('admin.skin_colors.edit', compact('skin_color'));
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

        $skin_color = SkinColor::find($id);
        $skin_color->name = $request->name;
        $skin_color->update();

        $translate = ListHelper::translate($request->ar_name,$skin_color);

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
        $skin_color = SkinColor::find($id);
        $skin_color->translate()->delete();
        $user_details = UserDetail::where('skin_color_id',$id)->update(['skin_color_id' => null , 'profile_progress' =>  DB::raw('profile_progress - 5')]);
   
        $skin_color->delete();

       return redirect()->back()->with('success', 'Deleted successfully');
    }
}
