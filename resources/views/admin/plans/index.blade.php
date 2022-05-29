@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-text-align-left icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Plans
               
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
                    <th>{{ __('Plan name') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($plans as $id=>$plan)
                <tr>
                    <td>
                        {{ ++$id }}
                    </td>
                    <td>
                        {{ $plan->name }}
                    </td>
                    <td>
                        ${{ $plan->price }}
                    </td>
                    
                    <td>
                        <a href="{{route('plans.edit_price',$plan->id)}}" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i> Edit plan</a>
                        <a href="{{ route('plans.packages', $plan->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-file"></i> Packages</a>
                        

                        
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
