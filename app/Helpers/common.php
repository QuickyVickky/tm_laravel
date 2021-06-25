<?php

use App\Services\CustomService;
date_default_timezone_set('Asia/Kolkata');
use App\Models\Admin;
use App\Models\Company;
use App\Events\AlertEvent;



function pushNotificationToAdmin($title, $text1, $PUSHER_APP_CHANNELNAME, $PUSHER_APP_EVENTNAME, $icon='', $image='', $linkurl='') {
    try {
    event(new AlertEvent($title, $text1, $PUSHER_APP_CHANNELNAME, $PUSHER_APP_EVENTNAME, $icon, $image, $linkurl));
    } catch(\Exception $e) { }
    return true;
}

function dde($arr){
	echo "<pre>"; print_r($arr); die;
}

function random_text($length_of_string = 8) {
    $chr = 'GHIJKLA123MNOSTUVW0XYZPQR456789BCDEF'; 
    $randomString = ''; 
  
    for ($i = 0; $i < $length_of_string; $i++) { 
        $index = rand(0, strlen($chr) - 1); 
        $randomString .= $chr[$index]; 
    }   
    return $randomString; 
}

function random_number($length_of_string = 8) {
    $chr = '1234506789'; 
    $randomString = ''; 
    for ($i = 0; $i < $length_of_string; $i++) { 
        $index = rand(0, strlen($chr) - 1); 
        $randomString .= $chr[$index]; 
    }   
    return '9'.$randomString; 
}

function qry($str,$return_in_array=0){
    $data = DB::select($str);
    if($return_in_array!=1){
        return $data;
    }
    else
    {
        return json_decode(json_encode($data), true);
    }
    
}
function insert_data($tbl,$data){
	DB::table($tbl)->insert($data);
}

function insert_data_id($tbl,$data){
	$id = DB::table($tbl)->insertGetId($data);
	return $id;
}

function update_data($tbl,$data,$con){
	$affected_id = DB::table($tbl)->where($con)->update($data);
	return $affected_id;
}

function UploadImage($file, $dir,$filename_prefix='') {
    $fileName = $filename_prefix.uniqid().time() . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('storage'. '/'. $dir), $fileName);
    return $fileName;
}

function DeleteFile($filename, $dir) {
    $existImage = public_path('storage/'.$dir.'/'.$filename);
        if (File::exists($existImage)) {
            File::delete($existImage);
        }
    return 1;
}

function sendMail($html, $useremail, $username, $subject, $data =[]){
    Mail::send('admin.mail.forgot_otp', $data, function ($message) use ($useremail,$username,$subject) {
            $message->from('xyz@gmail.com', 'account')
                ->to($useremail, $username)
                ->subject($subject);
    });
    return 1;
}

function constants($key=''){
    if(trim($key=='')){
        return 0;
    }
    else
    {
        return Config::get('constants.'.$key);
    }
}


function getLastNDays($days, $format = 'd/m'){
    $m = date("m"); $de= date("d"); $y= date("Y");
    $dateArray = array();
    for($i=0; $i<=$days-1; $i++){
        $dateArray[] = date($format, mktime(0,0,0,$m,($de-$i),$y)); 
    }
    return array_reverse($dateArray);
}

function sendPath($dir=''){
    return asset('storage').'/'.$dir.'/';
}

function uuid(){
    return uniqid().time().mt_rand(10000,99999);
}



function getIPAddress() {  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
    else{  
        $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
}  


function secondsToTimings($seconds=0,$excludeSeconds=0) {
  $t = round($seconds);
  if($excludeSeconds==1){
    return sprintf('%02d:%02d', ($t/3600),($t/60%60));
  }
  else{
    return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
  }
}


function valid_password($password='') {
    if(strlen(trim($password))>=6 && strlen(trim($password))<25)
    {
        return true;
    }
    return false;
}

function valid_email($email='') {
    if($email!='' && filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }
    return false;
}

function valid_id($id='') {
    if(is_numeric($id) && $id>0)
    {
        return true;
    }
    return false;
}


function getCompanyConfiguration(){
    return Company::where('id', Config::get('constants.company_configurations_id'))->orderBy('id','ASC')->first();
}



function if_allowedRoute($routename) {
    if(Session::get("adminrole")!=constants('adminrole.A.key')){
        echo 'You are not Allowed to This.';
        die;
    }
}





