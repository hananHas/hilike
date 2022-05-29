@extends('admin.layouts.master')

@section('content')
<style>
.clickable a{
    text-decoration: none;
    color: #495057;
}
</style>
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-science icon-gradient bg-plum-plate">
                </i>
            </div>
            <div>Users
                
            </div>
        </div>
    </div>
</div>

<div class="main-card mb-3 card">
    <div class="no-gutters row">
        <div class="col-md-4">
            <div class="pt-0 pb-0 card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer clickable">
                                <a href="{{url('users')}}" class="widget-content-wrapper ">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Total Users</div>
                                        <div class="widget-subheading">Total number of users in the app</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-success">{{$total_users}}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer clickable">
                                <a href="{{url('users?plan=1')}}" class="widget-content-wrapper ">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Free Users</div>
                                        <div class="widget-subheading">Number of Free subscription users </div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-danger">{{$free}}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="pt-0 pb-0 card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer clickable">
                                <a href="{{url('users?plan=3')}}" class="widget-content-wrapper ">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">VIP Users</div>
                                        <div class="widget-subheading">Number of VIP subscription users</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-primary">{{$vip}}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer clickable">
                                <a href="{{url('users?type=new')}}" class="widget-content-wrapper ">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">New Users</div>
                                        <div class="widget-subheading">Number of users who joined last month</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-warning">{{$new}}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="pt-0 pb-0 card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer clickable">
                                <a href="{{url('users?plan=2')}}" class="widget-content-wrapper ">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Gold users</div>
                                        <div class="widget-subheading">Number of Gold subscription users</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-warning">{{$gold}}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer clickable">
                                <a href="{{url('users?type=online')}}" class="widget-content-wrapper ">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Online Users</div>
                                        <div class="widget-subheading">Number of online users</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-primary">{{$online}}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="divider mt-0" style="margin-bottom: 30px;"></div>

<div class="col-md-12">
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">USers Subscriptions</h5>
            <div id="chart-users-column"></div>
        </div>
    </div>
</div>
<div class="divider mt-0" style="margin-bottom: 30px;"></div>

<div class="row">
    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Ages</h5>
                <canvas  style="min-height: 200px; height: 225px; max-height: 225px; max-width: 100%;" id="chart-area-users"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Genders</h5>
                <canvas  style="min-height: 200px; height: 225px; max-height: 225px; max-width: 100%;" id="doughnut-chart-users"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="divider mt-0" style="margin-bottom: 30px;"></div>

<div class="mbg-3 h-auto pl-0 pr-0 bg-transparent no-border card-header">
    <div class="card-header-title fsize-2 text-capitalize font-weight-normal">Users Countries</div>
    {{-- <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
        <button class="btn btn-link btn-sm">View Details</button>
    </div> --}}
</div>


<div class="row">
    @php
        

    @endphp
    @foreach($countries as $i => $country)
    @php
        // $color = array_rand($colors);
    @endphp
    <div class="col-md-6 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-primary card clickable" id="country{{$i}}">
            <a class="widget-chat-wrapper-outer" href="{{url('users?country='.$country->residence_country_name)}}">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">{{$country->residence_country_name}}</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                {{-- <span class="opacity-10 text-success pr-2">
                                    <i class="fa fa-angle-up"></i>
                                </span> --}}
                                {{$country->total}}
                                {{-- <small class="opacity-5 pl-1">%</small> --}}
                            </div>
                            <div class="widget-title ml-auto font-size-lg font-weight-normal text-muted">
                                <div class="circle-progress d-inline-block country{{$country->total}}">
                                    <small></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @endforeach
   
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.30.0/apexcharts.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-circle-progress/1.2.2/circle-progress.min.js"></script>






<script>  
var options3 = {
    chart: {
        height: 350,
        type: 'bar',
    },
    plotOptions: {
        bar: {
            horizontal: false,
            endingShape: 'rounded',
            columnWidth: '55%',
        },
    },
    colors: ['#00e396', '#feb019', '#008ffb'],
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    series: [{
        name: 'VIP',
        data: JSON.parse('{!! json_encode($vip_sum) !!}')
    }, {
        name: 'Gold',
        data: JSON.parse('{!! json_encode($gold_sum) !!}')
    }, {
        name: 'Free',
        data: JSON.parse('{!! json_encode($free_sum) !!}')
    }],
    xaxis: {
        categories: JSON.parse('{!! json_encode($months_arr) !!}'),
    },
   
    fill: {
        opacity: 1,
        
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return  val ;
            }
        }
    }
};

var chart3 = new ApexCharts(
    document.querySelector("#chart-users-column"),
    options3
);



    setTimeout(function () {
        if (document.getElementById('chart-users-column')) {
            chart3.render();
        }
    }, 1000);



</script>

<script>

var configPie = {
  type: "pie",
  data: {
    datasets: [
      {
        data: [
          {{$under_20}},
          {{$from_20_30}},
          {{$from_30_40}},
          {{$from_40_50}},
          {{$above_50}},
        ],
        backgroundColor: [
          window.chartColors.red,
          window.chartColors.orange,
          window.chartColors.yellow,
          window.chartColors.green,
          window.chartColors.blue,
        ],
        label: "Dataset 1",
      },
    ],
    labels: ["-20 Years", "20-30 Years", "31-40 Years", "41-50 Years", "+50 Years"],
  },
  options: {
    responsive: true,
  },
};


var configDoughnut = {
  type: "doughnut",
  data: {
    datasets: [
      {
        data: [
          {{$males}},
          {{$females}},
        ],
        backgroundColor: [
          window.chartColors.orange,
          window.chartColors.green,
        ],
        label: "Dataset 1",
      },
    ],
    labels: ["female" ,"male"],
  },
  options: {
    responsive: true,
    legend: {
      position: "top",
    },
    title: {
      display: false,
      text: "Chart.js Doughnut Chart",
    },
    animation: {
      animateScale: true,
      animateRotate: true,
    },
  },
};

if (document.getElementById("chart-area-users")) {
    var ctx2 = document.getElementById("chart-area-users");
    window.myPie = new Chart(ctx2, configPie);
  }

  // Doughnut
  
  if (document.getElementById("doughnut-chart-users")) {
    var ctx3 = document.getElementById("doughnut-chart-users");
    window.myDoughnut = new Chart(ctx3, configDoughnut);
  }
</script>
<script>
const colors = ["#d92550", "#3ac47d", "#fd7e14",'#007bff',"#3ac47d", "#007bff","#d92550", "#fd7e14"];

</script>
@foreach($countries as $i => $country)
<script>
    console.log({{$country->total*100/$total_users}});
$(".country{{$country->total}}")
    .circleProgress({
      value: {{$country->total*100/$total_users}}/100,
      size: 46,
      lineCap: "round",
      fill: { color: colors[{{$i}}] },
    })
    .on("circle-animation-progress", function (event, progress, stepValue) {
      $(this)
        .find("small")
        .html("<span>" + stepValue.toFixed(2).substr(2) + "<span>");
    });
    if(colors[{{$i}}] == "#d92550" ){
        $('#country{{$i}}').addClass('border-danger');
    }else if(colors[{{$i}}] == "#3ac47d"){
        $('#country{{$i}}').addClass('border-success');
    }else if(colors[{{$i}}] == "#fd7e14"){
        $('#country{{$i}}').addClass('border-warning');
    }else if(colors[{{$i}}] == "#007bff"){
        $('#country{{$i}}').addClass('border-primary');
    }
    
</script>
@endforeach
@endpush

@endsection