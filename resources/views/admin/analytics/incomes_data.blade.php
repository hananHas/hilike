@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-credit icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Incomes
               
            </div>
        </div>
    </div>
</div> 
<div class="main-card mb-3 card">
    <div class="card-body">
        <table id="idtable" class="table table-bordered table-striped data_table">
            <thead>
                <tr>
                    
                    <th>{{ __('User') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Payment method') }}</th>
                    <th>{{ __('Created at') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incomes as $income)
                    <tr>
                        <td>{{$income->user->name}}</td>
                        <td>{{ isset($income->subscriptable_type) ? 'Plan' : 'Coin'}}</td>
                        <td>{{$income->price}}</td>
                        <td>{{$income->payment_method}}</td>
                        <td>{{$income->created_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
</div>
@push('scripts')

@endpush
@endsection