@extends('admin.layouts.master')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-gift icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Add Gift
               
               
            </div>
        </div>
       
    </div>
</div>  

<div class="main-card mb-3 card">
    <div class="card-body">
        <form class="form-horizontal" action="{{ route('gifts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Category') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <select name="gift_category_id" class="form-control">
                        @foreach($categories as $cat)
                            <option value={{$cat->id}}>{{$cat->name}}</option>
                        @endforeach
                    </select>
                    
                    @if ($errors->has('gift_category_id'))
                        <p class="text-danger"> {{ $errors->first('gift_category_id') }} </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Price') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <input type="number" class="form-control" name="price" placeholder="{{ __('Price') }}" value="{{ old('price') }}">
                    @if ($errors->has('price'))
                        <p class="text-danger"> {{ $errors->first('price') }} </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Image') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    
                    <img style="max-width: 300px" class="mw-400 mb-3 show-img img-demo" src="{{ asset('assets/admin/img/img-demo.jpg') }}" alt="">
                    
                    <div class="custom-file">
                        <label class="custom-file-label" for="image">{{ __('Choose Image') }}</label>
                        <input type="file" class="custom-file-input up-img" name="image" id="image">
                    </div>
                    @if ($errors->has('image'))
                        <p class="text-danger"> {{ $errors->first('image') }} </p>
                    @endif
                    <p class="help-block text-info">{{ __('Upload 250X250 (Pixel) Size image for best quality.
                        Only jpg, jpeg, png image is allowed.') }}
                    </p>
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
