<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class SubscriptionsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:subscriptions-list');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.subscriptions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('admin.subscriptions.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_data()
    {
        $subscriptions = Subscription::orderBy('id','Desc')->with('user')->get();
        // return $users;
        return Datatables::of($subscriptions)->editColumn('created_at', function ($sub) {
            return Carbon::parse($sub->created_at)->toDateTimeString();
        })->editColumn('ends_at', function ($sub) {
            return Carbon::parse($sub->ends_at)->toDateTimeString();
        })->addColumn('plan', function ($sub) {
            if($sub->subscriptable_type == 'App\Models\Plan'){
                return $sub->subscriptable->name ;
            }else{
                return $sub->subscriptable->plan->name;
            }
            
        })->addColumn('months', function ($sub) {
            if($sub->subscriptable_type == 'App\Models\Plan'){
                return 1 ;
            }else{
                return $sub->subscriptable->months;
            }
            
        })
        ->rawColumns([
            'plan','months'
        ])->make(true);
    }

}
