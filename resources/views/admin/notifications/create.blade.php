@extends('admin.layouts.master')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-plus-circle icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Add Notification
               
            </div>
        </div>
       
    </div>
</div>  

<div class="main-card mb-3 card">
    <div class="card-body">
        <form class="form-horizontal" action="{{ route('notifications.store') }}" method="POST">
            @csrf
            
            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Message') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <textarea class="form-control" name="message">{{ old('message') }}</textarea>
                    @if ($errors->has('message'))
                        <p class="text-danger"> {{ $errors->first('message') }} </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('To users') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <select name="users" class="form-control">
                        
                        <option value=0>All users</option>
                        <option value=1>Normal users</option>
                        <option value=2>Gold users</option>
                        <option value=3>VIP users</option>
                        
                    </select>
                    
                    @if ($errors->has('users'))
                        <p class="text-danger"> {{ $errors->first('users') }} </p>
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
