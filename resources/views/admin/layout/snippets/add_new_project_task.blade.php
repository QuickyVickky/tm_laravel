<!-- Button trigger modal -->
<!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#project_taskModal"> Launch project_task modal</button-->
<!-- project_task Modal Starts -->

<div class="modal fade" id="project_taskModal" tabindex="-1" role="dialog" aria-labelledby="project_taskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="project_taskModalLabel">Project Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <form id="project_taskformid">
          @csrf
          <input type="hidden" name="hidproject_taskid" id="hidproject_taskid" value="0" >
          <div class="row">
            <div class="form-group col-md-6">
              <label>Select Project *</label>
              <select class="form-control" name="selectProjectFromSelect2DropdownId" id="selectProjectFromSelect2DropdownId">
                <option value="" selected="selected">Select A Project</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label>Category *</label>
              <select class="form-control" name="selectProjectCategoryFromSelect2DropdownId" id="selectProjectCategoryFromSelect2DropdownId">
                <option value="" selected="selected">Select Category</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-2">
              <label>Hours *</label>
              <select name="project_dailytask_hours" class="form-control" id="project_dailytask_hours" required>
                <?php for($varHour=0; $varHour <= 12; $varHour++) {?>
                <option value="{{ $varHour }}" {{ ($varHour==8) ? 'selected' : '' }}>{{ $varHour }}</option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group col-md-2">
              <label>Minutes *</label>
              <select name="project_dailytask_minutes" class="form-control" id="project_dailytask_minutes" required>
                <?php for($varMinute=0; $varMinute <= 59; $varMinute++) {?>
                <option value="{{ $varMinute }}" {{ ($varMinute==30) ? 'selected' : '' }}>{{ $varMinute }}</option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Task Date * </label>
              <input type="date" id="project_dailytask_date" class="form-control" placeholder="Select Date" name="project_dailytask_date" required="required" value="{{ date('Y-m-d') }}" autocomplete="off" min="{{ date('Y-m-d', strtotime(date('Y-m-d') . ' -1 days')) }}" max="{{ date('Y-m-d') }}">
            </div>
          </div>
          <div class="form-group">
            <label>Task Description *</label>
            <textarea type="text" rows="3" name="project_task_description" class="form-control" id="project_task_description" 
            placeholder="Description" value="" maxlength="5000" minlength="2"></textarea>
          </div>
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" name="addOverTimeCheckBoxId" id="addOverTimeCheckBoxId" value="1"> Check This to Add in OverTime.</label>
            </div>
          </div>
          <div class="row" id="showHideOverTimeByCheckBoxId" style="display:none;">
          <div class="form-group col-md-12">
          <p>Please Tell Us How Much OverTime From Above [Must Be Less Than Above Timing].</p>
          </div>
            <div class="form-group col-md-2">
              <label>Hours *</label>
              <select name="overtime_dailytask_hours" class="form-control" id="overtime_dailytask_hours">
                <?php for($varHour=0; $varHour <= 7; $varHour++) {?>
                <option value="{{ $varHour }}" {{ ($varHour==1) ? 'selected' : '' }}>{{ $varHour }}</option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group col-md-2">
              <label>Minutes *</label>
              <select name="overtime_dailytask_minutes" class="form-control" id="overtime_dailytask_minutes">
                <?php for($varMinute=0; $varMinute <= 59; $varMinute++) {?>
                <option value="{{ $varMinute }}" {{ ($varMinute==0) ? 'selected' : '' }}>{{ $varMinute }}</option>
                <?php } ?>
              </select>
            </div>
          </div>
          
          
          <div class="row">
            <div class="form-group col-md-12">
              <label>Notes (optional)</label>
              <input type="text" name="project_task_any_notes" class="form-control" id="project_task_any_notes" placeholder="Any Project Task Notes (optional)" value="" maxlength="250">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="project_taskformsaveid">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- project_task Modal Ends --> 
<!----Customer Add Snippet------starts------here------> 
<script type="text/javascript" >
var currentPageRoute = '{{ Route::currentRouteName() }}';
$('body').on('click', '#project_taskformsaveid', function () {
        var id = $('#hidproject_taskid').val();
		var project_task_any_notes = $('#project_task_any_notes').val();
		var project_task_description = $('textarea#project_task_description').val();
		var project_task_is_active = 1;
		var hidselected_project_id = $('#selectProjectFromSelect2DropdownId').val();
		var hidselected_projectcategory_id = $('#selectProjectCategoryFromSelect2DropdownId').val();
		var project_dailytask_hours = $('#project_dailytask_hours').val();
		var project_dailytask_minutes = $('#project_dailytask_minutes').val();
		var project_dailytask_date = $('#project_dailytask_date').val();
		var overtime_dailytask_hours = $('#overtime_dailytask_hours').val();
		var overtime_dailytask_minutes = $('#overtime_dailytask_minutes').val();
		var addOverTimeCheckBoxId = document.getElementById("addOverTimeCheckBoxId");
		if (addOverTimeCheckBoxId.checked == true){var addOverTimeCheckBoxId = 1;}
		else{var addOverTimeCheckBoxId = 0;}
		
        if(hidselected_projectcategory_id=='' || id=='' || project_task_description=='' || hidselected_project_id=='' || project_dailytask_hours=='' || project_dailytask_minutes=='' || project_task_is_active!=1){
			showSweetAlert('Error','Please Check All Required Fields.', 0); 
          	return false;
        }
					
		var x = confirm("Confirm This Task Details, Will not Be Editable ?");
		if(x==false){ return false; }
        $("#project_taskModal").modal('hide');
		
     	$.ajax({
            url: "{{ route('add-new-project-task') }}",
            data: {
              _token:'{{ csrf_token() }}',
              hid: id, 
			  any_notes: project_task_any_notes,
			  project_id: hidselected_project_id,
              project_category_id: hidselected_projectcategory_id,
			  task_description: project_task_description,
			  is_active: project_task_is_active,
			  project_dailytask_hours: project_dailytask_hours,
			  project_dailytask_minutes: project_dailytask_minutes,
			  dailytask_date: project_dailytask_date,
			  addOverTimeCheckBoxId: addOverTimeCheckBoxId,
			  overtime_dailytask_hours: overtime_dailytask_hours,
			  overtime_dailytask_minutes: overtime_dailytask_minutes,
            },
            type: 'post',
            dataType: 'json',
            success: function (e) {
				showAlert(e); 
				setTimeout(function(){ if(currentPageRoute=='dashboard'){ window.location.href = "{{ route('daily-tasks') }}"; } }, 1500);
				if (typeof getDailyTaskData == 'function') { getDailyTaskData(); }
				if (typeof getAllDailyTaskData == 'function') { getAllDailyTaskData(); }
				
            },
			error: function(jqXHR, textStatus, errorThrown) {
                showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
  });


  function showAddNewProjectTaskTodayModal(idx=0){
	  $('#selectProjectFromSelect2DropdownId').val(null).trigger('change');
	  $('#selectProjectCategoryFromSelect2DropdownId').val(null).trigger('change');
	  $('#project_taskformid')[0].reset();
	  $("#showHideOverTimeByCheckBoxId").hide();
	  $('#hidproject_taskid,#hidproject_taskuuid,#hidselected_project_id').val(idx);
	  
	  if(idx==0){
		  $("#project_taskModal").modal('show');
	  }
  }



var selectProjectFromSelect2DropdownId = $("#selectProjectFromSelect2DropdownId").select2({
    		placeholder: "Select A Project ",
    		width:"100%",
                ajax: {
					url: "{{ route('getProjectsInDropdownAssigned') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                     data: function (params) {
                        return {
                            searchTerm: params.term ,
							_token:'{{ csrf_token() }}',
							'includeid': 0, 
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
 });
 
var selectProjectCategoryFromSelect2DropdownId = $("#selectProjectCategoryFromSelect2DropdownId").select2({
    		placeholder: "Select A Project Category",
    		width:"100%",
                ajax: {
					url: "{{ route('getProjectCategoryInDropdown') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                     data: function (params) {
                        return {
                            searchTerm: params.term ,
							_token:'{{ csrf_token() }}',
							'includeid': 0, 
							'project_id': $('#selectProjectFromSelect2DropdownId').val(), 
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
 });

$('body').on('change', '#selectProjectFromSelect2DropdownId', function () {
	$('#selectProjectCategoryFromSelect2DropdownId').val(null).trigger('change');
});


$('body').on('change', '#addOverTimeCheckBoxId', function () {
	var addOverTimeCheckBoxId = document.getElementById("addOverTimeCheckBoxId");
	if (addOverTimeCheckBoxId.checked == true){
		$("#showHideOverTimeByCheckBoxId").show();
	}
	else
	{
		$("#showHideOverTimeByCheckBoxId").hide();
	}
});
	






</script> 
<!----Customer Add Snippet------ends------here------>