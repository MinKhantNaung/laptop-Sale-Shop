@extends('admin.layouts.master')

@section('title', 'Admin Dashboard-Posts')
@section('style')
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
@endsection
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Posts
        <a href="{{ route('admin.posts') }}" class="btn btn-sm btn-secondary float-end">
            << back</a>
    </h1>

    <!-- Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Post</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.postUpdate', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title">Title*</label>
                            <input type="text" name="title" id="title"
                                class="form-control mt-2 @error('title') is-invalid @enderror"
                                placeholder="Enter title" value="{{ old('title', $post->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="category_id">Category*</label>
                            <select name="category_id" id="category_id"
                                class="form-select mt-2 @error('category_id') is-invalid @enderror" required>
                                <option value="">Choose category*</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description">Content*</label>
                            <textarea name="content" id="description" placeholder="Enter content">{!! old('content', $post->content) !!}</textarea>
                            @error('content')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image">Post Image*</label> <br>
                            <small class="text-muted">Recommended Size 400 x 200</small>
                            <img src="{{ asset('storage/post_images/' . $post->image) }}" alt="post image"
                                class="w-100 img-fluid img-thumbnail object-fit-cover">
                            <input type="file" name="image" id="image"
                                class="form-control mt-2 @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="btn btn-info">
                                <i class="fa-solid fa-up-long me-1"></i>Update
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('script')
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
