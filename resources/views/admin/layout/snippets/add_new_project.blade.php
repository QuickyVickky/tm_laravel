<!-- Button trigger modal -->
<!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#projectModal"> Launch Project modal</button-->

<!-- Project Modal Starts -->

<div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="projectModalLabel">Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <form id="projectformid">
          @csrf
          <input type="hidden" name="hidprojectid" id="hidprojectid" value="0" >
          <input type="hidden" name="hidprojectuuid" id="hidprojectuuid" value="0" >
          <div class="form-group">
            <label>Name * </label>
            <input type="text" name="project_name" class="form-control" id="project_name" placeholder="Enter Project Name" value="" maxlength="255" required>
          </div>
          <div class="form-group">
            <label>Description (optional)</label>
            <input type="text" name="project_description" class="form-control" id="project_description" placeholder="Description" value="" maxlength="1000">
          </div>
          <div class="row">
          <div class="form-group col-md-6">
            <label>Start Date *</label>
           <input type="date" class="form-control" name="start_date" id="start_date" value="{{ date('Y-m-d') }}">
           </div>
           
           <div class="form-group col-md-6">
            <label>End Date</label>
           <input type="date" class="form-control" name="end_date" id="end_date" value="">
           </div>
           </div>
           
           
            <div class="form-group" id="showHideIdProjectCategory">
            <label>Category (optional)</label>
            <select class="form-control" name="add_project_category[]" id="selectTagsCategoryFromSelect2DropdownId" multiple="multiple">
            </select>
          </div>
           

          <div class="row">
                    <div class="form-group col-md-12">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="project_is_active" id="project_is_active{{constants('is_active.active')}}" value="{{constants('is_active.active')}}" checked="">
                        <label class="form-check-label" for="project_is_active{{constants('is_active.active')}}"> Active </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="project_is_active" id="project_is_active{{constants('is_active.deactive')}}" value="{{constants('is_active.deactive')}}">
                        <label class="form-check-label" for="project_is_active{{constants('is_active.deactive')}}"> DeActive </label>
                      </div>
                  </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-md-12">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="project_is_deployed" id="project_is_deployed{{constants('confirmation.no')}}" value="{{constants('confirmation.no')}}" checked="">
                        <label class="form-check-label" for="project_is_deployed{{constants('confirmation.no')}}"> Not Deployed </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="project_is_deployed" id="project_is_deployed{{constants('confirmation.yes')}}" value="{{constants('confirmation.yes')}}">
                        <label class="form-check-label" for="project_is_deployed{{constants('confirmation.yes')}}"> Deployed </label>
                      </div>
                  </div>
                </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="projectformsaveid">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Project Modal Ends --> 
<!----Customer Add Snippet------starts------here------> 
<script type="text/javascript" >
$('body').on('click', '#projectformsaveid', function () {
        var id = $('#hidprojectid').val();
		var uuid = $('#hidprojectuuid').val();
		var project_name = $('#project_name').val();
		var project_description = $('#project_description').val();
		var project_is_active = $("input[name='project_is_active']:checked").val();
		var project_is_deployed = $("input[name='project_is_deployed']:checked").val();
		var start_date = $('#start_date').val();
		var end_date = $('#end_date').val();
		var add_project_category = $('#selectTagsCategoryFromSelect2DropdownId').val();
		
		
        if(id=='' || uuid=='' || project_name=='' || project_is_active==''){
		showSweetAlert('Error','Please Check All Required Fields.', 0); 
          return false;
        }
        $("#projectModal").modal('hide');
		
     	$.ajax({
            url: "{{ route('add-update-projects') }}",
            data: {
              _token:'{{ csrf_token() }}',
              hid: id, 
			  uuid: uuid,
              project_name: project_name,
			  project_description: project_description,
			  is_active: project_is_active,
			  is_deployed: project_is_deployed,
			  start_date: start_date,
			  end_date: end_date,
			  add_project_category: add_project_category,
            },
            type: 'post',
            dataType: 'json',
            success: function (e) {
				showAlert(e); 
				if(typeof t1 !== "undefined"){ t1.draw(); } 
            },
			error: function(jqXHR, textStatus, errorThrown) {
                showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
  });


function showAddNewProjectModal(idx=0){
	  $('#selectTagsCategoryFromSelect2DropdownId').val(null).trigger('change');
	  $('#projectformid')[0].reset();
	  $('#hidprojectid,#hidprojectuuid').val(idx);
	  
	  if(idx==0){
		  $("#showHideIdProjectCategory").show();
		  $("#projectModal").modal('show');
	  }
	  else if(idx>0){
		 $("#showHideIdProjectCategory").hide();
		$('#projectModalLabel').html('Edit');
		

     $.ajax({
            url: "{{ route('project-getedit') }}",
            data: {
              _token:'{{ csrf_token() }}',
              id: idx
            },
            type: 'get',
            dataType: 'json',
            success: function (data) {
				if (typeof data !== 'undefined' && data != null) {
				$("#projectModal").modal('show');
				$('#hidprojectid').val(data.id);
				$('#hidprojectuuid').val(data.uuid);
				$('#project_name').val(data.project_name);
				$('#project_description').val(data.project_description);
				$('#project_is_active'+data.is_active).prop('checked', true);
				$('#project_is_deployed'+data.is_deployed).prop('checked', true);
				$('#start_date').val(data.start_date);
				$('#end_date').val(data.end_date);
				}
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
		}
  }

</script> 
@include('admin.layout.snippets.add_tags_category') 
<!----Customer Add Snippet------ends------here------>