@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-menu icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Jobs
               
            </div>
        </div>
        <div class="page-title-actions">
            <a href="{{ route('jobs.create') }}"  class="btn-shadow mr-3 btn btn-info">
                <i class="fa fa-plus"></i> Add Job
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
                    <th>{{ __('English Name') }}</th>
                    <th>{{ __('Arabic Name') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($jobs as $id=>$job)
                <tr>
                    <td>
                        {{ ++$id }}
                    </td>
                    <td>
                        {{ $job->name }}
                    </td>
                    <td>
                        @if(isset($job->translate))
                        {{ $job->translate->name }}
                        @endif
                    </td>
                    
                    
                    <td>
                        <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i> {{ __('Edit') }}</a>

                        <form  id="deleteform" class="d-inline-block" action="{{ route('jobs.destroy', $job->id ) }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" value="{{ $job->id }}">
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
