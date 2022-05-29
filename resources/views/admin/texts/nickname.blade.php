@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-text-align-left icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Preview Nicknames
               
            </div>
        </div>
        
    </div>
</div> 
<div class="main-card mb-3 card">
    <div class="card-body">
        <table id="idtable" class="table table-bordered table-striped data_table">
            <thead>
                <tr>
                    <th>{{ __('Nickname') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($users as $id=>$user)
                <tr>
                    <td>
                        {{ $user->nickname }}
                    </td>
                   
                    <td>
                        <button data-id="{{$user->id}}" class="btn btn-info btn-sm open_edit_modal"><i class="fas fa-pencil-alt"></i> Edit</button>
                        <button data-id="{{$user->id}}" class="btn btn-success btn-sm acceptB"><i class="fas fa-file"></i> Accept</button>
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
                url: '{{url("/accept/nickname/")}}'+'/'+ id,
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
        $(".open_edit_modal").click(function () {
            var id = $(this).data('id');
            $('#modal_title_edit').html('Edit Nickname');
            $('#label_edit').html('Nickname');
            $('#form_edit_text').attr('action','{{url("/update/nickname/")}}'+'/'+ id);
            $("#modal-edit-text").modal("show");
        });
    </script>
@endpush
@endsection
