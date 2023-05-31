@extends('admin.layouts.master')

@section('title', 'Admin Dashboard-Products')
@section('style')
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
@endsection
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Products
        <a href="{{ route('products.index') }}" class="btn btn-sm btn-secondary float-end">
            << back</a>
    </h1>

    <!-- Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Product</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Name*</label>
                            <input type="text" name="name" id="name"
                                class="form-control mt-2 @error('name') is-invalid @enderror"
                                placeholder="Enter product name" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="brand_id">Brand*</label>
                            <select name="brand_id" id="brand_id"
                                class="form-select mt-2 @error('brand_id') is-invalid @enderror" required>
                                <option value="">Choose brand*</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand_id', $product->brand->id) == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description">Description*</label>
                            <textarea name="description" id="description" placeholder="Enter Description">{!! old('description', $product->description) !!}</textarea>
                            @error('description')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image">Product Image*</label> <br>
                            <small class="text-muted">Recommended Size 400 x 200</small>
                            <img src="{{ asset('storage/product_images/' . $product->image) }}" alt="product image"
                                class="w-100 img-fluid img-thumbnail object-fit-cover">
                            <input type="file" name="image" id="image"
                                class="form-control mt-2 @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price">Price*</label>
                            <div class="input-group mt-2">
                                <span class="input-group-text">$</span>
                                <input type="number" name="price" id="price" step="0.01" min="0"
                                    placeholder="Enter price" value="{{ old('price', $product->price) }}"
                                    class="form-control @error('price') is-invalid @enderror" required>
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="discount">Discount (%):</label>
                            <input type="number" name="discount" id="discount" min="0" step="0.01"
                                max="1" placeholder="Discount value"
                                value="{{ old('discount', $product->discount) }}"
                                class="form-control mt-2 @error('discount') is-invalid @enderror" required>
                            @error('discount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted">Please enter a discount value between 0 and 1.
                                <i class="fa-solid fa-triangle-exclamation"></i> 0 means 0% and 1 means
                                100% discount!
                            </small>
                        </div>
                        <div class="mb-3">
                            <label for="condition">Condition*</label>
                            <select name="condition" id="condition"
                                class="form-select mt-2 @error('condition') is-invalid @enderror" required>
                                <option value="">Choose condition</option>
                                <option value="new"
                                    {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>New</option>
                                <option value="second"
                                    {{ old('condition', $product->condition) == 'second' ? 'selected' : '' }}>Second
                                </option>
                            </select>
                            @error('condition')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status" value="yes" id="status"
                                    {{ old('status', $product->status) == 'yes' ? 'checked' : '' }}>
                                <label class="form-check-label user-select-none ms-0" for="status">
                                    Available
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info text-light mt-2">Update</button>
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
