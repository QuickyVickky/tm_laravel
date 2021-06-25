<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Project;
use App\Models\DailyTask;
use App\Models\Admin;
date_default_timezone_set('Asia/Kolkata');
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Exports\JustExcelExport;
use Maatwebsite\Excel\Facades\Excel;


class DailyTaskController extends Controller
{
    private $tbl = "daily_tasks";
    private $tbl2 = "projects";
    private $tbl3 = "project_category";
    

    public function index(Request $request){
        $data = [ 'control' => 'DailyTask'];
        return view('admin.project.dailytask.list')->with($data);
    }

    public function indexAll(Request $request){
        if_allowedRoute("daily-tasks-all");
        $dataAdmin = Admin::whereIn('is_active', constants('is_active'))->limit(1000)->get();
        $dataProject = Project::whereIn('is_active', constants('is_active'))->limit(1000)->get();
        $data = [ 'control' => 'DailyTask', 'dataAdmin' => $dataAdmin, 'dataProject' => $dataProject ];
        return view('admin.project.dailytask.listall')->with($data);
    }

    public function getEdit(Request $request){
        $one = DailyTask::where('id', $request->id)->first();
        $response = [ 'one' => $one,  ];
        return response()->json($response);
    }

    public function getData(Request $request){
        $status = "'" . implode ( "', '", constants('is_active') ) . "'";
        $status_sql =  " dt.is_active IN(".$status.") and dt.admin_id=".Session::get('adminid')." ";

        $columns = array(          
            0 => 'dt.id',
            1 => 'p.project_name',
            2 => 'dt.task_description',
            3 => 'dt.dailytask_minutes',
            4 => 'dt.overtime_minutes',
        );

        $filter_global_date_Sql = '';
        if(isset($request->filter_global_date) && strlen($request->filter_global_date)==23){
            $date_start = explode(' - ', $request->filter_global_date);
            if(isset($date_start[1])){
                $stop_date = date('Y-m-d', strtotime($date_start[1] . ' +0 day'));
                $filter_global_date_Sql = " and dt.dailytask_date BETWEEN '".$date_start[0]."' and '".$stop_date."' ";
            }
        }


        $sqlx = " from ".$this->tbl." dt LEFT JOIN ".$this->tbl2." p ON p.id=dt.project_id LEFT JOIN ".$this->tbl3." pc ON pc.id=dt.project_category_id WHERE $status_sql $filter_global_date_Sql ";
        $sql = "select dt.*,p.project_name,pc.category_title $sqlx ";
        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        $sqlS = '';
        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sqlS .= " and ( p.project_name LIKE " . $searchString;
            $sqlS .= " OR pc.category_title LIKE " . $searchString;
            $sqlS .= " OR dt.dailytask_date LIKE " . $searchString;
            $sqlS .= " OR dt.task_description LIKE " . $searchString . ")";
        }
        $sql .= $sqlS;
        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $sqltotalHour = "select SUM(dt.dailytask_minutes) as totalHour $sqlx $sqlS ";
        $totalMinutes = qry($sqltotalHour)[0]->totalHour;

        $cnts = $request->start + 1;
        foreach ($query as $row) {
            $projectCategoryText = "<br><span class='badge badge-pill bg-info-light'>".$row->category_title."</span>";
            $view = '<br><a href="javascript:void(0)" class="btn btn-rounded btn-outline-success edititdailytask" data-id="'.$row->id.'" title="edit this"><i class="fa fa-eye" aria-hidden="true"></i></a>';

            $nestedData = array();
            $nestedData[] = Carbon::parse($row->dailytask_date)->format('d-F-Y');
            $nestedData[] = $row->project_name.$projectCategoryText;
            $nestedData[] = nl2br($row->task_description);
            $nestedData[] = secondsToTimings($row->dailytask_minutes*60).$view;
            $nestedData[] = "<b class='redcolorcls'>".secondsToTimings($row->overtime_minutes*60)."</b>";
            $nestedData['DT_RowId'] = "r" . $row->id;
            $data[] = $nestedData;
            $cnts++;
        }

