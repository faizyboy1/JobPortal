@extends('layouts.app') @push('head-script')
<link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
<style>
    .mb-20 {
        margin-bottom: 20px
    }
    .badge-color{
        color: aliceblue;
    }
</style>


@endpush 
@section('content')
<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon" style="background-color: #95a5a6;"><i class="icon-badge badge-color"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">@lang('modules.report.jobapplication')</span>
                <span class="info-box-number">{{$jobApplication}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon" style="background-color: #9b59b6;"><i class="icon-badge badge-color"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">@lang('modules.report.job')</span>
                <span class="info-box-number">{{$job}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon" style="background-color: #28a745;"><i class="icon-badge badge-color"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">@lang('modules.report.candidatehired')</span>
                <span class="info-box-number">{{$candidatesHired}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon" style="background-color: #3D8EE8;"><i class="icon-badge badge-color"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">@lang('modules.report.interviewschedule')</span>
                <span class="info-box-number">{{$interviewScheduled}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
           
        </div>
    </div>
    

</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row clearfix">
                    <div class="col-md-12 mb-20" id="">
                    <h3>@lang('modules.report.jobapplicationstatus')</h3>
                    <canvas id="myChart">
                       
                    </div>
                </div>

                
            </div>
        </div>
    </div>
</div>
@endsection
 @push('footer-script')
<script src="//cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
 <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
 <script>
 //for pie chart
  var chart = document.getElementById("myChart").getContext('2d');
  var cData = JSON.parse(`<?php echo $chart_data; ?>`);
  var keys = [];
  var value = [];
  $.each(cData, function(k, v) {
    value.push(v)
    keys.push(k)
});
  var myChart = new Chart(chart, {
  type: 'pie',
  data: {
    labels: keys,
    datasets: [{
      backgroundColor: [
       
        "#95a5a6",
        "#9b59b6",
        "#28a745",
        "#3D8EE8",
      ],
      data:value,
    }]
  }
});
</script>
@endpush
