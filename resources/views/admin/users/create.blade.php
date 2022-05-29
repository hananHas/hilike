@extends('admin.layouts.master')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-users icon-gradient bg-ripe-malin">
                </i>
            </div>
            <div>Add User
               
            </div>
        </div>
          
    </div>
</div>  
<div class="main-card mb-3 card">
    <div class="card-body">
        <form class="form-horizontal" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h5 class="card-title">Main Information</h5>

            <div class="position-relative row form-group">
                <label for="exampleEmail" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" id="Username" value="{{ old('name') }}" required="" name="name" class="form-control" placeholder="Username">
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" id="email" name="email" value="{{ old('email') }}"  required="" class="form-control" placeholder="email">
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Gender</label>
                <div class="col-sm-10">
                    <select name="gender" id="gender" class="form-control">
                        <option {{ old('gender') == 'male' ? 'selected' : '' }} value="male">Male</option>
                        <option {{ old('gender') == 'female' ? 'selected' : '' }} value="female">Female</option>
                    </select>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Nickname</label>
                <div class="col-sm-10">
                    <input type="text" value="{{ old('nickname') }}" id="Nickname" required="" name="nickname" class="form-control" placeholder="Nickname">
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" id="password" autocomplete="new-password" name="password" class="form-control">
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Confirm Password</label>
                <div class="col-sm-10">
                    <input type="password" name="password_confirmation" autocomplete="new-password" id="confirm_password" class="form-control">
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="exampleFile" class="col-sm-2 col-form-label">Profile image</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control-file" name="profile_image" id="image">
                </div>
            </div>

            <h5 class="card-title">Basic Information</h5>

            <div class="position-relative row form-group">
                <label for="exampleText" class="col-sm-2 col-form-label">About user</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="about" id="intro" rows="3">{{ old('about') }}</textarea>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="exampleText" class="col-sm-2 col-form-label">Looking for</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="looking_for" name="looking_for" rows="3">{{ old('looking_for') }}</textarea>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Age</label>
                <div class="col-sm-10">
                    <input type="number" required="" value="{{ old('age') }}" name="age" id="age" class="form-control">
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Religion</label>
                <div class="col-sm-10">
                    <select class="form-control chosen-select" name="religion_id" id="religions">
                        @foreach($religions as $religion)
                            <option {{ old('religion_id') == $religion->id ? 'selected' : '' }} value="{{$religion->id}}">{{$religion->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Origin Country</label>
                <div class="col-sm-10">
                    <select class="form-control chosen-select" id="origin_country" name="origin_country_name">
                        @foreach($countries as $country)
                        <option {{ old('origin_country_name') == $country->country_name ? 'selected' : '' }} value="{{$country->country_name}}">{{$country->country_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Residence Country</label>
                <div class="col-sm-10">
                    <select class="form-control chosen-select" id="residence_country" name="residence_country_name">
                        @foreach($countries as $country)
                        <option {{ old('residence_country_name') == $country->country_name ? 'selected' : '' }} value="{{$country->country_name}}">{{$country->country_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Social Type</label>
                <div class="col-sm-10">
                    <select class="form-control chosen-select" name="social_type_id" id="social_category">
                        @foreach($social_types as $type)
                        <option {{ old('social_type_id') == $type->id ? 'selected' : '' }} value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Marriage Type</label>
                <div class="col-sm-10">
                    <select class="form-control chosen-select" name="marriage_type_id" id="marriage_types">
                        @foreach($marriage_types as $type)
                        <option {{ old('marriage_type_id') == $type->id ? 'selected' : '' }} value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <h5 class="card-title">Personal Information</h5>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Education</label>
                <div class="col-sm-10">
                    <select class="form-control chosen-select" name="education_id" id="education">
                        @foreach($educations as $type)
                        <option {{ old('education_id') == $type->id ? 'selected' : '' }} value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Job</label>
                <div class="col-sm-10">
                    <select class="form-control chosen-select" name="job_id" id="Job">
                        @foreach($jobs as $job)
                        <option {{ old('job_id') == $job->id ? 'selected' : '' }} value="{{$job->id}}">{{$job->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Children</label>
                <div class="col-sm-10">
                    <input type="number" value="{{ old('children')}}" id="Children" required="" name="children" class="form-control" placeholder="Children">
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Smoking</label>
                <div class="col-sm-10">
                    <select class="form-control chosen-select" name="smoking" id="Smoking">
                        <option {{ old('smoking') == 1 ? 'selected' : '' }} value="1">Yes</option>
                        <option {{ old('smoking') == 0 ? 'selected' : '' }} value="0">No</option>
                    </select>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Language</label>
                <div class="col-sm-10">
                    <select class="form-control chosen-select" name="language" id="Language">
                        <option {{ old('language') == 'ar' ? 'selected' : '' }} value="ar">Arabic</option>
                        <option {{ old('language') == 'en' ? 'selected' : '' }} value="en">English</option>
                    </select>
                </div>
            </div>

            <h5 class="card-title">Shape</h5>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Smoking</label>
                <div class="col-sm-10">
                    <input type="number" value="{{ old('height')}}" id="Height" required="" name="height" class="form-control" placeholder="Height">
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Skin Color</label>
                <div class="col-sm-10">
                    <select class="form-control chosen-select chosen-select" name="skin_color_id" id="Skin_Color">
                        @foreach($skin_colors as $color)
                            <option {{ old('skin_color_id') == $color->id ? 'selected' : '' }} value="{{$color->id}}">{{$color->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="examplePassword" class="col-sm-2 col-form-label">Body shape</label>
                <div class="col-sm-10">
                    <select class="form-control chosen-select chosen-select" name="body_id" id="Body">
                        @foreach($bodies as $body)
                            <option {{ old('body_id') == $body->id ? 'selected' : '' }} value="{{$body->id}}">{{$body->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <h5 class="card-title">Other Images</h5>

            <div class="position-relative row form-group">
                <label for="exampleFile" class="col-sm-2 col-form-label">Other Images</label>
                <div class="col-sm-10">
                    <input multiple type="file" class="form-control-file" name="other_images[]" id="image">
                </div>
            </div>

            <div class="position-relative row form-check">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
  
               
@endsection
