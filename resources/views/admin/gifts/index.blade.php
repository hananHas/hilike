@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-gift icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Gifts
               
            </div>
        </div>
        <div class="page-title-actions">
            <a href="{{ route('gifts.create') }}"  class="btn-shadow mr-3 btn btn-info">
                <i class="fa fa-plus"></i> Add Gift
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
                    <th>{{ __('Gift') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Category') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($gifts as $id=>$gift)
                <tr>
                    <td>
                        {{ ++$id }}
                    </td>
                    <td>
                        <img width="60" class="img-circle img-fluid" src="{{ asset('images/gifts/'.$gift->image) }}">
                    </td>
                    <td>
                        {{ $gift->price }}
                    </td>
                    
                    <td>
                        {{ $gift->category->name }}
                    </td>
                    <td>
                        <a href="{{ route('gifts.edit', $gift->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i> {{ __('Edit') }}</a>

                        <form  id="deleteform" class="d-inline-block" action="{{ route('gifts.destroy', $gift->id ) }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" value="{{ $gift->id }}">
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
@push('scripts')

@endpush
@endsection
