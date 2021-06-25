@include('admin.layout.meta') 
<title>Add New Admin/Employee - {{ constants('SITE_TITLE') }}</title>
<!-- Main Wrapper -->
<div class="main-wrapper"> @include('admin.layout.header')
  @include('admin.layout.sidebar')
  <link href="{{ asset('admin_assets/assets/css/flatpickr.min.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/bootstrap-multiselect.min.css') }}">
  
  <!-- Page Wrapper -->
  <div class="page-wrapper">
    <div class="content container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Add New {{ $control }}
                <button type="submit" class="btn btn-primary float-right" form="form1">Submit</button>
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
              <form method="post" action="{{ route('add-new-admin-submit') }}" enctype="multipart/form-data"  id="form1">
                @csrf
                <input type="hidden" name="hid" value="0" />
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>Full Name *</label>
                    <input type="text" name="fullname" id="fullname" class="form-control" required="required" placeholder="" maxlength="100">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Email *</label>
                    <input type="email" class="form-control" name="email" id="email" required="required" placeholder="">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-4">
                    <label>Mobile Number</label>
                    <input type="text" name="mobile" id="mobile" class="form-control allownumber" maxlength="13" minlength="10">
                  </div>
                  <div class="form-group col-md-5">
                    <label>Password * <span style="cursor:pointer" class="badge badge-primary float-right GenerateRandomPasswordClass">Generate Random Password</span></label>
                    <input type="text" class="form-control" name="password" id="password" required="required" placeholder="required">
                  </div>
                  <div class="form-group col-md-3">
                    <label>Type *</label>
                    <select class="form-control" name="role" id="role" required>
                      <option value="" selected="selected">Select</option>
                    @foreach(constants('adminrole') as $key => $row)
                      <option value="{{$key}}">{{$row['name']}}</option>
                    @endforeach
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>Designation *</label>
                    <input type="text" class="form-control" name="designation" id="designation" placeholder="like Laravel Developer" required="required">
                  </div>
                  <div class="form-group col-md-3">
                    <label>Joining Date</label>
                    <input type="text" class="form-control" name="joining_date" id="joining_date" value="{{ date('Y-m-d') }}">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-12">
                    <label>Description</label>
                    <textarea type="text" rows="3" class="form-control" name="about" id="about" placeholder="Enter Description"></textarea>
                  </div>
                </div>
                
                <div class="row">
                  <div class="form-group col-md-12">
                  <label>Select Projects to Assign</label>
							@foreach($listProject as $lp)
						<div class="checkbox">
                        <label for="project_ids{{ $lp->id }}"><input type="checkbox" name="project_ids[]" id="project_ids{{ $lp->id }}" value="{{ $lp->id }}" class=""> {{ $lp->project_name }} </label>
                        </div>
                            @endforeach					
			</div>
            </div>
            
            
                <div class="row">
                    <div class="form-group col-md-12">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_active" id="is_active{{constants('is_active.active')}}" value="{{constants('is_active.active')}}" checked="">
                        <label class="form-check-label" for="is_active{{constants('is_active.active')}}"> Active </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_active" id="is_active{{constants('is_active.deactive')}}" value="{{constants('is_active.deactive')}}">
                        <label class="form-check-label" for="is_active{{constants('is_active.deactive')}}"> DeActive </label>
                      </div>
                  </div>
                </div>
                <div class="text-right">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <hr />
              </form>
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
<script src="{{ asset('admin_assets/assets/js/flatpickr.min.js')}}"></script> 
<script src="{{ asset('admin_assets/assets/js/bootstrap-multiselect.min.js') }}"></script> 
<script type="text/javascript">

$('body').on('click', '.GenerateRandomPasswordClass', function () {
     var password = makeid(randomIntFromInterval(6, 12));
	 $('#password').val(password);
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




</script> 