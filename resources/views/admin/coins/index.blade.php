@extends('admin.layouts.master')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-cash icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Coins
               
            </div>
        </div>
        <div class="page-title-actions">
            <a href="{{ route('coins.create') }}"  class="btn-shadow mr-3 btn btn-info">
                <i class="fa fa-plus"></i> Add Coin
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
                    <th>{{ __('Coins') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($coins as $id=>$coin)
                <tr>
                    <td>
                        {{ ++$id }}
                    </td>
                    <td>
                        {{ $coin->coins }}
                    </td>
                    <td>
                        ${{ $coin->price }}
                    </td>
                    
                    
                    <td>
                        <a href="{{ route('coins.edit', $coin->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i> {{ __('Edit') }}</a>

                        <form  id="deleteform" class="d-inline-block" action="{{ route('coins.destroy', $coin->id ) }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" value="{{ $coin->id }}">
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
