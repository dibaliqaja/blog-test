@include('layout_blog.header')

    <div class="hero-wrap js-fullheight"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start"
                data-scrollax-parent="true">
                <div class="col-md-12 ftco-animate">
                    <h2 class="subheading">Hello! Welcome to</h2>
                    <h1 class="mb-4 mb-md-0">Blog Test</h1>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="text">
                                <br>
                                <p> Register yourself, Posts that are around you.
                                    Register yourself, Posts that are around you.
                                    Register yourself, Posts that are around you.
                                    Register yourself, Posts that are around you. </p>
                                <div class="mouse">
                                    <a href="#post" class="mouse-icon">
                                        <div class="mouse-wheel"><span class="ion-ios-arrow-round-down"></span></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row d-flex">
                @forelse ($posts_data as $post_data)
                <div class="col-md-4 d-flex ftco-animate">
                    <div class="blog-entry justify-content-end">
                        <a href="{{ route('blog.detail', $post_data->slug) }}" class="block-20"
                            style="background-image: url({{ asset('storage/images/'.$post_data->image) }});">
                        </a>
                        <div class="text p-4 float-right d-block">
                            <div class="topper d-flex align-items-center">
                                <div class="one py-2 pl-3 pr-1 align-self-stretch">
                                    <span class="day">{{ $post_data->created_at->format('d') }}</span>
                                </div>
                                <div class="two pl-0 pr-3 py-2 align-self-stretch">
                                    <span class="yr">{{ $post_data->created_at->format('Y') }}</span>
                                    <span class="mos">{{ $post_data->created_at->format('F') }}</span>
                                </div>
                            </div>
                            <h3 class="heading mb-3"><a href="{{ route('blog.detail', $post_data->slug) }}">{{ $post_data->title }}</a></h3>
                            <p>{{ $post_data->short_description }}</p>
                            <p><a href="{{ route('blog.detail', $post_data->slug) }}" class="btn-custom"><span class="ion-ios-arrow-round-forward mr-3"></span>Read more</a></p>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="container">
                        <h1>No data found.</h1>
                    </div>
                @endforelse
            </div>
            <div class="row mt-5">
                <div class="col text-center">
                    <div class="block-27">
                        <div class="link-page">
                            {{ $posts_data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@include('layout_blog.footer')
