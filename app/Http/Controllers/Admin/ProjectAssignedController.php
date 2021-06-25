<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Services\CustomService;
use App\Models\Admin;
use App\Models\Project;
use App\Models\ProjectAssigned;
date_default_timezone_set('Asia/Kolkata');
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;



class ProjectAssignedController extends Controller
{
    private $tbl = "project_assigned";
    private $tbl2 = "projects";

    public function index(Request $request){
        $data = [ 'control' => 'Your Projects'];
        return view('admin.project.assigned.list')->with($data);
    }

    public function getEdit(Request $request){
        $response = ProjectAssigned::where('id', $request->id)->first();
        return response()->json($response);
    }

    public function getData(Request $request){
        $status = "'" . implode ( "', '", constants('is_active') ) . "'";
        $status_sql =  " pa.is_active IN(".$status.") and pa.admin_id=".Session::get('adminid')." ";

        $columns = array(          
            0 => 'pa.project_id',
            1 => 'p.project_name',
            2 => 'p.project_description',
            3 => 'pa.created_at',
        );

        $sql = "select pa.*,p.project_name,p.project_description,p.uuid as puuid, (select sum(dt.dailytask_minutes) from daily_tasks dt where dt.is_active IN(".$status.") and dt.admin_id=".Session::get('adminid')." and dt.project_id=pa.project_id) as total_minutes 
        from ".$this->tbl." pa INNER JOIN ".$this->tbl2." p ON p.id=pa.project_id 
        WHERE $status_sql ";
        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;


        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( p.project_name LIKE " . $searchString;
            $sql .= " OR pa.created_at LIKE " . $searchString;
            $sql .= " OR p.project_description LIKE " . $searchString . ")";
        }

        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $cnts = $request->start + 1;
        foreach ($query as $row) {

            $nestedData = array();
            $nestedData[] = $cnts;
            $nestedData[] = $row->project_name;
            $nestedData[] = $row->project_description;
            $nestedData[] = secondsToTimings($row->total_minutes*60,1).' <br> Total Hours';
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

    

    public function getProjectsInDropdown(Request $request){
        $dataArray = [];
        try {
            $searchTerm = ''; 
            if(isset($request->searchTerm)) {
                $searchTerm = $request->searchTerm;
            }


            $dataVendor = Project::where('is_active', constants('is_active.active'))
            ->where(function($querySearch) use ($searchTerm) {
                    $querySearch->where('project_name','LIKE', '%'.$searchTerm.'%')->orwhere('project_description','LIKE', '%'.$searchTerm.'%');
            })
          	->orderBy('id','ASC')
          	->limit(25)
          	->get();


            foreach ($dataVendor as $key => $value) {
                $dataArray[] = [
                "text" => $value->project_name,
                "id" => $value->id,
                ];
            }
            return response()->json($dataArray);
        } catch (\Exception $e) {
        	Log::error($e);
            return [];
        }
    }

    public function getAssignedProjectsOfAdmin(Request $request){
        try {
            $getAssignedProjects = ProjectAssigned::where('admin_id', $request->admin_id)->where('is_active', constants('is_active.active'))->limit(1000)->get();
            $listProject = Project::where('is_active', constants('is_active.active'))->limit(1000)->get();
            $response = ['msg' => '', 'success' => 1, 'data' => ['assigned' => $getAssignedProjects, 'listProject' => $listProject ] ];
            return response()->json($response);

        } catch (\Exception $e) {
            Log::error($e);
            $response = ['msg' => 'Error', 'success' => 0, ];
            return response()->json($response);
        }
    }


    




    


    









}
