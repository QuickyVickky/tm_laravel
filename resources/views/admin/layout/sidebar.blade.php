<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
      <ul>
        <li class="menu-title"><span>Task Management</span></li>
        <li class='{{ (request()->is(env("ADMINBASE_NAME")."/dashboard")) ? "active" : "" }}'> <a href="{{ route('dashboard') }}" ><i data-feather="home"></i> <span>Dashboard</span></a> </li>
        
        @if(Session::get('adminrole')!=constants('adminrole.A.key'))
         <li class="submenu {{ ('your-project-list'==Route::currentRouteName() || 'daily-tasks'==Route::currentRouteName() ) ? 'active' : '' }}"> <a href="#"><i data-feather="grid"></i> <span>Assigned Projects</span> <span class="menu-arrow"></span></a>
          <ul>
           <li><a href="{{ route('your-project-list') }}" class="submenu {{ ( 'your-project-list'==Route::currentRouteName()) ? 'active' : '' }}">Your Projects</a></li>
            <li><a href="{{ route('daily-tasks') }}"  class="{{ ( 'daily-tasks'==Route::currentRouteName()) ? 'active' : '' }}">DailyTasks</a></li>
          </ul>
        </li>
        @endif

	@if(Session::get('adminrole')==constants('adminrole.A.key'))
        <li class="submenu {{ ( 'project-list'==Route::currentRouteName() || 'project-category-list'==Route::currentRouteName() || 'daily-tasks-all'==Route::currentRouteName() || 'view-project'==Route::currentRouteName() ) ? 'active' : '' }}"> <a href="#"><i data-feather="grid"></i> <span>All Projects</span> <span class="menu-arrow"></span></a>
          <ul>
            <li><a href="{{ route('project-list') }}" class="submenu {{ ( 'project-list'==Route::currentRouteName() || 'view-project'==Route::currentRouteName()) ? 'active' : '' }}">List</a></li>
            <li><a href="{{ route('project-category-list') }}"  class="{{ ( 'project-category-list'==Route::currentRouteName() ) ? 'active' : '' }}">Category</a></li>
            <li><a href="{{ route('daily-tasks-all') }}"  class="{{ ( 'daily-tasks-all'==Route::currentRouteName() ) ? 'active' : '' }}">All DailyTasks</a></li>
          </ul>
        </li>
        <!--li  class="{{ ( 'company-configuration'==Route::currentRouteName() ) ? 'active' : '' }}"> <a href="{{ route('company-configuration') }}"  ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg> <span>Company</span></a> </li-->
        
        <li  class="{{ ( 'admin-list'==Route::currentRouteName() || 'add-new-admin'==Route::currentRouteName() || 'view-admin'==Route::currentRouteName()  ) ? 'active' : '' }}"> <a href="{{ route('admin-list') }}"  ><i data-feather="users"></i> <span>Employee</span></a> </li>
        
        @endif
        
        
        
      </ul>
    </div>
  </div>
</div>
<!-- /Sidebar --> 