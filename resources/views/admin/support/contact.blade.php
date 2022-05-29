@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-menu icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Contact Messages
               
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
                    <th>{{ __('Subject') }}</th>
                    <th>{{ __('Message') }}</th>
                    <th>{{ __('User') }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($messages as $id=>$message)
                <tr>
                    <td>
                        {{ ++$id }}
                    </td>
                    <td>
                        {{ $message->subject }}
                    </td>
                    <td>
                        {{ $message->message }}
                    </td>
                    <td>
                        @if($message->user_id != null)
                        {{ $message->user->name }}
                        @endif
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
