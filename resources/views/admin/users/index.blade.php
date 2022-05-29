@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-users icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Users
               
            </div>
        </div>
        <div class="page-title-actions">
            <a href="{{ route('users.create') }}"  class="btn-shadow mr-3 btn btn-info">
                <i class="fa fa-plus"></i> Add User
            </a>
            
        </div>    
    </div>
</div>  

<div class="main-card mb-3 card">
    <div class="card-body">
        <table id="idtable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    {{-- <th>#</th> --}}
                    {{-- <th>{{ __('id') }}</th> --}}
                    <th data-search>{{ __('Username') }}</th>
                    <th data-search>{{ __('email') }}</th>
                    <th data-search>{{ __('Nickname') }}</th>
                    <th data-search>{{ __('Gender') }}</th>
                    <th data-search>{{ __('Registered at') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@push('scripts')

<script>
    $(function() {
               $('#idtable').DataTable({
               processing: true,
               serverSide: true,
               ajax: '{{ isset($plan) ? url("/users_ajax?plan=".$plan) : ( isset($type) ? url("/users_ajax?type=".$type) : (isset($country) ? url("/users_ajax?country=".$country) : url("/users_ajax") )  ) }}',
               columns: [
                        // { data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'details.nickname', name: 'details.nickname' },
                        { data: 'details.gender', name: 'details.gender' },
                        { data: 'created_at', name: 'created_at' },
                        {data: 'actions', name: 'actions', orderable: false, searchable: false}
                     ]
            });
         });
</script>

@endpush
@endsection
