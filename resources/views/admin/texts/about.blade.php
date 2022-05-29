@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-text-align-left icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Preview About texts
               
            </div>
        </div>
        
    </div>
</div> 
<div class="main-card mb-3 card">
    <div class="card-body">
        <table id="idtable" class="table table-bordered table-striped data_table">
            <thead>
                <tr>
                    <th>{{ __('Text') }}</th>
                    <th style="width: 25%;">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($users as $id=>$user)
                <tr>
                    <td>
                        {{ $user->about }}
                    </td>
                   
                    <td>
                        <button data-id="{{$user->id}}" class="btn btn-info btn-sm open_edit_modal"><i class="fas fa-pencil-alt"></i> Edit</button>
                        <button data-id="{{$user->id}}" class="btn btn-success btn-sm acceptB"><i class="fas fa-file"></i> Accept</button>
                        <button data-id="{{$user->id}}" class="btn btn-danger btn-sm rejectB"><i class="fas fa-trash"></i> Reject</button>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
                   
    </div>
</div>

</section>
@push('scripts')
    <script>
        $(document).on('click','.acceptB',function(e){
            var id = $(this).data('id');
            var element = $(e.currentTarget);
            var tr = element.closest('tr');

            $.ajax({
                url: '{{url("/accept/about/")}}'+'/'+ id,
                type: 'GET',
                
                success: function(data){
                    tr.remove();

                    // tr.remove/();
                    if(data == 'accept'){
                        toastr.success('Accepted successfully');
                    }
                },
                error: function(error){
                    toastr.error('error!');  
                }
            });

        });
    </script>
    <script>
        $(document).on('click','.rejectB',function(e){
            var id = $(this).data('id');
            var element = $(e.currentTarget);
            var tr = element.closest('tr');

            $.ajax({
                url: '{{url("/reject/about/")}}'+'/'+ id,
                type: 'GET',
                
                success: function(data){
                    tr.remove();

                    // tr.remove/();
                    if(data == 'reject'){
                        toastr.success('Rejected successfully');
                    }
                },
                error: function(error){
                    toastr.error('error!');  
                }
            });

        });
    </script>
    <script>
        $(".open_edit_modal").click(function () {
            var id = $(this).data('id');
            $('#modal_title_edit').html('Edit About');
            $('#label_edit').html('About');
            $('#form_edit_text').attr('action','{{url("/update/about/")}}'+'/'+ id);
            $("#modal-edit-text").modal("show");
        });
    </script>
@endpush
@endsection
