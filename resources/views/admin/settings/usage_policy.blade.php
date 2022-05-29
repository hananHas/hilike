@extends('admin.layouts.master')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-text-align-left icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Usage Policy
               
            </div>
        </div>
       
    </div>
</div> 

<div class="main-card mb-3 card">
    <div class="card-body">
        <form class="form-horizontal" action="{{ route('usage_policy.update') }}" method="POST">
            @csrf
            @method('put')
            
            
            <div class="form-group row">
                <label class="col-sm-2 control-label">{{ __('English Text') }}<span class="text-danger">*</span></label>

                <div class="col-sm-10">
                    <textarea id="editor" name="value">
                        {{$usage_policy->value}}
                    </textarea>
                    @if ($errors->has('value'))
                        <p class="text-danger"> {{ $errors->first('value') }} </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 control-label">{{ __('Arabic Text') }}<span class="text-danger">*</span></label>

                <div class="col-sm-10">
                    <textarea id="editor2" name="ar_value">
                        {{$usage_policy->ar_value}}
                        </textarea>
                        @if ($errors->has('ar_value'))
                        <p class="text-danger"> {{ $errors->first('ar_value') }} </p>
                    @endif
                </div>
            </div>
            
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </div>
        
        </form>
                          
    </div>
</div>

@push('scripts')

<script src="https://cdn.ckeditor.com/ckeditor5/11.2.0/classic/ckeditor.js"></script>
<script>
    var editor = null;
    ClassicEditor.create(document.querySelector("#editor"), {
        toolbar: [
            "bold",
            "italic",
            "link",
            "bulletedList",
            "numberedList",
            "blockQuote",
            "undo",
            "redo"
        ]
    })
    .then(editor => {
        //debugger;
        window.editor = editor;
    })
    .catch(error => {
        console.error(error);
    })

</script>
<script>
    var editor2 = null;
    ClassicEditor.create(document.querySelector("#editor2"), {
        toolbar: [
            "bold",
            "italic",
            "link",
            "bulletedList",
            "numberedList",
            "blockQuote",
            "undo",
            "redo"
        ]
    })
    .then(editor2 => {
        //debugger;
        window.editor = editor2;
    })
    .catch(error => {
        console.error(error);
    })

</script>
@endpush
@endsection
