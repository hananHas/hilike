@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-text-align-left icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Packages
               
            </div>
        </div>
        
    </div>
</div> 
<div class="main-card mb-3 card">
    <div class="card-body">
        <form class="form-horizontal" action="{{ route('plans.packages.add',$id)}}" method="POST">
            @csrf
            
            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Months') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <input type="number" class="form-control" name="months" placeholder="{{ __('Months') }}" value="{{ old('months') }}">
                    @if ($errors->has('months'))
                        <p class="text-danger"> {{ $errors->first('months') }} </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Price') }}<span class="text-danger">*</span></label>

                <div class="col-sm-6">
                    <input type="number" class="form-control" name="price" placeholder="{{ __('price') }}" value="{{ old('months') }}">
                    @if ($errors->has('price'))
                        <p class="text-danger"> {{ $errors->first('price') }} </p>
                    @endif
                </div>
            </div>
            
            <div class="form-group row">
                <div class="offset-sm-3 col-sm-9">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </div>
        
        </form>
                                
    </div>
    <!-- /.card-body -->
</div>
<div class="main-card mb-3 card">
    <div class="card-body">
        <table id="idtable" class="table table-bordered table-striped data_table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('Months') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @if($packages != null)
                @foreach ($packages as $id=>$package)
                <tr>
                    <td>
                        {{ ++$id }}
                    </td>
                    <td>
                        {{ $package->months }}
                    </td>
                    <td>
                        ${{ $package->price }}
                    </td>
                    
                    <td>
                        
                        <form  id="deleteform" class="d-inline-block" action="{{ route('plans.packages.delete', $package->id ) }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" value="{{ $package->id }}">
                            <button type="submit" class="btn btn-danger btn-sm" id="delete">
                            <i class="fas fa-trash"></i>{{ __('Delete') }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

    </div>
</div>
@endsection
