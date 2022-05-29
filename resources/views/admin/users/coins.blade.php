@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-credit icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>User Coins
               
            </div>
        </div>
    </div>
</div> 
<div class="main-card mb-3 card">
    <div class="card-body">
        <table class="mb-0 table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('Coins') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Payment method') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Created at') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coins as $coin)
                    <tr>
                      
                        
                        <td>{{ $coin->coin->coins }}</td>
                           
                        <td>
                            {{ $coin->price }}
                        </td>
                        <td>
                            {{ $coin->payment_method }}
                        </td>
                        <td>
                            {{ $coin->status == 0 ? "error" : "success"  }}
                        </td>
                        <td>
                            {{$coin->created_at}}
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