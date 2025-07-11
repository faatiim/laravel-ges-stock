<!doctype html>
<html lang="en">

  
<!-- Mirrored from www.bootstrapget.com/demos/templatemonster/arise-admin-dashboard/reset-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 03 Nov 2024 10:56:50 GMT -->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Best Bootstrap Admin Dashboards">
    <meta name="author" content="Bootstrap Gallery" />
    <link rel="canonical" href="https://www.bootstrap.gallery/">
    <meta property="og:url" content="https://www.bootstrap.gallery/">
    <meta property="og:title" content="Admin Templates - Dashboard Templates | Bootstrap Gallery">
    <meta property="og:description" content="Marketplace for Bootstrap Admin Dashboards">
    <meta property="og:type" content="Website">
    <meta property="og:site_name" content="Bootstrap Gallery">
    <link rel="shortcut icon" href="assets/images/favicon.svg">

    <!-- Title -->
    <title>Stock</title>


    <!-- *************
			************ Common Css Files *************
		************ -->

    <!-- Animated css -->
    <link rel="stylesheet" href="{{ asset ('assets/css/animate.css')}}">

    <!-- Bootstrap font icons css -->
    <link rel="stylesheet" href="{{ asset ('assets/fonts/bootstrap/bootstrap-icons.css')}}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset ('assets/css/main.min.css')}}">


  </head>

  <body class="login-container">

    <!-- Loading wrapper start -->
    <!-- <div id="loading-wrapper">
			<div class="spinner">
                <div class="line1"></div>
				<div class="line2"></div>
				<div class="line3"></div>
				<div class="line4"></div>
				<div class="line5"></div>
				<div class="line6"></div>
            </div>
		</div> -->
    <!-- Loading wrapper end -->

    <!-- Login box start -->
    <form action="{{ route('password.reset.handle') }}" method="POST">
      @csrf
      <div class="login-box">
        <div class="login-form center">
          <a href="index.html" class="login-logo">
            <img src="{{ asset ('assets/images/logo.svg')}}" alt="Vico Admin" />
          </a>
          <div class="login-welcome">
            Reset Password
          </div>
          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul class="mb-0">
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif

          <div class="mb-3">
            <label class="form-label" for="currentPwd">Current password <span class="text-danger">*</span></label>
            <div class="input-group ">
              <input type="password"  name="current_password" id="currentPwd" class="form-control" placeholder="Enter current password">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label" for="newPwd">New password <span class="text-danger">*</span></label>
            <div class="input-group ">
              <input type="password" name="password" id="newPwd" class="form-control" placeholder="Enter new password">
            </div>
            <div class="form-text">
              Your password must be 8-20 characters long.
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label" name="password_confirmation" for="confNewPwd">Confirm new password <span class="text-danger">*</span></label>
            <div class="input-group ">
              <input type="password"  name="password_confirmation"  id="confNewPwd" class="form-control" placeholder="Confirm new password">
            </div>
          </div>
          <div class="login-form-actions">
            <button type="submit" class="btn"> <span class="icon"> <i class="bi bi-arrow-right-circle"></i> </span>
              Reset Password</button>
          </div>
        </div>
      </div>
    </form>
    <!-- Login box end -->

    <!-- *************
			************ Required JavaScript Files *************
		************* -->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->
    <script src="{{ asset ('assets/js/jquery.min.js')}}"></script>
    <script src="{{ asset ('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset ('assets/js/modernizr.js')}}"></script>
    <script src="{{ asset ('assets/js/moment.js')}}"></script>

    <!-- *************
			************ Vendor Js Files *************
		************* -->

    <!-- Main Js Required -->
    <script src="{{ asset ('assets/js/main.js')}}"></script>

  </body>


<!-- Mirrored from www.bootstrapget.com/demos/templatemonster/arise-admin-dashboard/reset-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 03 Nov 2024 10:56:50 GMT -->
</html>