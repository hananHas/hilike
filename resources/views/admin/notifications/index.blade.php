@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-menu icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Notifications
               
            </div>
        </div>
        <div class="page-title-actions">
            <a href="{{ route('notifications.create') }}"  class="btn-shadow mr-3 btn btn-info">
                <i class="fa fa-plus"></i> Add Notification
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
                    <th>{{ __('Message') }}</th>
                    <th>{{ __('Users') }}</th>
                    <th>{{ __('Date') }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($nots as $id=>$not)
                <tr>
                    <td>
                        {{ ++$id }}
                    </td>
                    <td>
                        {{ $not->message }}
                    </td>
                    <td>
                        @if($not->users == 0)
                        All Users
                        @elseif($not->users == 1)
                        Normal Users
                        @elseif($not->users == 2)
                        Gold Users
                        @elseif($not->users == 3)
                        VIP Users
                        @endif
                    </td>
                   
                    <td>
                        {{ $not->created_at }}
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
