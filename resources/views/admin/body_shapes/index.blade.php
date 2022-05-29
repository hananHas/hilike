@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-menu icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Body Shapes
               
            </div>
        </div>
        <div class="page-title-actions">
            <a href="{{ route('body_shapes.create') }}"  class="btn-shadow mr-3 btn btn-info">
                <i class="fa fa-plus"></i> Add Body Shape
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

                @foreach ($body_shapes as $id=>$shape)
                <tr>
                    <td>
                        {{ ++$id }}
                    </td>
                    <td>
                        {{ $shape->name }}
                    </td>
                    <td>
                        @if(isset($shape->translate))
                        {{ $shape->translate->name }}
                        @endif
                    </td>
                    
                    
                    <td>
                        <a href="{{ route('body_shapes.edit', $shape->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i> {{ __('Edit') }}</a>

                        <form  id="deleteform" class="d-inline-block" action="{{ route('body_shapes.destroy', $shape->id ) }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" value="{{ $shape->id }}">
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
