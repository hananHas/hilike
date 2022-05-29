@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-credit icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Subscriptions
               
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
                    <th>{{ __('Plan') }}</th>
                    <th>{{ __('Months') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Payment method') }}</th>
                    <th>{{ __('Created at') }}</th>
                    <th>{{ __('ends at') }}</th>
                </tr>
            </thead>
            
        </table>
                   
    </div>
</div>
@push('scripts')

<script>
    $(function() {
               $('#idtable').DataTable({
                order: [[ 5, "desc" ]],
                processing: true,
                serverSide: true,
                ajax: '{{ url('/subscriptions_ajax') }}',
                columns: [
                    // { data: 'id', name: 'id' },
                    { data: 'user.name', name: 'user.name' },
                    { data: 'plan', name: 'plan' },
                    { data: 'months', name: 'months' },
                    { data: 'price', name: 'price' },
                    { data: 'payment_method', name: 'payment_method' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'ends_at', name: 'created_at' },
                ]
            });
         });
</script>

@endpush
@endsection
