@extends('admin.layouts.master')

@section('title', 'Admin Dashboard-Brands')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Brands
        <a href="{{ route('brands.index') }}" class="btn btn-sm btn-secondary float-end">
            << back</a>
    </h1>

    <!-- Table -->
    <div class="card shadow mb-4 row">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Brand</h6>
        </div>
        <div class="card-body col-12 col-md-6">
            <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label for="name">Brand*</label>
                    <input type="text" name="name" id="name"
                        class="form-control mt-2 @error('name') is-invalid @enderror" placeholder="Type brand name"
                        value="{{ old('name', $brand->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="image">Brand Photo*</label> <br>
                    <small class="text-muted">Recommended Size 400 x 200</small>
                    <img src="{{ asset('storage/brand_images/' . $brand->image) }}" alt="brand image"
                        class="w-100 img-fluid img-thumbnail object-fit-cover">
                    <input type="file" name="image" id="image"
                        class="form-control mt-2 @error('image') is-invalid @enderror">
                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary px-3">Update</button>
                </div>
            </form>
        </div>
    </div>

@endsection
