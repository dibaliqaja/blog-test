@extends('layout_cms.home')
@section('title_page','Update Category')
@section('content')

    <form action="{{ route('categories.update', $category->id) }}" method="post">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $category->name) }}">

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('categories.index') }}" class="btn btn-danger">Back</a>
        </div>
    </form>

@endsection

