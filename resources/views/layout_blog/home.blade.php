<!DOCTYPE html>
<html lang="en">

<head>
    <title>Blogtest</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('front/css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/animate.css') }}">

    <link rel="stylesheet" href="{{ asset('front/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ asset('front/css/aos.css') }}">

    <link rel="stylesheet" href="{{ asset('front/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('front/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    @yield('style')
</head>

<body>

    <nav class="navbar px-md-0 navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="/">Blog<i>test</i>.</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{ (request()->routeIs('homepage')) ? 'active' : '' }}"><a href="{{ route('homepage') }}" class="nav-link">Home</a></li>
                    @if (Auth::user())
                        <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a></li>
                    @else
                        <li class="nav-item {{ (request()->routeIs('login')) ? 'active' : '' }}"><a href="/login#login-card" class="nav-link">Login</a></li>
                        <li class="nav-item {{ (request()->routeIs('register')) ? 'active' : '' }}"><a href="/register#register-card" class="nav-link">Register</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <!-- END nav -->

    @yield('post')

    <footer class="ftco-footer ftco-bg-dark ftco-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="logo"><a href="#">Blog<span>test</span>.</a></h2>
                        <p> Register yourself, Posts that are around you.
                            Register yourself, Posts that are around you.
                            Register yourself, Posts that are around you.</p>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                            <li class="ftco-animate"><a href="https://twitter.com/dibaliqaja" target="_blank"><span class="icon-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="https://www.facebook.com/dibaliqaja" target="_blank"><span class="icon-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="https://www.instagram.com/dibaliqaja" target="_blank"><span class="icon-instagram"></span></a></li>
                            <li class="ftco-animate"><a href="https://www.github.com/dibaliqaja/blog-test" target="_blank"><span class="icon-github"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Latest Posts</h2>
                        @forelse ($take_posts as $take_post)
                            <div class="block-21 mb-4 d-flex">
                                <a class="img mr-4 rounded" style="background-image: url({{ $take_post->thumbnail == null ? asset('front/images/thumbnail_1.jpg') : asset('storage/thumbnails/'.$take_post->thumbnail) }});"></a>
                                <div class="text">
                                    <h3 class="heading"><a href="{{ route('blog.detail', $take_post->slug) }}">{{ $take_post->title }}</a>
                                    </h3>
                                    <div class="meta">
                                        <div><a href="{{ route('blog.detail', $take_post->slug) }}"></span> {{ $take_post->created_at->diffForHumans() }}</a></div>
                                        <div><a href="#"></span> {{ $take_post->users->name }}</a></div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No data found.</p>
                        @endforelse
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Have a Questions?</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><span class="icon icon-map-marker"></span><span class="text">Jalan Raya Rengel No.
                                        155, Rengel, Tuban, Jawa Timur</span></li>
                                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+62 896 8735
                                            3934</span></a></li>
                                <li><a href="#"><span class="icon icon-envelope"></span><span
                                            class="text">dibaliqaja@gmail.com</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">

                    <p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | This template is made with <i class="icon-heart color-danger"
                            aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- END footer -->

    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen">
        <svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
        </svg>
    </div>

<script src="{{ asset('front/js/jquery.min.js') }}"></script>
<script src="{{ asset('front/js/jquery-migrate-3.0.1.min.js') }}"></script>
<script src="{{ asset('front/js/popper.min.js') }}"></script>
<script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('front/js/jquery.easing.1.3.js') }}"></script>
<script src="{{ asset('front/js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('front/js/jquery.stellar.min.js') }}"></script>
<script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('front/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('front/js/aos.js') }}"></script>
<script src="{{ asset('front/js/jquery.animateNumber.min.js') }}"></script>
<script src="{{ asset('front/js/scrollax.min.js') }}"></script>
<script src="{{ asset('front/js/main.js') }}"></script>

</body>
</html>
