@extends('layout_cms.home')
@section('title_page','Update Tag')
@section('content')

    <form action="{{ route('tags.update', $tag->id) }}" method="post">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $tag->name) }}">

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('tags.index') }}" class="btn btn-danger">Back</a>
        </div>
    </form>

@endsection

