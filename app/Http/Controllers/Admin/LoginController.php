<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
date_default_timezone_set('Asia/Kolkata');
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Models\Admin;


class LoginController extends Controller
{
	private $tbl = "admins";

	public function index(){
		if(Session::get('adminid')!=''){
			return redirect()->route('dashboard');
		}
		else
		{
			return view('admin.login.login');	
		}
	}

    public function login(Request $request){
    	try {

    	if(!isset($request->hid) OR !isset($request->username) OR $request->username=='' OR !isset($request->password) OR $request->password==''){
            Session::flash('msg', 'Invalid Value !!');
            Session::flash('cls', 'danger');
            return redirect()->route('loginpage');
        }


		$dataAdmin = Admin::where('email', $request->username)->where('is_active', constants('is_active.active'))->whereNotNull('email')->first();


		if(!empty($dataAdmin)){
			if (!password_verify($request->password, $dataAdmin->password)) 
			{
    			Session::flash('msg', 'Email or Password is wrong !');
    			Session::flash('cls', 'danger');
            	return redirect()->route('loginpage');
			}
			else
			{
				$getCompanyData = getCompanyConfiguration();
				
				$activesession = time().random_text(8).uniqid();
				Session::put('adminid', $dataAdmin->id);
				Session::put('adminfullname', $dataAdmin->fullname);
				Session::put('adminemail', $dataAdmin->email);
				Session::put('adminrole', $dataAdmin->role);
				Session::put('adminactivesession', $activesession);
				Session::put('admindesignation', $dataAdmin->designation);
				Session::put('companydata', $getCompanyData);

				$updateData = [
					'active_session' => $activesession,
					'ipaddress' => getIPAddress(), 
				];
				Admin::where('id', $dataAdmin->id)->update($updateData);
        		return redirect()->route('dashboard');

			}
		}
		else
		{
			Session::flash('msg', 'User not found !');
            return redirect()->route('loginpage');
		}

		} catch (\Exception $e) {
            Log::error($e);
            Session::flash('msg', 'Error, Something Went Wrong.');
            Session::flash('cls', 'danger');
            return redirect()->back();
        }
	}













}
