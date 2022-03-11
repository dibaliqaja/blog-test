@extends('layout_cms.home')
@section('title_page','Download Posts')
@section('content')

    @if (Session::has('alert'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ Session('alert') }}
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
        <div class="col-md-8">
            <input type="checkbox" name="check_all" id="check_all"><label for="check_all" class="pl-2 pt-2">Pilih Semua ({{ $posts->count() }})</label>
        </div>
        <div class="col-md-4">
            <a href="#" class="btn btn-info float-right" id="download-all">Download Terpilih (0)</a>
        </div>
    </div>
    <br>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th width="10%">No</th>
                    <th>Title</th>
                    <th>Short Desc</th>
                    <th>Content</th>
                    <th>Category</th>
                    <th>Thumbnail</th>
                    <th width="15%">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post => $result)
                    <tr>
                        <td>
                            <input type="checkbox" name="checkbox_download" class="checkbox_download" data-id="{{ $result->id }}">
                        </td>
                        <td>{{ $post + $posts->firstitem() }}</td>
                        <td>{{ $result->title }}</td>
                        <td>{{ $result->short_description }}</td>
                        <td>{!! Str::words($result->content, 10, '...') !!}</td>
                        <td>{{ $result->category->name }}</td>
                        <td><img src="{{ $result->thumbnail == null ? asset('front/images/thumbnail_1.jpg') : asset('storage/thumbnails/'.$result->thumbnail) }}" class="img-fluid" alt="thumbnail"></td>
                        <td align="center">
                            <a href="#" class="btn btn-sm btn-warning" onclick="downloadData({{ $result->id }})"><i class="fas fa-download"></i></a>
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
    <div class="mt-3">
        {{ $posts->links() }}
    </div>

@endsection

@section('script')
    <script>
        let articles_id   = [];
        let selected_downloads = 0;

        function downloadData(id) {
            var id = id;
            var url = '{{ route("post.download.data", ":id") }}';
            url = url.replace(':id', id);
            window.location = url
        }

        $('#download-all').on('click', function() {
            if (articles_id.length == 0) {
                alert('Download Terpilih 0');
                return false;
            } else {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': `{{ csrf_token() }}` },
                    url: `{{ route('post.download.multiple') }}`,
                    type: 'POST',
                    data: { data: JSON.stringify(articles_id) },
                    xhrFields: { responseType: 'blob' },
                    success: function(response) {
                        let blob  = new Blob([response]);
                        let link  = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = Date.now()+".zip";
                        link.click();
                        window.location.reload();
                    }
                });
            }
        });

        $(document).ready(function(){
            $('.checkbox_download').on('change', function () {
                if ($('#check_all').prop('checked')) {
                    selected_downloads = `{{ $posts->count() }}`;
                    $('#check_all').prop("checked", false);
                }

                if ($(this).prop('checked')) {
                    $(this).addClass('checked');
                    articles_id.push($(this).data('id'));
                    $('#download-all').text("Download Terpilih ("+ ++selected_downloads +")");
                } else {
                    if ($('#check_all').prop("checked", false)) {
                        if (articles_id.includes($(this).data('id'))) {
                            const index = articles_id.indexOf($(this).data('id'));
                            if (index > -1) {
                                articles_id.splice(index, 1);
                            }
                        } else {
                            articles_id.pop($(this).data('id'));
                        }
                    }
                    $(this).removeClass('checked');
                    $('#download-all').text("Download Terpilih ("+ --selected_downloads +")");
                }
            });

            $("#check_all").on('click', function () {
                selected_downloads = 0;
                let article_id = [];
                $('.checkbox_download').prop('checked', this.checked);
                if ($("#check_all").prop('checked') && articles_id.length > 0) articles_id = [];

                if ($('.checkbox_download').prop('checked')) {
                    $(".checkbox_download:checked").each(function(i) {
                        if(articles_id.includes($(this).data('id'))) articles_id = [];
                        article_id[i] = $(this).data('id');
                        articles_id.push(article_id[i]);
                    });
                    $('#download-all').text("Download Terpilih (" + articles_id.length + ")");
                } else {
                    $(".checkbox_download:not(:checked)").each(() => articles_id = []);
                    $('#download-all').text("Download Terpilih (" + articles_id.length + ")");
                }
            });


        });

    </script>
@endsection
