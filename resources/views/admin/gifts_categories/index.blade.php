@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-gift icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Gifts Categories
               
            </div>
        </div>
        <div class="page-title-actions">
            <a href="{{ route('gifts_categories.create') }}"  class="btn-shadow mr-3 btn btn-info">
                <i class="fa fa-plus"></i> Add Category
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
                    <th>{{ __('English Name') }}</th>
                    <th>{{ __('Arabic Name') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($categories as $id=>$cat)
                <tr>
                    <td>
                        {{ ++$id }}
                    </td>
                    <td>
                        {{ $cat->name }}
                    </td>
                    <td>
                        @if(isset($cat->translate))
                        {{ $cat->translate->name }}
                        @endif
                    </td>
                    
                    
                    <td>
                        <a href="{{ route('gifts_categories.edit', $cat->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i> {{ __('Edit') }}</a>

                        <form  id="deleteform" class="d-inline-block" action="{{ route('gifts_categories.destroy', $cat->id ) }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" value="{{ $cat->id }}">
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
