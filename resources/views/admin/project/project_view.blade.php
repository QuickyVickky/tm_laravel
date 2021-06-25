@include('admin.layout.meta') 
<title> Project Category List - {{ constants('SITE_TITLE') }}</title>
<!-- Main Wrapper -->
<div class="main-wrapper"> @include('admin.layout.header')
  @include('admin.layout.sidebar') 
  
  <!-- Page Wrapper -->
  <div class="page-wrapper">
    <div class="content container-fluid">
    @if(!empty($one))
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">{{ $control }}</h4>
            </div>
            <div class="card-body">
              <ul class="nav nav-tabs nav-tabs-bottom">
                <li class="nav-item"><a class="nav-link active" href="#bottom-tab1" data-toggle="tab">Project Category</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane show active" id="bottom-tab1">
                  <div class="table">
                    <table id="t1" class="datatable table table-stripped" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Description</th>
                          <th>Status</th>
                          <th>Action</th>
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
       @else
            <h4>Not Found</h4>
            @endif
    </div>
  </div>
  <!-- /Page Wrapper --> 
  
</div>
<!-- /Main Wrapper --> 
@include('admin.layout.js') 
<script type="text/javascript">
	var project_id = "{{ @$one->id }}";
	var t1; 
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
    data: {"project_id": project_id },
    url: "{{ route('get-projects-category-list') }}" ,
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


$('body').on('click', '.editit', function () {
	var id = $(this).data('id');
	showAddNewProjectCategoryModal(id);
});


</script>
<!----Add here global Js ----start----->
@include('admin.layout.snippets.add_new_project_category') 
</body></html>