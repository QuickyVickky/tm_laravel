<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\TagCategory;
date_default_timezone_set('Asia/Kolkata');
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class TagsCategoryController extends Controller
{
    private $tbl = "tags_category";    

    public function getEdit(Request $request){
        $response = TagCategory::where('id', $request->id)->first();
        return response()->json($response);
    }

    public function getData(Request $request){
        $status = "'" . implode ( "', '", constants('is_active') ) . "'";
        $status_sql =  " tc.is_active IN(".$status.") ";

        $columns = array(          
            0 => 'tc.id',
            1 => 'tc.category_title',
			2 => 'pc.is_active',
            3 => 'tc.created_at',
        );

        $sql = "select tc.* from ".$this->tbl." tc WHERE $status_sql ";
        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( tc.category_title LIKE " . $searchString;
            $sql .= " OR tc.id LIKE " . $searchString;
            $sql .= " OR tc.created_at LIKE " . $searchString . ")";
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
            $nestedData[] = $row->category_title;
			
			if($row->is_active==constants('is_active.active')){
                $status = "<span class='badge badge-pill bg-success'>Active</span>";
            }
            else {
                $status = "<span class='badge badge-pill bg-danger'>DeActive</span>";
            }
			$nestedData[] = $status;

            $edit = '<a href="javascript:void(0)" class="btn btn-rounded btn-outline-primary editittagscategory" data-id="'.$row->id.'" title="edit this"><i class="fas fa-pen-square"></i></a>';

            $delete = ' <a href="javascript:void(0)" class="btn btn-rounded btn-outline-danger deleteittagscategory" data-id="'.$row->id.'" title="delete this"><i class="far fa-trash-alt"></i></a>';

            $nestedData[] = $edit.$delete;
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
            'category_title' =>'required|string',
        ]);   

        if($validator->fails()) {  
            $response = ['msg' => 'Please Check Properly.', 'success' => 0 ];
            return response()->json($response);
        }  
        

        if($request->hid==0){

            $insertData = [
                'category_title' => trim($request->category_title),
                'uuid' => uuid(),
                'is_active' => ($request->is_active==0) ? 0 : 1,
            ];
            $lastInsertData = TagCategory::create($insertData);

            if(isset($lastInsertData)){
                $response = ['msg' => 'Added Successfully.', 'success' => 1 ];
            }
            else
            {
                $response = ['msg' => 'Not Created.', 'success' => 0 ];
            }
            return response()->json($response);
        }
        else if($request->hid > 0)
        {
            $updateData = [
                'category_title' => $request->category_title,
                'is_active' => ($request->is_active==0) ? 0 : 1,
            ];
            TagCategory::where('id', $request->hid)->where('uuid', $request->uuid)->update($updateData);

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
    

    public function getTagsCategoryInDropdown(Request $request){
        $dataArray = [];
        try {
            $searchTerm = ''; 
            if(isset($request->searchTerm)) {
                $searchTerm = $request->searchTerm;
            }

            $dataReturned = TagCategory::where('is_active', constants('is_active.active'))
            ->where(function($querySearch) use ($searchTerm) {
                $querySearch->where('category_title','LIKE', '%'.$searchTerm.'%');
            })
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
    

    public function deleteTagsCategory(Request $request) {
        $request->validate([
            'status' => 'required|numeric',
             'id' => 'required|integer|min:1',
        ]);
         try {
            TagCategory::whereIn('id', [ $request->id ])->delete();
            $response = ['msg' => ' Deleted Successfully !', 'success' => 1, 'data' => 1];
            return response()->json($response);
         } catch (\Exception $e) {
            $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            return response()->json($response);
        }

    }






}
