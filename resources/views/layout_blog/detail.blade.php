@include('layout_blog.header')

<section class="hero-wrap hero-wrap-2 js-fullheight" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <h1 class="mb-3 bread">{{ $detail->title }}</h1><br>
                <p class="breadcrumbs"><span class="mr-2"><a href="/">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>{{ $detail->title }}</span></p>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 ftco-animate">

                <p class="mb-5">
                    <img src="{{ $detail->image == null ? asset('front/images/image_1.jpg') : asset('storage/thumbnails/'.$detail->image) }}" class="img-fluid" style="width: 770px">
                </p>
                <h2 class="mb-3">{{ $detail->short_description }}</h2>

                <p>{!! $detail->content !!}</p>

                <div class="tag-widget post-tag-container mb-5 mt-5">
                    <div class="tagcloud">
                        <a class="tag-cloud-link">{{ $detail->category->name }}</a>
                    </div>
                </div>

                <div class="about-author d-flex p-4 bg-light">
                    <div class="desc">
                        <h3>Posted By {{ $detail->users->name }}</h3>
                        <h6>{{ $detail->created_at->diffForHumans() }}</h6>
                    </div>
                </div>

            </div> <!-- .col-md-8 -->
            <div class="col-lg-4 sidebar pl-lg-5 ftco-animate">
                <div class="sidebar-box">
                    <form action="{{ route('blog.search') }}" method="GET" class="search-form">
                        <div class="form-group">
                            <span class="icon icon-search"></span>
                            <input type="text" name="search" class="form-control"
                                placeholder="Type a keyword and hit enter">
                        </div>
                    </form>
                </div>
                <div class="sidebar-box ftco-animate">
                    <div class="categories">
                        <h3>Categories</h3>
                        @foreach ($categories as $category)
                        <li><a href="{{ route('blog.categories', $category->slug) }}">{{ $category->name }} <span
                                    class="ion-ios-arrow-forward"></span></a></li>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</section> <!-- .section -->

@include('layout_blog.footer')
