@extends('admin.layouts.master')

@section('title', 'Admin Dashboard-Categories')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Blog
        <a href="{{ route('admin.categories') }}" class="btn btn-sm btn-secondary float-end">
            << back</a>
    </h1>

    <!-- Create -->
    <div class="card shadow mb-4 row">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Create Category</h6>
        </div>
        <div class="card-body col-12 col-md-6">
            <form action="{{ route('admin.categoryCreate') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name">Category*</label>
                    <input type="text" name="name" id="name"
                        class="form-control mt-2 @error('name') is-invalid @enderror" placeholder="Type Category name"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary px-3">Create</button>
                </div>
            </form>
        </div>
    </div>

@endsection
