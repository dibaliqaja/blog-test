@extends('layout_cms.home')
@section('title_page','Edit Post')
@section('content')

    <form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $post->title) }}">

            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="short_description">Short Description</label>
            <input type="text" class="form-control @error('short_description') is-invalid @enderror" name="short_description" value="{{ old('short_description', $post->short_description) }}">

            @error('short_description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" class="form-control @error('content') is-invalid @enderror" id="content">{{ old('content', $post->content) }}</textarea>

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
                    <option value="{{ $category->id }}"
                        @if ($category->id == $post->category_id)
                            selected
                        @endif
                    >{{ $category->name }}</option>
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
            <input type="file" class="form-control-file @error('image') is-invalid @enderror" name="image" value="{{ $post->image }}">
            <span class="text-small text-danger font-italic">Max image upload is 1024 kilobytes</span>

            @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <br>
            <img src="{{ $post->thumbnail == null ? asset('front/images/thumbnail_1.jpg') : asset('storage/thumbnails/'.$post->thumbnail) }}" class="img-fluid" alt="thumbnail" style="width: 200px">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Update</button>
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
