<!DOCTYPE HTML>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('title')
    
    <meta name="author" content="simsimpro" />

    <!-- Favicons -->
    <link rel="shortcut icon" href="img/favicon.ico">
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Hind:400,600,700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i" rel="stylesheet">
    <link href="{{ url('public/front/css/style.css')}}" rel="stylesheet" media="screen">
</head>

<body>

    <!-- Loader -->

    <div class="loader">
        <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>

    <!-- Header -->

    <header class="navbar">
        <div class="container">
            <a href="{{ route('index')}}" class="brand js-target-scroll">
                <img src="{{ url('public/front/logo/black-logo.png') }}" alt="" width="auto" height="45">
            </a>

            <!-- Navbar Collapse -->

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Navigation Desctop -->

            <nav class="nav-desctop hidden-xs hidden-sm">
                <ul class="nav-desctop-list">
                    <li>
                        <a href='home-agency.html'>Home</a>
                       
                    </li>
                   
                    <li class="active">
                        <a href='blog-list1.html'>Blog</a>
                        <ul>
                            <li class="active">
                                <a href='blog-list1.html'>Blog list</a>
                               
                            </li>
                            <li><a href='blog-post.html'>Blog details</a></li>
                        </ul>
                    </li>
                   
                    <li>
                        <a href='contacts.html'>Contacts</a>
                      
                    </li>
                </ul>
            </nav>

            <!-- Navigation Mobile -->

            <nav class="nav-mobile hidden-md hidden-lg">
                <div class="collapse navbar-collapse" id="nav-collapse">
                    <ul class="nav-mobile-list">
                        <li>
                            <a href='{{ route('home')}}'>Home</a>
                        </li>
                       
                        <li class="active">
                            <a href=''>Blog</a>
                            <ul>
                                <li class="active">
                                    <a href=''>Blog list</a>
                                   
                                </li>
                                <li><a href=''>Blog details</a></li>
                            </ul>
                        </li>
                       
                        <li>
                            <a href='contacts.html'>Contacts</a>
                            
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Home -->

    <main class="main main-inner main-blog jarallax" data-jarallax='{"speed": 0.7}'>
        <div class="container">
            <div class="opener">
                <h1>Useful articles.</h1>
                <div class="row">
                    <p class="lead col-md-6 col-md-offset-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Esse non earum consectetur, ratione.</p>
                </div>
            </div>
        </div>
    </main>

    <div class="content">

                      @if (session('success'))
                            <div class="alert alert-success alert-dismissible alert-fixed text-center">
                                <i class="las la-thumbs-up"></i>
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible alert-fixed text-center">
                                <i class="las la-thumbs-down"></i>
                                {{ session('error') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible alert-fixed">
                                <ul>
                                    <li> <i class="las la-thumbs-down"></i> Error found , please check all value again !
                                    </li>
                                    @foreach ($errors->all() as $error)
                                        <li> {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
        <!-- Blog List -->

          @yield('content')

        <!-- Footer -->

        <footer id="footer" class="footer bg-dark">
            <div class="container">
                <div class="row-base row-space row">
                    <div class="brand-info col-base col-space col-sm-6 col-md-3">
                        <a href="#top" class="brand js-target-scroll" style="margin-left: -50px;">
                            <img src="{{ url('public/front/logo/white_logo.png') }}" alt="" width="auto" height="70">
                        </a>
                        <p>We create web products for the help and growth of your business.</p>
                        <address><strong class="text-white">E-mail:</strong> selena@info.ru</address>
                    </div>
                    <div class="col-base col-space col-sm-6 col-md-2">
                        <strong class="footer-title">Links</strong>
                        <ul class="nav-bottom">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Pages</a></li>
                            <li><a href="#">Portfolio</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Contacts</a></li>
                        </ul>
                    </div>
                    <div class="col-base col-space col-sm-6 col-md-4">
                        <div class="widget_recent_entries">
                            <strong class="footer-title">Recent Posts</strong>
                            <ul>
                                <li>
                                    <div class="media-left"><a href="#"><img alt=""
                                                src="{{ url('public/front/img/blog/1-70x70.jpg') }}"></a></div>
                                    <div class="media-right">
                                        <a href="#" class="recet-entries-title">Don’t miss Top Things To Do In
                                            San Francisco</a>
                                        <div class="recent-entries-time">12/09/2016 </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media-left"><a href="#"><img alt=""
                                                src="{{ url('public/front/img/blog/2-70x70.jpg') }}"></a></div>
                                    <div class="media-right">
                                        <a href="#" class="recet-entries-title">Don’t miss Top Things To Do In
                                            San Francisco</a>
                                        <div class="recent-entries-time">12/09/2016 </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-subscribe col-base col-space col-sm-6 col-md-3">
                        <strong class="footer-title">Newsletter</strong>
                        <form class="subscribe-form js-subscribe-form">
                            <div class="input-group">
                                <input id="mc-email" type="email" class="input-round form-control"
                                    placeholder="Email">
                                <span class="input-group-btn">
                                    <button class="btn" type="submit"><span
                                            class="icon-arrow-right"></span></button>
                                </span>
                            </div>
                            <label class="mc-label" for="mc-email" id="mc-notification"></label>
                        </form>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="copyrights">
                        © 2020 RaiWorld. Design by Themeslelo.
                    </div>
                    <ul class="social-list">
                        <li><a href="#" class="fa fa-facebook"></a></li>
                        <li><a href="#" class="fa fa-twitter"></a></li>
                        <li><a href="#" class="fa fa-linkedin"></a></li>
                        <li><a href="#" class="fa fa-instagram"></a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>

    
    <!-- SCRIPTS -->

    <script src="{{ url('public/front/js/jquery.min.js') }}"></script>
    <script src="{{ url('public/front/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('public/front/js/smoothscroll.js') }}"></script>
    <script src="{{ url('public/front/js/jquery.viewport.js') }}"></script>
    <script src="{{ url('public/front/js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('public/front/js/wow.min.js') }}"></script>
    <script src="{{ url('public/front/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ url('public/front/js/jarallax.js') }}"></script>
    <script src="{{ url('public/front/js/jquery.magnific-popup.js') }}"></script>
    <script src="{{ url('public/front/js/owl.carousel.min.js') }}"></script>
    <script src="{{ url('public/front/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ url('public/front/js/imagesloaded.pkgd.js') }}"></script>

    <!-- SLIDER REVOLUTION -->
    <script src="{{ url('public/front/js/rev-slider/jquery.themepunch.tools.min.js') }}"></script>
    <script src="{{ url('public/front/js/rev-slider/jquery.themepunch.revolution.min.js') }}"></script>

    <!-- SLIDER REVOLUTION 5x EXTENSIONS   -->
    <script src="{{ url('public/front/js/rev-slider/revolution.extension.actions.min.js') }}"></script>
    <script src="{{ url('public/front/js/rev-slider/revolution.extension.carousel.min.js') }}"></script>
    <script src="{{ url('public/front/js/rev-slider/revolution.extension.kenburn.min.js') }}"></script>
    <script src="{{ url('public/front/js/rev-slider/revolution.extension.layeranimation.min.js') }}"></script>
    <script src="{{ url('public/front/js/rev-slider/revolution.extension.migration.min.js') }}"></script>
    <script src="{{ url('public/front/js/rev-slider/revolution.extension.navigation.min.js') }}"></script>
    <script src="{{ url('public/front/js/rev-slider/revolution.extension.parallax.min.js') }}"></script>
    <script src="{{ url('public/front/js/rev-slider/revolution.extension.slideanims.min.js') }}"></script>
    <script src="{{ url('public/front/js/rev-slider/revolution.extension.video.min.js') }}"></script>
    <script src="{{ url('public/front/js/rev-slider-init.js') }}"></script>
    <script src="{{ url('public/front/js/interface.js') }}"></script>
    @yield('js_bottom')
</body>


</html>
