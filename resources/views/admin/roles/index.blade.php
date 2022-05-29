@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-text-align-left icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Roles
               
            </div>
        </div>
        <div class="page-title-actions">
            <a href="{{ route('roles.create') }}"  class="btn-shadow mr-3 btn btn-info">
                <i class="fa fa-plus"></i> Add Role
            </a>
            
        </div>    
    </div>
</div>  

<div class="main-card mb-3 card">
    <div class="card-body">

        <table id="idtable" class="table table-bordered table-striped data_table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($roles as $id=>$role)
                <tr>
                    <td>
                        {{ ++$id }}
                    </td>
                    
                    <td>
                        {{ $role->name }}
                    </td>
                    
                    <td>
                        @if($role->name !== 'super-admin')
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i> {{ __('Edit') }}</a>

                        <form  id="deleteform" class="d-inline-block" action="{{ route('roles.destroy', $role->id ) }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" value="{{ $role->id }}">
                            <button type="submit" class="btn btn-danger btn-sm" id="delete">
                            <i class="fas fa-trash"></i> {{ __('Delete') }}
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
@push('scripts')

@endpush
@endsection
