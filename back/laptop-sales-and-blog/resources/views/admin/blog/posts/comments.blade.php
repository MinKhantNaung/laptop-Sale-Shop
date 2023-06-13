@extends('admin.layouts.master')

@section('title', 'Admin Dashboard-Comments')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">
                {{ $post->title }}
                <a href="{{ route('admin.posts') }}" class="btn btn-sm btn-secondary mt-1 float-end">
                    << back </a>
            </h1>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $post->comments->count() }} Comments
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($post->comments->count() > 0)
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>User</th>
                                        <th>Comment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($post->comments as $comment)
                                        <tr>
                                            <td class="text-nowrap commentId">{{ $comment->id }}</td>
                                            <td class="text-nowrap">{{ $comment->user->name }}</td>
                                            <td class="text-nowrap">{{ $comment->comment }}</td>
                                            <td class="text-nowrap">
                                                <button type="button"
                                                    class="btn btn-sm text-white {{ $comment->status == 'show' ? 'btn-danger' : 'btn-info' }} showHideBtn">
                                                    {{ $comment->status == 'show' ? 'Hide' : 'Show' }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h1 class="text-center text-warning my-5">No comments yet...</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.showHideBtn').click(function() {
                let tr = $(this).closest('tr');
                let commentId = Number(tr.find('.commentId').text());

                // for changing btn
                let btn = tr.find('.showHideBtn');

                $.ajax({
                    type: "get",
                    url: "{{ route('admin.manageComment') }}",
                    data: {
                        'commentId': commentId
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.message == 'hided') {
                            // class change
                            btn.removeClass('btn-danger');
                            btn.addClass('btn-info');
                            btn.text('Show');
                        } else {
                            // class change
                            btn.removeClass('btn-info');
                            btn.addClass('btn-danger');
                            btn.text('Hide');
                        }
                    }
                });
            })
        });
    </script>
@endsection
