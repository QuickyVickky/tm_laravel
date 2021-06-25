@include('admin.layout.meta') 
<title>List Admin/Employee - {{ constants('SITE_TITLE') }}</title>
<!-- Main Wrapper -->
<div class="main-wrapper"> 
@include('admin.layout.header')
@include('admin.layout.sidebar') 
  
  <!-- Page Wrapper -->
  <div class="page-wrapper">
    <div class="content container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">{{ $control }} <a href="{{ route('add-new-admin') }}?type={{ constants('adminrole.E.name') }}" class="btn btn-primary float-right">Add</a></h4>
            </div>
            <div class="card-body">
              <div class="table">
                <table id="t1" class="datatable table table-stripped">
                  <thead>
                    <tr>
                      <th width="15%">Name</th>
                      <th width="10%">Mobile</th>
                      <th width="10%">Status</th>
                      <th width="20%">Action</th>
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
  <!-- /Page Wrapper --> 
  
</div>
<!-- /Main Wrapper --> 
@include('admin.layout.js') 
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


$(document).ready(function () {
   t1 = $('#t1').DataTable({
    processing: true,
	language: {
		processing: processingHTML_Datatable,
  	},
	serverSide: true,
 	paging: true,
	searching: true,
	searchDelay: 999,
    lengthMenu: [[10, 50, 100,500], [10, 50, 100,500]],
	pageLength: 100, 
	order: [[ 0, "desc" ]],
    ajax:  { 
    data: {"testonly": 1 },
    url: "{{ route('get-admin-list') }}" ,
	type: "get" 
	},
    aoColumnDefs: 
	[{ 
		'bSortable': false,
		 'aTargets': [-1] 
	}],
   }); 
});



$('body').on('click', '.editit', function () {
	var id = $(this).data('id');
	show_add_newadminModal(id);
});
				
</script> 
@include('admin.layout.snippets.assign_project')
<!----Add here global Js ----start----->
</body></html>