<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
date_default_timezone_set('Asia/Kolkata');
use App\Models\Admin;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;



class DashboardController extends Controller
{
    private $tbl = "admins";

	public function index(Request $request) {
        $chartData = [];
        $thisMonth = date('Y-m').'%';

        $countAdmin = Admin::where('is_active', constants('is_active.active'))->count();
        $countProject = Project::where('is_active', constants('is_active.active'))->count();

        $sql = "SELECT (SUM(dt.dailytask_minutes)) as dailytaskMinutes, DATE(dt.dailytask_date) as date_number, count(*) as total_count FROM `daily_tasks` dt where dt.is_active=".constants('is_active.active')." AND dt.admin_id=".Session::get('adminid')." AND dt.dailytask_date LIKE '".$thisMonth."' GROUP BY DATE(dt.dailytask_date) ";
        $chartData['DailyTaskTimingOfThisMonth'] = qry($sql);

        $data = [ 'control' => 'Dashboard', 'countAdmin' => $countAdmin, 'countProject' => $countProject , 'chartData' => $chartData ];
		return view('admin.dashboard.index')->with($data);
	}

    public function log_out(Request $request) {
        $updateData = [ 'active_session' => NULL ];
        if(Session::has('adminid')){
            Admin::where('id', Session::get('adminid'))->update($updateData);
        }
        $request->session()->flush();
        return redirect()->route('loginpage');
    }


    public function main(Request $request){
        return view('admin.login');
    }




}
