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
        <div class="col-md-10">
            <input type="checkbox" name="check_all" id="check_all"><label for="check_all" class="pl-2 pt-2">Pilih Semua ({{ $posts->count() }})</label>
        </div>
        <div class="col-md-2">
            <a href="#" class="btn btn-info" id="download-all">Download Terpilih (0)</a>
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
                        <td id="td_down">
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
        let arr = [];

        function downloadData(id) {
            var id = id;
            var url = '{{ route("post.download.data", ":id") }}';
            url = url.replace(':id', id);
            window.location = url
        }

        $('#download-all').on('click', function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': `{{ csrf_token() }}`
                },
                url: `{{ route('post.download.multiple') }}`,
                type: 'POST',
                data: { data: JSON.stringify(arr) },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    var blob  = new Blob([response]);
                    var link  = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = Date.now()+".zip";
                    link.click();
                    window.location.href = `{{ route('post.download') }}`;
                }
            });
        });


        $(document).ready(function(){
            let count = 0;
            $('.checkbox_download').on('change', function () {
                let $checkdown = $(this);
                let $checkall  = $('#check_all');

                if ($checkall.prop('checked')) {
                    count = `{{ $posts->count() }}`;
                    $checkall.prop("checked", false);
                }

                if ($checkdown.prop('checked')) {
                    $checkdown.addClass('checked');
                    arr.push($(this).data('id'));
                    $('#download-all').text("Download Terpilih ("+ ++count +")");
                } else {
                    if ($checkall.prop("checked", false)) {
                        if (arr.includes($(this).data('id'))) {
                            const index = arr.indexOf($(this).data('id'));
                            if (index > -1) {
                                arr.splice(index, 1);
                            }
                        } else {
                            arr.pop($(this).data('id'));
                        }
                    }
                    $checkdown.removeClass('checked');
                    $('#download-all').text("Download Terpilih ("+ --count +")");
                }
                console.log('array checkdown:' + arr)
            });

            $("#check_all").on('click', function () {
                count = 0;
                let d = [];
                $('.checkbox_download').prop('checked', this.checked);

                // if ($('#check_all').prop("checked", true)) {
                //     if (arr.includes($(this).data('id'))) {
                //         const index = arr.indexOf($(this).data('id'));
                //         if (index > -1) {
                //             arr.splice(index, 1);
                //         }
                //     } else {
                //         arr.pop($(this).data('id'));
                //     }
                // }

                if ($('.checkbox_download').prop('checked')) {
                    $('#download-all').text("Download Terpilih (" + {{ $posts->count() }} + ")");
                    $(".checkbox_download:checked").each(function(i) {
                        d[i] = $(this).data('id');
                        arr.push(d[i]);
                    });
                } else {
                    $('#download-all').text("Download Terpilih (0)");
                    $(".checkbox_download:not(:checked)").each(function(i) {
                        arr = [];
                    });
                }
                console.log('array checkall:' + arr)
            });


        });

    </script>
@endsection
