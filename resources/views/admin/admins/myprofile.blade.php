@include('admin.layout.meta')
<title>My Profile - {{ constants('SITE_TITLE') }}</title>
<!-- Main Wrapper -->
<div class="main-wrapper"> @include('admin.layout.header')
  @include('admin.layout.sidebar') 
  
  <!-- Page Wrapper -->
  <div class="page-wrapper">
    <div class="content container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h3 class="page-title">Hello, {{ Session::get('adminfullname') }}</h3>
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a>{{ Session::get('admindesignation') }}</a> </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-3 col-md-4"> 
          
          <!-- Settings Menu -->
          <div class="widget settings-menu">
            <ul>
              <li class="nav-item"> <a href="javascript:void(0)" class="nav-link active"> <i class="far fa-user"></i> <span>Profile</span> </a> </li>
              <li class="nav-item"> <a href="javascript:void(0)" onclick="showUpdateChangePasswordModal()" class="nav-link"> <i class="fas fa-unlock-alt"></i> <span>Change Password</span> </a> </li>
            </ul>
          </div>
          <!-- /Settings Menu --> 
          
        </div>
        <div class="col-xl-9 col-md-8">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Profile information</h5>
            </div>
            <div class="card-body"> 
              
              <!-- Form -->
              <form enctype="multipart/form-data"  id="myprofile-form1">
              @csrf
              <input type="hidden" name="hid" value="{{ $one->id }}" />
              <input type="hidden" name="uuid" value="{{ $one->uuid }}" />
                <input type="hidden" name="created_at" value="{{ $one->created_at }}" />
                <!--div class="row form-group">
											<label for="name" class="col-sm-3 col-form-label input-label">Name</label>
											<div class="col-sm-9">
												<div class="d-flex align-items-center">
													<label class="avatar avatar-xxl profile-cover-avatar m-0" for="edit_img">
														<img id="avatarImg" class="avatar-img" src="assets/img/profiles/avatar-02.jpg" alt="Profile Image">
														<input type="file" id="edit_img">
														<span class="avatar-edit">
															<i data-feather="edit-2" class="avatar-uploader-icon shadow-soft"></i>
														</span>
													</label>
												</div>
											</div>
										</div-->
                                        
                <div class="row form-group">
                  <label for="name" class="col-sm-3 col-form-label input-label">FullName</label>
                  <div class="col-sm-9">
                    <input type="text" name="fullname" id="fullname" value="{{ $one->fullname }}" class="form-control showcls24mec" required="required" placeholder="" maxlength="100" disabled="disabled">
                  </div>
                </div>
                <div class="row form-group">
                  <label for="email" class="col-sm-3 col-form-label input-label">Email</label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control showcls24mec" value="{{ $one->email }}" name="email" id="email" required="required" placeholder="" disabled="disabled">
                  </div>
                </div>
                <div class="row form-group">
                  <label for="phone" class="col-sm-3 col-form-label input-label">Mobile</label>
                  <div class="col-sm-9">
                    <input type="text" name="mobile" id="mobile" value="{{ $one->mobile }}" class="form-control allownumber showcls24mec" maxlength="13" minlength="10" disabled="disabled">
                  </div>
                </div>
                <div class="row form-group">
                  <label class="col-sm-3 col-form-label input-label">Employee Id</label>
                  <div class="col-sm-9">
                    <input type="text" value="{{ $one->id }}" class="form-control" disabled="disabled">
                  </div>
                </div>
                <div class="row form-group">
                  <label class="col-sm-3 col-form-label input-label">Designation</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control showcls24mec" value="{{ $one->designation }}" name="designation" id="designation" placeholder="like Laravel Developer" required="required" disabled="disabled">
                  </div>
                </div>
                <div class="row form-group">
                  <label class="col-sm-3 col-form-label input-label">Joining Date</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="joining_date" id="joining_date" value="{{ $one->joining_date }}" disabled="disabled">
                  </div>
                </div>
                
                
                <div class="text-right"> 
                  <!--button type="submit" class="btn btn-primary">Save Changes</button--> 
                </div>
              </form>
              <!-- /Form --> 
              
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



</script> 
@include('admin.layout.snippets.change_password') 