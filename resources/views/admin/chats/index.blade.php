@extends('admin.layouts.master')

@section('content')
<style>
    /* width */
    #chat_page::-webkit-scrollbar {
      width: 10px;
    }
    
    /* Track */
    #chat_page::-webkit-scrollbar-track {
      background: #f1f1f1; 
    }
     
    /* Handle */
    #chat_page::-webkit-scrollbar-thumb {
      background: #888; 
    }
    
    /* Handle on hover */
    #chat_page::-webkit-scrollbar-thumb:hover {
      background: #555; 
    }
</style>

<div class="app-inner-layout chat-layout">
    
    <div class="app-inner-layout__wrapper">
        <div class="app-inner-layout__content">
            
            <div class="table-responsive" id="chat_page" style="height: 100vh">
                
                
            </div>
        </div>
        <div class="app-inner-layout__sidebar card">
            <div class="app-inner-layout__sidebar-header">
                <ul class="nav flex-column">
                    <li class="pt-4 pl-3 pr-3 pb-3 nav-item">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>
                            <input placeholder="Search..." type="text" class="form-control" id="search_name"></div>
                    </li>
                    {{-- <li class="nav-item-header nav-item">Friends Online</li> --}}
                </ul>
            </div>
            <ul class="nav flex-column" id="users_list">
                @foreach($chats as $chat)
                @if($chat->thread_id[0] != 'a' && $chat->thread_id[0] != 's')
                <li class="nav-item get_chat" data-thread="{{$chat->thread_id}}">
                    <button type="button" tabindex="0" class="dropdown-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <div class="avatar-icon-wrapper" style="margin-right: -0.9rem;">
                                        <div class="badge badge-bottom badge-success badge-dot badge-dot-lg"></div>
                                        <div class="avatar-icon">
                                            <a href="{{route('users.show',$chat->f_user->id)}}">
                                            @if($chat->f_user->details->profile_image != null)
                                            <img src="{{url('images/users/'.$chat->f_user->details->profile_image)}}" alt="">
                                            @else
                                            <img src="{{url("images")}}/{{$chat->f_user->details->gender == 'female' ? 'avatar_female.jpg' : 'avatar_male.jpg'}}" alt="">
                                            @endif
                                            </a>
                                        </div>
                                    </div>
                                    <div class="avatar-icon-wrapper">
                                        <div class="badge badge-bottom badge-success badge-dot badge-dot-lg"></div>
                                        <div class="avatar-icon">
                                            <a href="{{route('users.show',$chat->s_user->id)}}">
                                            @if($chat->s_user->details->profile_image != null)
                                            <img src="{{url('images/users/'.$chat->s_user->details->profile_image)}}" alt="">
                                            @else
                                            <img src="{{url("images")}}/{{$chat->s_user->details->gender == 'female' ? 'avatar_female.jpg' : 'avatar_male.jpg'}}" alt="">
                                            @endif
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left">
                                    <div class="widget-heading"><a style="color: #212529;" href="{{route('users.show',$chat->f_user->id)}}">{{$chat->f_user->details->nickname}}</a> & <a style="color: #212529;" href="{{route('users.show',$chat->s_user->id)}}">{{$chat->s_user->details->nickname}}</a></div>
                                </div>
                            </div>
                        </div>
                    </button>
                </li>
                @endif
                @endforeach
            </ul>
            
        </div>
    </div>
</div>

@push('scripts')
<script>
$('.app-main__inner').addClass('p-0');
</script>

<script>
    $(document).on('click', ".get_chat", function () {
        $('#chat_page').html('<div class="align-items-center" style="text-align:center; margin-top: 30%;"  id="example_load"><div class="ball-beat"><div></div><div></div><div></div></div></div>');
        var thread_id = $(this).data('thread');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "GET",
            url: '{{url('get_chat')}}' + '/' + thread_id ,
           
            dataType: 'json',
            success: function (data) {
                $('#example_load').hide();
                $('#chat_page').html(data.html);
                $('#chat_page').animate({scrollTop: $('#chat_page').prop("scrollHeight")});
                
            },
            error: function (error) {
                console.log(error);
            }
        });
        // $(".cat-active").removeClass("cat-active");
        // $(this).closest("li").addClass("cat-active");
        // $("html, body").animate({ scrollTop: 0 }, "slow");
        
    });
    

</script>
<script>
    $("#search_name").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#users_list .nav-item").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
</script>
@endpush

@endsection
