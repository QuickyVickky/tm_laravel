<!-- Button trigger modal -->
<!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#project_categoryModal"> Launch project_category modal</button-->

<!-- project_category Modal Starts -->

<div class="modal fade" id="project_categoryModal" tabindex="-1" role="dialog" aria-labelledby="project_categoryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="project_categoryModalLabel">Project Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <form id="project_categoryformid">
          @csrf
          <input type="hidden" name="hidproject_categoryid" id="hidproject_categoryid" value="0" >
          <input type="hidden" name="hidproject_categoryuuid" id="hidproject_categoryuuid" value="0" >
          <input type="hidden" name="hidselected_project_id" id="hidselected_project_id" value="0" >
          
          <div class="form-group">
            <label>Select Project </label>
            <select class="form-control" name="selectProjectFromSelect2DropdownId" id="selectProjectFromSelect2DropdownId">
            <option value="" selected="selected">Select A Project</option>
            </select>
          </div>
          
          <div class="form-group">
            <label>Project *</label>
            <input type="text" name="project_name_only" class="form-control" id="project_name_only" value="" readonly="readonly">
          </div>

          <div class="form-group">
            <label>Category Name * </label>
            <input type="text" name="project_category_name" class="form-control" id="project_category_name" placeholder="Enter Project Category Name" value="" required maxlength="255">
          </div>
          <div class="form-group">
            <label>Description (optional)</label>
            <input type="text" name="project_category_description" class="form-control" id="project_category_description" placeholder="Description" value="" maxlength="1000" autocomplete="off">
          </div>
          
          
          <div class="row">
                    <div class="form-group col-md-12">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="project_category_is_active" id="project_category_is_active{{constants('is_active.active')}}" value="{{constants('is_active.active')}}" checked="">
                        <label class="form-check-label" for="project_category_is_active{{constants('is_active.active')}}"> Active </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="project_category_is_active" id="project_category_is_active{{constants('is_active.deactive')}}" value="{{constants('is_active.deactive')}}">
                        <label class="form-check-label" for="project_category_is_active{{constants('is_active.deactive')}}"> DeActive </label>
                      </div>
                  </div>
                </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="project_categoryformsaveid">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- project_category Modal Ends --> 
<!----Customer Add Snippet------starts------here------> 
<script type="text/javascript" >
$('body').on('click', '#project_categoryformsaveid', function () {
        var id = $('#hidproject_categoryid').val();
		var uuid = $('#hidproject_categoryuuid').val();
		var category_title = $('#project_category_name').val();
		var category_description = $('#project_category_description').val();
		var project_category_is_active = $("input[name='project_category_is_active']:checked").val();
		var hidselected_project_id = $('#hidselected_project_id').val();
		
        if(id=='' || uuid=='' || hidselected_project_id=='' || category_title=='' || project_category_is_active==''){
			showSweetAlert('Error','Please Check All Required Fields.', 0); 
          return false;
        }
        $("#project_categoryModal").modal('hide');
		
     	$.ajax({
            url: "{{ route('add-update-projects-category') }}",
            data: {
              _token:'{{ csrf_token() }}',
              hid: id, 
			  uuid: uuid,
			  project_id: hidselected_project_id,
              category_title: category_title,
			  category_description: category_description,
			  is_active: project_category_is_active,
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






  function showAddNewProjectCategoryModal(idx=0){
	  $('#selectProjectFromSelect2DropdownId').val(null).trigger('change');
	  $('#project_categoryformid')[0].reset();
	  $('#hidproject_categoryid,#hidproject_categoryuuid,#hidselected_project_id').val(idx);
	  
	  if(idx==0){
		  $("#project_categoryModal").modal('show');
	  }
	  else if(idx>0){
		$('#project_categoryModalLabel').html('Edit');
		

     $.ajax({
            url: "{{ route('project-category-getedit') }}",
            data: {
              _token:'{{ csrf_token() }}',
              id: idx
            },
            type: 'get',
            dataType: 'json',
            success: function (data) {
				if (typeof data !== 'undefined' && data != null) {
				$("#project_categoryModal").modal('show');
				$('#hidproject_categoryid').val(data.id);
				$('#hidproject_categoryuuid').val(data.uuid);
				$('#project_category_name').val(data.category_title);
				$('#project_name_only').val(data.project.project_name);
				$('#project_category_description').val(data.category_description);
				$('#project_category_is_active'+data.is_active).prop('checked', true);
				$('#hidselected_project_id').val(data.project_id);
				}
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
		}
  }






var selectProjectFromSelect2DropdownId = $("#selectProjectFromSelect2DropdownId").select2({
    		placeholder: "Select A Project ",
    		width:"100%",
                ajax: {
					url: "{{ route('getProjectsInDropdown') }}",
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
 

$('body').on('change', '#selectProjectFromSelect2DropdownId', function () {
  var selected = $('#selectProjectFromSelect2DropdownId').select2("data");
  $('#project_name_only').val(selected[0].text);
  $('#hidselected_project_id').val(selected[0].id);
  });

</script> 
<!----Customer Add Snippet------ends------here------>