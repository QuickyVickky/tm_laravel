@include('admin.layout.meta') 
<title> Project Category List - {{ constants('SITE_TITLE') }}</title>
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
              <h4 class="card-title">{{ $control }} <a href="javascript:void(0)" class="btn btn-success float-right" id="add_newprojectcategory_btnid" onclick="showAddNewProjectCategoryModal()">Add Project Category</a><a href="javascript:void(0)" class="btn btn-info float-right" onclick="showTagsCategoryModal()">Add Tags</a></h4>
            </div>
            <div class="card-body">
              <ul class="nav nav-tabs nav-tabs-bottom">
                <li class="nav-item"><a class="nav-link active" href="#bottom-tab1" data-toggle="tab">Project Category</a></li>
                <li class="nav-item"><a class="nav-link" href="#bottom-tab2" data-toggle="tab">Tags</a></li>
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
                
                <div class="tab-pane" id="bottom-tab2">
                  <div class="table">
                    <table id="t2" class="datatable table table-stripped" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
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
   /*--------------*/
    t2 = $('#t2').DataTable({
    processing: true,
	language: {
		processing: processingHTML_Datatable,
  	},
	serverSide: true,
 	paging: true,
	searching: true,
	searchDelay: 999,
    lengthMenu: [[10, 50, 100], [10, 50, 100]],
	pageLength: 10, 
	order: [[ 0, "desc" ]],
    ajax:  { 
    data: {"testonly": 1 },
    url: "{{ route('get-tags-category-list') }}" ,
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

$('body').on('click', '.deleteittagscategory', function () {
		var id = $(this).data('id');
  swal({
      title: 'Are You Sure ?',
      text: "Do You Want to Delete This ?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
      padding: '-2em'
    }).then(function(result) {
      if (result.value) {
		  
		 $.ajax({
            url: "{{ route('change-tags-category-deleted') }}",
            data: {
              _token : '{{ csrf_token() }}',
              id: id,
			  status: 2, 
            },
            type: 'post',
            dataType: 'json',
            success: function (e) {
				showAlert(e); 
             	t2.draw(); 
            },  error: function(){ showSweetAlert('Something Went Wrong!','please refresh page and try again', 0);  }
        });

      }
    });
});

</script>
<!----Add here global Js ----start----->
@include('admin.layout.snippets.add_new_project_category') 
@include('admin.layout.snippets.add_tags_category') 
</body></html>