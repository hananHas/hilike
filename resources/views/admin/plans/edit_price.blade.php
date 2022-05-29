@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-text-align-left icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Edit Plan
               
               
            </div>
        </div>
       
    </div>
</div>  
<div class="main-card mb-3 card">
    <div class="card-body">
        <form class="form-horizontal" action="{{ route('plans.update',$plan->id) }}" method="POST">
            @csrf
            @method('put')
            
            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Price') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <input type="number" class="form-control" name="price" placeholder="{{ __('price') }}" value="{{ $plan->price }}">
                    @if ($errors->has('price'))
                        <p class="text-danger"> {{ $errors->first('price') }} </p>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-3 control-label">{{ __('English - Description') }} <span class="text-danger">*</span></label>
                <div class="col-sm-6">
                    <textarea class="form-control" name="description" placeholder="{{ __('English Description') }}"  rows="2">{{$plan->description}}</textarea>
                    <span>Please add ' , ' between sentences </span>
                    @if ($errors->has('description'))
                        <p class="text-danger"> {{ $errors->first('description') }} </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-sm-3 control-label">{{ __('Arabic - Description') }} <span class="text-danger">*</span></label>
                <div class="col-sm-6">
                    <textarea class="form-control" name="ar_description" placeholder="{{ __('Arabic Description') }}"  rows="2">{{$plan->ar_description}}</textarea>
                    <span>Please add ' , ' between sentences </span>
                    @if ($errors->has('ar_description'))
                        <p class="text-danger"> {{ $errors->first('ar_description') }} </p>
                    @endif
                </div>
            </div>
            @if($plan->id == 2)
            <div class="form-group row">
                <label for="description" class="col-sm-3 control-label">{{ __('Free trial') }} <span class="text-danger">*</span></label>
                <div class="col-sm-6">
                    <div class="position-relative form-check">
                        <label class="form-check-label">
                            <input type="checkbox" value="1" name="free_trial" class="form-check-input" @if(isset($free_trial) && $free_trial==1) checked @endif> Enable free trial
                        </label>
                    </div>
                </div>
            </div>

            @endif

            <div class="form-group row">
                <div class="offset-sm-3 col-sm-9">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </div>
        
        </form>
                          
    </div>
</div>

@endsection
