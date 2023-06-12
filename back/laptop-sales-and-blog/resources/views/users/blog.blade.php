@extends('users.layouts.master')

@section('title', 'MM Laptops-Blog')

@section('content')
    <!-- Posts Section -->
    <div class="col-md-8 order-md-5">
        <div class="row">
            @if ($posts->count() > 0)
                <!-- Posts -->
                @foreach ($posts as $post)
                    <div class="col-12 col-sm-6 mt-5 mt-md-0 mb-md-4">
                        <img src="{{ asset('storage/post_images/' . $post->image) }}" alt="image"
                            class="w-100 img-fluid object-fit-cover" style="height:200px">
                        <p class="text-muted mt-3">
                            <i class="fa-regular fa-calendar"></i>
                            {{ $post->updated_at->format('M d, Y') }}
                            <i class="fa-regular fa-comment ps-2"></i>
                            {{ $post->comments->count() }}
                        </p>
                        <h5 class="fw-bold text-capitalize">{{ $post->title }}</h5>
                        <a href="{{ route('blog.detail', $post->id) }}" class="btn border border-1 border-black text-black my-3 rounded-pill">
                            Read
                            <i class="fa-solid fa-right-long ms-1 fs-6"></i>
                        </a>
                    </div>
                @endforeach
            @else
                    <h1 class="my-5 text-center text-warning">No posts found...</h1>
            @endif
        </div>
        <div>
            {{ $posts->links() }}
        </div>
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

