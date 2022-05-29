@extends('admin.layouts.master')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-smartphone icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Onboarding
               
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
                    <th>{{ __('English Title') }}</th>
                    <th>{{ __('Arabic Title') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($onboarding as $id=>$screen)
                @php
                    
                $screen_en = json_decode($screen->value);
                $screen_ar = json_decode($screen->ar_value);   
                    
                @endphp
                <tr>
                    <td>
                        {{ ++$id }}
                    </td>
                    <td>
                        {{ $screen_en ? $screen_en->title : '' }}
                    </td>
                    <td>
                        {{ $screen_ar ? $screen_ar->title : '' }}
                    </td>
                    
                    
                    <td>
                        <a href="{{ route('onboarding.edit', $screen->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i> {{ __('Edit') }}</a>

                        
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
