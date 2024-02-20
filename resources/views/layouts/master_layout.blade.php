<!DOCTYPE HTML>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('title')

    <meta name="author" content="www.myblog.com" />


    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ url('public/icon.png') }}" type="image/x-icon">

    <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Hind:400,600,700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i" rel="stylesheet">
    <link href="{{ url('public/front/css/style.css') }}" rel="stylesheet" media="screen">

    <style>
        #head_navbar {
            color: white;
            /* Text color */
            background-color: #222222;
            /* Background color - you can replace this with your preferred color code */
        }

        .blog-thumbnail-img>img {
            height: 250px !important;
            width: 100%;
        }

        .post-thumbnail {
            positive: relative;
            display: flex;
            justify-content: center;
            align-item: center;
        }

        .customheading {
            padding: 40px !important;
        }

        @media only screen and (max-width: 600px) {
            .customheading {
                padding: 20px !important;
                font-size: 30px;
            }

            .blog-thumbnail-img>img {
                height: 270px !important;
                width: 100%;
            }

        }

    </style>

</head>

<body>

    <!-- Loader -->


    <!-- Header -->

    <header class="navbar" id="head_navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="brand js-target-scroll">
                <img src="{{ url('public/front/logo/logomyblog.png') }}" alt="" width="auto" height="45">
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
                    <li class="">
                        <a href='{{ route('home') }}'>Home</a>
                    </li>
                    <li class="">
                        <a href="{{ route('topic-page') }}">Social</a>
                    </li>
                    @auth
                    <li class="">
                        <p>Welcome, {{ Auth::user()->name }}!</p>


                        <ul>
                            <li>
                                <a href="{{ route('admin-dashboard') }}"> <b>Dashboard </b></a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"> <b>Logout </b></a>
                            </li>
                        </ul>

                    </li>

                    @else
                    <li class="">
                        <a href='{{ route('login') }}'>Login</a>
                    </li>
                    <li class="">
                        <a href="{{ route('register') }}">Register</a>
                    </li>
                    @endauth


                    {{-- <li class="active">
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
                      
                    </li> --}}
                </ul>
            </nav>

            <!-- Navigation Mobile -->

            <nav class="nav-mobile hidden-md hidden-lg">
                <div class="collapse navbar-collapse" id="nav-collapse">
                    <ul class="nav-mobile-list">
                        @auth
                        <li>
                            <p style="color: white;">Welcome, {{ Auth::user()->name }} !</p>
                        </li>
                          <li>
                            <a href="{{ route('admin-dashboard') }}" style="color: white;">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" style="color: white;">Logout</a>
                        </li>
                        @else
                        <li>
                            <a href='{{ route('login') }}' style="color: white;">Login</a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" style="color: white;">Register</a>
                        </li>
                        @endauth
                        <li>
                            <a href='{{ route('home') }}' style="color: white;">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('topic-page') }}" style="color: white;">Social</a>
                        </li>

                        {{-- <li class="active">
                            <a href=''>Blog</a>
                            <ul>
                                <li class="active">
                                    <a href=''>Blog list</a>
                                   
                                </li>
                                <li><a href=''>Blog details</a></li>
                            </ul>
                        </li> --}}

                        {{-- <li>
                            <a href='contacts.html'>Contacts</a>
                            
                        </li> --}}
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Home -->

    @yield('headbanner');

    <div class="content">

        @if (session('success'))
        <div class="alert alert-success alert-dismissible alert-fixed text-center" style="margin-top: 80px;">
            <i class="las la-thumbs-up"></i>
            {{ session('success') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible alert-fixed text-center" style="margin-top: 80px;">
            <i class="las la-thumbs-down"></i>
            {{ session('error') }}
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible alert-fixed" style="margin-top: 80px;">
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
                    <div class="brand-info col-base col-space col-sm-9 col-md-9">
                        <a href="#top" class="brand js-target-scroll">
                            <img src="{{ url('public/front/logo/logomyblog.png') }}" alt="" width="auto" height="70">

                        </a>
                        <p>This blogging website focuses on providing content that inspires and uplifts readers in their daily lives. It might cover topics like personal development, motivation, and positive lifestyle choices.</p>

                    </div>
                    <div class="col-base col-space col-sm-3 col-md-3">
                        <strong class="footer-title">Links</strong>
                        <ul class="nav-bottom">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <address><strong class="text-white">E-mail:</strong> help@myblog.com </address>
                            </li>

                        </ul>
                    </div>


                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="copyrights">
                        © <script>
                            document.write(new Date().getFullYear())

                        </script> myblog
                    </div>
                    {{-- <ul class="social-list">
                        <li><a href="#" class="fa fa-facebook"></a></li>
                        <li><a href="#" class="fa fa-twitter"></a></li>
                        <li><a href="#" class="fa fa-linkedin"></a></li>
                        <li><a href="#" class="fa fa-instagram"></a></li>
                    </ul> --}}
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

    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#myeditor'), {

                removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed']
            , })
            .catch(error => {
                console.error(error);
            });

    </script>

</body>


</html>
