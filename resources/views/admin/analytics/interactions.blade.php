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
            <div>Interactions
                
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-xl-4">
        <div class="card mb-3 widget-content clickable">
            <a href="{{url('analytics_interactions/data?type=chats')}}" class="widget-content-wrapper">
                <div class="widget-content-left">
                    <div class="widget-heading">Total Chats</div>
                    <div class="widget-subheading">Total chats in the app</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-success"><span>{{$total_chats}}</span></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-6 col-xl-4">
        <div class="card mb-3 widget-content clickable">
            <a href="{{url('analytics_interactions/data?type=likes')}}" class="widget-content-wrapper">
                <div class="widget-content-left">
                    <div class="widget-heading">Likes</div>
                    <div class="widget-subheading">Total likes in the app</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-primary"><span>{{$total_likes}}</span></div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-6 col-xl-4">
        <div class="card mb-3 widget-content clickable">
            <a href="{{url('analytics_interactions/data?type=gifts')}}"  class="widget-content-wrapper">
                <div class="widget-content-left">
                    <div class="widget-heading">Gifts</div>
                    <div class="widget-subheading">Total sent gifts in the app</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-warning"><span>{{$total_gifts}}</span></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-6 col-xl-4">
        <div class="card mb-3 widget-content clickable">
            <a href="{{url('analytics_interactions/data?type=blocks')}}" class="widget-content-wrapper">
                <div class="widget-content-left">
                    <div class="widget-heading">Blocks</div>
                    <div class="widget-subheading">Total Blocks in the app</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-danger"><span>{{$total_Blocks}}</span></div>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="divider mt-0" style="margin-bottom: 30px;"></div>

<div class="row">
    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Inteactions</h5>
                <canvas id="canvas1"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Chats</h5>
                <div id="canvas2"></div>
            </div>
        </div>
    </div>
    
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.30.0/apexcharts.min.js"></script>

<script>
 var barChartData = {
  labels: JSON.parse('{!! json_encode($month_arr) !!}'),
  datasets: [
    {
      label: "Blocks",
      backgroundColor: window.chartColors.red,
      data: JSON.parse('{!! json_encode($blocks) !!}'),
    },
    {
      label: "Likes",
      backgroundColor: window.chartColors.blue,
      data: JSON.parse('{!! json_encode($likes) !!}'),
    },
    {
      label: "Gifts",
      backgroundColor: window.chartColors.green,
      data: JSON.parse('{!! json_encode($gifts) !!}'),
    },
  ],
};


window.onload = function () {
    //Bar

    if (document.getElementById("canvas1")) {
        var ctx = document.getElementById("canvas1").getContext("2d");
        window.myBar = new Chart(ctx, {
        type: "bar",
        data: barChartData,
        options: {
            responsive: true,
            legend: {
            position: "top",
            },
            title: {
            display: false,
            text: "Chart.js Bar Chart",
            },
        },
        });
    }
}
</script>
<script>
var options3 = {
    chart: {
        height: 215,
        type: 'bar',
    },
    plotOptions: {
        bar: {
            horizontal: false,
            endingShape: 'rounded',
            columnWidth: '55%',
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    series: [{
        name: 'Chats',
        data: JSON.parse('{!! json_encode($chats) !!}')
    }],
    xaxis: {
        categories: JSON.parse('{!! json_encode($month_arr) !!}'),
    },
    yaxis: {
        title: {
            
        }
    },
    fill: {
        opacity: 1

    },
    tooltip: {
        y: {
            
        }
    }
};
var chart3 = new ApexCharts(
    document.querySelector("#canvas2"),
    options3
);

setTimeout(function () {
        if (document.getElementById('canvas2')) {
            chart3.render();
        }
    }, 1000);
</script>
@endpush

@endsection