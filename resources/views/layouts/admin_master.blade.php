@include('layouts.admin_head')

<body>



    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar" style="background: #fff;">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="{{route('index')}}" target="_blank" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ url('public/assets/specialimage/black-logo.png') }}" alt="" height="45">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ url('public/assets/specialimage/black-logo.png') }}" alt="" height="45">
                                </span>
                            </a>

                            <a href="{{route('index')}}" target="_blank" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ url('public/assets/specialimage/black-logo.png') }}" alt="" height="45">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ url('public/assets/images/logo-light.png') }}" alt=""
                                        height="17">
                                </span>
                            </a>
                        </div>

                        <button type="button"
                            class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                            id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>

                        <!-- App Search-->

                    </div>

                    <div class="d-flex align-items-center">

                        <div class="dropdown d-md-none topbar-head-dropdown header-item">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bx bx-search fs-22"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..."
                                                aria-label="Recipient's username">
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>





                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    @role('admin|writer')
                                        {{-- <img class="rounded-circle header-profile-user"
                                            src="{{ url('public/img/azim.jpg') }}" alt="Azeem
                                            Khan"> --}}
                                        <span class="text-start ms-xl-2">
                                            <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                                {{ strtoupper(Auth::user()->name)}} </span>
                                            <span
                                                class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">@if(Auth::user()->hasRole('admin')) Admin @else Writter @endif</span>
                                        </span>
                                    @endrole
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header">Welcome @if(Auth::user()->hasRole('admin')) Admin @else Writter @endif!</h6>

                                <a class="dropdown-item" href="{{ route('logout') }}"><i
                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle" data-key="t-logout">Logout</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu border-end">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="{{route('index')}}" target="_blank" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ url('public/assets/specialimage/black-logo.png') }}" alt="" height="45">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ url('public/assets/specialimage/black-logo.png') }}" alt="" height="45">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="{{route('index')}}" target="_blank" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ url('public/assets/specialimage/black-logo.png') }}" alt="" height="45">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ url('public/assets/images/logo-light.png') }}" alt="" height="17">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                        @if (auth()->check())
                            @role('admin|writer')
                                <li class="nav-item" >
                                    <a class="nav-link menu-link" href="{{ route('admin-dashboard') }}" @if ($active_menu == 'dashboard') style="color: #db8f5e !important;" @endif>
                                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                                    </a>

                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="{{ route('admin-blog')}}"  @if ($active_menu == 'blog') style="color: #db8f5e !important;" @endif>
                                        <i class=" las la-book"></i> <span data-key="t-dashboards">Blog</span>
                                    </a>

                                </li>
                                <li class="nav-item" >
                                    <a class="nav-link menu-link" href="{{ route('admin-viralblog')}}" @if ($active_menu == 'viralblog') style="color: #db8f5e !important;" @endif>
                                        <i class="las la-user"></i> <span data-key="t-dashboards">Social Blog</span>
                                    </a>

                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="#secondDropdown" data-bs-toggle="collapse"
                                        role="button" aria-expanded="false" aria-controls="secondDropdown"  @if ($active_menu == 'master') style="color: #db8f5e !important;" @endif>
                                        <i class="ri-mastercard-line"></i> <span
                                            data-key="t-another-dropdown">Master</span>
                                    </a>
                                    <div class="collapse menu-dropdown" id="secondDropdown" style="background: #2a2a2a">
                                        <ul class="nav nav-sm flex-column">
                                            @if(Auth::user()->hasRole('admin'))
                                             <li class="nav-item">
                                                <a href="{{ route('admin-category')}}"
                                                    class="nav-link" @if ($active_sub_menu == 'category') style="color: #db8f5e !important;"  @endif>Categories</a>
                                             </li>
                                             <li class="nav-item">
                                                <a href="{{ route('admin-subcategory')}}"
                                                    class="nav-link" @if ($active_sub_menu == 'subcategory') style="color: #db8f5e !important;" @endif>SubCategory</a>
                                             </li>
                                            @endif
                                            <li class="nav-item">
                                                <a href="{{ route('admin-topic')}}"
                                                    class="nav-link" @if ($active_sub_menu == 'topic') style="color: #db8f5e !important;" @endif>Topic</a>
                                            </li>
                                          
                                        </ul>
                                    </div>
                                </li>
                            


                            @endrole
                     
                              
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="{{ url('/admin/resetPassword') }}"  @if ($active_menu == 'resetPassword') style="color: #db8f5e !important;" @endif>
                                        <i class="ri-lock-line"></i> <span data-key="t-dashboards">Reset
                                            password</span>
                                    </a>
                                </li>

                                <li class="nav-item" @if ($active_menu == 'logout') style="color: #db8f5e !important;" @endif>
                                    <a class="nav-link menu-link" href="{{ url('/logout') }}">
                                        <i class=" las la-lock-open"></i> <span data-key="t-dashboards">Logout</span>
                                    </a>

                                </li>
                        @else
                            <li class="nav-item @if ($active_menu == 'master') active @endif">
                                <a class="nav-link menu-link" href="{{ url('/login') }}">
                                    <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Login</span>
                                </a>

                            </li>
                        @endif






                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            @yield('content')
        </div>





        <!-- End Page-content -->



        @include('layouts.admin_footer')
