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
            <div>Incomes
                
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
                                <a href="{{url('analytics_incomes/data')}}" class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Total Incomes</div>
                                        <div class="widget-subheading">Total incomes in the app</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-success">{{$general_total}}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer clickable">
                                <a href="{{url('analytics_incomes/data?type=plan')}}" class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Plans incomes</div>
                                        <div class="widget-subheading">Incomes from plans subscriptions </div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-danger">{{$total_users}}</div>
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
                                <a href="{{url('analytics_incomes/data?type=myfatoorah')}}" class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Myfatoorah incomes</div>
                                        <div class="widget-subheading">Incomes from Myfatoorah </div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-primary">{{$myfatoorah}}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer clickable">
                                <a href="{{url('analytics_incomes/data?type=coins')}}" class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Coins Incomes</div>
                                        <div class="widget-subheading">Incomes from purchase coins </div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-warning">{{$total_users1}}</div>
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
                                <a href="{{url('analytics_incomes/data?type=stripe')}}" class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Stripe incomes</div>
                                        <div class="widget-subheading">Incomes from Stripe payment </div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-warning">{{$stripe}}</div>
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
            <h5 class="card-title">Total Incomes</h5>
            <div id="chart-apex-area11"></div>
        </div>
    </div>
</div>
<div class="divider mt-0" style="margin-bottom: 30px;"></div>

<div class="mbg-3 h-auto pl-0 pr-0 bg-transparent no-border card-header">
    <div class="card-header-title fsize-2 text-capitalize font-weight-normal">Plans Incomes Countries</div>
    
</div>
<div class="row">
   
    @foreach($countries as $i => $country)
    
    <div class="col-md-6 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-primary card border-success" id="country{{$i}}">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">{{$i}}</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                {{-- <span class="opacity-10 text-success pr-2">
                                    <i class="fa fa-angle-up"></i>
                                </span> --}}
                                {{$country}}
                                {{-- <small class="opacity-5 pl-1">%</small> --}}
                            </div>
                            <div class="widget-title ml-auto font-size-lg font-weight-normal text-muted">
                                <div class="circle-progress d-inline-block country{{$country}}">
                                    <small></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
   
</div>

<div class="divider mt-0" style="margin-bottom: 30px;"></div>

<div class="row">
    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Plans</h5>
                <canvas  style="min-height: 200px; height: 225px; max-height: 225px; max-width: 100%;" id="chart-area-users"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Coins</h5>
                <canvas  style="min-height: 200px; height: 225px; max-height: 225px; max-width: 100%;" id="doughnut-chart-users"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="divider mt-0" style="margin-bottom: 30px;"></div>

<div class="mbg-3 h-auto pl-0 pr-0 bg-transparent no-border card-header">
    <div class="card-header-title fsize-2 text-capitalize font-weight-normal">Coins Incomes Countries</div>
    
</div>
<div class="row">
   
    @foreach($countries1 as $i => $country)
    
    <div class="col-md-6 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-primary card border-danger" id="country1{{$i}}">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">{{$i}}</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                {{-- <span class="opacity-10 text-success pr-2">
                                    <i class="fa fa-angle-up"></i>
                                </span> --}}
                                {{$country}}
                                {{-- <small class="opacity-5 pl-1">%</small> --}}
                            </div>
                            <div class="widget-title ml-auto font-size-lg font-weight-normal text-muted">
                                <div class="circle-progress d-inline-block country1{{$country}}">
                                    <small></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
   
</div>
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.30.0/apexcharts.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-circle-progress/1.2.2/circle-progress.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/google-palette/1.1.0/palette.min.js" integrity="sha512-+rKeqfKuzCrzOolK5cPvYqzEHJTEPWG1MTvH02P+MYgmw7uMyNiewzvzlPj0wOgPd10jdNAtkf8tL1aQt7RsxQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

var series =
{
    "monthDataSeries1": {
        "prices": JSON.parse('{!! json_encode($total_arr) !!}'),
        "dates": JSON.parse('{!! json_encode($month_arr) !!}')
            
    },
};


var options = {
    chart: {
        height: 350,
        type: 'area',
        zoom: {
            enabled: false
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'straight'
    },
    series: [{
        name: "Incomes",
        data: series.monthDataSeries1.prices
    }],
    title: {
        text: 'Total Incomes in last 15 days',
        align: 'left'
    },
    
    labels: series.monthDataSeries1.dates,
    xaxis: {
        
    },
    yaxis: {
        opposite: true
    },
    legend: {
        horizontalAlign: 'left'
    }
};

var chart = new ApexCharts(
    document.querySelector("#chart-apex-area11"),
    options
);

setTimeout(function () {

    if (document.getElementById('chart-apex-area11')) {
        chart.render();
    }
});

</script>
<script>
    const colors = ["#d92550", "#3ac47d", "#fd7e14",'#007bff',"#3ac47d", "#007bff","#d92550", "#fd7e14"];
    
    </script>
    @foreach($countries as $i => $country)
    <script>
        
    $(".country{{$country}}")
        .circleProgress({
          value: {{$country*100/$total_users}}/100,
          size: 46,
          lineCap: "round",
        //   fill: { color: colors[{{$i}}] },
        })
        .on("circle-animation-progress", function (event, progress, stepValue) {
          $(this)
            .find("small")
            .html("<span>" + stepValue.toFixed(2).substr(2) + "<span>");
        });
        
        
    </script>
    @endforeach

    @foreach($countries1 as $i => $country)
    <script>
        
    $(".country{{$country}}")
        .circleProgress({
          value: {{$country*100/$total_users1}}/100,
          size: 46,
          lineCap: "round",
        //   fill: { color: colors[{{$i}}] },
        })
        .on("circle-animation-progress", function (event, progress, stepValue) {
          $(this)
            .find("small")
            .html("<span>" + stepValue.toFixed(2).substr(2) + "<span>");
        });
        
        
    </script>
    @endforeach




    
    <script>
    
    var configPie = {
      type: "pie",
      data: {
        datasets: [
          {
            data: [
              {{$gold}},
              {{$vip}},
            ],
            backgroundColor: [
              window.chartColors.yellow,
              window.chartColors.blue,
            ],
            label: "Dataset 1",
          },
        ],
        labels: ["Gold", "VIP"],
      },
      options: {
        responsive: true,
      },
    };
    var myData = JSON.parse('{!! json_encode($coins_total) !!}')
    var configDoughnut = {
      type: "doughnut",
      data: {
        datasets: [
          {
            data: myData,
            backgroundColor: palette('tol', myData.length).map(function(hex) {
                return '#' + hex;
            }),
            label: "Dataset 1",
          },
        ],
        labels: JSON.parse('{!! json_encode($coins_names) !!}'),
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
@endpush

@endsection