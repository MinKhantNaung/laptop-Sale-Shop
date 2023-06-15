@extends('admin.layouts.master')

@section('title', 'Admin Dashboard-Posts')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Posts
                <a href="{{ route('admin.postCreate') }}" class="btn btn-sm btn-primary float-end">+ Add Post</a>
            </h1>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Table -->
            <div class="card shadow mb-4">
                {{-- alert messages --}}
                @if (session('success'))
                    <div class="col-12 col-sm-6 col-md-4 alert alert-info alert-dismissible fade show mt-1" role="alert">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('warning'))
                    <div class="col-12 col-sm-6 col-md-4 alert alert-warning alert-dismissible fade show mt-1"
                        role="alert">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('danger'))
                    <div class="col-12 col-sm-6 col-md-4 alert alert-danger alert-dismissible fade show mt-1"
                        role="alert">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ session('danger') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                {{-- alert messages end --}}
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $posts->count() }} Posts
                        <div class="float-end">
                            <form action="{{ route('admin.posts') }}">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="search" id="search" placeholder="Search..."
                                        value="{{ request('search') }}" class="form-control">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </h6>
                </div>
                <div class="card-body">
                    <div>
                        {{ $posts->links() }}
                    </div>
                    <div class="table-responsive">
                        @if ($posts->count() > 0)
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Image</th>
                                        <th>Category</th>
                                        <th>Likes</th>
                                        <th>View</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $index => $post)
                                        <tr>
                                            <td class="text-nowrap">{{ $index + $posts->firstItem() }}</td>
                                            <td class="text-nowrap">{{ $post->title }}</td>
                                            <td class="text-nowrap">
                                                <img src="{{ asset('storage/post_images/' . $post->image) }}"
                                                    alt="post image" class="img-fluid object-fit-cover"
                                                    style="width:100px">
                                            </td>
                                            <td class="text-nowrap">{{ $post->category->name }}</td>
                                            <td class="text-nowrap">{{ $post->likes->count() }}
                                                <i class="fa-regular fa-heart"></i>
                                            </td>
                                            <td class="text-nowrap">{{ $post->view_count }}
                                                <i class="fa-solid fa-eye"></i>
                                            </td>
                                            <td class="text-nowrap">
                                                <form action="{{ route('admin.postDelete', $post->id) }}" method="POST">
                                                    @csrf

                                                    <button type="button" class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal" data-bs-target="#modal{{ $post->id }}"
                                                        title="Info">
                                                        <i class="fa-solid fa-circle-info"></i>
                                                    </button>
                                                    <!--Content Modal -->
                                                    <div class="modal fade" id="modal{{ $post->id }}"
                                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-scrollable">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                                        {{ $post->title }} (Content)
                                                                    </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    {!! $post->content !!}
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-info"
                                                                        data-bs-dismiss="modal">
                                                                        Ok
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- Content Modal end --}}
                                                    <a href="{{ route('admin.postComments', $post->id) }}" class="btn btn-sm btn-secondary">
                                                        <i class="fa-regular fa-comment-dots"></i>
                                                    </a>
                                                    <a href="{{ route('admin.postEdit', $post->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                    <button type="submit" onclick="return confirm('Sure to delete?')" class="btn btn-sm btn-danger">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h1 class="text-center text-warning my-5">No posts found...</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