        $json_data = array(
            "draw" => intval($request['draw']), 
            "recordsTotal" => intval($totalData), 
            "recordsFiltered" => intval($totalFiltered), 
            "totalMinutes" => intval($totalMinutes),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function getDataAll(Request $request){
        $status = "'" . implode ( "', '", constants('is_active') ) . "'";
        $status_sql =  " dt.is_active IN(".$status.") ";
        $totalHour = 0;

        $columns = array(          
            0 => 'dt.dailytask_date',
            1 => 'p.project_name',
            2 => 'a.fullname',
            3 => 'dt.task_description',
            4 => 'dt.dailytask_minutes',
            5 => 'dt.overtime_minutes',
            6 => 'dt.created_at',
        );


        $filter_global_admin_id_Sql = '';
        $filter_global_project_id_Sql = '';
        $filter_global_date_Sql = '';


        if(isset($request->filter_global_admin_id) && is_array($request->filter_global_admin_id) && !empty($request->filter_global_admin_id)){
            $filter_global_admin_id_Status = "'" . implode ( "', '", $request->filter_global_admin_id ) . "'";
            $filter_global_admin_id_Sql =  " and dt.admin_id IN(".$filter_global_admin_id_Status.") ";
        }
        if(isset($request->filter_global_date) && strlen($request->filter_global_date)==23){
            $date_start = explode(' - ', $request->filter_global_date);
            if(isset($date_start[1])){
                $stop_date = date('Y-m-d', strtotime($date_start[1] . ' +0 day'));
                $filter_global_date_Sql = " and dt.dailytask_date BETWEEN '".$date_start[0]."' and '".$stop_date."' ";
            }
        }
        if(isset($request->filter_global_project_id) && is_array($request->filter_global_project_id) && !empty($request->filter_global_project_id)){
            $filter_global_project_id_Status = "'" . implode ( "', '", $request->filter_global_project_id ) . "'";
            $filter_global_project_id_Sql =  " and dt.project_id IN(".$filter_global_project_id_Status.") ";
        }

        $sqlx = " from ".$this->tbl." dt LEFT JOIN ".$this->tbl2." p ON p.id=dt.project_id LEFT JOIN ".$this->tbl3." pc ON pc.id=dt.project_category_id LEFT JOIN admins a ON a.id=dt.admin_id  WHERE $status_sql $filter_global_project_id_Sql $filter_global_date_Sql $filter_global_admin_id_Sql ";

        $sql = "select dt.*,p.project_name,pc.category_title,a.fullname as afullname,a.email as aemail $sqlx ";
        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        $sqlS = '';
        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sqlS .= " and ( p.project_name LIKE " . $searchString;
            $sqlS .= " OR pc.category_title LIKE " . $searchString;
            $sqlS .= " OR dt.dailytask_date LIKE " . $searchString;
            $sqlS .= " OR dt.task_description LIKE " . $searchString . ")";
        }

        $sql .= $sqlS;
        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  

        $query = qry($sql);

        $data = array();

        $sqltotalHour = "select SUM(dt.dailytask_minutes) as totalHour $sqlx $sqlS ";
        $totalMinutes = qry($sqltotalHour)[0]->totalHour;


        $cnts = $request->start + 1;
        foreach ($query as $row) {

            $projectCategoryText = "<br><span class='badge badge-pill bg-info-light'>".$row->category_title."</span>";

            $edit = '<a href="javascript:void(0)" class="btn btn-rounded btn-outline-warning edititdailytask" data-id="'.$row->id.'" title="edit this"><i class="fas fa-pen-square"></i></a>';


            $nestedData = array();
            $nestedData[] = Carbon::parse($row->dailytask_date)->format('d-F-Y');
            $nestedData[] = $row->project_name.$projectCategoryText;
            $nestedData[] = $row->afullname."[".$row->admin_id."]";
            $nestedData[] = nl2br($row->task_description);
            $nestedData[] = secondsToTimings($row->dailytask_minutes*60);
            $nestedData[] = "<b class='redcolorcls'>".secondsToTimings($row->overtime_minutes*60)."</b>";
            $nestedData[] = $edit;
            $nestedData['DT_RowId'] = "r" . $row->id;
            $data[] = $nestedData;
            $cnts++;
        }

        $json_data = array(
            "draw" => intval($request['draw']), 
            "recordsTotal" => intval($totalData), 
            "recordsFiltered" => intval($totalFiltered), 
            "totalMinutes" => intval($totalMinutes), 
            "data" => $data
        );

        echo json_encode($json_data);
    }


