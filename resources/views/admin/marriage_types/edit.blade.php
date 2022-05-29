@extends('admin.layouts.master')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-pencil icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Edit Marriage Type
               
            </div>
        </div>
       
    </div>
</div>  
<div class="main-card mb-3 card">
    <div class="card-body">
        <form class="form-horizontal" action="{{ route('marriage_types.update',$marriage_type->id) }}" method="POST">
            @csrf
            @method('put')
            
            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('English - Marriage Type Name') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" placeholder="{{ __('English name') }}" value="{{ $marriage_type->name }}">
                    @if ($errors->has('name'))
                        <p class="text-danger"> {{ $errors->first('name') }} </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Arabic - Marriage Type Name') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <input type="text" class="form-control" name="ar_name" placeholder="{{ __('Arabic name') }}" value="@if(isset($marriage_type->translate)){{$marriage_type->translate->name}}@endif">
                    @if ($errors->has('ar_name'))
                        <p class="text-danger"> {{ $errors->first('ar_name') }} </p>
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
