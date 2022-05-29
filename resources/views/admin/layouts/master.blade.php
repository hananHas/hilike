<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>HiLike</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{  asset('favicon.ico') }}" type="image/png">
    <meta name="msapplication-tap-highlight" content="no">

    {{-- @includeif('admin.partials.styles') --}}
    <link href="{{ asset('dashboard/main/main.87c0748b313a1dda75f5.css') }}" rel="stylesheet"></head>
    {{-- <link rel="stylesheet" href="{{ asset('assets/admin/plugins/summernote/summernote-bs4.css') }}"> --}}
    <link href="{{ asset('assets/admin/plugins/toastr/toastr.min.css') }}" rel="stylesheet"/>

</head>

<body>

<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">

    @include('admin.partials.top-navbar')

    @include('admin.partials.theme-setting')

    <div class="app-main">
        @include('admin.partials.side-navbar')

        <div class="app-main__outer">
          <div class="app-main__inner">
            @yield('content')
          </div>

          @include('admin.partials.footer')

        </div>
    </div>

</div>



<div class="modal fade" id="modal-ban" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          
            <div class="modal-header">
                <h4 class="modal-title">Ban user</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ban" class="form-horizontal" action="" method="POST">
                @csrf
                @method('put')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Days number</label>
                                <input type="number" min="0" id="ban_days" required="" name="days" class="form-control" placeholder="Days number">
                            </div>
                        </div>
                    
                    </div>
                
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Ban</button>
                </div>
            </form>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-edit-text" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title_edit"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_edit_text" class="form-horizontal" action="" method="POST">
                @csrf
                @method('put')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" id="label_edit"></label>
                                <input type="text" id="new_text" required="" name="new_text" class="form-control">
                            </div>
                        </div>
                    
                    </div>
                
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

{{-- @includeif('admin.partials.scripts') --}}

<script type="text/javascript" src="{{ asset('dashboard/main/assets/scripts/main.87c0748b313a1dda75f5.js') }}"></script>

<script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/admin/plugins/toastr/toastr.min.js') }}"></script>

<script src="{{ asset('assets/admin/plugins/data-table/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/data-table/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/data-table/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/data-table/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/data-table/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/data-table/buttons.bootstrap4.min.js') }}"></script>

<script>
    @if(\Session::has('success'))
        toastr.success("{{\Session::get('success')}}");
    @endif
    @if(\Session::has('error'))
        toastr.error("{{\Session::get('error')}}");
    @endif
</script>
@stack('scripts')

</body>
</html>
