@extends('layout_cms.home')
@section('title_page','Update Category')
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
                {{ $error }} <br>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ route('categories.update', $category->id) }}" method="post">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $category->name) }}">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('categories.index') }}" class="btn btn-danger">Back</a>
        </div>
    </form>

@endsection

