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
                        <a class="img mr-4 rounded" style="background-image: url({{ asset('/storage/thumbnails/'.$take_post->thumbnail)}});"></a>
                        <div class="text">
                            <h3 class="heading"><a href="{{ route('blog.detail', $take_post->slug) }}">{{ $take_post->title }}</a>
                            </h3>
                            <div class="meta">
                                <div><a href="{{ route('blog.detail', $take_post->slug) }}"></span> {{ $take_post->created_at->diffForHumans() }}</a></div>
                                {{-- <div><a href="#"></span> {{ $take_post->users->name }}</a></div> --}}
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



<!-- loader -->
<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
            stroke="#F96D00" /></svg></div>

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
