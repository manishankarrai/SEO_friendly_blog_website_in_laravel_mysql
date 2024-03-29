@extends('layouts.app')

@section('content')
<!-- auth-page wrapper -->
<div class="auth-page-content" style="margin-top: 0px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mt-sm-5 mb-4 text-white-50">
                    <div>
                        <a href="{{ route('home') }}" class="d-inline-block auth-logo">
                            <img src="" alt="" height="120">
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card mt-4 card-bg-fill">
                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <img src="{{ url('public/assets/specialimage/logomyblog.png') }}" alt="" height="45" width="auto">

                            <h5 class="text-primary">Welcome Back !</h5>
                            <p class="text-muted">Sign in to continue ...</p>
                        </div>
                        <div class="p-2 mt-4">

                             <form action="{{ route('login') }}" method="post" class="contact-form"
                                 data-aos="fade-up" data-aos-delay="300" role="form">
                                 @csrf

                                <div class="mb-3">
                                    <label for="username" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email"
                                    name="email" placeholder="Enter email">
                                </div>

                                <div class="mb-3">

                                    <label class="form-label" for="password-input">Password</label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                        <input type="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password" name="password">
                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                    </div>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                    <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-primary w-100" type="submit">Sign In</button>
                                </div>


                            </form>
                             <div class="mt-4">
                                   <span> If you have not any account , go for register </span> <a class="btn btn-info" href="{{route('register')}}" > Go</a>
                                </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->



            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
@endsection
