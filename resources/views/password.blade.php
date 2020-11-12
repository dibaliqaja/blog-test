@extends('layout_cms.home')
@section('title_page','Change Password')
@section('content')

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (Session::has('error') || $errors->any() )
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session('error') }}
            @foreach ($errors->all() as $error)
                {{ $error }} <br>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ route('change.password') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="current_password">Old Password</label>
            <input type="password" class="form-control" name="current_password" autofocus>
        </div>
        <div class="form-group">
            <label for="">New Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <label for="">New Password Confirmation</label>
            <input type="password" class="form-control" name="password_confirmation">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Update</button>
        </div>
    </form>

@endsection
