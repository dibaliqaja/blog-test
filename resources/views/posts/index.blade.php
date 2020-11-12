@extends('layout_cms.home')
@section('title_page','Posts')
@section('content')

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

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

    <div class="row">
        <div class="col-md-8">
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Add Post</a><br><br>
        </div>
        <div class="col-md-4">
            <form action="#" class="flex-sm">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Search by title" value="{{ Request::get('keyword') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th width="10%">No</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Short Desc</th>
                    <th>Content</th>
                    <th>Category</th>
                    <th>Thumbnail</th>
                    <th width="25%">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post => $result)
                    <tr>
                        <td>{{ $post + $posts->firstitem() }}</td>
                        <td>{{ $result->title }}</td>
                        <td>{{ $result->slug }}</td>
                        <td>{{ $result->short_description }}</td>
                        <td>{{ $result->content }}</td>
                        <td>{{ $result->category->name }}</td>
                        <td><img src="{{ asset('storage/thumbnails/'.$result->thumbnail) }}" class="img-fluid" alt="thumbnail"></td>
                        <td>
                            <a href="{{ route('posts.edit', $result->id) }}" type="button" class="btn btn-sm btn-info"><i class="fas fa-pen"></i></a>
                            <a href="" class="btn btn-sm btn-danger" onclick="deleteData({{ $result->id }})" data-toggle="modal" data-target="#deletePostModal"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No data found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $posts->links() }}

@endsection

@section('modal')
    <!-- Modal Delete -->
    <div class="modal fade" id="deletePostModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="" id="deleteForm" method="post">
                @csrf
                @method('delete')
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="vcenter">Delete Post</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function deleteData(id) {
            var id = id;
            var url = '{{ route("posts.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function formSubmit() {
            $("#deleteForm").submit();
        }
    </script>
@endsection
