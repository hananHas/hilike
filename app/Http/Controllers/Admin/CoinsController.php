<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coin;
use Validator;

class CoinsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:coins-management');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coins = Coin::all();
        return view('admin.coins.index', compact('coins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coins.create');
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
            'price' => 'required|numeric',
            'coins' => 'required|numeric',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('errors',$validator->messages())->withInput();
        }

        $coin = Coin::create(['price' => $request->price , 'coins' => $request->coins ]);

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
        $coin = Coin::find($id);
        return view('admin.coins.edit', compact('coin'));
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
            'price' => 'required|numeric',
            'coins' => 'required|numeric',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('errors',$validator->messages())->withInput();
        }

        $coin = Coin::find($id);
        $coin->price = $request->price;
        $coin->coins = $request->coins;
        $coin->update();

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
        $coin = Coin::find($id);
        $coin->delete();

       return redirect()->back()->with('success', 'Deleted successfully');
    }
}
