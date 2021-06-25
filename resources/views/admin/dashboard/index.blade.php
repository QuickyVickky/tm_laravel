@include('admin.layout.meta')
<title>Dashboard - {{ constants('SITE_TITLE') }}</title>
<!-- Main Wrapper -->
<div class="main-wrapper"> @include('admin.layout.header')
  @include('admin.layout.sidebar') 
  
  <!-- Page Wrapper -->
  <div class="page-wrapper">
    <div class="content container-fluid"> 
      
       @if(Session::get('adminrole')==constants('adminrole.A.key'))
      <!--div class="row">
        <div class="col">
          <h3 class="page-title">{{ $control }}</h3>
        </div>
        <div class="btn-group">
          <button type="button" class="btn btn-rounded btn-primary page-header-button dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Add a New</button>
          <div class="dropdown-menu"> 
            <a class="dropdown-item" href="javascript:void(0)" onclick="showAddNewProjectModal()">Project</a>
            <a class="dropdown-item" href="{{ route('add-new-admin') }}">Employee</a> 
            </div>
        </div>
      </div--> 
      @endif
     
      <div class="row"> @if(Session::get('adminrole')==constants('adminrole.A.key'))
        <div class="col-xl-3 col-sm-6 col-12"> <a href="{{ route('daily-tasks-all') }}">
          <div class="card">
            <div class="card-body">
              <div class="dash-widget-header"> <span class="dash-widget-icon bg-1"> <i class="fas fa-tasks"></i> </span>
                <div class="dash-count">
                  <div class="dash-title">Daily Tasks</div>
                  <div class="dash-counts">
                    <p></p>
                  </div>
                </div>
              </div>
              <!--div class="progress progress-sm mt-3">
                <div class="progress-bar bg-5" role="progressbar" style="width: 83%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <p class="text-muted mt-3 mb-0">All Projects</p-->
            </div>
          </div>
          </a> </div>
          <div class="col-xl-3 col-sm-6 col-12"> <a href="{{ route('project-list') }}">
          <div class="card">
            <div class="card-body">
              <div class="dash-widget-header"> <span class="dash-widget-icon bg-1"> <i class="fas fa-tasks"></i> </span>
                <div class="dash-count">
                  <div class="dash-title">Projects</div>
                  <div class="dash-counts">
                    <p>{{ @$countProject }}</p>
                  </div>
                </div>
              </div>
              <!--div class="progress progress-sm mt-3">
                <div class="progress-bar bg-5" role="progressbar" style="width: 83%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <p class="text-muted mt-3 mb-0">All Projects</p-->
            </div>
          </div>
          </a> </div>
        <div class="col-xl-3 col-sm-6 col-12" > <a href="{{ route('admin-list') }}">
          <div class="card">
            <div class="card-body">
              <div class="dash-widget-header"> <span class="dash-widget-icon bg-2"> <i class="fas fa-users"></i> </span>
                <div class="dash-count">
                  <div class="dash-title">Employee</div>
                  <div class="dash-counts">
                    <p>{{ @$countAdmin }}</p>
                  </div>
                </div>
              </div>
              <!--div class="progress progress-sm mt-3">
                <div class="progress-bar bg-6" role="progressbar" style="width: 65%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <p class="text-muted mt-3 mb-0">Total Employee</p-->
            </div>
          </div>
          </a> </div>
          <div class="col-xl-3 col-sm-6 col-12" > <a href="javascript:void(0)" onclick="showAddNewProjectModal()">
          <div class="card">
            <div class="card-body">
              <div class="dash-widget-header"> <span class="dash-widget-icon bg-4"> <i class="fa fa-plus"></i> </span>
                <div class="dash-count">
                  <div class="dash-title">Add Project</div>
                </div>
              </div>
            </div>
          </div>
          </a> </div>
          <div class="col-xl-3 col-sm-6 col-12" > <a href="{{ route('add-new-admin') }}">
          <div class="card">
            <div class="card-body">
              <div class="dash-widget-header"> <span class="dash-widget-icon bg-3"> <i class="fas fa-users"></i> </span>
                <div class="dash-count">
                  <div class="dash-title">Add Employee</div>
                </div>
              </div>
            </div>
          </div>
          </a> </div>
          
        @else
        <div class="col-xl-3 col-sm-6 col-12" > <a href="javascript:void(0)" onclick="showAddNewProjectTaskTodayModal()">
          <div class="card">
            <div class="card-body">
              <div class="dash-widget-header"> <span class="dash-widget-icon bg-2"> <i class="fas fa-plus-square"></i> </span>
                <div class="dash-count">
                  <div class="dash-title">Add Task</div>
                </div>
              </div>
            </div>
          </div>
          </a> </div>
        @endif </div>
      
      <!---charts--starts--->
      @if(Session::get('adminrole')!=constants('adminrole.A.key'))
      <div class="row">
        <div class="col-xl-12 d-flex">
          <div class="card flex-fill">
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Daily Task Timing Chart [{{ date('F-Y') }}]</h5>
              </div>
            </div>
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between flex-wrap flex-md-nowrap"> 
                <!--div class="w-md-100 d-flex align-items-center mb-3">
                  <div> <span>Total Income</span>
                    <p class="h3 text-primary mr-5"></p>
                  </div>
                </div--> 
              </div>
              <div id="DailyTaskTimingChartId"></div>
            </div>
          </div>
        </div>
      </div>
      @endif
      <!---charts--ends---> 
    </div>
  </div>
  <!-- /Page Wrapper --> 
  
