@extends('admin.layouts.master')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-text-align-left icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Add Role
               
               
            </div>
        </div>
       
    </div>
</div>  

<div class="main-card mb-3 card">
    <div class="card-body">
        <form class="form-horizontal" action="{{ route('roles.update',$role->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Name') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" placeholder="{{ __('Name') }}" value="{{ $role->name }}">
                    @if ($errors->has('name'))
                        <p class="text-danger"> {{ $errors->first('name') }} </p>
                    @endif
                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Permissions') }}<span class="text-danger">*</span></label>
                <br/>
                <div class="col-sm-9">
                    <div class="row">
                        @foreach($permission as $value)
                            <div class="col-sm-6">
                            <label>
                                <input type="checkbox" @if( in_array($value->id, $rolePermissions)) checked @endif class="" name="permission[]" placeholder="{{ __('Email') }}" value="{{ $value->id }}">
                                
                            {{ $value->name }}</label>
                            </div>

                        @endforeach
                    </div>
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
