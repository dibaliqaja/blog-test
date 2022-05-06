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
                    <i class="fas fa-tags"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Tags</h4>
                    </div>
                    <div class="card-body">
                        {{ DB::table('tags')->count() }}
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
                        @if (Gate::allows('admin-access'))
                            {{ DB::table('posts')->count() }}
                        @else
                            {{ DB::table('posts')->where('users_id', auth()->id())->count() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
