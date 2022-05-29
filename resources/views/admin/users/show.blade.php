@extends('admin.layouts.master')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-users icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>User Information
                
            </div>
        </div>
        
    </div>
</div> 
<div class="row">
    <div class="col-md-4">
        <div class="card-hover-shadow profile-responsive card-border border-success mb-3 card">
            <div class="dropdown-menu-header">
                <div class="dropdown-menu-header-inner bg-success">
                    <div class="menu-header-content">
                        <div class="avatar-icon-wrapper btn-hover-shine mb-2 avatar-icon-xl">
                            <div class="avatar-icon rounded">
                                <img
                                @if($user->details->profile_image != null)
                                src="{{url("images/users/{$user->details->profile_image}")}}"
                                @else
                                src="{{url("images")}}/{{$user->details->gender == 'female' ? 'avatar_female.jpg' : 'avatar_male.jpg'}}"
            
                                @endif
                                alt="profile image">
                            </div>
                        </div>
                        <div>
                            <h5 class="menu-header-title">{{$user->name}}</h5>
                            <h6 class="menu-header-subtitle">{{$user->email}}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-0 card-body">
                <ul class="list-group list-group-flush">
                
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left flex2">
                                    <div class="widget-heading"  style="display: inline-block;">Nickname</div>
                                    <div class="widget-subheading opacity-10"style="display: inline-block;
                                    float: right;"> {{$user->details->nickname}}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left flex2">
                                    <div class="widget-heading" style="display: inline-block;">Plan</div>
                                    <div class="widget-subheading opacity-10" style="display: inline-block;
                                    float: right;"> {{$user->details->plan->name}}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @if($user->details->plan_id != 1)
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left flex2">
                                    <div class="widget-heading" style="display: inline-block;">Ends at</div>
                                    <div class="widget-subheading opacity-10" style="display: inline-block;
                                    float: right;"> {{$last_subscription ? $last_subscription->ends_at : null}}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endif
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left flex2">
                                    <div class="widget-heading" style="display: inline-block;">Gender</div>
                                    <div class="widget-subheading opacity-10" style="display: inline-block;
                                    float: right;"> {{$user->details->gender}}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left flex2">
                                    <div class="widget-heading" style="display: inline-block;">Total incomes</div>
                                    <div class="widget-subheading opacity-10" style="display: inline-block;
                                    float: right;"> {{$total_incomes}}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                
                                <div class="widget-content-left flex2">
                                    <div class="widget-heading">Profile progress</div>
                                    
                                </div>
                                <div class="widget-content-right">
                                    <div class="icon-wrapper m-0">
                                        <div class="progress-circle-wrapper">
                                            <div class="circle-progress d-inline-block circle-progress-success1">
                                                <small></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="text-center d-block card-footer">
                @if($user->blocked == 0)
                <a href="{{url('block_user/'.$user->id)}}" class="mr-2 border-0 btn-transition btn btn-outline-danger">Block</a>
                @else
                <a href="{{url('block_user/'.$user->id)}}" class="mr-2 border-0 btn-transition btn btn-outline-success">Unblock</a>
                @endif
                @if($user->isBanned())
                <a href="{{url('revoke_user/'.$user->id)}}" class="mr-2 border-0 btn-transition btn btn-outline-success"><b>Revoke</b></a>

                @else
                <button id="open_ban_modal" class="mr-2 border-0 btn-transition btn btn-outline-warning"><b>Ban</b></button>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="mb-3 card">
            <div class="card-header">
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link active" href="#about" data-toggle="tab">About user</a></li>
                    <li class="nav-item"><a class="nav-link" href="#basic" data-toggle="tab">Basic information</a></li>
                    <li class="nav-item"><a class="nav-link" href="#personal" data-toggle="tab">Personal information</a></li>
                    <li class="nav-item"><a class="nav-link" href="#shape" data-toggle="tab">Shape</a></li>
                    <li class="nav-item"><a class="nav-link" href="#images" data-toggle="tab">Other images</a></li>
                    {{-- <li class="nav-item"><a data-toggle="tab" href="#tab-eg1-0" class="nav-link active show">Tab 1</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-eg1-1" class="nav-link show">Tab 2</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-eg1-2" class="nav-link show">Tab 3</a></li> --}}
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="about">
                        <strong> About user</strong>
                        <p class="text-muted">
                          {{$user->details->about}}
                        </p>
                        <strong>Looking for</strong>
                        <p class="text-muted">{{$user->details->looking_for}}</p>
                    </div>
                    <div class="tab-pane" id="basic">
                        <strong> Age</strong>
                        <p class="text-muted">
                          {{$user->details->age}}
                        </p>
                        <hr>
                        <strong>Origin country</strong>
                        
                        <p class="text-muted">{{$user->details->origin_country_name}}</p>
                        
                        <hr>
                        <strong> Residence country</strong>
                        
                        <p class="text-muted">{{$user->details->residence_country_name}}</p>
                        
                        <hr>
                        <strong> Religion</strong>
                        @if($user->details->religion)
                        <p class="text-muted">{{$user->details->religion->name}}</p>
                        @endif
                        <hr>
                        <strong> Social type</strong>
                        @if($user->details->social_type)
                        <p class="text-muted">{{$user->details->social_type->name}}</p>
                        @endif
                        <hr>
                        <strong> Marriage type</strong>
                        @if($user->details->marriage_type)
                        <p class="text-muted">{{$user->details->marriage_type->name}}</p>
                        @endif
                        
                    </div>
                    <div class="tab-pane" id="personal">
                        <strong> Education</strong>
                        <p class="text-muted">
                        @if($user->details->education)
                        {{$user->details->education->name}}
                        @endif
                        </p>
                        <hr>
                        <strong>Job</strong>
                        @if($user->details->job)
                        <p class="text-muted">{{$user->details->job->name}}</p>
                        @endif
                        <hr>
                        <strong> Children</strong>
                       
                        <p class="text-muted">{{$user->details->children}}</p>
                        
                        <hr>
                        <strong> Smoking</strong>
                        @if($user->details->smoking == 1)
                        <p class="text-muted">Yes</p>
                        @else
                        <p class="text-muted">No</p>
                        @endif
                        <hr>
                        <strong> Language</strong>
                        @if($user->details->language == 'en')
                        <p class="text-muted">English</p>
                        @else
                        <p class="text-muted">Arabic</p>
                        @endif
                    </div>
                    <div class="tab-pane" id="shape">
                        <strong> Height</strong>
                        <p class="text-muted">{{$user->details->height}}</p>
                        <hr>
                        <strong> Skin color</strong>
                        @if($user->details->skin_color)
                        <p class="text-muted">{{$user->details->skin_color->name}}</p>
                        @endif
                        <hr>
                        <strong> Body shape</strong>
                        @if($user->details->body)
                        <p class="text-muted">{{$user->details->body->name}}</p>
                        @endif
                    </div>

                    <div class="tab-pane" id="images">
                        <div class="row">
                            @foreach($user_images as $image)
                            <div class="col-md-3">
                                <img src="/images/users/{{$image->image}}" width='150'>
                            </div>
        
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-circle-progress/1.2.2/circle-progress.min.js" integrity="sha512-6kvhZ/39gRVLmoM/6JxbbJVTYzL/gnbDVsHACLx/31IREU4l3sI7yeO0d4gw8xU5Mpmm/17LMaDHOCf+TvuC2Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $("#open_ban_modal").click(function () {
        $('#form_ban').attr('action',"{{ route('users.update', $user->id) }}");
        jQuery.noConflict();
        $("#modal-ban").modal("show");
    });
</script>
<script>
$(".circle-progress-success1")
    .circleProgress({
      value: {{$user->details->profile_progress}},
      size: 50,
      lineCap: "round",
      fill: { color: "#3ac47d" },
    })
    .on("circle-animation-progress", function (event, progress, stepValue) {
      $(this)
        .find("small")
        .html("<span>" + stepValue + "%<span>");
    });
</script>
@endpush

@endsection
