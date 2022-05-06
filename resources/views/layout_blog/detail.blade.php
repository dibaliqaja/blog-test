@extends('layout_blog.home')
@section('post')

<section class="hero-wrap hero-wrap-2 js-fullheight" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <h1 class="mb-3 bread">{{ $detail->title }}</h1><br>
                <p class="breadcrumbs"><span class="mr-2"><a href="/">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>{{ $detail->title }}</span></p>
                <div class="article-header--rating">
                    <span class="article-header--rating-star" style="--rating: {{ $response_total }}"></span>
                    <span class="article-header--rating-rate">{{ round($response_total, 2) }}</span>
                    <span class="article-header--rating-qty">({{ $rating_count }} Reviews)</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 ftco-animate">

                <p class="mb-5">
                    <img src="{{ $detail->image == null ? asset('front/images/image_1.jpg') : asset('storage/images/'.$detail->image) }}" class="img-fluid" style="width: 770px">
                </p>
                <h2 class="mb-3">{{ $detail->short_description }}</h2>
                <p>
                <h6>
                    <a href="{{ route('blog.categories', $detail->category->slug) }}">
                        {{ $detail->category->name }}
                    </a>
                </h6>

                <p>{!! $detail->content !!}</p>

                <div class="tag-widget post-tag-container mb-5 mt-5">
                    <div class="tagcloud">
                        @foreach ($detail->tags as $tag)
                            <a class="tag-cloud-link">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="about-author d-flex p-4 bg-light">
                    <div class="desc">
                        <h3>Posted By {{ $detail->users->name }}</h3>
                        <h6>{{ $detail->created_at->diffForHumans() }}</h6>
                    </div>
                </div>

                <div class="pt-5 mt-5 mb-5">
                    <h3 class="mb-5">Review Post</h3>
                    <ul class="comment-list">
                        @forelse($detail->ratings as $review)
                        <li class="comment">
                            <div class="vcard bio">
                                <img src="https://www.w3schools.com/howto/img_avatar.png" alt="Image placeholder">
                            </div>
                            <div class="comment-body">
                                <h3>{{ $review->users->name }}</h3>
                                <h6>{{ $review->users->email }}</h6>
                                <div class="meta mb-3">{{ $review->created_at->diffForHumans() }}</div>
                                @for($i = 1; $i <= $review->star_rating; $i++)
                                    <span><i class="fa fa-star text-warning"></i></span>
                                @endfor
                                <p>{{ $review->comments }}</p>
                            </div>
                        </li>
                        @empty
                        <li class="comment">
                            <h6>No reviews yet</h6>
                        </li>
                        @endforelse
                    </ul>

                    <div class="comment-form-wrap pt-5">
                        <h3 class="mb-5">Leave a review</h3>
                        <form method="POST" action="{{ route('rating.store') }}" class="p-5 bg-light">
                            @if(Session::has('alert'))
                               <div class="alert alert-success alert-dismissible p-2">
                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                  <strong>Success!</strong> {!! session('alert')!!}.
                               </div>
                            @endif
                            @csrf
                            <input type="hidden" name="posts_id" value="{{$detail->id}}">
                            <input type="hidden" name="users_id" value="{{ auth()->check() ? auth()->user()->id : '' }}">
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <div class="rate @error('star_rating') is-invalid @enderror">
                                    <input type="radio" id="star5" class="rate" name="star_rating" value="5"/>
                                    <label for="star5" title="text">5 stars</label>
                                    <input type="radio" checked id="star4" class="rate" name="star_rating" value="4"/>
                                    <label for="star4" title="text">4 stars</label>
                                    <input type="radio" id="star3" class="rate" name="star_rating" value="3"/>
                                    <label for="star3" title="text">3 stars</label>
                                    <input type="radio" id="star2" class="rate" name="star_rating" value="2">
                                    <label for="star2" title="text">2 stars</label>
                                    <input type="radio" id="star1" class="rate" name="star_rating" value="1"/>
                                    <label for="star1" title="text">1 star</label>
                                 </div>
                                @error('star_rating')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control @error('comments') is-invalid @enderror" name="comments" rows="6" placeholder="Message" maxlength="200"></textarea>
                                @error('comments')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Post Review" class="btn py-3 px-4 btn-primary">
                            </div>
                        </form>
                    </div>
                </div>

            </div>

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
                <div class="sidebar-box ftco-animate">
                    <h3>Tags</h3>
                    <div class="tagcloud">
                        @foreach ($tags as $tag)
                            <a class="tag-cloud-link">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!-- .section -->

@endsection

@section('style')
<style>
.article-header--rating {
    margin-top: 3rem;
}

.article-header--rating-rate,
.article-header--rating-qty {
    font-family: "Poppins", Arial, sans-serif;
    font-style: normal;
    font-weight: 500;
    font-size: 25px;
    line-height: 34px;
    color: #ffffff;
}

.article-header--rating-star {
    color: #ffffff;
    display: inline-block;
    position: relative;
    font-size: 25px;
    line-height: 1em;
}

.article-header--rating-star::before,
.article-header--rating-star::after {
    content: "★★★★★";
    overflow: hidden;
    font-size: 30px
}

.article-header--rating-star::after {
    position: absolute;
    top: 0;
    left: 0;
    color: #ffc700;
    width: calc(var(--rating) / 5 * 100%);
}

.rate {
    height: 46px;
    padding: 0 10px;
    display: flex;
    flex-direction: row-reverse;
    align-content: center;
    justify-content: flex-end;
}

.rate:not(:checked)>input {
    position: absolute;
    display: none;
}

.rate:not(:checked)>label {
    float: right;
    width: 1em;
    overflow: hidden;
    white-space: nowrap;
    cursor: pointer;
    font-size: 30px;
    color: #ccc;
}

.rate:not(:checked)>label:before {
    content: '★ ';
}

.rate>input:checked~label {
    color: #ffc700;
}

.rate:not(:checked)>label:hover,
.rate:not(:checked)>label:hover~label {
    color: #deb217;
}

.rate>input:checked+label:hover,
.rate>input:checked+label:hover~label,
.rate>input:checked~label:hover,
.rate>input:checked~label:hover~label,
.rate>label:hover~input:checked~label {
    color: #c59b08;
}

.rating-container .form-control:hover,
.rating-container .form-control:focus {
    background: #fff;
    border: 1px solid #ced4da;
}

.rating-container textarea:focus,
.rating-container input:focus {
    color: #000;
}
</style>
@endsection
