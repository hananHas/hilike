@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-credit icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Interactions
               
            </div>
        </div>
    </div>
</div> 
<div class="main-card mb-3 card">
    <div class="card-body">
        <table id="idtable" class="table table-bordered table-striped data_table">
            @if($type == 'chats')
            <thead>
                <tr>
                    
                    <th>{{ __('First User') }}</th>
                    <th>{{ __('Second User') }}</th>
                    <th>{{ __('Created at') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($interactions as $int)
                    <tr>
                        <td>{{$int->f_user->name}}</td>
                        <td>{{$int->s_user->name}}</td>
                        
                        <td>{{$int->created_at}}</td>
                    </tr>
                @endforeach
            </tbody>
            @elseif($type == 'likes' || $type == 'blocks')
            <thead>
                <tr>
                    
                    <th>{{ __('From User') }}</th>
                    <th>{{ __('To User') }}</th>
                    <th>{{ __('Created at') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($interactions as $int)
                    <tr>
                        <td>{{$int->user_from->name}}</td>
                        <td>{{$int->user_to->name}}</td>
                        
                        <td>{{$int->created_at}}</td>
                    </tr>
                @endforeach
            </tbody>
            @elseif($type == 'gifts')
            <thead>
                <tr>
                    
                    <th>{{ __('From User') }}</th>
                    <th>{{ __('To User') }}</th>
                    <th>{{ __('Gift') }}</th>
                    <th>{{ __('Created at') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($interactions as $int)
                    <tr>
                        <td>{{$int->user->name}}</td>
                        <td>{{$int->user_to->name}}</td>
                        <td><img width="50" src="{{asset('images/gifts/'.$int->gift->image)}}"></td>
                        
                        <td>{{$int->created_at}}</td>
                    </tr>
                @endforeach
            </tbody>
            @endif
        </table>
        
    </div>
</div>
@push('scripts')

@endpush
@endsection