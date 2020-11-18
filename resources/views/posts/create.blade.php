@extends('layout_cms.home')
@section('title_page','Add Post')
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}">

            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="short_description">Short Description</label>
            <input type="text" class="form-control @error('short_description') is-invalid @enderror" name="short_description" value="{{ old('short_description') }}">

            @error('short_description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" class="form-control @error('content') is-invalid @enderror" id="content">{{ old('content') }}</textarea>

            @error('content')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="category_id">Category</label>
            <select class="form-control select2 @error('category_id') is-invalid @enderror" name="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            @error('category_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file @error('image') is-invalid @enderror" name="image">
            <span class="text-small text-danger font-italic">Max image upload is 1024 kilobytes</span>

            @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Add</button>
            <a href="{{ route('posts.index') }}" class="btn btn-danger">Back</a>
        </div>
    </form>


@endsection

@section('script')
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection
