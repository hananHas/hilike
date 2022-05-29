<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>HiLike</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/css/custom.css') }}">

</head>

<body class="hold-transition login-page">

<div class="login-box">
    <div class="login-logo">
      <img src="{{ asset('assets/front/img/') }}" alt="">
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body text-center">
        @if (session()->has('alert'))
          <p class="text-danger"> {{ session('alert') }}</p>
        @endif
        
        <p class="login-box-msg">{{ __('Login To Go Your Dashboard') }}</p>
  
        <form action="{{ route('login') }}" method="POST">
          @csrf
          <div class="input-group mb-3">
            <input id="email" type="email" placeholder="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            
            <div class="input-group-append">
              <div class="input-group-text">
                <i class="fas fa-user"></i>
              </div>
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="password" autocomplete="current-password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">{{ __('LOGIN') }}</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

    
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
    <!-- jQuery 3 -->
   

    <script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('assets/admin/js/adminlte.min.js') }}"></script>

    </body>
</html>

