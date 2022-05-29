<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Body;
use App\Models\UserDetail;
use App\Helpers\ListHelper;
use DB;

class BodyController extends Controller
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
        $body_shapes = Body::all();
        return view('admin.body_shapes.index', compact('body_shapes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.body_shapes.create');
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

        $body_shapes = Body::create(['name' => $request->name]);

        $translate = ListHelper::translate($request->ar_name,$body_shapes);

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
        $body_shape = Body::find($id);
        return view('admin.body_shapes.edit', compact('body_shape'));
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

        $body_shape = Body::find($id);
        $body_shape->name = $request->name;
        $body_shape->update();

        $translate = ListHelper::translate($request->ar_name,$body_shape);

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
        $body_shape = Body::find($id);
       $body_shape->translate()->delete();
       $user_details = UserDetail::where('body_id',$id)->update(['body_id' => null , 'profile_progress' =>  DB::raw('profile_progress - 5')]);
      
       $body_shape->delete();

       return redirect()->back()->with('success', 'Deleted successfully');
    }
}
