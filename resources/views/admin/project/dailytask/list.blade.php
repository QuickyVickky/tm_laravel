@include('admin.layout.meta') 
<title> Project List - {{ constants('SITE_TITLE') }}</title>
<!-- Main Wrapper -->
<div class="main-wrapper"> @include('admin.layout.header')
  @include('admin.layout.sidebar') 
      <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/bootstrap-multiselect.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/assets/css/daterangepicker.min.css') }}">
  
  <!-- Page Wrapper -->
  <div class="page-wrapper">
    <div class="content container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">{{ $control }} <a href="javascript:void(0)" class="btn btn-success float-right" id="add_newprojecttaskfortoday_btnid" onclick="showAddNewProjectTaskTodayModal()">Submit Project Task For Today</a></h4>
            </div>
            
            <form id="filterFormid">
              @csrf
              <div class="card-header">
                <div class="row">
                  <div class="form-group col-md-2">
                    <label>Task Date </label>
                    <input type="text" id="filter_global_date" class="form-control" placeholder="Select Date" name="filter_global_date" required="required" value="" autocomplete="off">
                  </div>
                  <div class="form-group col-md-4"><br /> <a class="btn btn-outline-success" onclick="getDailyTaskData()"> Apply Filter</a>  </div>
                </div>
              </div>
            </form>
            <div class="card-header">
            <h6>Total Timings : <b class="totaltimingshowcls">0 Minute</b></h5>
            </div>
            
            <div class="card-body">
              <ul class="nav nav-tabs nav-tabs-bottom">
                <li class="nav-item"><a class="nav-link active" href="#bottom-tab1" data-toggle="tab">Project Tasks</a></li>
                <li class="nav-item"><a class="nav-link" href="#bottom-tab2" data-toggle="tab">ProjectTasks DateWise</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane show active" id="bottom-tab1">
                  <div class="table-responsive">
                    <table id="t1" class="datatable table table-stripped" style="width:100%">
                      <thead>
                        <tr>
                          <th width="6%">TaskDate</th>
                          <th width="10%">Project</th>
                          <th width="60%">Task Details</th>
                          <th width="6%">Timings</th>
                          <th width="6%">OverTime</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane" id="bottom-tab2">
                  <div class="table-responsive">
                    <table id="t2" class="datatable table table-stripped" style="width:100%">
                      <thead>
                        <tr>
                          <th width="6%">TaskDate</th>
                          <th width="6%">Timings</th>
                          <th width="6%">OverTime</th>
                          <th width="10%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Page Wrapper --> 
  
</div>
<!-- /Main Wrapper --> 
@include('admin.layout.js') 
<script src="{{ asset('admin_assets/assets/js/bootstrap-multiselect.min.js') }}"></script> 
<script src="{{ asset('admin_assets/assets/js/daterangepicker.min.js') }}"></script> 
<script type="text/javascript">
	var t1; 
	var t2; 
	$.fn.dataTable.ext.errMode = 'none';
    errorCount = 0;
    $('#t1').on('error.dt', function(e, settings, techNote, message) {
        if (errorCount > 2) {
            showSweetAlert('something went wrong', 'please refresh page and try again', 0);
			errorCount = 0;
        } else {
            t1.draw();
        }
        errorCount++;
    });

$(document).ready(function() {
	getDailyTaskData();
});
	

