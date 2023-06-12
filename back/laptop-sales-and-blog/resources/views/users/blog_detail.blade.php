@extends('users.layouts.master')

@section('title', 'MM Laptops-Blog')

@section('content')
    <!-- Post Detail Section -->
    <div class="col-md-8 order-md-5">
        <h2 class="text-black text-capitalize text-center fw-bolder px-1 pb-3">
            {{ $post->title }}
        </h2>
        <p class="fs-6 text-black text-center pb-3">By Admin | {{ $post->updated_at->format('M d, Y') }}</p>
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
                <span class="badge bg-danger position-absolute rounded-circle">{{ $post->comments->count() }}</span>
            </button>
        </p>
        <!-- Comments Modal -->
        <div class="modal fade" id="commentModal{{ $post->id }}" tabindex="-1" aria-labelledby="commentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="commentModalLabel">Comments({{ $post->comments->count() }})</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($post->comments->count() > 0)
                            <ul class="list-group">
                                @foreach ($post->comments as $comment)
                                    <li class="list-group-item">
                                        {{-- for get post_id and user_id --}}
                                        <input type="text" value="{{ $post->id }}">
                                        <input type="text" value="{{ $comment->user->id }}">
                                        {{-- for get post_id and user_id --}}
                                        <a href="#" class="btn-close float-end"
                                            onclick="confirm('Sure to delete?')"></a>
                                        {{ $comment->comment }}
                                        <div class="mt-2 small">
                                            By <b>{{ $comment->user->name }}</b>,
                                            {{ $comment->created_at->diffForHumans() }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <h3 class="text-danger">No comments yet...</h3>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @guest
                            <p>Please <a href="{{ route('login') }}">login</a> to comment this post!</p>
                        @endguest
                        @auth
                            <!-- Auth -->
                            <form action="" class="col-12">
                                <textarea id="" class="form-control my-2" placeholder="Write a public comment..."></textarea>
                                <button class="btn btn-sm btn-secondary float-end">
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
                    success: function (response) {
                        if (response.message == 'fail') {
                            return swal('Oops!', `You already liked this post!`,
                                'warning');
                        } else {
                            // success
                            likeCountNumber++;
                            likeCount.text(likeCountNumber);
                        }
                    }
                });
            })
        })
    </script>
@endsection
