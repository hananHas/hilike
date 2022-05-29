<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\GiftCategory;
use App\Models\Gift;
use App\Helpers\ListHelper;

class GiftsCategoriesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:gifts-management');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = GiftCategory::all();
        return view('admin.gifts_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gifts_categories.create');
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

        $cat = GiftCategory::create(['name' => $request->name]);

        $translate = ListHelper::translate($request->ar_name,$cat);

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
        $cat = GiftCategory::find($id);
        return view('admin.gifts_categories.edit', compact('cat'));
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

        $cat = GiftCategory::find($id);
        $cat->name = $request->name;
        $cat->update();

        $translate = ListHelper::translate($request->ar_name,$cat);

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
        $GiftCategory = GiftCategory::find($id);
        $gifts = Gift::where('gift_category_id',$id)->delete();
        $GiftCategory->translate()->delete();
    
        $GiftCategory->delete();

       return redirect()->back()->with('success', 'Deleted successfully');
    }
}
