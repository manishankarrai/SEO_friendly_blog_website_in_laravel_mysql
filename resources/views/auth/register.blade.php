@extends('layouts.master-layouts')

@section('content')
<main id="main">
    <!-- banner of the page -->
    <section class="banner banner3 bg-full overlay" style="background-image: url({{ url('public/images/img30.jpg') }});">
        <div class="holder">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h1>Register</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- twocolumns of the page -->
    <div class="twocolumns pad-top-lg pad-bottom-lg">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <!-- Register holder of the page -->
                    <div class="register-holder">
                        <div class="txt-holder">
                            <h3 class="heading2">Register Now</h3>
                            <p>Fill the form to confirm your registration</p>
                            <form action="#" class="register-form">
                                <fieldset>
                                    <input type="text" class="form-control" placeholder="Your Name *">
                                    <input type="email" class="form-control" placeholder="Email Address *">
                                    <input type="password" class="form-control" placeholder="Password *">
                                    <input type="password" class="form-control" placeholder="Password Confirmation *">
                                    <div class="row">
                                    @foreach ($packages as $value)
                                    <div class="col-xs-12">
                                        <input name="package" required type="radio" >&nbsp;{{ $value->package_name.' ('.$value->package_ads.' Ads) - USD '.$value->package_price }}
                                    </div>
                                    @endforeach
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="vehicle" value="Car"> Accept <a href="#" class="clr">Terms and Conditions</a>
                                    </div>
                                    <button type="submit" class="btn-primary text-center text-uppercase">Register Now</button>
                                </fieldset>
                            </form>

                        </div>
                        <div class="img-holder">
                            <img src="{{ url('public/images/img62.jpg')}}" alt="image description" class="img-responsive">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
