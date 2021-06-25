<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Admin;
use App\Models\Project;
use App\Models\ProjectAssigned;
date_default_timezone_set('Asia/Kolkata');
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminManage extends Controller
{
    public $tbl = "admins";

    public function index(Request $request){
        if_allowedRoute("admin-list");
        $data = [ 'control' => 'Employee', ];
        return view('admin.admins.list')->with($data);
    }

    public function addIndex(Request $request){
        if_allowedRoute("add-new-admin");
        $listProject = Project::where('is_active', constants('is_active.active'))->limit(1000)->get();
        $data = ['control' => 'Employee',  'listProject' => $listProject ];
        return view('admin.admins.add')->with($data);
    }

    public function viewEditIndex(Request $request){
        if_allowedRoute("view-admin");
        $Id = isset($_GET['id']) ? trim(intval($_GET['id'])) : 0;
        $one = Admin::with([
                'project_assigned' => function($qryProject_assigned) {
                    $qryProject_assigned->where('is_active', constants('is_active.active'));
                },
                ])
            ->whereIn('is_active', constants('is_active'))
            ->where('id', $Id)->first();    
        $listProject = Project::where('is_active', constants('is_active.active'))->limit(1000)->get();

        $data = [ 'control' => 'Employee', 'one' => $one,  'listProject' => $listProject, ];
        return view('admin.admins.view')->with($data);
    }



    public function viewProfileIndex(Request $request){
        $Id = Session::get('adminid');
        $one = Admin::whereIn('is_active', constants('is_active'))->where('id', $Id)->first();
        $data = [ 'control' => 'My Profile', 'one' => $one, ];
        return view('admin.admins.myprofile')->with($data);
    }

    public function getdata(Request $request){
        $status = "'" . implode ( "', '", constants('is_active') ) . "'";
        $status_sql =  " ad.is_active IN(".$status.") ";

        $columns = array(          
            0 => 'ad.fullname',
            1 => 'ad.mobile',
            2 => 'ad.is_active',
            3 => 'ad.created_at',
        );
        $sql = "select ad.id,ad.fullname,ad.email,ad.mobile,ad.is_active,ad.designation,(select count(pa.id) from project_assigned pa where pa.admin_id=ad.id) as assignedProjectCounts from ".$this->tbl." ad  WHERE $status_sql ";
        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( ad.email  LIKE " . $searchString;
            $sql .= " OR ad.mobile  LIKE " . $searchString;
            $sql .= " OR ad.fullname  LIKE " . $searchString . ")";
        }

        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $cnts = $request->start + 1;
        foreach ($query as $row) {
            $admin_typeText = "<br><span class='badge badge-pill bg-info-light'>".$row->designation."</span>";
            $assignedProjectCounts = 2;
            $nestedData = array();
            $nestedData[] = $row->fullname.$admin_typeText."<br>".$row->assignedProjectCounts." Project(s) Assigned";
            $nestedData[] = $row->mobile."<br>".$row->email;

            if($row->is_active==constants('is_active.active')){
                $status = "<span class='badge badge-pill bg-success'>Active</span>";
            }
            else{
                $status = "<span class='badge badge-pill bg-danger'>DeActive</span>";
            }

            $nestedData[] = $status;

            $view = "<a href='".route('view-admin').'?id='.$row->id."' class='btn btn-primary btn-sm editit' data-id='".$row->id."'>View</a>";
            $assign = "<a class='btn btn-info btn-sm assignitproject' data-id='".$row->id."'>Assign</a>";

            $nestedData[] = $assign." ".$view;
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



    public function Add(Request $request) {
        try {

        $validator = Validator::make($request->all(), [ 
            'hid' => 'required',
            'is_active' => 'required',
            'fullname' =>'required|string|max:100',
            'email' =>'required|email',
            'mobile' =>'nullable|max:13',
            'password' =>'required|string|max:25|min:3',
            'role' =>'required',
            'about' =>'nullable|max:1000',
            'designation' => 'required|string|max:255',
            'joining_date' => 'nullable|date_format:Y-m-d',
        ]);   

        if($validator->fails()) {          
            Session::flash('msg', 'Please Check All Required Fields Properly.');
            Session::flash('cls', 'danger');
            return redirect()->back()->withErrors($validator)->withInput();  
        }  


        $emailAddress = trim($request->email);
        $mobileNumber = isset($request->mobile) ? trim($request->mobile) : NULL;

        $count =  Admin::where('id','>', 0)
            ->where(function($queryEmail) use ($emailAddress) {
                    $queryEmail->where('email', $emailAddress)->where('email', '!=', '');
            })
            ->orWhere(function($queryMobile) use ($mobileNumber) {
                    $queryMobile->where('mobile', $mobileNumber)->where('mobile', '!=', '');
            })
            ->count();

            if($count > 0){
                Session::flash('msg', 'This Mobile Number or Email Address is Already Registered, Please Check.');
                Session::flash('cls', 'danger');
                return redirect()->back();
            }

        $insertData = [
                'uuid' => uuid(),
                'fullname' => $request->fullname,
                'email' => $emailAddress,
                'mobile' => $mobileNumber,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'is_active' => ($request->is_active==0) ? 0 : 1,
                'active_session' => NULL,
                'ipaddress' => NULL,
                'about' => isset($request->about) ? $request->about : NULL,
                'joining_date' => isset($request->joining_date) ? $request->joining_date : NULL,
                'designation' => isset($request->designation) ? $request->designation : NULL,
        ];


        $lastInsertedData = Admin::create($insertData);
        Session::flash('msg', ' Added Successfully!');
        Session::flash('cls', 'success');


        if(isset($request->project_ids) && is_array($request->project_ids) && !empty($request->project_ids)){
            foreach($request->project_ids as $key => $value) {
                $is_exists = Project::where('id', $value)->where('is_active', constants('is_active.active'))->count();
                if($is_exists>0){
                $insertDataProjectAssigned = [
                    'uuid' => uuid(),
                    'project_id' => $value,
                    'admin_id' => $lastInsertedData->id,
                    'is_active' => constants('is_active.active'),
                ];
                ProjectAssigned::create($insertDataProjectAssigned);
                }
            }
        }


        } catch (\Exception $e) {
            Log::error($e);
            Session::flash('msg', 'Error, Something Went Wrong. Please Try Again!!');
            Session::flash('cls', 'danger');
        }
        return redirect()->back();
    }


    public function Update(Request $request) {
        try {

        $validator = Validator::make($request->all(), [ 
            'hid' => 'required',
            'uuid' => 'required',
            'created_at' => 'required',
            'is_active' => 'required',
            'fullname' =>'required|string|max:100',
            'email' =>'required|email',
            'mobile' =>'nullable|max:13',
            'role' =>'required',
            'about' =>'nullable|max:1000',
            'designation' => 'required|string|max:255',
            'joining_date' => 'nullable|date_format:Y-m-d',
        ]);   

        if($validator->fails()) {          
            Session::flash('msg', 'Please Check All Required Fields Properly.');
            Session::flash('cls', 'danger');
            return redirect()->back()->withErrors($validator)->withInput();  
        }


        $is_exists = Admin::where('id', $request->hid)->where('uuid', $request->uuid)->where('created_at', $request->created_at)->count(); 
        if($is_exists==0){
            Session::flash('msg', 'Not Found to Update.');
            Session::flash('cls', 'danger');
            return redirect()->back();
        } 

        $emailAddress = trim($request->email);
        $mobileNumber = isset($request->mobile) ? trim($request->mobile) : NULL;

        $sql = "select a.id from ".$this->tbl." a WHERE a.id!=".$request->hid." and ( a.email='".$request->email."' OR ( a.mobile='".$request->mobile."' AND a.mobile!='' )) LIMIT 1 ";
        $count = qry($sql);

        if(!empty($count)){
            Session::flash('msg', 'This Mobile Number or Email Address is Already Registered, Please Check.');
            Session::flash('cls', 'danger');
            return redirect()->back();
        }

        $updateData = [
            'fullname' => $request->fullname,
            'email' => $emailAddress,
            'mobile' => $mobileNumber,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'is_active' => ($request->is_active==0) ? 0 : 1,
            'about' => isset($request->about) ? $request->about : NULL,
            'joining_date' => isset($request->joining_date) ? $request->joining_date : NULL,
            'designation' => isset($request->designation) ? $request->designation : NULL,
        ];

        if(isset($request->password) && strlen($request->password)>1){
            $updateData['password'] = bcrypt(trim($request->password));
            $updateData['active_session'] = NULL;
        }


        Admin::where('id', $request->hid)->where('uuid', $request->uuid)->where('created_at', $request->created_at)->update($updateData);
        Session::flash('msg', ' Updated Successfully!');
        Session::flash('cls', 'success');

        ProjectAssigned::where('admin_id', $request->hid)->delete();


        if(isset($request->project_ids) && is_array($request->project_ids) && !empty($request->project_ids)){
            foreach($request->project_ids as $key => $value) {
                $is_exists = Project::where('id', $value)->whereIn('is_active', constants('is_active'))->count();
                if($is_exists>0){
                $insertDataProjectAssigned = [
                    'uuid' => uuid(),
                    'project_id' => $value,
                    'admin_id' => $request->hid,
                    'is_active' => constants('is_active.active'),
                ];
                ProjectAssigned::create($insertDataProjectAssigned);
                }
            }
        }


        } catch (\Exception $e) {
            Log::error($e);
            Session::flash('msg', 'Error, Something Went Wrong. Please Try Again!!');
            Session::flash('cls', 'danger');
        }
        return redirect()->back();
    }

  
    public function getAdminInDropdown(Request $request){
        $dataArray = [];
        try {
            $searchTerm = ''; 
            if(isset($request->searchTerm)) {
                $searchTerm = $request->searchTerm;
            }


            $dataReturned = Admin::where('is_active', constants('is_active.active'))
            ->where(function($querySearch) use ($searchTerm) {
                    $querySearch->where('fullname','LIKE', '%'.$searchTerm.'%')
                    ->orwhere('email','LIKE', '%'.$searchTerm.'%')
                    ->orwhere('mobile','LIKE', '%'.$searchTerm.'%');
            })
            ->orderBy('id','ASC')
            ->limit(25)
            ->get();


            foreach($dataReturned as $key => $value) {
                $dataArray[] = [
                "text" => $value->fullname."[".$value->id."]",
                "id" => $value->id,
                ];
            }
            return response()->json($dataArray);
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }


    public function assignProjectToAdmin(Request $request){
        try {
        $is_exists = Admin::where('id', $request->admin_id)->whereIn('is_active', constants('is_active'))->count();
        if($is_exists==0 || empty($request->assignedProject)){
            $response = ['msg' => 'Please Check Properly.', 'success' => 0, ];
            return response()->json($response);
        }
        ProjectAssigned::where('admin_id', $request->admin_id)->delete();

        if(isset($request->assignedProject) && is_array($request->assignedProject) && !empty($request->assignedProject)){
            foreach($request->assignedProject as $key => $value) {
                $is_exists = Project::where('id', $value)->whereIn('is_active', constants('is_active'))->count();
                if($is_exists>0){
                $insertDataProjectAssigned = [
                    'uuid' => uuid(),
                    'project_id' => $value,
                    'admin_id' => $request->admin_id,
                    'is_active' => constants('is_active.active'),
                ];
                ProjectAssigned::create($insertDataProjectAssigned);
                }
            }
        }

        $response = ['msg' => 'Assigned Successfully.', 'success' => 1, ];
        return response()->json($response);

        } catch (\Exception $e) {
            Log::error($e);
            $response = ['msg' => 'Error', 'success' => 0, ];
            return response()->json($response);
        }
    }



    public function changePassword(Request $request) {
        try {

        $validator = Validator::make($request->all(), [ 
            'hid' => 'required',
            'uuid' => 'required',
            'fill_current_password' =>'required|string|max:25|min:3',
            'fill_new_password' =>'required|string|max:25|min:3',
        ]);   

        if($validator->fails()) { 
            $response = ['msg' => 'Please Check All Required Fields Properly.', 'success' => 0, ];
            return response()->json($response);         
        }  
        $dataAdmin =  Admin::where('id', Session::get('adminid'))->where('is_active', constants('is_active.active'))->first(['password']);
        if(empty($dataAdmin)){
            $response = ['msg' => 'You Can Not Changed Password.', 'success' => 0, ];
            return response()->json($response); 
        }
        if(trim($request->fill_current_password)==trim($request->fill_new_password)){
            $response = ['msg' => 'Current & New Password Can Not Be Same.', 'success' => 0, ];
            return response()->json($response); 
        }
        if(!password_verify($request->fill_current_password, $dataAdmin->password)) 
        {
            $response = ['msg' => 'Your Current Password is Not Correct.', 'success' => 0, ];
            return response()->json($response); 
        }

        $updateData = [
            'password' => bcrypt(trim($request->fill_new_password)),
        ];
        Admin::where('id', Session::get('adminid'))->where('is_active', constants('is_active.active'))->update($updateData);
        $response = ['msg' => 'Password Changed Successfully.', 'success' => 1, ];
        return response()->json($response); 

        } catch (\Exception $e) {
            Log::error($e);
            $response = ['msg' => 'Error', 'success' => 0, ];
            return response()->json($response); 
        }
    }
    




    





}