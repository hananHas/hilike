@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-credit icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>User Subscriptions
               
            </div>
        </div>
    </div>
</div> 
<div class="main-card mb-3 card">
    <div class="card-body">
        <table id="idtable" class="table table-bordered table-striped data_table">
            <thead>
                <tr>
                    <th>{{ __('Plan') }}</th>
                    <th>{{ __('Months') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Payment method') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Created at') }}</th>
                    <th>{{ __('ends at') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscriptions as $sub)
                <tr>
                  
                    @if($sub->subscriptable_type == 'App\Models\Plan')
                        <td>{{ $sub->subscriptable->name }}</td>
                        <td>
                            1
                        </td>
                    @else
                        <td>{{ $sub->subscriptable->plan->name }}</td>
                        <td>
                            {{ $sub->subscriptable->months }}
                        </td>
                    @endif
                    <td>
                        {{ $sub->price }}
                    </td>
                    <td>
                        {{ $sub->payment_method }}
                    </td>
                    <td>
                        {{ $sub->status == 0 ? "error" : "success"  }}
                    </td>
                    <td>
                        {{$sub->created_at}}
                    </td>
                    <td>
                        {{$sub->ends_at}}
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