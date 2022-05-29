@extends('admin.layouts.master')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-gift icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>App Links
               
               
            </div>
        </div>
       
    </div>
</div>  

<div class="main-card mb-3 card">
    <div class="card-body">
        <form class="form-horizontal" action="{{ route('app_links.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('IOS') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <input type="text" class="form-control" name="ios" placeholder="{{ __('IOS') }}" value="{{$ios}}">
                   
                    
                    @if ($errors->has('ios'))
                        <p class="text-danger"> {{ $errors->first('ios') }} </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Android') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <input type="text" class="form-control" name="android" placeholder="{{ __('Android') }}" value="{{$android}}">
                   
                    
                    @if ($errors->has('android'))
                        <p class="text-danger"> {{ $errors->first('android') }} </p>
                    @endif
                </div>
            </div>
            
            <div class="form-group row">
                <div class="offset-sm-3 col-sm-9">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </div>
        
        </form>
    </div>
</div>

@endsection
