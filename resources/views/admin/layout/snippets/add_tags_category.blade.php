<!-- Button trigger modal -->
<!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tags_categoryModal"> Launch project_category modal</button-->

<!-- project_category Modal Starts -->

<div class="modal fade" id="tags_categoryModal" tabindex="-1" role="dialog" aria-labelledby="tags_categoryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tags_categoryModalLabel">Tags Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <form id="tags_categoryformid">
          @csrf
          <input type="hidden" name="hidtags_categoryid" id="hidtags_categoryid" value="0" >
          <input type="hidden" name="hidtags_categoryuuid" id="hidtags_categoryuuid" value="0" >

          <div class="form-group">
            <label>Category Tags * </label>
            <input type="text" name="tags_category_name" class="form-control" id="tags_category_name" placeholder="Enter Tags Category Name" value="" required maxlength="255" autocomplete="off">
          </div>

          <div class="row">
                    <div class="form-group col-md-12">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tags_category_is_active" id="tags_category_is_active{{constants('is_active.active')}}" value="{{constants('is_active.active')}}" checked="">
                        <label class="form-check-label" for="tags_category_is_active{{constants('is_active.active')}}"> Active </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tags_category_is_active" id="tags_category_is_active{{constants('is_active.deactive')}}" value="{{constants('is_active.deactive')}}">
                        <label class="form-check-label" for="tags_category_is_active{{constants('is_active.deactive')}}"> DeActive </label>
                      </div>
                  </div>
                </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="tags_categoryformsaveid">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- project_category Modal Ends --> 
<!----Customer Add Snippet------starts------here------> 
<script type="text/javascript" >
$('body').on('click', '#tags_categoryformsaveid', function () {
        var id = $('#hidtags_categoryid').val();
		var uuid = $('#hidtags_categoryuuid').val();
		var category_title = $('#tags_category_name').val();
		var tags_category_is_active = $("input[name='tags_category_is_active']:checked").val();
		
        if(id=='' || uuid=='' || category_title=='' || tags_category_is_active==''){
			showSweetAlert('Error','Please Check All Required Fields.', 0); 
          return false;
        }
        $("#tags_categoryModal").modal('hide');
		
     	$.ajax({
            url: "{{ route('add-update-tags-category') }}",
            data: {
              _token:'{{ csrf_token() }}',
              hid: id, 
			  uuid: uuid,
              category_title: category_title,
			  is_active: tags_category_is_active,
            },
            type: 'post',
            dataType: 'json',
            success: function (e) {
				showAlert(e); 
				if(typeof t2 !== "undefined"){ t2.draw(); } 
            },
			error: function(jqXHR, textStatus, errorThrown) {
                showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
  });






  function showTagsCategoryModal(idx=0){
	  $('#tags_categoryformid')[0].reset();
	  $('#hidtags_categoryid,#hidtags_categoryuuid,#hidselected_project_id').val(idx);
	  
	  if(idx==0){
		  $("#tags_categoryModal").modal('show');
	  }
	  else if(idx>0){
		$('#tags_categoryModalLabel').html('Edit');
		

     $.ajax({
            url: "{{ route('tags-category-getedit') }}",
            data: {
              _token:'{{ csrf_token() }}',
              id: idx
            },
            type: 'get',
            dataType: 'json',
            success: function (data) {
				if (typeof data !== 'undefined' && data != null) {
				$("#tags_categoryModal").modal('show');
				$('#hidtags_categoryid').val(data.id);
				$('#hidtags_categoryuuid').val(data.uuid);
				$('#tags_category_name').val(data.category_title);
				$('#tags_category_is_active'+data.is_active).prop('checked', true);
				}
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
		}
  }

$('body').on('click', '.editittagscategory', function () {
	var id = $(this).data('id');
	showTagsCategoryModal(id);
});


if($("#selectTagsCategoryFromSelect2DropdownId").length > 0) {
	var addNewTagsCategoryBtnId = '<button type="button" onclick="showTagsCategoryModal()" class="btn btn-warning fullwidthbtncls">Add New Tags Category +</button>';
var selectTagsCategoryFromSelect2DropdownId = $("#selectTagsCategoryFromSelect2DropdownId").select2({
    		placeholder: "Select Tags Category ",
    		width:"100%",
                ajax: {
					url: "{{ route('getTagsCategoryInDropdown') }}",
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
var flg = 0;
$("#selectTagsCategoryFromSelect2DropdownId").on("select2:open", function () {
        flg++;
        if (flg == 1) {
            $(".select2-results").append(addNewTagsCategoryBtnId);
        }
});

}
</script> 
<!----Customer Add Snippet------ends------here------>