    public function getDataAllDateWise(Request $request){
        $status = "'" . implode ( "', '", constants('is_active') ) . "'";
        $status_sql =  " dt.is_active IN(".$status.") ";

        $columns = array(          
            0 => 'dt.dailytask_date',
            1 => 'a.fullname',
            2 => 'dt.dailytask_minutes',
            3 => 'dt.overtime_minutes',
            4 => 'dt.created_at',
        );


        $filter_global_admin_id_Sql = '';
        $filter_global_project_id_Sql = '';
        $filter_global_date_Sql = '';
        if(isset($request->filter_global_admin_id) && is_array($request->filter_global_admin_id) && !empty($request->filter_global_admin_id)){
            $filter_global_admin_id_Status = "'" . implode ( "', '", $request->filter_global_admin_id ) . "'";
            $filter_global_admin_id_Sql =  " and dt.admin_id IN(".$filter_global_admin_id_Status.") ";
        }
        if(isset($request->filter_global_date) && strlen($request->filter_global_date)==23){
            $date_start = explode(' - ', $request->filter_global_date);
            if(isset($date_start[1])){
                $stop_date = date('Y-m-d', strtotime($date_start[1] . ' +0 day'));
                $filter_global_date_Sql = " and dt.dailytask_date BETWEEN '".$date_start[0]."' and '".$stop_date."' ";
            }
        }
        if(isset($request->filter_global_project_id) && is_array($request->filter_global_project_id) && !empty($request->filter_global_project_id)){
            $filter_global_project_id_Status = "'" . implode ( "', '", $request->filter_global_project_id ) . "'";
            //$filter_global_project_id_Sql =  " and dt.project_id IN(".$filter_global_project_id_Status.") ";
        }

        $sqlx = " from ".$this->tbl." dt LEFT JOIN ".$this->tbl2." p ON p.id=dt.project_id LEFT JOIN ".$this->tbl3." pc ON pc.id=dt.project_category_id LEFT JOIN admins a ON a.id=dt.admin_id WHERE $status_sql $filter_global_project_id_Sql $filter_global_date_Sql $filter_global_admin_id_Sql ";

        $sql = "select dt.dailytask_date,dt.admin_id,a.fullname as afullname,a.email as aemail,sum(dt.dailytask_minutes) as dailytask_minutes,sum(dt.overtime_minutes) as overtime_minutes $sqlx ";
        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( dt.dailytask_date LIKE " . $searchString;
            $sql .= " OR a.fullname LIKE " . $searchString;
            $sql .= " OR dt.any_notes LIKE " . $searchString;
            $sql .= " OR dt.task_description LIKE " . $searchString . ")";
        }
        $sql .= " GROUP BY dt.dailytask_date,dt.admin_id ";  

        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $cnts = $request->start + 1;
        foreach ($query as $row) {
            $overTimeText = '';
            $edit = '<a href="javascript:void(0)" class="btn btn-rounded btn-outline-info getviewdailytaskdate" data-admin_id="'.$row->admin_id.'" data-dailytask_date="'.$row->dailytask_date.'"><i class="fa fa-eye"></i></a>';
            $nestedData = array();
            $nestedData[] = Carbon::parse($row->dailytask_date)->format('d-F-Y');
            $nestedData[] = $row->afullname."[".$row->admin_id."]";

            if($row->dailytask_minutes>constants('currentDailyTaskMinutes')){
                $overTimeMinutes = $row->dailytask_minutes - constants('currentDailyTaskMinutes');
                $overTimeText = "<br><b class='greencolorcls'> + ".secondsToTimings($overTimeMinutes*60)."</b>";
            }
            elseif($row->dailytask_minutes<constants('currentDailyTaskMinutes')){
                $overTimeMinutes = constants('currentDailyTaskMinutes') - $row->dailytask_minutes;
                $overTimeText = "<br><b class='redcolorcls'> - ".secondsToTimings($overTimeMinutes*60)."</b>";
            }

            $nestedData[] = secondsToTimings($row->dailytask_minutes*60).$overTimeText;
            $nestedData[] = "<b class='redcolorcls'>".secondsToTimings($row->overtime_minutes*60)."</b>";
            $nestedData[] = $edit;
            $nestedData['DT_RowId'] = "r" . $row->dailytask_date;
            $data[] = $nestedData;
            $cnts++;
        }

        $json_data = array(
            "draw" => intval($request['draw']), 
            "recordsTotal" => intval($totalData), 
            "recordsFiltered" => intval($totalFiltered), 
            "data" => $data
        );
        echo json_encode($json_data);
    }
    

