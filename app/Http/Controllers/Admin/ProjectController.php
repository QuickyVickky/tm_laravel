<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\TagCategory;
date_default_timezone_set('Asia/Kolkata');
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\ProjectAssigned;
use Illuminate\Database\Eloquent\Builder;


class ProjectController extends Controller
{
    private $tbl = "projects";
    private $tbl2 = "project_assigned";

    public function index(Request $request){
        if_allowedRoute("project-list");
        $data = [ 'control' => 'Project'];
        return view('admin.project.list')->with($data);
    }

    public function getEdit(Request $request){
        $response = Project::where('id', $request->id)->first();
        return response()->json($response);
    }


    public function viewIndex(Request $request){
        if_allowedRoute("view-project");
        $Id = isset($_GET['id']) ? trim(intval($_GET['id'])) : 0;
        $one = Project::whereIn('is_active', constants('is_active'))->where('id', $Id)->first();    
        $data = [ 'control' => 'Project View', 'one' => $one,  ];
        return view('admin.project.project_view')->with($data);
    }
	
    public function getData(Request $request){

        $columns = array(          
            0 => 'p.id',
            1 => 'p.project_name',
            2 => 'p.project_description',
            3 => 'p.start_date',
            4 => 'p.is_active',
            5 => 'p.created_at',
        );

        $sql = "select p.* from ".$this->tbl." p WHERE p.is_active!='2' ";
        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( p.project_name LIKE " . $searchString;
            $sql .= " OR p.created_at LIKE " . $searchString;
            $sql .= " OR p.project_description LIKE " . $searchString . ")";
        }

        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $cnts = $request->start + 1;
        foreach ($query as $row) {
            $edit = ''; $isDeployed = '';
			$view = "<a href='".route('view-project').'?id='.$row->id."' class='btn btn-primary btn-sm editit' data-id='".$row->id."'>View</a>";
          
            $nestedData = array();
            $nestedData[] = $cnts;
            $nestedData[] = $row->project_name."<br>".$view;
            $nestedData[] = $row->project_description;
            $nestedData[] = Carbon::parse($row->start_date)->format('F-Y');

            if($row->is_active==constants('is_active.active')){
                $status = "<span class='badge badge-pill bg-success'>Active</span>";
            }
            else if($row->is_deployed==constants('confirmation.yes')){
                $status = "<span class='badge badge-pill bg-info'>Deployed</span>";
            }
            else if($row->is_active==constants('is_active.deactive')){
                $status = "<span class='badge badge-pill bg-danger'>DeActive</span>";
            }
            else {
                $status = '';
            }

            if($row->is_deployed==constants('confirmation.yes')){
                $status = "<span class='badge badge-pill bg-info'>Deployed</span>";
            }

            $nestedData[] = $status;

            $edit = '<a href="javascript:void(0)" class="btn btn-rounded btn-outline-primary editit" data-id="'.$row->id.'" title="edit this"><i class="fas fa-pen-square"></i></a>';

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

    public function addUpdate(Request $request) {
    	try {

        $validator = Validator::make($request->all(), [ 
            'hid' => 'required|integer|min:0',
            'uuid' => 'required',
            'is_active' => 'required|numeric',
            'is_deployed' => 'required|numeric',
            'project_name' =>'required|string|max:255',
            'project_description' =>'nullable|string|max:1000',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d|after_or_equal:start_date',
        ]);   

        if($validator->fails()) {  
            $response = ['msg' => 'Please Check Properly.', 'success' => 0 ];
            return response()->json($response);
        }


        if($request->hid==0){
            $insertData = [
                'project_name' => $request->project_name,
                'uuid' => uuid(),
                'project_description' => isset($request->project_description) ? trim($request->project_description) : NULL,
                'is_active' => ($request->is_active==0) ? 0 : 1,
                'is_deployed' => ($request->is_deployed==0) ? 0 : 1,
                'admin_id' => Session::get('adminid'),
                'start_date' => $request->start_date,
                'end_date' => ($request->end_date!='') ? trim($request->end_date) : NULL,
            ];
            $lastInsertData = Project::create($insertData);

            if($lastInsertData->id > 0){

                if(isset($request->add_project_category) && is_array($request->add_project_category) && !empty($request->add_project_category)){
                    foreach ($request->add_project_category as $key => $value) {
                        if($value>0){
                            $firstTagCategory = TagCategory::where('id', $value)->first(['category_title']);
                    $insertProjectCategoryData = [
                        'category_title' => @$firstTagCategory->category_title,
                        'uuid' => uuid(),
                        'category_description' => NULL,
                        'is_active' => ($request->is_active==0) ? 0 : 1,
                        'project_id' => $lastInsertData->id,
                    ];
                    ProjectCategory::create($insertProjectCategoryData);
                        }
                    }
                }

                $response = ['msg' => 'Added Successfully', 'success' => 1 ];
            }
            else
            {
                $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            }
            return response()->json($response);
        }
        else if($request->hid > 0)
        {
            $updateData = [
                'project_name' => $request->project_name,
                'project_description' => isset($request->project_description) ? trim($request->project_description) : NULL,
                'is_active' => ($request->is_active==0) ? 0 : 1,
                'is_deployed' => ($request->is_deployed==0) ? 0 : 1,
                'start_date' => $request->start_date,
                'end_date' => ($request->end_date!='') ? trim($request->end_date) : NULL,
            ];
            Project::where('id', $request->hid)->where('uuid', $request->uuid)->update($updateData);

            $response = ['msg' => 'Updated Successfully!', 'success' => 1 ];
            return response()->json($response);
        }
        else
        {
            $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            return response()->json($response);
        }
        } catch (\Exception $e) {
        	Log::error($e);
            $response = ['msg' => 'Error '.$e->getMessage(), 'success' => 0 ];
            return response()->json($response);
        }
    }
    

    public function getProjectsInDropdown(Request $request){
        $dataArray = [];
        try {
            $searchTerm = ''; 
            if(isset($request->searchTerm)) {
                $searchTerm = $request->searchTerm;
            }


            $dataReturned = Project::where('is_active', '!=', 2)
            ->where(function($querySearch) use ($searchTerm) {
                    $querySearch->where('project_name','LIKE', '%'.$searchTerm.'%')->orwhere('project_description','LIKE', '%'.$searchTerm.'%');
            })
          	->orderBy('id','ASC')
          	->limit(25)
          	->get();


            foreach ($dataReturned as $key => $value) {
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
    
    public function getProjectsInDropdownAssigned(Request $request){
        $dataArray = [];
        try {
            $searchTerm = ''; 
            if(isset($request->searchTerm)) {
                $searchTerm = $request->searchTerm;
            }

            $AdminId = Session::get('adminid');
            if(isset($request->admin_id)) {
                $AdminId = $request->admin_id;
            }

            $dataReturned = Project::whereHas('project_assigned', function (Builder $queryPA) use ($AdminId) {
                    $queryPA->where('admin_id', $AdminId);
                    $queryPA->where('is_active', constants('is_active.active'));
            })
            ->where('is_active', constants('is_active.active'))
            ->where(function($querySearch) use ($searchTerm) {
                    $querySearch->where('project_name','LIKE', '%'.$searchTerm.'%')->orwhere('project_description','LIKE', '%'.$searchTerm.'%');
            })
            ->orderBy('id','ASC')
            ->limit(25)
            ->get();


            foreach($dataReturned as $key => $value) {
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
    








}
