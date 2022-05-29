@extends('admin.layouts.master')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-pencil icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Edit onboarding
               
            </div>
        </div>
       
    </div>
</div>  

<div class="main-card mb-3 card">
    <div class="card-body">
        <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('onboarding.update',$onboarding->id) }}" method="POST">
            @csrf
            @method('put')
            
            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('English - Title') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <input type="text" class="form-control" name="title" placeholder="{{ __('English Title') }}" value="{{ $screen_en ? $screen_en->title : '' }}">
                    @if ($errors->has('title'))
                        <p class="text-danger"> {{ $errors->first('title') }} </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-sm-3 control-label">{{ __('English - Description') }} <span class="text-danger">*</span></label>
                <div class="col-sm-6">
                    <textarea class="form-control" name="description" placeholder="{{ __('English Description') }}"  rows="2">{{ $screen_en ? $screen_en->description : '' }}</textarea>
                    @if ($errors->has('description'))
                        <p class="text-danger"> {{ $errors->first('description') }} </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Arabic - Title') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <input type="text" class="form-control" name="ar_title" placeholder="{{ __('Arabic Title') }}" value="{{$screen_ar ? $screen_ar->title : ''}}">
                    @if ($errors->has('ar_title'))
                        <p class="text-danger"> {{ $errors->first('ar_title') }} </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="ar_description" class="col-sm-3 control-label">{{ __('Arabic - Description') }} <span class="text-danger">*</span></label>
                <div class="col-sm-6">
                    <textarea class="form-control" name="ar_description" placeholder="{{ __('Arabic Description') }}"  rows="2">{{ $screen_ar ? $screen_ar->description : '' }}</textarea>
                    @if ($errors->has('ar_description'))
                        <p class="text-danger"> {{ $errors->first('ar_description') }} </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Image') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    @if($screen_en)
                    <img style="max-width: 300px" class="mw-400 mb-3 show-img img-demo" src="{{ asset('images/onboarding/'.$screen_en->image) }}" alt="">
                    @else
                    <img style="max-width: 300px" class="mw-400 mb-3 show-img img-demo" src="{{ asset('assets/admin/img/img-demo.jpg') }}" alt="">
                        
                    @endif
                    <div class="custom-file">
                        <label class="custom-file-label" for="image">{{ __('Choose Image') }}</label>
                        <input type="file" class="custom-file-input up-img" name="image" id="image">
                    </div>
                    @if ($errors->has('image'))
                        <p class="text-danger"> {{ $errors->first('image') }} </p>
                    @endif
                    <p class="help-block text-info">{{ __('Upload 270X290 (Pixel) Size image for best quality.
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
