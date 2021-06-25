@include('admin.layout.meta') 
<title> Project List - {{ constants('SITE_TITLE') }}</title>
<!-- Main Wrapper -->
<div class="main-wrapper"> @include('admin.layout.header')
  @include('admin.layout.sidebar') 
  
  <!-- Page Wrapper -->
  <div class="page-wrapper">
    <div class="content container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">{{ $control }} <a href="javascript:void(0)" class="btn btn-success float-right" id="add_newprojecttaskfortoday_btnid" onclick="showAddNewProjectTaskTodayModal()">Submit Project Task For Today</a></h4>
            </div>
            <div class="card-body">
              <ul class="nav nav-tabs nav-tabs-bottom">
                <li class="nav-item"><a class="nav-link active" href="#bottom-tab1" data-toggle="tab">Projects</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane show active" id="bottom-tab1">
                  <div class="table-responsive">
                    <table id="t1" class="datatable table table-stripped" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Description</th>
                          <th>Hours:Minutes</th>
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
<script type="text/javascript">
	var t1; 
	var t2; 
	$.fn.dataTable.ext.errMode = 'none';
    errorCount = 0;
    $('#t1').on('error.dt', function(e, settings, techNote, message) {
        if (errorCount > 3) {
            showSweetAlert('Something Went Wrong', 'Please Refresh Page.', 0);
			errorCount = 0;
        } else {
            t1.draw();
        }
        errorCount++;
    });


$(document).ready(function () {
	/*--------------*/
   /*--------------*/
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
	pageLength: 50, 
	order: [[ 0, "desc" ]],
    ajax:  { 
    data: {"testonly": 1 },
    url: "{{ route('get-your-project-list') }}" ,
	type: "get" 
	},
    aoColumnDefs: 
	[{ 
		'bSortable': false,
		 'aTargets': [-1] 
	}],
   }); 
   /*--------------*/
});
		
</script> 
<script type="text/javascript">


</script>
<!----Add here global Js ----start----->
@include('admin.layout.snippets.add_new_project_task') 
</body></html>