<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Styles -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>

<div class="main-wrapper">

    <!-- Header -->
    @include('partials.header')

    <!-- Sidebar -->
    {{-- <div class="sidebar" style="overflow-y: auto; height: 100vh;"> --}}
        <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        @include('partials.sidebar')
    </div>

    <!-- Page Content -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            <!-- Breadcrumb -->
            @yield('breadcrumb')

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

</div>

<!-- Scripts -->
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>

@stack('scripts')

<script>
    $(document).ready(function() {
        // Enable slimscroll on sidebar
        $('.sidebar').slimScroll({
            height: '100%',
            color: '#888',
            size: '5px'
        });
    });
</script>



@if (session()->get('error'))
<script>
    iziToast.error({
        title: 'Erreur',
        position: "topRight",
        message:'{{ session()->get('error') }}'
    })
</script>
@endif

@if (session()->get('success'))
<script>
    iziToast.success({
        title: 'Succés',
        position: "topRight",
        message:'{{ session()->get('success') }}'
    })
</script>
@endif



</body>
</html>

