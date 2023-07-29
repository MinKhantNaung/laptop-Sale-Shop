@extends('users.layouts.master')

@section('title', 'MM Laptops-Blog')

@section('content')
    <div class="row mt-5">   
        <!-- Post Detail Section -->
    <div class="col-md-8 order-md-5">
        <h2 class="text-black text-capitalize text-center fw-bolder px-1 pb-3">
            {{ $post->title }}
        </h2>
        <p class="fs-6 text-black text-center pb-3">By Admin | {{ $post->updated_at->format('M d, Y') }}
            | <i class="fa-solid fa-eye"></i>
            {{ $post->view_count }}
        </p>
        <img src="{{ asset('storage/post_images/' . $post->image) }}" alt="post image"
            class="w-100 border img-fluid object-fit-cover">
        <div class="row mt-4 mb-4">
            <div class="col overflow-auto">
                {!! $post->content !!}
            </div>
        </div>
        <!-- like and comment -->
        <p class="text-center">
            {{-- like button show  --}}
            @guest
                <a href="{{ route('login') }}">
                    <button class="button-hover btn text-white bg-dark rounded-circle position-relative" title="like">
                        <i class="fa-solid fa-heart"></i>
                        <span class="badge bg-danger position-absolute rounded-circle">
                            {{ $post->likes->count() }}
                        </span>
                    </button>
                </a>
            @endguest
            @auth
                {{-- for get post_id and user_id --}}
                <input type="hidden" id="postId" value="{{ $post->id }}">
                <input type="hidden" id="userId" value="{{ auth()->user()->id }}">
                {{-- for get post_id and user_id --}}
                <button id="likeBtn" class="button-hover btn text-white bg-dark rounded-circle position-relative"
                    title="like">
                    <i class="fa-solid fa-heart"></i>
                    <span id="likeCount" class="badge bg-danger position-absolute rounded-circle">
                        {{ $post->likes->count() }}
                    </span>
                </button>
            @endauth
            {{-- like button show --}}
            <button class="button-hover btn text-white bg-dark rounded-circle position-relative ms-5" title="comment"
                data-bs-toggle="modal" data-bs-target="#commentModal{{ $post->id }}">
                <i class="fa-solid fa-comment"></i>
                <span id="btnCommentCount"
                    class="badge bg-danger position-absolute rounded-circle">{{ $post->comments->count() }}</span>
            </button>
        </p>
        <!-- Comments Modal -->
        <div class="modal fade" id="commentModal{{ $post->id }}" tabindex="-1" aria-labelledby="commentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="commentModalLabel">Comments(<span
                                id="commentCount">{{ $post->comments->count() }}</span>)</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="commentList">
                        <ul class="list-group">
                            @foreach ($comments as $comment)
                                <li class="list-group-item">
                                    {{-- for get post_id and user_id --}}
                                    <input type="hidden" value="{{ $post->id }}">
                                    <input type="hidden" value="{{ $comment->user->id }}">
                                    {{-- for get post_id and user_id --}}
                                    <input type="hidden" class="commentId" value="{{ $comment->id }}">
                                    @auth
                                        <button type="button" class="btn-close float-end deleteCommentBtn"></button>
                                    @endauth
                                    {{ $comment->comment }}
                                    <div class="mt-2 small">
                                        By <b>{{ $comment->user->name }}</b>,
                                        {{ $comment->created_at->diffForHumans() }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer">
                        @guest
                            <p>Please <a href="{{ route('login') }}">login</a> to comment this post!</p>
                        @endguest
                        @auth
                            <!-- Auth -->
                            <form id="commentForm" class="col-12">
                                @csrf
                                {{-- for get post_id, user_id  --}}
                                <input type="hidden" id="post-id" value="{{ $post->id }}">
                                <input type="hidden" id="user-id" value="{{ auth()->user()->id }}">
                                {{-- for get post_id, user_id  --}}
                                <textarea id="comment" class="form-control my-2" placeholder="Write a public comment..." required></textarea>
                                <button type="submit" class="btn btn-sm btn-secondary float-end">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    Confirm Comment
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <!-- share -->
        <p class="fw-bolder">Category:
            <span class="text-muted">{{ $post->category->name }}</span>
        </p>
        <p class="fw-bolder">Share on:
            <a href="" class="btn btn-sm text-black rounded-circle bg-white me-1 link-hover"><i
                    class="fa-brands fa-facebook-f"></i></a>
            <a href="" class="btn btn-sm text-black rounded-circle bg-white me-1 link-hover"><i
                    class="fa-brands fa-instagram"></i></a>
            <a href="" class="btn btn-sm text-black rounded-circle bg-white me-1 link-hover"><i
                    class="fa-brands fa-telegram"></i></a>
            <a href="" class="btn btn-sm text-black rounded-circle bg-white me-1 link-hover"><i
                    class="fa-brands fa-twitter"></i></a>
        </p>
    </div>
    <div class="col-md-4 order-md-1">
        <!-- Search -->
        <form action="{{ route('blog.search') }}" method="GET">
            @csrf

            <div class="input-group bg-secondary-subtle p-4 rounded">
                <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                    placeholder="Search posts">
                <button type="submit" class="btn btn-outline-secondary bg-white"><i
                        class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
        <!-- Categories -->
        <div class="mt-4">
            <h4 class="p-3 fw-bold">Categories</h4>
            <ul class="list-group list-group-flush py-2">
                @foreach ($categories as $category)
                    <a href="{{ route('blog.categorySearch', $category->id) }}">
                        <li class="list-group-item">{{ $category->name }} ({{ $category->posts->count() }})</li>
                    </a>
                @endforeach
            </ul>
        </div>
        <!-- Recent Posts -->
        <div class="mt-4">
            <h4 class="p-3 fw-bold">Recent Posts</h4>
            @foreach ($recentPosts as $post)
                <a href="{{ route('blog.detail', $post->id) }}" class="text-decoration-none">
                    <div class="row mt-2">
                        <div class="col-4">
                            <img src="{{ asset('storage/post_images/' . $post->image) }}" alt="post image"
                                class="w-100 img-fluid object-fit-cover" style="height: 100%;">
                        </div>
                        <div class="col-8">
                            <h6 class="fw-bold text-black text-capitalize">
                                {{ $post->title }}
                            </h6>
                            <small class="text-muted">{{ strtoupper($post->updated_at->format('M d, Y')) }}</small>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Like
            $('#likeBtn').click(function() {
                let postId = Number($('#postId').val());
                let userId = Number($('#userId').val());
                // for success
                let likeCount = $('#likeCount');
                let likeCountNumber = Number(likeCount.text());

                $.ajax({
                    type: "get",
                    url: "{{ route('blog.ajaxLike') }}",
                    data: {
                        'postId': postId,
                        'userId': userId
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.message == 'fail') {
                            return Swal.fire(
                                'Oops!',
                                'You already liked this post!',
                                'error'
                            );
                        } else {
                            // success
                            likeCountNumber++;
                            likeCount.text(likeCountNumber);
                        }
                    }
                });
            })

            // Comment Form
            $('#commentForm').submit(function(e) {
                e.preventDefault();
                let comment = $('#comment').val();
                let postId = Number($('#post-id').val());
                let userId = Number($('#user-id').val());
                // for increase comment count
                let commentCount = Number($('#commentCount').text());
                let btnCommentCount = Number($('#btnCommentCount').text());

                $.ajax({
                    type: 'get',
                    url: "{{ route('blog.ajaxComment') }}",
                    data: {
                        'postId': postId,
                        'userId': userId,
                        'comment': comment
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            let newComment = response.comment;
                            let newCommentHtml = `
                                <li class="list-group-item">
                                        <input type="hidden" value="${newComment.post_id}">
                                        <input type="hidden" value="${newComment.user_id}">
                                        <input type="hidden" class="commentId" value="${newComment.id}">
                                        <button type="button" class="btn-close float-end deleteCommentBtn"></button>
                                        ${newComment.comment}
                                        <div class="mt-2 small">
                                            By <b>${response.user}</b>,
                                            ${response.timeAgo}
                                        </div>
                                    </li>
                            `;

                            // Append the new comment to the list-group
                            $('#commentList ul').append(newCommentHtml);

                            // Clear the comment input
                            $('#comment').val('');

                            // increase comment count
                            commentCount++;
                            btnCommentCount++;
                            $('#commentCount').text(commentCount);
                            $('#btnCommentCount').text(btnCommentCount);
                        }
                    }
                })
            })

            // Comment Delete
            $('#commentList ul').on('click', '.deleteCommentBtn', function() {
                Swal.fire({
                    title: 'Oops!',
                    text: "Sure to delete this comment?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        let li = $(this).closest('li');
                        let commentId = li.find('.commentId').val();
                        // for decrease comment count
                        let commentCount = Number($('#commentCount').text());
                        let btnCommentCount = Number($('#btnCommentCount').text());

                        $.ajax({
                            type: "get",
                            url: "{{ route('blog.ajaxCommentDelete') }}",
                            data: {
                                'commentId': commentId
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    // remove comment in view
                                    li.remove();
                                    // decresae comment count
                                    commentCount--;
                                    btnCommentCount--;
                                    $('#commentCount').text(commentCount);
                                    $('#btnCommentCount').text(btnCommentCount);
                                    return Swal.fire(
                                        'Attention!',
                                        'Your comment deleted successfully.',
                                        'success'
                                    );
                                } else {
                                    return Swal.fire(
                                        'Access Denied',
                                        'Only authorized users can delete their comments',
                                        'error'
                                    );
                                }
                            }
                        })
                    }
                })
            });
        })
    </script>
@endsection
