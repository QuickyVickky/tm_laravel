<!-- Button trigger modal -->
<!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assignprojectModal"> Launch Project modal</button-->

<!-- Project Modal Starts -->

<div class="modal fade" id="assignprojectModal" tabindex="-1" role="dialog" aria-labelledby="assignprojectModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="assignprojectModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <form id="assignprojectformid">
          @csrf
          <input type="hidden" name="hidadminid" id="hidadminid" value="0" >
          
          <div class="row">
                  <div class="form-group col-md-12">
                  <label>Select Projects to Assign</label>
                  	<div id="SelectProjectsToAssignDivId">
						
			</div></div></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="assignprojectformsaveid">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Project Modal Ends --> 
<!----Customer Add Snippet------starts------here------> 
<script type="text/javascript" >
$('body').on('click', '#assignprojectformsaveid', function () {
        var id = $('#hidadminid').val();
		var checkedCheckbox = [];
        $("input:checkbox[class=checkedCheckbox]:checked").each(function() {
              checkedCheckbox.push($(this).val());
      	});

        if(id=='' || checkedCheckbox.length<1){
			showSweetAlert('Error','Please Check All Required Fields.', 0); 
          	return false;
        }
        $("#assignprojectModal").modal('hide');
		
     	$.ajax({
            url: "{{ route('assign-projects-toadmin') }}",
            data: {
              _token:'{{ csrf_token() }}',
              admin_id: id, 
              assignedProject: checkedCheckbox,
            },
            type: 'post',
            dataType: 'json',
            success: function (e) {
				showAlert(e); 
				if(typeof t1 !== "undefined"){ t1.draw(); } 
            },
			error: function(jqXHR, textStatus, errorThrown) {
                showSweetAlert('Something Went Wrong!','An Error Occurred, Please Refresh Page and Try again.', 0); 
            },
        });
  });




  function showAssignProjectModal(idx=0){	
	  $('#assignprojectformid')[0].reset();
	  $('#hidadminid').val(idx);
	  
	  if(idx==0){
		  return false;
	  }
	  else if(idx>0){

	 $('#assignprojectModalLabel').html('Select & Assign');
		
     $.ajax({
            url: "{{ route('get-assigned-projects-ofadmin') }}",
            data: {
              _token:'{{ csrf_token() }}',
              admin_id: idx
            },
            type: 'post',
            dataType: 'json',
            success: function (e) {
				var ehtml = '';  
				
				if (typeof e.data.assigned !== 'undefined' && e.data.assigned != null) {
				$("#assignprojectModal").modal('show');
				$('#hidadminid').val(idx);
				var selectedListProjects = [];
				for(var projectListIncrement=0; projectListIncrement<e.data.listProject.length; projectListIncrement++){
					for(var projectAssignedIncrement=0; projectAssignedIncrement<e.data.assigned.length; projectAssignedIncrement++){
						if(e.data.assigned[projectAssignedIncrement].project_id==e.data.listProject[projectListIncrement].id){
							selectedListProjects.push(e.data.listProject[projectListIncrement].id);
						}
					}
				}
				
				for(var ijk=0; ijk<e.data.listProject.length; ijk++){
					var is_checked = '';
					if (jQuery.inArray(e.data.listProject[ijk].id, selectedListProjects)!='-1') {
						var is_checked = 'checked';
        			} 
				 ehtml += '<div class="checkbox"><label for="project_ids'+e.data.listProject[ijk].id+'"><input type="checkbox" name="project_ids[]" id="project_ids'+e.data.listProject[ijk].id+'" value="'+e.data.listProject[ijk].id+'" '+is_checked+' class="checkedCheckbox"> '+e.data.listProject[ijk].project_name+' </label></div>';
				}
				
				$("#SelectProjectsToAssignDivId").html(ehtml);
				}
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','An Error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
		}
  }



$('body').on('click', '.assignitproject', function () {
	var id = $(this).data('id');
	showAssignProjectModal(id);
});



</script> 
 
<!----Customer Add Snippet------ends------here------>