<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Project;
use App\Models\ProjectCategory;
date_default_timezone_set('Asia/Kolkata');
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;



class ProjectCategoryController extends Controller
{
    private $tbl = "project_category";
    private $tbl2 = "projects";
    

    public function index(Request $request){
        if_allowedRoute("project-category-list");
        $data = [ 'control' => 'Project Category'];
        return view('admin.project.category.list')->with($data);
    }

    public function getEdit(Request $request){
        $response = ProjectCategory::with(['project'])->where('id', $request->id)->first();
        return response()->json($response);
    }

    public function getData(Request $request){
        $status = "'" . implode ( "', '", constants('is_active') ) . "'";
        $status_sql =  " pc.is_active IN(".$status.") ";
		

        $columns = array(          
            0 => 'pc.id',
            1 => 'pc.category_title',
            2 => 'pc.category_description',
			3 => 'pc.is_active',
            4 => 'pc.created_at',
        );
		
		$project_idSQL = '';
		if(isset($request->project_id)){
			$project_idSQL = ' and pc.project_id='.$request->project_id.'';
		}

        $sql = "select pc.*,p.project_name from ".$this->tbl." pc INNER JOIN ".$this->tbl2." p ON p.id=pc.project_id WHERE $status_sql $project_idSQL ";
        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( pc.category_title LIKE " . $searchString;
            $sql .= " OR pc.created_at LIKE " . $searchString;
            $sql .= " OR pc.category_description LIKE " . $searchString . ")";
        }

        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $cnts = $request->start + 1;
        foreach ($query as $row) {

            $project_nameText = "<br><span class='badge badge-pill bg-success-light'>".$row->project_name."</span>";
          
            $nestedData = array();
            $nestedData[] = $cnts;
            $nestedData[] = $row->category_title.$project_nameText;
            $nestedData[] = $row->category_description;
			
			if($row->is_active==constants('is_active.active')){
                $status = "<span class='badge badge-pill bg-success'>Active</span>";
            }
            else {
                $status = "<span class='badge badge-pill bg-danger'>DeActive</span>";
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
            'project_id' => 'required|integer|min:1',
            'uuid' => 'required',
            'is_active' => 'required|numeric',
            'category_title' => 'required|string',
            'category_description' => 'nullable|string|max:1000',
        ]);   

        if($validator->fails()) {  
            $response = ['msg' => 'Please Check Properly.', 'success' => 0 ];
            return response()->json($response);
        }  
        

        if($request->hid==0){

            $category_titleMultiple = explode(',', $request->category_title);

            if(is_array($category_titleMultiple) && !empty($category_titleMultiple)){
                foreach ($category_titleMultiple as $key => $value) {
                    $insertData = [
                        'category_title' => trim($value),
                        'uuid' => uuid(),
                        'category_description' => isset($request->category_description) ? trim($request->category_description) : NULL,
                        'is_active' => ($request->is_active==0) ? 0 : 1,
                        'project_id' => $request->project_id,
                    ];
                    $lastInsertData = ProjectCategory::create($insertData);
                }
            }

            if(isset($lastInsertData)){
                $response = ['msg' => 'Added Successfully.', 'success' => 1 ];
            }
            else
            {
                $response = ['msg' => 'Not Created Any Category.', 'success' => 0 ];
            }
            return response()->json($response);
        }
        else if($request->hid > 0)
        {
            $updateData = [
                'category_title' => $request->category_title,
                'category_description' => isset($request->category_description) ? trim($request->category_description) : NULL,
                'is_active' => ($request->is_active==0) ? 0 : 1,
                'project_id' => $request->project_id,
            ];
            ProjectCategory::where('id', $request->hid)->where('uuid', $request->uuid)->update($updateData);

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
            $response = ['msg' => 'Error', 'success' => 0 ];
            return response()->json($response);
        }
    }
    

    public function getProjectCategoryInDropdown(Request $request){
        $dataArray = [];
        try {
            $searchTerm = ''; 
            if(isset($request->searchTerm)) {
                $searchTerm = $request->searchTerm;
            }
            $project_id = 0; 
            if(isset($request->project_id) && $request->project_id>0) {
                $project_id = $request->project_id;
            }


            $dataReturned = ProjectCategory::where('is_active', constants('is_active.active'))
            ->where(function($querySearch) use ($searchTerm) {
                $querySearch->where('category_title','LIKE', '%'.$searchTerm.'%')->orwhere('category_description','LIKE', '%'.$searchTerm.'%');
            })
            ->where('project_id', $project_id)
            ->orderBy('id','ASC')
            ->limit(25)
            ->get();


            foreach ($dataReturned as $key => $value) {
                $dataArray[] = [
                "text" => $value->category_title,
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
