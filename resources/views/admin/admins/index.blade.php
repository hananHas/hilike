@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-users icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Administrators
               
            </div>
        </div>
        <div class="page-title-actions">
            <a href="{{ route('admins.create') }}"  class="btn-shadow mr-3 btn btn-info">
                <i class="fa fa-plus"></i> Add Admin
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
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Roles') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($users as $id=>$user)
                <tr>
                    <td>
                        {{ ++$id }}
                    </td>
                    
                    <td>
                        {{ $user->name }}
                    </td>
                    
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        @if(!empty($user->getRoleNames()))
                          @foreach($user->getRoleNames() as $v)
                             <label class="badge badge-success">{{ $v }}</label>
                          @endforeach
                        @endif
                      </td>
                    <td>
                        <a href="{{ route('admins.edit', $user->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i> {{ __('Edit') }}</a>

                        <form  id="deleteform" class="d-inline-block" action="{{ route('admins.destroy', $user->id ) }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-danger btn-sm" id="delete">
                            <i class="fas fa-trash"></i> {{ __('Delete') }}
                            </button>
                        </form>
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
