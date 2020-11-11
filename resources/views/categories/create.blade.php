@extends('layout_cms.home')
@section('title_page','Add Category')
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

    <form action="{{ route('categories.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Add</button>
            <a href="{{ route('categories.index') }}" class="btn btn-danger">Back</a>
        </div>
    </form>

@endsection
