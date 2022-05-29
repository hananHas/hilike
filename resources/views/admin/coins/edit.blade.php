@extends('admin.layouts.master')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-cash icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Edit Coin
               
            </div>
        </div>
    </div>
</div>  

<div class="main-card mb-3 card">
    <div class="card-body">
        <form class="form-horizontal" action="{{ route('coins.update',$coin->id) }}" method="POST">
            @csrf
            @method('put')
            
            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Coins') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <input type="text" class="form-control" name="coins" placeholder="{{ __('Coins') }}" value="{{ $coin->coins }}">
                    @if ($errors->has('coins'))
                        <p class="text-danger"> {{ $errors->first('coins') }} </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Price') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <input type="text" class="form-control" name="price" placeholder="{{ __('Price') }}" value="{{$coin->price}}">
                    @if ($errors->has('price'))
                        <p class="text-danger"> {{ $errors->first('price') }} </p>
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
