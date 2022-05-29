@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-home icon-gradient bg-plum-plate">
                </i>
            </div>
            <div>
                Dashboard
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-3 widget-chart card-hover-shadow-2x">
            <div class="icon-wrapper border-light rounded">
                <div class="icon-wrapper-bg bg-light"></div>
                <i class="lnr-users icon-gradient bg-night-fade"></i></div>
            <div class="widget-numbers">{{$users}}</div>
            <div class="widget-subheading">Total Users</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3 widget-chart card-hover-shadow-2x">
            <div class="icon-wrapper border-light rounded">
                <div class="icon-wrapper-bg bg-light"></div>
                <i class="lnr-screen icon-gradient bg-ripe-malin"></i></div>
            <div class="widget-numbers">{{$online}}</div>
            <div class="widget-subheading">Online Users</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3 widget-chart card-hover-shadow-2x">
            <div class="icon-wrapper border-light rounded">
                <div class="icon-wrapper-bg bg-light"></div>
                <i class="lnr-envelope icon-gradient bg-arielle-smile"></i></div>
            <div class="widget-numbers">15</div>
            <div class="widget-subheading">Contact Messages</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3 widget-chart card-hover-shadow-2x">
            <div class="icon-wrapper border-light rounded">
                <div class="icon-wrapper-bg bg-light"></div>
                <i class="lnr-file-empty icon-gradient bg-happy-itmeo"></i></div>
            <div class="widget-numbers">{{$reports}}</div>
            <div class="widget-subheading">Reports</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3 widget-chart card-hover-shadow-2x">
            <div class="icon-wrapper border-light rounded-circle">
                <div class="icon-wrapper-bg bg-light"></div>
                <i class="lnr-gift icon-gradient bg-malibu-beach"> </i></div>
            <div class="widget-numbers">{{$gifts}}</div>
            <div class="widget-subheading">Sent Gifts</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3 widget-chart card-hover-shadow-2x">
            <div class="icon-wrapper border-light rounded">
                <div class="icon-wrapper-bg bg-light"></div>
                <i class="lnr-heart icon-gradient bg-love-kiss"> </i></div>
            <div class="widget-numbers">{{$likes}}</div>
            <div class="widget-subheading">Likes</div>
        </div>
    </div>
    <div class="col-md-4">
      <div class="card mb-3 widget-chart card-hover-shadow-2x">
          <div class="icon-wrapper border-light rounded">
              <div class="icon-wrapper-bg bg-light"></div>
              <i class="lnr-hourglass icon-gradient bg-love-kiss"> </i></div>
          <div class="widget-numbers">{{$blocks}}</div>
          <div class="widget-subheading">Blocks</div>
      </div>
    </div>
  
</div>
                     
@endsection
