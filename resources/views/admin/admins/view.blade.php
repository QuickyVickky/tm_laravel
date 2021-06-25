@include('admin.layout.meta') 
<title>{{ @$one->fullname }} Admin/Employee - {{ constants('SITE_TITLE') }}</title>
<!-- Main Wrapper -->
<div class="main-wrapper"> @include('admin.layout.header')
  @include('admin.layout.sidebar')
  <link href="{{ asset('admin_assets/assets/css/flatpickr.min.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/bootstrap-multiselect.min.css') }}">
  
  <!-- Page Wrapper -->
  <div class="page-wrapper">
    <div class="content container-fluid">
    @if(!empty($one))
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Update {{ $control }}
              <button type="button" class="btn btn-info float-right wanttoeditidspan">Want to Edit</button>
              </h5>
            </div>
            @if(!$errors->isEmpty())
            @foreach ($errors->all(':message') as $input_error)
            <div class="alert alert-warning alert-dismissible fade show">{{ $input_error }}
              <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="fa fa-times" aria-hidden="true"></i></span></button>
            </div>
            @endforeach 
            @endif
            @if(Session::get("msg")!='')
            <div class="alert alert-{{ Session::get("cls") }} mb-4" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span> <i class="fa fa-times" aria-hidden="true"></i></span></button>
              {{ Session::get("msg") }} </div>
            @endif
            
           
            <div class="card-body">
              <form method="post" action="{{ route('update-admin-submit') }}" enctype="multipart/form-data"  id="form1">
                @csrf
                <input type="hidden" name="hid" value="{{ $one->id }}" />
                <input type="hidden" name="uuid" value="{{ $one->uuid }}" />
                <input type="hidden" name="created_at" value="{{ $one->created_at }}" />
                <div class="row">
                  <div class="form-group col-md-5">
                    <label>Full Name * </label>
                    <input type="text" name="fullname" id="fullname" value="{{ $one->fullname }}" class="form-control showcls24mec" required="required" placeholder="" maxlength="100" disabled="disabled">
                  </div>
                  <div class="form-group col-md-4">
                    <label>Email *</label>
                    <input type="email" class="form-control showcls24mec" value="{{ $one->email }}" name="email" id="email" required="required" placeholder="" disabled="disabled">
                  </div>
                  <div class="form-group col-md-3">
                    <label>Employee Id</label>
                    <input type="text" value="{{ $one->id }}" class="form-control" disabled="disabled">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-4">
                    <label>Mobile Number</label>
                    <input type="text" name="mobile" id="mobile" value="{{ $one->mobile }}" class="form-control allownumber showcls24mec" maxlength="13" minlength="10" disabled="disabled">
                  </div>
                  <div class="form-group col-md-5">
                    <label>Password 	&nbsp; <span style="cursor:pointer" class="badge badge-primary float-right GenerateRandomPasswordClass">Change Password</span></label>
                    <input type="password" class="form-control" name="password" id="password" value="123456" disabled="disabled">
                  </div>
                  <div class="form-group col-md-3">
                    <label>Type *</label>
                    <select class="form-control showcls24mec" name="role" id="role" required disabled="disabled">
                      <option value="" selected="selected">Select</option>
                    @foreach(constants('adminrole') as $key => $row)
                    @if($one->role==$key)
                      <option value="{{$key}}" selected="selected">{{$row['name']}}</option>
                      @else
                      <option value="{{$key}}">{{$row['name']}}</option>
                      @endif
                    @endforeach
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>Designation *</label>
                    <input type="text" class="form-control showcls24mec" value="{{ $one->designation }}" name="designation" id="designation" placeholder="like Laravel Developer" required="required" disabled="disabled">
                  </div>
                  <div class="form-group col-md-3">
                    <label>Joining Date</label>
                    <input type="text" class="form-control" name="joining_date" id="joining_date" value="{{ $one->joining_date }}">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-12">
                    <label>Description</label>
                    <textarea type="text" rows="3" class="form-control showcls24mec" name="about" id="about" placeholder="Enter Description" disabled="disabled">{{ $one->about }}</textarea>
                  </div>
                </div>
           
               
                <div class="row">
                  <div class="form-group col-md-12">
                  <label>Select Projects to Assign</label>
                  <?php
				  $selectedListProjects = [];
                  foreach($listProject as $lp){
					  foreach($one->project_assigned as $sPA){
						 if($sPA->project_id==$lp->id) {
							 $selectedListProjects[] = $lp->id;
				  }}}
				 ?>
							@foreach($listProject as $lp)
						<div class="checkbox">
                        <label for="project_ids{{ $lp->id }}"><input {{ (in_array($lp->id, $selectedListProjects)) ? 'checked' : '' }} type="checkbox" name="project_ids[]" id="project_ids{{ $lp->id }}" value="{{ $lp->id }}" class="showcls24mec" disabled="disabled"> {{ $lp->project_name }} </label>
                        </div>
                            @endforeach					
			</div></div>
                                            
                                            
                                            
                <div class="row">
                  <div class="form-group col-md-12">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input showcls24mec" type="radio" name="is_active" id="is_active{{constants('is_active.active')}}" disabled="disabled" value="{{constants('is_active.active')}}" {{ (!isset($one->is_active)) ? 'checked' : '' }}  {{ (isset($one->is_active) && ($one->is_active==1)) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active{{constants('is_active.active')}}"> Active </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input showcls24mec" disabled="disabled" type="radio" name="is_active" id="is_active{{constants('is_active.deactive')}}" value="{{constants('is_active.deactive')}}" {{ (isset($one->is_active) && ($one->is_active==0)) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active{{constants('is_active.deactive')}}"> DeActive </label>
                      </div>
                    </div>
                </div>
                <div class="text-right">
                  <button type="submit" class="btn btn-primary btnsubmitidclass">Submit</button>
                </div>
                <hr />
              </form>
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
<script src="{{ asset('admin_assets/assets/js/flatpickr.min.js')}}"></script> 
<script src="{{ asset('admin_assets/assets/js/bootstrap-multiselect.min.js') }}"></script> 
<!--http://davidstutz.github.io/bootstrap-multiselect/---->
<script type="text/javascript">

$('body').on('click', '.GenerateRandomPasswordClass', function () {
	var x = confirm("are you sure ?");
	if(x==true){
     var password = makeid(randomIntFromInterval(6, 12));
	 $('#password').val(password);
	 $('#password').val(password).attr("type","text").removeAttr("disabled");
	 $(".GenerateRandomPasswordClass").remove();
	}
});

var joining_date_flatpickr = flatpickr(document.getElementById('joining_date'), {
    enableTime: false,
    dateFormat: "Y-m-d",
});

$(document).ready(function() {
        $('.transaction_filter_multi_selectid').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
			 maxHeight: 300,
        });
});

$('body').on('click', '.wanttoeditidspan', function () {
	 $('.showcls24mec').removeAttr("disabled");
	 $('.btnsubmitidclass').show();
	 $('.wanttoeditidspan').remove();
});

$(document).ready(function() {
     $('.btnsubmitidclass').hide();   
});



</script> 