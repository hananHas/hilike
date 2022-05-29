<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\MarriageType;
use App\Helpers\ListHelper;
use DB;
use App\Models\UserDetail;

class MarriageTypesController extends Controller
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
        $marriage_types = MarriageType::all();
        return view('admin.marriage_types.index', compact('marriage_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.marriage_types.create');
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

        $MarriageType = MarriageType::create(['name' => $request->name]);

        $translate = ListHelper::translate($request->ar_name,$MarriageType);

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
        $marriage_type = MarriageType::find($id);
        return view('admin.marriage_types.edit', compact('marriage_type'));
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

        $marriage_type = MarriageType::find($id);
        $marriage_type->name = $request->name;
        $marriage_type->update();

        $translate = ListHelper::translate($request->ar_name,$marriage_type);

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
        $marriage_type = MarriageType::find($id);
        $marriage_type->translate()->delete();
        $user_details = UserDetail::where('marriage_type_id',$id)->update(['marriage_type_id' => null , 'profile_progress' =>  DB::raw('profile_progress - 5')]);
      
        $marriage_type->delete();

       return redirect()->back()->with('success', 'Deleted successfully');
    }
}