    public function getDataAllDateWiseOfAdminId(Request $request){
        $status = "'" . implode ( "', '", constants('is_active') ) . "'";
        $status_sql =  " dt.is_active IN(".$status.") and dt.admin_id=".Session::get('adminid')." ";

        $columns = array(          
            0 => 'dt.dailytask_date',
            1 => 'a.fullname',
            2 => 'dt.dailytask_minutes',
            3 => 'dt.overtime_minutes',
            4 => 'dt.created_at',
        );

        $filter_global_date_Sql = '';
         if(isset($request->filter_global_date) && strlen($request->filter_global_date)==23){
            $date_start = explode(' - ', $request->filter_global_date);
            if(isset($date_start[1])){
                $stop_date = date('Y-m-d', strtotime($date_start[1] . ' +0 day'));
                $filter_global_date_Sql = " and dt.dailytask_date BETWEEN '".$date_start[0]."' and '".$stop_date."' ";
            }
        }

        $sqlx = " from ".$this->tbl." dt LEFT JOIN ".$this->tbl2." p ON p.id=dt.project_id LEFT JOIN ".$this->tbl3." pc ON pc.id=dt.project_category_id LEFT JOIN admins a ON a.id=dt.admin_id WHERE $status_sql $filter_global_date_Sql  ";

        $sql = "select dt.dailytask_date,dt.admin_id,a.fullname as afullname,a.email as aemail,sum(dt.dailytask_minutes) as dailytask_minutes,sum(dt.overtime_minutes) as overtime_minutes $sqlx ";
        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( dt.dailytask_date LIKE " . $searchString;
            $sql .= " OR a.fullname LIKE " . $searchString;
            $sql .= " OR dt.any_notes LIKE " . $searchString;
            $sql .= " OR dt.task_description LIKE " . $searchString . ")";
        }
        $sql .= " GROUP BY dt.dailytask_date,dt.admin_id ";  

        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $cnts = $request->start + 1;
        foreach ($query as $row) {
            $overTimeText = '';
            $edit = '<a href="javascript:void(0)" class="btn btn-rounded btn-outline-info getviewdailytaskdate" data-admin_id="'.$row->admin_id.'" data-dailytask_date="'.$row->dailytask_date.'"><i class="fa fa-eye"></i></a>';
            $nestedData = array();
            $nestedData[] = Carbon::parse($row->dailytask_date)->format('d-F-Y');

            if($row->dailytask_minutes>constants('currentDailyTaskMinutes')){
                $overTimeMinutes = $row->dailytask_minutes - constants('currentDailyTaskMinutes');
                $overTimeText = "<br><b class='greencolorcls'> + ".secondsToTimings($overTimeMinutes*60)."</b>";
            }
            elseif($row->dailytask_minutes<constants('currentDailyTaskMinutes')){
                $overTimeMinutes = constants('currentDailyTaskMinutes') - $row->dailytask_minutes;
                $overTimeText = "<br><b class='redcolorcls'> - ".secondsToTimings($overTimeMinutes*60)."</b>";
            }

            $nestedData[] = secondsToTimings($row->dailytask_minutes*60).$overTimeText;
            $nestedData[] = "<b class='redcolorcls'>".secondsToTimings($row->overtime_minutes*60)."</b>";
            $nestedData[] = $edit;
            $nestedData['DT_RowId'] = "r" . $row->dailytask_date;
            $data[] = $nestedData;
            $cnts++;
        }

        $json_data = array(
            "draw" => intval($request['draw']), 
            "recordsTotal" => intval($totalData), 
            "recordsFiltered" => intval($totalFiltered), 
            "data" => $data
        );
        echo json_encode($json_data);
    }


    public function addNewTask(Request $request) {
    	try {

        $validator = Validator::make($request->all(), [ 
            'hid' => 'required|integer|min:0',
            'project_id' => 'required|integer|min:1',
            'project_dailytask_hours' => 'required|integer|min:0|max:13',
            'project_dailytask_minutes' => 'required|integer|min:0|max:59',
            'is_active' => 'required|numeric',
            'task_description' =>'required|string|max:5000',
            'any_notes' =>'nullable|string|max:255',
            'project_category_id' => 'required|integer|min:1',
            'dailytask_date' => 'required|date_format:Y-m-d',
            'addOverTimeCheckBoxId' => 'nullable|integer|min:0',
            'overtime_dailytask_hours' => 'nullable|integer|min:0|max:7',
            'overtime_dailytask_minutes' => 'nullable|integer|min:0|max:59',
        ]);   

        if($validator->fails()) {  
            $response = ['msg' => 'Validation Failed, Please Check Properly.', 'success' => 0 ];
            return response()->json($response);
        }

        $dailytask_minutes = intval($request->project_dailytask_hours*60 + $request->project_dailytask_minutes*1);
        if($dailytask_minutes > 13*60 || $dailytask_minutes<1){
            $response = ['msg' => 'Timing Out Of Limit, Please Check Properly.', 'success' => 0 ];
            return response()->json($response);
        }
        
        $overtime_minutes = 0;
        if($request->addOverTimeCheckBoxId==1){
        $overtime_dailytask_hours = isset($request->overtime_dailytask_hours) ? $request->overtime_dailytask_hours : 0;
        $overtime_dailytask_minutes = isset($request->overtime_dailytask_minutes) ? $request->overtime_dailytask_minutes : 0;
        $overtime_minutes = intval($overtime_dailytask_hours*60 + $overtime_dailytask_minutes*1);
            if($overtime_minutes > 7*60 || $overtime_minutes<1 || $overtime_minutes >= $dailytask_minutes){
                $response = ['msg' => 'OverTime is Out Of Range, Please Check Properly.', 'success' => 0 ];
                return response()->json($response);
            }
        }


        $yesterday = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 days'));
        $dateRangeArray = [ date('Y-m-d'), $yesterday];
        if(!in_array($request->dailytask_date, $dateRangeArray)) {  
            $response = ['msg' => 'This Date is Not Allowed.', 'success' => 0 ];
            return response()->json($response);
        }

        $fromTimeAgo = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' -9 seconds'));
        $toTimeAhead = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +1 minutes'));
        $countInLastnTime =  DailyTask::where('admin_id', Session::get('adminid'))->where('created_at', 'LIKE' , date('Y-m-d').'%')->whereBetween('created_at', [$fromTimeAgo, $toTimeAhead])->where('is_active', constants('is_active.active'))->count();

