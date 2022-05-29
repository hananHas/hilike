@extends('admin.layouts.master')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-gift icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Add Admin
               
               
            </div>
        </div>
       
    </div>
</div>  

<div class="main-card mb-3 card">
    <div class="card-body">
        <form class="form-horizontal" action="{{ route('admins.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Name') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" placeholder="{{ __('Name') }}" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <p class="text-danger"> {{ $errors->first('name') }} </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Email') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <input type="email" class="form-control" name="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <p class="text-danger"> {{ $errors->first('email') }} </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Password') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <input type="password" class="form-control" name="password" placeholder="{{ __('Password') }}" value="">
                    @if ($errors->has('password'))
                        <p class="text-danger"> {{ $errors->first('password') }} </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Confirm password') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirm password') }}" value="">
                    @if ($errors->has('password'))
                        <p class="text-danger"> {{ $errors->first('password') }} </p>
                    @endif
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Roles') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <select name="roles[]" class="form-control" multiple>
                        @foreach($roles as $role)
                            <option value={{$role}}>{{$role}}</option>
                        @endforeach
                    </select>
                    
                    @if ($errors->has('roles'))
                        <p class="text-danger"> {{ $errors->first('roles') }} </p>
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

@push('scripts')
<script>
    $(".up-img").on("change", function () {
        var imgpath = $(this).parent().parent().find('.show-img');
        var file = $(this);
        readURL(this, imgpath);
    });

    function readURL(input, imgpath) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                imgpath.attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
