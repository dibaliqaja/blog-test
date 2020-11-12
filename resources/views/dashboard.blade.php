@extends('layout_cms.home')
@section('title_page','Dashboard')

@section('content')

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-list-alt"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Categories</h4>
                    </div>
                    <div class="card-body">
                        {{ DB::table('categories')->count() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-file-signature"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Posts</h4>
                    </div>
                    <div class="card-body">
                        {{ DB::table('posts')->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