function getDailyTaskData() {
	filter_global_date =  $("#filter_global_date").val();	
	
	/*--------------------t1 starts-----------------------*/
    t1 = $('#t1').DataTable({
    processing: true,
	destroy: true,
	language: {
		processing: processingHTML_Datatable,
  	},
	serverSide: true,
 	paging: true,
	searching: true,
	searchDelay: 999,
    lengthMenu: [[10, 50, 100,500], [10, 50, 100,500]],
	pageLength: 50, 
	order: [[ 0, "desc" ]],
    ajax:  { 
    data: { 
		filter_global_date:filter_global_date,  
	},
    url: "{{ route('get-daily-tasks-list') }}" ,
	type: "get" 
	},
    aoColumnDefs: 
	[{ 
		'bSortable': false,
		 'aTargets': [-1] 
	},
	{
        targets: 2,
        render: function (data, type, row ) {
            return data.substr(0,50);
        }
	},],
	initComplete: function(settings, jsonData) {
		var hours = Math.floor(jsonData.totalMinutes / 60);          
    	var minutes = jsonData.totalMinutes % 60;
		$(".totaltimingshowcls").html( hours +" Hour(s), "+ minutes + " Minute(s)");
  	},
   }); 
   /*--------------------t1 ends-----------------------*/
   /*--------------------t2 starts-----------------------*/
   	t2 = $('#t2').DataTable({
    processing: true,
	destroy: true,
	language: {
		processing: processingHTML_Datatable,
  	},
	serverSide: true,
 	paging: true,
	 searching: true,
    lengthMenu: [[10, 50, 100,500], [10, 50, 100,500]],
	pageLength: 50, 
	order: [[ 0, "desc" ]],
     ajax:{ 
    data: { 
			admin_id:0,
			filter_global_date:filter_global_date,  
	},
    url: "{{ route('get-dailytaskslist-datewise-ofadmin') }}" ,
	type: "get" ,
	},
    aoColumnDefs: 
	[{ 
		'bSortable': false,
		 'aTargets': [-1] 
	}],
	initComplete: function(settings, jsonData) {
		//your code
  	},
   }); 
/*--------------------t2 ends-----------------------*/
}
		
</script> 
<script type="text/javascript">
$(function () {
            var start = moment().subtract(365, 'days');
            var end = new Date();

            function cb(start, end) {
                /*$('#filter_global_date').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));*/
            }

            $('#filter_global_date').daterangepicker({
                autoUpdateInput: true,
                maxDate: moment().endOf("day"),
                startDate: start,
                endDate: end,
                ranges: {
					'Last 365 Days': [moment().subtract(365, 'days'), moment()],
					'Last 30 Days': [moment().subtract(30, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Today': [moment(), moment()],
                    'Last 7 Days': [moment().subtract(7, 'days'), moment()],
                }, locale: {
                    format: 'YYYY-MM-DD'
                }
            }, cb);
             $('input[name="date"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
        });
	$(document).ready(function() {
		$('#filter_global_date').val('');
    });
</script>
<script type="text/javascript">
$('body').on('click', '.edititdailytask', function () {
	var id = $(this).data('id');
	showEditDailyTaskInModal(id);
	$('#tableDailyTaskViewByIdModal').modal('hide');
	$(".removeByClass").remove();
	$(".disableByClass").prop('disabled', true);
});

</script>
<!----Add here global Js ----start----->
@include('admin.layout.snippets.add_new_project_task') 
@include('admin.layout.snippets.edit_dailytask_byadmin') 


<div class="modal fade" id="tableDailyTaskViewByIdModal" tabindex="-1" role="dialog" aria-labelledby="tableDailyTaskViewByIdModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tableDailyTaskViewByIdModalLabel">Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <table id="tableDailyTaskViewById" class="datatable table table-stripped" style="width:100%">
                      <thead>
                        <tr>
                          <th width="6%">TaskDate</th>
                          <th width="60%">Task Details</th>
                          <th width="6%">Timings</th>
                          <th width="10%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$('body').on('click', '.getviewdailytaskdate', function () {
	var dailytask_date = $(this).data('dailytask_date');
	$('#tableDailyTaskViewByIdModal').modal('show');
   	tableDailyTaskViewById = $('#tableDailyTaskViewById').DataTable({
    processing: true,
	destroy: true,
	language: {
		processing: processingHTML_Datatable,
  	},
	serverSide: true,
 	paging: true,
	searching: false,
    lengthMenu: [[10, 50], [10, 50]],
	pageLength: 10, 
	order: [[ 0, "desc" ]],
     ajax:{ 
    data: { 
			admin_id:0,
			dailytask_date:dailytask_date,
	},
    url: "{{ route('getDailyTasksListByDate') }}" ,
	type: "get" ,
	},
    aoColumnDefs: 
	[{ 
		'bSortable': false,
		 'aTargets': [-1,0] 
	},{
        targets: 1,
        render: function (data, type, row ) {
            return data.substr(0,50);
        }
	},],
   }); 
}); 
</script>
</body></html>