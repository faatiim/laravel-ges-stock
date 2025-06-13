<!doctype html>
<html lang="en">
    <head>
        <title>Login 04</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <link rel="stylesheet" href="{{asset('auth/css/style.css')}}">

	</head>
	<body>
        <section class="ftco-section">
            <div class="container">
                {{-- <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-5">
                        <h2 class="heading-section">Login #04</h2>
                    </div>
                </div> --}}
                
            @yield('auth-form')


                    {{-- </div>
                </div> --}}
            </div>
        </section>

        <script src="{{asset('auth/js/jquery.min.js')}}"></script>
        <script src="{{asset('auth/js/popper.js')}}"></script>
        <script src="{{asset('auth/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('auth/js/main.js')}}"></script>

    </body>
</html>
















{{-- <!doctype html>
<html lang="en">

	
<!-- Mirrored from www.bootstrapget.com/demos/templatemonster/arise-admin-dashboard/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 03 Nov 2024 10:56:49 GMT -->
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
		<title> @yield('title') </title>


		<!-- *************
			************ Common Css Files *************
		************ -->

		<!-- Animated css -->
		<link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">

		<!-- Bootstrap font icons css -->
		<link rel="stylesheet" href="{{asset('assets/fonts/bootstrap/bootstrap-icons.css')}}">

		<!-- Main css -->
		<link rel="stylesheet" href="{{asset('assets/css/main.min.css')}}">


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
        @yield('auth-form')
	
		<!-- Login box end -->

		<!-- *************
			************ Required JavaScript Files *************
		************* -->
		<!-- Required jQuery first, then Bootstrap Bundle JS -->
		<script src="{{asset('assets/js/jquery.min.js')}}"></script>
		<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{asset('assets/js/modernizr.js')}}"></script>
		<script src="{{asset('assets/js/moment.js')}}"></script>

		<!-- *************
			************ Vendor Js Files *************
		************* -->

		<!-- Main Js Required -->
		<script src="assets/js/main.js"></script>

	</body>


<!-- Mirrored from www.bootstrapget.com/demos/templatemonster/arise-admin-dashboard/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 03 Nov 2024 10:56:50 GMT -->
</html> --}}