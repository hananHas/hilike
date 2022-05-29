<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Gift;
use App\Models\GiftCategory;
use App\Models\UserGift;
use File;

class GiftsController extends Controller
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
        $gifts = Gift::all();
        return view('admin.gifts.index', compact('gifts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = GiftCategory::all();
        return view('admin.gifts.create',compact('categories'));
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
            'gift_category_id' => 'required|numeric',
            'price' => 'required|numeric',
            'image' => 'file|mimes:jpeg,jpg,png',
        ],
        [
            'gift_category_id.required' => 'The Category field is required.'
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('errors',$validator->messages())->withInput();
        }

        $ext = $request->file('image')->getClientOriginalExtension();
        // filename to store
        $image_name ='gift_'.rand().'.'.$ext;
        // upload image
        $path = public_path().'/images/gifts';
        $uplaod = $request->file('image')->move($path,$image_name);

        $gift = Gift::create([
            'gift_category_id' => $request->gift_category_id,
            'price' => $request->price,
            'image' => $image_name,
        ]);

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
        $gift = Gift::find($id);
        $categories = GiftCategory::all();
        return view('admin.gifts.edit', compact('gift','categories'));
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
            'gift_category_id' => 'required|numeric',
            'price' => 'required|numeric',
            'image' => 'file|mimes:jpeg,jpg,png',
        ],
        [
            'gift_category_id.required' => 'The Category field is required.'
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('errors',$validator->messages())->withInput();
        }

        $gift = Gift::find($id);
        if($request->has('image') && $request->file('image') != null){
            
            $image_path = public_path()."/images/gifts/".$gift->image;  // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $ext = $request->file('image')->getClientOriginalExtension();
            // filename to store
            $image_name ='gift_'.rand().'.'.$ext;
            // upload image
            $path = public_path().'/images/gifts';
            $uplaod = $request->file('image')->move($path,$image_name);
        }else{
            $image_name = $gift->image;
        }

        $gift->price = $request->price;
        $gift->image = $image_name;
        $gift->gift_category_id = $request->gift_category_id;
        $gift->update();

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
        $gift = Gift::find($id);
        $image_path = public_path()."/images/gifts/".$gift->image;  // Value is not URL but directory file path
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $user_gift = UserGift::where('gift_id',$id)->delete();
        $gift->delete();
 
        return redirect()->back()->with('success', 'Deleted successfully');
    }
}
