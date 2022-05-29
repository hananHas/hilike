@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-file icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Reports
               
            </div>
        </div>
    </div>
</div> 
<div class="main-card mb-3 card">
    <div class="card-body">
        <table id="idtable" class="table table-bordered table-striped data_table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('Repotrer User') }}</th>
                    <th>{{ __('Repotred User') }}</th>
                    <th>{{ __('Reason') }}</th>
                    <th>{{ __('Report time') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($reports as $id=>$report)
                <tr>
                    <td>
                        {{ ++$id }}
                    </td>
                    <td>
                        {{ $report->from->name }}
                    </td>
                    <td>
                        {{ $report->to->name }}
                    </td>
                    <td>
                        {{ $report->reason }}
                    </td>
                    <td>
                        {{ $report->created_at }}
                    </td>
                    <td>
                        <a href="{{route('users.show',$report->to_user)}}" class="btn btn-info btn-sm"><i class="fas fa-file"></i> View profile</a>
                        <form  id="deleteform" class="d-inline-block" action="{{ route('reports.delete', $report->id ) }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" value="{{ $report->id }}">
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

</section>
@push('scripts')

@endpush
@endsection
