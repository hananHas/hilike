@extends('admin.layouts.master')

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-picture icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Preview Profile Images
               
            </div>
        </div>
    </div>
</div>

<div class="row">
@foreach($images as $user)
    <div class="col-md-12 col-lg-6 col-xl-4 trr">
        <div class="card-shadow-primary card-border mb-3 card">
            <div class="dropdown-menu-header">
                <div class="dropdown-menu-header-inner bg-dark">
                    <div class="menu-header-content">
                        <div class="avatar-icon-wrapper mb-3 avatar-icon-xl">
                            <div class="avatar-icon" style="width: 150px; height: 150px; border-radius: 7%;">
                                <img src="{{url('/images/users/'.$user->profile_image)}}">
                            </div>
                        </div>
                        <div><h5 class="menu-header-title">{{$user->nickname}}</h5></div>
                        
                    </div>
                </div>
            </div>
            <div class="text-center d-block card-footer">
                <button data-type="reject" data-id="{{$user->id}}" class="mr-2 border-0 btn-transition btn btn-outline-danger changeA">Reject</button>
                <button data-type="accept" data-id="{{$user->id}}"  class="border-0 btn-transition btn btn-outline-success changeA">Accept</button>
            </div>
        </div>
    </div>
@endforeach
</div>


        
       
@push('scripts')
<script>
    $(document).on('click','.changeA',function(e){
        var id = $(this).data('id');
        var type = $(this).data('type');
        var element = $(e.currentTarget);
        var tr = element.closest('.trr');
        $.ajax({
            url: '{{url("/accept_or_reject/profile/")}}'+"/"+ type +'/'+ id,
            type: 'GET',
            
            success: function(data){
                tr.remove();

                if(data == 'accept'){
                  toastr.success('Accepted successfully');
                }else{
                  toastr.success('Rejected successfully');
                }
            },
            error: function(error){
                toastr.error('error!');  
            }
        });

    });
</script>
@endpush
@endsection