
<div class="chat-wrapper">
    @foreach($documents as $document)
    @php
        $doc = $document->data();
    @endphp
    @if($doc['sender_id'] == $f_user->user_id)
    <div class="chat-box-wrapper">
        <div>
            <div class="avatar-icon-wrapper mr-1">
                <div class="badge badge-bottom btn-shine badge-success badge-dot badge-dot-lg"></div>
                <div class="avatar-icon avatar-icon-lg rounded">
                    @if($f_user->profile_image != null)
                    <img src="{{url('images/users/'.$f_user->profile_image)}}" alt="">
                    @else
                    <img src="{{url("images")}}/{{$f_user->gender == 'female' ? 'avatar_female.jpg' : 'avatar_male.jpg'}}" alt="">
                    @endif
                </div>
            </div>
        </div>
        <div>
            <div class="chat-box">
                @if($doc['is_gift'] == 1)
                    <img width="100" src="{{$doc['text']}}" alt="">
                @else
                    {{$doc['text']}}
                @endif
            </div>
            <small class="opacity-6">
                <i class="fa fa-calendar-alt mr-1"></i>
                {{\Carbon\Carbon::parse($doc['created_at'])->toDateTimeString()}}
            </small>
        </div>
    </div>
    @else
    <div class="float-right col-12">
        <div class="chat-box-wrapper chat-box-wrapper-right" style="float: right">
            <div>
                <div class="chat-box">
                    @if($doc['is_gift'] == 1)
                        <img width="100" src="{{$doc['text']}}" alt="">
                    @else
                        {{$doc['text']}}
                    @endif
                </div>
                <small class="opacity-6">
                    <i class="fa fa-calendar-alt mr-1"></i>
                    {{\Carbon\Carbon::parse($doc['created_at'])->toDateTimeString()}}
                </small>
            </div>
            <div>
                <div class="avatar-icon-wrapper ml-1">
                    <div class="badge badge-bottom btn-shine badge-success badge-dot badge-dot-lg"></div>
                    <div class="avatar-icon avatar-icon-lg rounded">
                        @if($s_user->profile_image != null)
                        <img src="{{url('images/users/'.$s_user->profile_image)}}" alt="">
                        @else
                        <img src="{{url("images")}}/{{$s_user->gender == 'female' ? 'avatar_female.jpg' : 'avatar_male.jpg'}}" alt="">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach

    
    
</div>