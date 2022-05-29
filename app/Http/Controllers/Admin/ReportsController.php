<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;

class ReportsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:report-list');
    }

    public function index()
    {
        $reports = Report::where('watched',0)->update(['watched'=>1]);
        $reports = Report::orderBy('id','DESC')->get();
        return view('admin.reports.index', compact('reports'));
    }

    public function delete_report($id)
    {
       $report = Report::find($id);
       $report->delete();

       return redirect()->back()->with('success', 'Deleted successfully');
    }
}
