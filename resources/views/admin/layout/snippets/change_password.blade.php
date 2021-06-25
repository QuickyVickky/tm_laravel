<!-- Button trigger modal -->
<!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePasswordModal"> Launch Project modal</button-->
<!-- Change Password Modal Starts -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <form id="changepasswordformid">
          @csrf
          <input type="hidden" name="hidadminid" id="hidadminid" value="0" >
          <input type="hidden" name="hidadminuuid" id="hidadminuuid" value="0" >
          <div class="form-group">
            <label>Current Password * </label>
            <input type="text" name="fill_current_password" class="form-control pass-input" id="fill_current_password" placeholder="Enter Current Password" value="" required autocomplete="off" maxlength="25">
          </div>
          <div class="form-group">
            <label>New Password * </label>
            <input type="text" name="fill_new_password" class="form-control pass-input" id="fill_new_password" placeholder="Enter New Password" value="" required autocomplete="off" maxlength="25" minlength="3">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="changepasswordformsaveid">Submit</button>
      </div>
    </div>
  </div>
</div>
<!-- Project Modal Ends --> 
<!----Customer Add Snippet------starts------here------> 
<script type="text/javascript" >
$('body').on('click', '#changepasswordformsaveid', function () {
        var id = $('#hidadminid').val();
		var uuid = $('#hidadminuuid').val();
		var fill_current_password = $('#fill_current_password').val();
		var fill_new_password = $('#fill_new_password').val();
		
        if(id=='' || uuid=='' || fill_current_password=='' || fill_new_password==''){
		  showSweetAlert('Error','Please Check All Required Fields.', 0); 
          return false;
        }
        $("#changePasswordModal").modal('hide');
		
     	$.ajax({
            url: "{{ route('change-password-update') }}",
            data: {
              _token:'{{ csrf_token() }}',
              hid: id, 
			  uuid: uuid,
              fill_current_password: fill_current_password,
			  fill_new_password: fill_new_password,
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


function showUpdateChangePasswordModal(){
	  $('#changepasswordformid')[0].reset();
	  $("#changePasswordModal").modal('show');
}

</script> 
<!----Change Password Snippet------ends------here------>