        if($countInLastnTime > 0) {  
            $response = ['msg' => 'Please Wait 5-10 Seconds Before Next Task Submit.', 'success' => 0 ];
            return response()->json($response);
        } 


        $sumOfDailyTaskMinutes =  DailyTask::where('admin_id', Session::get('adminid'))->where('dailytask_date', 'LIKE' , $request->dailytask_date)->where('is_active', constants('is_active.active'))->sum('dailytask_minutes');
        $totalSumOfDailyTaskMinutes = $sumOfDailyTaskMinutes + $dailytask_minutes;

        if($totalSumOfDailyTaskMinutes > 13*60){
            $response = ['msg' => 'Timing is Exceeded More Than Daily Working Time Limit, Please Check Properly.', 'success' => 0 ];
            return response()->json($response);
        }


        if($request->hid==0){
            $insertData = [
                'dailytask_date' => $request->dailytask_date,
                'task_description' => trim($request->task_description),
                'admin_id' => Session::get('adminid'),
                'is_active' => ($request->is_active==0) ? 0 : 1,
                'project_id' => $request->project_id,
                'project_category_id' => ($request->project_category_id!='') ? $request->project_category_id : 0,
                'any_notes' => isset($request->any_notes) ? trim($request->any_notes) : NULL,
                'dailytask_minutes' => $dailytask_minutes, 
                'overtime_minutes'  => $overtime_minutes,
            ];
            $lastInsertData = DailyTask::create($insertData);

            if($lastInsertData->id > 0){
                pushNotificationToAdmin('Task Update', Session::get('adminfullname').' Task Update Added for '.$request->dailytask_date, env("APP_NAME"), env("APP_NAME").'Event', $icon='', $image='', route('daily-tasks-all'));
                $response = ['msg' => 'Submitted Successfully', 'success' => 1 ];
            }
            else
            {
                $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            }
            return response()->json($response);
        }
        else
        {
            $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            return response()->json($response);
        }
        } catch (\Exception $e) {
        	Log::error($e);
            $response = ['msg' => 'Error', 'success' => 0 ];
            return response()->json($response);
        }
    }
    
    public function updateDailyTask(Request $request) {
        if_allowedRoute("update-daily-project-task");

        try {

        $validator = Validator::make($request->all(), [ 
            'hid' => 'required|integer|min:1',
            //'project_id' => 'required|integer|min:1',
            //'project_category_id' =>'nullable|integer|min:1',
            'project_dailytask_hours' => 'required|integer|min:0|max:13',
            'project_dailytask_minutes' => 'required|integer|min:0|max:59',
            'is_active' => 'required|numeric',
            'task_description' =>'required|string|max:5000',
            'any_notes' =>'nullable|string|max:255',
            'dailytask_date' => 'required|date_format:Y-m-d',
            'addOverTimeCheckBoxId' => 'nullable|integer|min:0',
            'overtime_dailytask_hours' => 'nullable|integer|min:0|max:7',
            'overtime_dailytask_minutes' => 'nullable|integer|min:0|max:59',
        ]);   

        if($validator->fails()) {  
            $response = ['msg' => 'Validation Failed.', 'success' => 0 ];
            return response()->json($response);
        }


        if($request->dailytask_date > date('Y-m-d')) {  
            $response = ['msg' => 'This Date is Not Allowed.', 'success' => 0 ];
            return response()->json($response);
        }

        $is_exists =  DailyTask::where('id', $request->hid)->count();
        if($is_exists == 0) {  
            $response = ['msg' => 'Not Found.', 'success' => 0 ];
            return response()->json($response);
        }

        $dailytask_minutes = intval($request->project_dailytask_hours*60 + $request->project_dailytask_minutes*1);
        if($dailytask_minutes > 13*60 || $dailytask_minutes<1){
            $response = ['msg' => 'Timing Out Of Limit, Please Check Properly.', 'success' => 0 ];
            return response()->json($response);
        }

        $overtime_minutes = 0;
        if($request->addOverTimeCheckBoxId==1){
        $overtime_dailytask_hours = isset($request->overtime_dailytask_hours) ? $request->overtime_dailytask_hours : 0;
        $overtime_dailytask_minutes = isset($request->overtime_dailytask_minutes) ? $request->overtime_dailytask_minutes : 0;
        $overtime_minutes = intval($overtime_dailytask_hours*60 + $overtime_dailytask_minutes*1);
            if($overtime_minutes > 7*60 || $overtime_minutes<1 || $overtime_minutes >= $dailytask_minutes){
                $response = ['msg' => 'OverTime is Out Of Range, Please Check Properly.', 'success' => 0 ];
                return response()->json($response);
            }
        }


        if($is_exists>0){
            $updateData = [
                'dailytask_date' => $request->dailytask_date,
                'task_description' => trim($request->task_description),
                //'admin_id' => Session::get('adminid'),
                //'is_active' => ($request->is_active==0) ? 0 : 1,
                //'project_id' => $request->project_id,
                //'project_category_id' => ($request->project_category_id!='') ? $request->project_category_id : 0,
                'any_notes' => isset($request->any_notes) ? trim($request->any_notes) : NULL,
                'dailytask_minutes' => $dailytask_minutes, 
                'overtime_minutes'  => $overtime_minutes,
            ];
            DailyTask::where('id', $request->hid)->update($updateData);

            $response = ['msg' => 'Updated Successfully', 'success' => 1 ];

            return response()->json($response);
        }
        else
        {
            $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            return response()->json($response);
        }
        } catch (\Exception $e) {
            Log::error($e);
            $response = ['msg' => 'Error', 'success' => 0 ];
            return response()->json($response);
        }
    }
    
    public function exportExcelDailyTask(Request $request){
        if_allowedRoute("exportExcelDailyTask");

        $status = "'" . implode ( "', '", constants('is_active') ) . "'";
        $status_sql =  " dt.is_active IN(".$status.") ";
        $filter_global_admin_id_Sql = '';
        $filter_global_project_id_Sql = '';
        $filter_global_date_Sql = '';


        if(isset($request->filter_global_admin_id) && is_array($request->filter_global_admin_id) && !empty($request->filter_global_admin_id)){
            $filter_global_admin_id_Status = "'" . implode ( "', '", $request->filter_global_admin_id ) . "'";
            $filter_global_admin_id_Sql =  " and dt.admin_id IN(".$filter_global_admin_id_Status.") ";
        }
        if(isset($request->filter_global_date) && strlen($request->filter_global_date)==23){
            $date_start = explode(' - ', $request->filter_global_date);
            if(isset($date_start[1])){
                $stop_date = date('Y-m-d', strtotime($date_start[1] . ' +0 day'));
                $filter_global_date_Sql = " and dt.dailytask_date BETWEEN '".$date_start[0]."' and '".$stop_date."' ";
            }
        }
        if(isset($request->filter_global_project_id) && is_array($request->filter_global_project_id) && !empty($request->filter_global_project_id)){
            $filter_global_project_id_Status = "'" . implode ( "', '", $request->filter_global_project_id ) . "'";
            $filter_global_project_id_Sql =  " and dt.project_id IN(".$filter_global_project_id_Status.") ";
        }


        $sql = "select dt.dailytask_date as DailyTaskDate, dt.task_description, dt.any_notes, (dt.dailytask_minutes/60) as DailyTask_Hours,(dt.overtime_minutes/60) as OverTime_Hours, p.project_name,pc.category_title,a.fullname as FullName,a.email as EmailAddress from ".$this->tbl." dt LEFT JOIN ".$this->tbl2." p ON p.id=dt.project_id LEFT JOIN admins a ON a.id=dt.admin_id LEFT JOIN ".$this->tbl3." pc ON pc.id=dt.project_category_id WHERE $status_sql $filter_global_project_id_Sql $filter_global_date_Sql $filter_global_admin_id_Sql ";
        $transactions = qry($sql,1);


        if(count($transactions)>0){
            $column_name =  array_keys($transactions[0]);
            $export = new JustExcelExport($transactions, $column_name );
            return Excel::download($export, "Reports".time().'.xlsx'); 
        }
        else
        {
            Session::flash('cls', 'danger');
            Session::flash('msg', 'No Data Found!!');
            return redirect()->back();
        }
    }


    public function addNewTaskByAdmin(Request $request) {
        try {

        $validator = Validator::make($request->all(), [ 
            'hid' => 'required|integer|min:0',
            'project_id' => 'required|integer|min:1',
            'admin_id' => 'required|integer|min:1',
            'project_dailytask_hours' => 'required|integer|min:0|max:13',
            'project_dailytask_minutes' => 'required|integer|min:0|max:59',
            'is_active' => 'required|numeric',
            'task_description' =>'required|string|max:5000',
            'any_notes' =>'nullable|string|max:255',
            'project_category_id' =>'required|integer|min:1',
            'dailytask_date' => 'required|date_format:Y-m-d',
            'addOverTimeCheckBoxId' => 'nullable|integer|min:0',
            'overtime_dailytask_hours' => 'nullable|integer|min:0|max:7',
            'overtime_dailytask_minutes' => 'nullable|integer|min:0|max:59',
        ]);   

        if($validator->fails()) {  
            $response = ['msg' => 'Validation Failed.', 'success' => 0 ];
            return response()->json($response);
        }



        if($request->dailytask_date > date('Y-m-d')) {  
            $response = ['msg' => 'This Date is Not Allowed.', 'success' => 0 ];
            return response()->json($response);
        }

        $dailytask_minutes = intval($request->project_dailytask_hours*60 + $request->project_dailytask_minutes*1);
        if($dailytask_minutes > 13*60 || $dailytask_minutes<1){
            $response = ['msg' => 'Timing Out Of Limit, Please Check Properly.', 'success' => 0 ];
            return response()->json($response);
        }

        $fromTimeAgo = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' -9 seconds'));
        $toTimeAhead = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +1 minutes'));
        $countInLastnTime =  DailyTask::where('admin_id', $request->admin_id)->where('created_at', 'LIKE' , date('Y-m-d').'%')->whereBetween('created_at', [$fromTimeAgo, $toTimeAhead])->where('is_active', constants('is_active.active'))->count();

        if($countInLastnTime > 0) {  
            $response = ['msg' => 'Please Wait 5-10 Seconds Before Next Task Submit.', 'success' => 0 ];
            return response()->json($response);
        } 

        $sumOfDailyTaskMinutes =  DailyTask::where('admin_id', $request->admin_id)->where('dailytask_date', 'LIKE' , $request->dailytask_date)->where('is_active', constants('is_active.active'))->sum('dailytask_minutes');
        $totalSumOfDailyTaskMinutes = $sumOfDailyTaskMinutes + $dailytask_minutes;

        if($totalSumOfDailyTaskMinutes > 13*60){
            $response = ['msg' => 'Timing is Exceeded More Than Daily Working Time Limit, Please Check Properly.', 'success' => 0 ];
            return response()->json($response);
        }

        $overtime_minutes = 0;
        if($request->addOverTimeCheckBoxId==1){
        $overtime_dailytask_hours = isset($request->overtime_dailytask_hours) ? $request->overtime_dailytask_hours : 0;
        $overtime_dailytask_minutes = isset($request->overtime_dailytask_minutes) ? $request->overtime_dailytask_minutes : 0;
        $overtime_minutes = intval($overtime_dailytask_hours*60 + $overtime_dailytask_minutes*1);
            if($overtime_minutes > 7*60 || $overtime_minutes<1 || $overtime_minutes >= $dailytask_minutes){
                $response = ['msg' => 'OverTime is Out Of Range, Please Check Properly.', 'success' => 0 ];
                return response()->json($response);
            }
        }


        if($request->hid==0){
            $insertData = [
                'dailytask_date' => $request->dailytask_date,
                'task_description' => trim($request->task_description),
                'admin_id' => $request->admin_id,
                'is_active' => ($request->is_active==0) ? 0 : 1,
                'project_id' => $request->project_id,
                'project_category_id' => ($request->project_category_id!='') ? $request->project_category_id : 0,
                'any_notes' => isset($request->any_notes) ? trim($request->any_notes) : NULL,
                'dailytask_minutes' => $dailytask_minutes,
                'overtime_minutes' => $overtime_minutes, 
            ];

            $lastInsertData = DailyTask::create($insertData);

            if($lastInsertData->id > 0){
                $response = ['msg' => 'Submitted Successfully', 'success' => 1 ];
            }
            else
            {
                $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            }
            return response()->json($response);
        }
        else
        {
            $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            return response()->json($response);
        }
        } catch (\Exception $e) {
            Log::error($e);
            $response = ['msg' => 'Error'.$e->getMessage(), 'success' => 0 ];
            return response()->json($response);
        }
    }


    public function getDailyTasksListByAdminIdnDate(Request $request){
        $status = "'" . implode ( "', '", constants('is_active') ) . "'";
        $status_sql =  " dt.is_active IN(".$status.") and dt.admin_id=".$request->admin_id." and dt.dailytask_date LIKE '".$request->dailytask_date."' ";

        $columns = array(          
            0 => 'dt.id',
            1 => 'p.task_description',
            2 => 'a.dailytask_minutes',
            3 => 'dt.created_at',
        );


        $sqlx = " from ".$this->tbl." dt LEFT JOIN ".$this->tbl2." p ON p.id=dt.project_id LEFT JOIN ".$this->tbl3." pc ON pc.id=dt.project_category_id LEFT JOIN admins a ON a.id=dt.admin_id  WHERE $status_sql ";

        $sql = "select dt.*,p.project_name,pc.category_title,a.fullname as afullname,a.email as aemail $sqlx ";
        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( p.project_name LIKE " . $searchString;
            $sql .= " OR pc.category_title LIKE " . $searchString;
            $sql .= " OR dt.dailytask_date LIKE " . $searchString;
            $sql .= " OR dt.task_description LIKE " . $searchString . ")";
        }

        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $cnts = $request->start + 1;

        foreach ($query as $row) {

            $projectCategoryText = "<br><span class='badge badge-pill bg-info-light'>".$row->category_title."</span>";

            $edit = '<a href="javascript:void(0)" class="btn btn-rounded btn-outline-warning edititdailytask" data-id="'.$row->id.'" title="edit this"><i class="fas fa-pen-square"></i></a>';


            $nestedData = array();
            $nestedData[] = Carbon::parse($row->dailytask_date)->format('d-F-Y')."<br>".$row->project_name.$projectCategoryText;
            $nestedData[] = nl2br($row->task_description);
            $nestedData[] = secondsToTimings($row->dailytask_minutes*60);
            $nestedData[] = $edit;
            $nestedData['DT_RowId'] = "r" . $row->id;
            $data[] = $nestedData;
            $cnts++;
        }

        $json_data = array(
            "draw" => intval($request['draw']), 
            "recordsTotal" => intval($totalData), 
            "recordsFiltered" => intval($totalFiltered), 
            "data" => $data
        );
        echo json_encode($json_data);
    }


    public function getDailyTasksListByDate(Request $request){
        $status = "'" . implode ( "', '", constants('is_active') ) . "'";
        $status_sql =  " dt.is_active IN(".$status.") and dt.admin_id=".Session::get('adminid')." and dt.dailytask_date LIKE '".$request->dailytask_date."' ";

        $columns = array(          
            0 => 'dt.id',
            1 => 'p.task_description',
            2 => 'a.dailytask_minutes',
            3 => 'dt.created_at',
        );


        $sqlx = " from ".$this->tbl." dt LEFT JOIN ".$this->tbl2." p ON p.id=dt.project_id LEFT JOIN ".$this->tbl3." pc ON pc.id=dt.project_category_id LEFT JOIN admins a ON a.id=dt.admin_id  WHERE $status_sql ";

        $sql = "select dt.*,p.project_name,pc.category_title,a.fullname as afullname,a.email as aemail $sqlx ";
        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( p.project_name LIKE " . $searchString;
            $sql .= " OR pc.category_title LIKE " . $searchString;
            $sql .= " OR dt.dailytask_date LIKE " . $searchString;
            $sql .= " OR dt.task_description LIKE " . $searchString . ")";
        }

        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $cnts = $request->start + 1;

        foreach ($query as $row) {

            $projectCategoryText = "<br><span class='badge badge-pill bg-info-light'>".$row->category_title."</span>";

            $edit = '<a href="javascript:void(0)" class="btn btn-rounded btn-outline-warning edititdailytask" data-id="'.$row->id.'" title="view this"><i class="fa fa-eye"></i></a>';


            $nestedData = array();
            $nestedData[] = Carbon::parse($row->dailytask_date)->format('d-F-Y')."<br>".$row->project_name.$projectCategoryText;
            $nestedData[] = nl2br($row->task_description);
            $nestedData[] = secondsToTimings($row->dailytask_minutes*60);
            $nestedData[] = $edit;
            $nestedData['DT_RowId'] = "r" . $row->id;
            $data[] = $nestedData;
            $cnts++;
        }

        $json_data = array(
            "draw" => intval($request['draw']), 
            "recordsTotal" => intval($totalData), 
            "recordsFiltered" => intval($totalFiltered), 
            "data" => $data
        );
        echo json_encode($json_data);
    }    










































}
