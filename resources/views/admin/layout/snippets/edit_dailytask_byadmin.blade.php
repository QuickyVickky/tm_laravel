<!-- Button trigger modal -->
<!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#auproject_taskModal"> Launch project_task modal</button-->

<!-- project_task Modal Starts -->

<div class="modal fade" id="auproject_taskModal" tabindex="-1" role="dialog" aria-labelledby="auproject_taskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="auproject_taskModalLabel">Project Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <form id="eproject_taskformid">
          @csrf
          <input type="hidden" name="ehidproject_taskid" id="ehidproject_taskid" value="0" >
          <!--div class="row">
            <div class="form-group col-md-6">
              <label>Select Project *</label>
              <select class="form-control" name="selectProjectFromSelect2DropdownId" id="selectProjectFromSelect2DropdownId">
                <option value="" selected="selected">Select A Project</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label>Category (optional)</label>
              <select class="form-control" name="selectProjectCategoryFromSelect2DropdownId" id="selectProjectCategoryFromSelect2DropdownId">
                <option value="" selected="selected">Select Category</option>
              </select>
            </div>
          </div-->
          <div class="row">
            <div class="form-group col-md-2">
              <label>Hours *</label>
              <select name="eproject_dailytask_hours" class="form-control disableByClass" id="eproject_dailytask_hours" required>
                <?php for($varHour=0; $varHour <= 12; $varHour++) {?>
                <option value="{{ $varHour }}" {{ ($varHour==8) ? 'selected' : '' }}>{{ $varHour }}</option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group col-md-2">
              <label>Minutes *</label>
              <select name="eproject_dailytask_minutes" class="form-control disableByClass" id="eproject_dailytask_minutes" required>
                <?php for($varMinute=0; $varMinute <= 59; $varMinute++) {?>
                <option value="{{ $varMinute }}" {{ ($varMinute==30) ? 'selected' : '' }}>{{ $varMinute }}</option>
                <?php } ?>
              </select>
            </div>
             <div class="form-group col-md-3">
                    <label>Task Date </label>
                    <input type="date" id="edailytask_date" class="form-control disableByClass" placeholder="Select Date" name="edailytask_date" required="required" value="{{ date('Y-m-d') }}" autocomplete="off" min="{{ date('Y-m-d', strtotime(date('Y-m-d') . ' -9999 days')) }}" max="{{ date('Y-m-d') }}">
                  </div>
          </div>
          <div class="form-group">
            <label>Task Description *</label>
            <textarea type="text" rows="10" name="eproject_task_description" class="form-control disableByClass" id="eproject_task_description" 
            placeholder="Description" value="" maxlength="5000" minlength="2"></textarea>
          </div>
          
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" name="eaddOverTimeCheckBoxId" id="eaddOverTimeCheckBoxId" value="1" class="disableByClass"> Check This to Add in OverTime.</label>
            </div>
          </div>
          <div class="row" id="eshowHideOverTimeByCheckBoxId" style="display:none;">
          <div class="form-group col-md-12">
          <p>Please Tell Us How Much OverTime From Above [Must Be Less Than Above Timing].</p>
          </div>
            <div class="form-group col-md-2">
              <label>Hours *</label>
              <select name="eovertime_dailytask_hours" class="form-control disableByClass" id="eovertime_dailytask_hours">
                <?php for($varHour=0; $varHour <= 7; $varHour++) {?>
                <option value="{{ $varHour }}" {{ ($varHour==1) ? 'selected' : '' }}>{{ $varHour }}</option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group col-md-2">
              <label>Minutes *</label>
              <select name="eovertime_dailytask_minutes" class="form-control disableByClass" id="eovertime_dailytask_minutes">
                <?php for($varMinute=0; $varMinute <= 59; $varMinute++) {?>
                <option value="{{ $varMinute }}" {{ ($varMinute==0) ? 'selected' : '' }}>{{ $varMinute }}</option>
                <?php } ?>
              </select>
            </div>
          </div>
          
          <div class="row">
            <div class="form-group col-md-12">
              <label>Notes (optional)</label>
              <input type="text" name="eproject_task_any_notes" class="form-control disableByClass" id="eproject_task_any_notes" placeholder="Any Project Task Notes (optional)" value="" maxlength="250">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary removeByClass" id="eproject_taskformsaveid">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- project_task Modal Ends --> 
<!----Customer Add Snippet------starts------here------> 
<script type="text/javascript" >
$('body').on('click', '#eproject_taskformsaveid', function () {
        var id = $('#ehidproject_taskid').val();
		var eproject_task_any_notes = $('#eproject_task_any_notes').val();
		var eproject_task_description = $('textarea#eproject_task_description').val();
		var eproject_task_is_active = 1;
		var eproject_dailytask_hours = $('#eproject_dailytask_hours').val();
		var eproject_dailytask_minutes = $('#eproject_dailytask_minutes').val();
		var edailytask_date = $('#edailytask_date').val();
		var eovertime_dailytask_hours = $('#eovertime_dailytask_hours').val();
		var eovertime_dailytask_minutes = $('#eovertime_dailytask_minutes').val();
		var eaddOverTimeCheckBoxId = document.getElementById("eaddOverTimeCheckBoxId");
		if (eaddOverTimeCheckBoxId.checked == true){var eaddOverTimeCheckBoxId = 1;}
		else{var eaddOverTimeCheckBoxId = 0;}

		
        if(id=='' || eproject_task_description=='' || eproject_dailytask_hours=='' || eproject_dailytask_minutes=='' || eproject_task_is_active!=1 || edailytask_date==''){
			showSweetAlert('Error','Please Check All Required Fields.', 0); 
          	return false;
        }
        $("#auproject_taskModal").modal('hide');
		
     	$.ajax({
            url: "{{ route('update-daily-project-task') }}",
            data: {
              _token:'{{ csrf_token() }}',
              hid: id, 
			  any_notes: eproject_task_any_notes,
			  task_description: eproject_task_description,
			  is_active: eproject_task_is_active,
			  project_dailytask_hours: eproject_dailytask_hours,
			  project_dailytask_minutes: eproject_dailytask_minutes,
			  dailytask_date: edailytask_date,
			  addOverTimeCheckBoxId: eaddOverTimeCheckBoxId,
			  overtime_dailytask_hours: eovertime_dailytask_hours,
			  overtime_dailytask_minutes: eovertime_dailytask_minutes,
            },
            type: 'post',
            dataType: 'json',
            success: function (e) {
				showAlert(e); 
				if (typeof getDailyTaskData == 'function') { getDailyTaskData(); }
				if (typeof getAllDailyTaskData == 'function') { getAllDailyTaskData(); }
            },
			error: function(jqXHR, textStatus, errorThrown) {
                showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
  });


  function showEditDailyTaskInModal(idx=0){
	  $('#selectEmployeeFromSelect2DropdownId').val(null).trigger('change');
	  $('#selectProjectFromSelect2DropdownId').val(null).trigger('change');
	  $('#selectProjectCategoryFromSelect2DropdownId').val(null).trigger('change');
	  $("#eshowHideOverTimeByCheckBoxId").hide();
	  $('#eproject_taskformid')[0].reset();
	  $('#ehidproject_taskid').val(idx);
	  
	  if(idx==0){
		  $("#auproject_taskModal").modal('show');
	  }
	  else if(idx>0){
		  $("#auproject_taskModal").modal('show');
		  
		  $.ajax({
            url: "{{ route('dailytask-getedit') }}",
            data: {
              _token:'{{ csrf_token() }}',
              id: idx
            },
            type: 'get',
            dataType: 'json',
            success: function (data) {
				if (typeof data.one !== 'undefined' && data.one != null) {
				$("#auproject_taskModal").modal('show');
				$('#ehidproject_taskid').val(data.one.id);
				$('#eproject_task_any_notes').val(data.one.any_notes);
				$('#eproject_task_description').val(data.one.task_description);
				$('#eproject_dailytask_hours').val(Math.floor(data.one.dailytask_minutes/60));
				$('#eproject_dailytask_minutes').val(data.one.dailytask_minutes%60);
				$('#edailytask_date').val(data.one.dailytask_date);
				if(data.one.overtime_minutes>0) {
					$('#eovertime_dailytask_hours').val(Math.floor(data.one.overtime_minutes/60));
					$('#eovertime_dailytask_minutes').val(data.one.overtime_minutes%60);
					$("#eshowHideOverTimeByCheckBoxId").show();
					$("#eaddOverTimeCheckBoxId").prop('checked', true);
					}
				}
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','Please Refresh Page & Try again.', 0); 
            },
        });
		
	  }	  
	  
	  
	  
  }

$('body').on('change', '#eaddOverTimeCheckBoxId', function () {
	var eaddOverTimeCheckBoxId = document.getElementById("eaddOverTimeCheckBoxId");
	if (eaddOverTimeCheckBoxId.checked == true){
		$("#eshowHideOverTimeByCheckBoxId").show();
	}
	else
	{
		$("#eshowHideOverTimeByCheckBoxId").hide();
	}
});

</script> 

<script type="text/javascript" >
</script>
<!----Customer Add Snippet------ends------here------>