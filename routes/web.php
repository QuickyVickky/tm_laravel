<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\AdminManage;
use App\Http\Controllers\Admin\ProjectAssignedController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectCategoryController;
use App\Http\Controllers\Admin\TagsCategoryController;
use App\Http\Controllers\Admin\DailyTaskController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




/*----XSS started------*/
Route::group(['middleware' => ['XSS']], function (){

Route::group(array('middleware' => ['checkLogin']), function () {
	Route::prefix(env('ADMINBASE_NAME'))->group(function () {


		/*-----reserved for admin----*/
		Route::get('admin-list', [AdminManage::class, 'index'])->name('admin-list');
		Route::get('project-list', [ProjectController::class, 'index'])->name('project-list');
		Route::get('project-category-list', [ProjectCategoryController::class, 'index'])->name('project-category-list');
		Route::get('daily-tasks-all', [DailyTaskController::class, 'indexAll'])->name('daily-tasks-all');
		Route::post('exportExcelDailyTask', [DailyTaskController::class, 'exportExcelDailyTask'])->name('exportExcelDailyTask');


		Route::get('view-admin', [AdminManage::class, 'viewEditIndex'])->name('view-admin');
		Route::get('add-new-admin', [AdminManage::class, 'addIndex'])->name('add-new-admin');
		Route::get('get-admin-list', [AdminManage::class, 'getdata'])->name('get-admin-list');
		Route::post('update-admin-submit', [AdminManage::class, 'Update'])->name('update-admin-submit');
		Route::post('add-new-admin-submit', [AdminManage::class, 'Add'])->name('add-new-admin-submit');
		Route::post('assign-projects-toadmin', [AdminManage::class, 'assignProjectToAdmin'])->name('assign-projects-toadmin');
		Route::get('my-profile', [AdminManage::class, 'viewProfileIndex'])->name('my-profile');
		Route::post('change-password-update', [AdminManage::class, 'changePassword'])->name('change-password-update');
		

		
		Route::get('get-projects-list', [ProjectController::class, 'getData'])->name('get-projects-list');
		Route::post('add-update-projects', [ProjectController::class, 'addUpdate'])->name('add-update-projects');
		Route::get('project-getedit', [ProjectController::class, 'getEdit'])->name('project-getedit');
		Route::get('view-project', [ProjectController::class, 'viewIndex'])->name('view-project');


		
		Route::get('get-projects-category-list', [ProjectCategoryController::class, 'getData'])->name('get-projects-category-list');
		Route::post('add-update-projects-category', [ProjectCategoryController::class, 'addUpdate'])->name('add-update-projects-category');
		Route::get('project-category-getedit', [ProjectCategoryController::class, 'getEdit'])->name('project-category-getedit');
		Route::get('get-tags-category-list', [TagsCategoryController::class, 'getData'])->name('get-tags-category-list');
		Route::get('tags-category-getedit', [TagsCategoryController::class, 'getEdit'])->name('tags-category-getedit');
		Route::post('add-update-tags-category', [TagsCategoryController::class, 'addUpdate'])->name('add-update-tags-category');

		
	
		
		Route::get('get-daily-tasks-list-all', [DailyTaskController::class, 'getDataAll'])->name('get-daily-tasks-list-all');
		Route::get('get-daily-tasks-list-all-datewise', [DailyTaskController::class, 'getDataAllDateWise'])->name('get-daily-tasks-list-all-datewise');
		Route::get('get-dailytaskslist-datewise-ofadmin', [DailyTaskController::class, 'getDataAllDateWiseOfAdminId'])->name('get-dailytaskslist-datewise-ofadmin');
		Route::get('getDailyTasksListByAdminIdnDate', [DailyTaskController::class, 'getDailyTasksListByAdminIdnDate'])->name('getDailyTasksListByAdminIdnDate');
		Route::get('getDailyTasksListByDate', [DailyTaskController::class, 'getDailyTasksListByDate'])->name('getDailyTasksListByDate');
		Route::get('company-configuration', [CompanyController::class, 'index'])->name('company-configuration');
		Route::post('update-company-details', [CompanyController::class, 'Add_Or_Update'])->name('update-company-details');
		/*-----reserved for admin----*/

		Route::post('getProjectsInDropdown', [ProjectController::class, 'getProjectsInDropdown'])->name('getProjectsInDropdown');
		Route::post('getProjectsInDropdownAssigned', [ProjectController::class, 'getProjectsInDropdownAssigned'])->name('getProjectsInDropdownAssigned');
		Route::post('getProjectCategoryInDropdown', [ProjectCategoryController::class, 'getProjectCategoryInDropdown'])->name('getProjectCategoryInDropdown');
		Route::post('getTagsCategoryInDropdown', [TagsCategoryController::class, 'getTagsCategoryInDropdown'])->name('getTagsCategoryInDropdown');
		Route::post('change-tags-category-deleted', [TagsCategoryController::class, 'deleteTagsCategory'])->name('change-tags-category-deleted');

		
		Route::post('getAdminInDropdown', [AdminManage::class, 'getAdminInDropdown'])->name('getAdminInDropdown');
		
		/*-----reserved for Employee----*/
		Route::get('your-project-list', [ProjectAssignedController::class, 'index'])->name('your-project-list');
		Route::get('get-your-project-list', [ProjectAssignedController::class, 'getData'])->name('get-your-project-list');
		Route::post('get-assigned-projects-ofadmin', [ProjectAssignedController::class, 'getAssignedProjectsOfAdmin'])->name('get-assigned-projects-ofadmin');


		

		Route::get('daily-tasks', [DailyTaskController::class, 'index'])->name('daily-tasks');
		Route::get('get-daily-tasks-list', [DailyTaskController::class, 'getData'])->name('get-daily-tasks-list');
		
		Route::post('add-new-project-task', [DailyTaskController::class, 'addNewTask'])->name('add-new-project-task');
		Route::post('update-daily-project-task', [DailyTaskController::class, 'updateDailyTask'])->name('update-daily-project-task');
		Route::get('dailytask-getedit', [DailyTaskController::class, 'getEdit'])->name('dailytask-getedit');
		Route::post('add-new-dailytask-byadmin', [DailyTaskController::class, 'addNewTaskByAdmin'])->name('add-new-dailytask-byadmin');
		/*-----reserved for Employee----*/


		/*-----------Normal used Globally functions -----------------*/
		Route::get('log-out', [DashboardController::class, 'log_out'])->name('log-out');
		Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
		/*-----------Normal used Globally functions -----------------*/
		



	});
});




Route::post('/adminside/log-in', [LoginController::class, 'login'])->name('log-in');
Route::get('/adminside/loginpage', [LoginController::class, 'index'])->name('loginpage');

Route::get('/adminside', function () {
    if (Session::has('adminid')) {
        return redirect()->route('dashboard'); 
    } else {
    	return redirect()->route('loginpage');
       // return view('admin.login'); 
    }
})->name('loginscreen');



});
/*----XSS ended------*/
