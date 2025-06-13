<div class="page-header">

    <!-- Toggle sidebar start -->
    <div class="toggle-sidebar" id="toggle-sidebar"><i class="bi bi-list"></i></div>
    <!-- Toggle sidebar end -->

        <!-- Logo sm starts -->
        <a href="index.html" class="loogoo">
        {{-- <img src="{{asset('assets/images/logo.svg')}}" class="logo-sm" alt="Bootstrap Gallery"> --}}
            {{-- <img src="{{ asset('assets/images/stockin.jpg') }}" alt="Admin Dashboards"> --}}
        {{-- <div class="logo">Quincaillerie.</div> --}}
        </a>
        <!-- Logo sm ends -->

        <!-- Breadcrumb start -->   
            @include('partials.breadcrumb')

        {{-- <ol class="breadcrumb d-lg-flex d-none">
        <li class="breadcrumb-item">
            <i class="bi bi-house"></i>
            <a href="index.html">Home</a>
        </li>
        <li class="breadcrumb-item breadcrumb-active" aria-current="page">Sales</li>
        </ol> --}}
        <!-- Breadcrumb end -->

        <!-- Header actions ccontainer start -->
        <div class="header-actions-container">

            <!-- Search container start -->
            <div class="search-container d-lg-block d-none">

                <!-- Search input group start -->
                <div class="input-group">
                <input type="text" class="form-control" id="searchAny" placeholder="Recherche">
                <button class="btn" type="button">
                    <i class="bi bi-search"></i>
                </button>
                </div>
                <!-- Search input group end -->

            </div>
            <!-- Search container end -->

            <!-- Leads start -->
            <a class="leads d-none d-xl-flex position-relative" href="{{ route('stock.alerts') }}" id="notificationDropdown">
                <span class="lead-icon position-relative">
                    <i class="bi bi-bell-fill animate__animated animate__swing animate__infinite infinite fs-5"></i>
            
                    @if($notificationsCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $notificationsCount }}
                            <span class="visually-hidden">stock alerts</span>
                        </span>
                    @endif
            
                    <b class=" animate__animated animate__heartBeat animate__infinite"></b>
                </span>
            </a>
            
            <!-- Leads end -->

            <!-- Header actions start -->
            <ul class="header-actions">
                <li class="dropdown d-none d-md-block">
                <a href="#" id="countries" data-toggle="dropdown" aria-haspopup="true">
                    <img src="{{asset('assets/images/flags/1x1/sn.png')}}" class="flag-img" alt="Admin Panels" />
                </a>
                {{-- <div class="dropdown-menu dropdown-menu-end mini" aria-labelledby="countries">
                    <div class="country-container">
                    <a href="index.html">
                        <img src="{{('assets/images/flags/1x1/us.svg')}}" alt="Clean Admin Dashboards" />
                    </a>
                    <a href="index.html">
                        <img src="{{('assets/images/flags/1x1/in.svg')}}" alt="Google Dashboards" />
                    </a>
                    <a href="index.html">
                        <img src="{{('assets/images/flags/1x1/gb.svg')}}" alt="AI Admin Dashboards" />
                    </a>
                    <a href="index.html">
                        <img src="{{('assets/images/flags/1x1/tr.svg')}}" alt="Modern Dashboards" />
                    </a>
                    <a href="index.html">
                        <img src="{{('assets/images/flags/1x1/ca.svg')}}" alt="Best Admin Dashboards" />
                    </a>
                    </div>
                </div> --}}
                </li>
                <li class="dropdown">
                    <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                        @if(Auth::check())
                            <span class="user-name d-none d-md-block">
                                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                            </span>
                            <span class="avatar">
                                <img src="{{ Auth::user()->image_url }}" alt="{{ Auth::user()->name }}" class="img-fluid">
                                <span class="status online"></span>
                            </span>
                        @endif
                    </a>
                    
                    {{-- <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                        @if(Auth::check())
                        <span class="user-name d-none d-md-block">{{\Illuminate\Support\Facades\Auth::user()->first_name }} {{\Illuminate\Support\Facades\Auth::user()->last_name }}</span>
                        <span class="avatar">
                            <img src="{{ Auth::user()->image_url }}" alt="{{ Auth::user()->name }}" class="img-fluid change-img-avatar">
                            <span class="status online"></span>
                        </span>
                        @endif
                    </a> --}}
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userSettings">
                        <div class="header-profile-actions">
                        <a href="{{ route('profile') }}">Profile</a>
                        <a href="{{ route('profile.setting')}}">Settings</a>
                        <form action="{{ route('logout')}}" method="POST">
                            @csrf
                        <button class="btn">Logout</button></form>
                        </div>
                    </div>
                </li>
            </ul>
            <!-- Header actions end -->

        </div>
        <!-- Header actions ccontainer end -->

  </div>