</div>
<!-- /Main Wrapper --> 
@include('admin.layout.js')
@if(Session::get('adminrole')==constants('adminrole.A.key'))
@include('admin.layout.snippets.add_new_project') 
@endif
@if(Session::get('adminrole')!=constants('adminrole.A.key'))
<?php
$AllDatesOfCurrentMonth=array();
$AllDatesOfCurrentMonthWithTiming=array();
$ThisMonth = date('m');
$ThisYear = date('Y');

for($d=1; $d<=31; $d++)
{
    $time = mktime(12, 0, 0, $ThisMonth, $d, $ThisYear);          
    if (date('m', $time)==$ThisMonth) {     
        $AllDatesOfCurrentMonth[date('Y-m-d', $time)]=date('d D', $time);
		$AllDatesOfCurrentMonthWithTiming[date('Y-m-d', $time)] = 0;
	}
}

foreach ($chartData['DailyTaskTimingOfThisMonth'] as $key => $value) {
	foreach ($AllDatesOfCurrentMonthWithTiming as $key1 => $value1) {
		if($value->date_number==$key1){
			$AllDatesOfCurrentMonthWithTiming[$key1] = $value->dailytaskMinutes;
		} 
	}
}


?>

<!-- Chart JS --> 
<script src="{{ asset('admin_assets/assets/plugins/apexchart/apexcharts.min.js') }}"></script> 
<script type="text/javascript">
var AllDatesOfCurrentMonthWithTiming =  <?php echo json_encode(array_values($AllDatesOfCurrentMonthWithTiming)); ?>;
var AllDatesOfCurrentMonth =  <?php echo json_encode(array_values($AllDatesOfCurrentMonth)); ?>;

 var DailyTaskTimingChartOptions = {
          series: [{
          name: 'Timing',
          data: AllDatesOfCurrentMonthWithTiming
        }],
          chart: {
          height: 350,
          type: 'bar',
        },
        plotOptions: {
          bar: {
            borderRadius: 10,
            dataLabels: {
              position: 'center', // top, center, bottom
            },
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return val;
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        xaxis: {
          categories: AllDatesOfCurrentMonth,
          position: 'top',
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          crosshairs: {
            fill: {
              type: 'gradient',
              gradient: {
                colorFrom: '#D8E3F0',
                colorTo: '#BED1E6',
                stops: [0, 100],
                opacityFrom: 0.4,
                opacityTo: 0.5,
              }
            }
          },
          tooltip: {
            enabled: true,
          }
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
            formatter: function (val) {
              return parseFloat(val/60).toFixed(3) + "Hrs";
            }
          }
        },
        title: {
          text: 'Daily Task Timing Chart Of This Month (Hours)',
          floating: true,
          offsetY: 330,
          align: 'center',
          style: {
            color: '#444'
          }
        }
        };
        var DailyTaskTimingChartVariable = new ApexCharts(document.querySelector("#DailyTaskTimingChartId"), DailyTaskTimingChartOptions);
        DailyTaskTimingChartVariable.render();
</script> 
@include('admin.layout.snippets.add_new_project_task') 
@endif