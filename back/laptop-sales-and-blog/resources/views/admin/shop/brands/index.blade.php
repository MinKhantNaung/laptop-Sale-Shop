@extends('admin.layouts.master')

@section('title', 'Admin Dashboard-Brands')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800 col-12">Brands
                <a href="{{ route('brands.create') }}" class="btn btn-sm btn-primary float-end">+ Add Brand</a>
            </h1>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Table -->
            <div class="card shadow mb-4 col-12">
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
                    <h6 class="m-0 font-weight-bold text-primary">{{ $brands->count() }} Brands
                        <div class="float-end">
                            <form action="{{ route('brands.index') }}" method="GET">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="search" id="search" placeholder="Search..."
                                        class="form-control" value="{{ request('search') }}">
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
                        {{ $brands->links() }}
                    </div>
                    <div class="table-responsive">
                        @if ($brands->count() > 0)
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brands as $index => $brand)
                                        <tr>
                                            <td class="text-nowrap">{{ $index + $brands->firstItem() }}</td>
                                            <td class="text-nowrap">{{ $brand->name }}</td>
                                            <td class="text-nowrap">
                                                <img src="{{ asset('storage/brand_images/' . $brand->image) }}"
                                                    alt="product image" class="img-fluid object-fit-cover"
                                                    style="width:100px">
                                            </td>
                                            <td class="text-nowrap">
                                                <form action="{{ route('brands.destroy', $brand->id) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <a href="{{ route('brands.edit', $brand->id) }}"
                                                        class="btn btn-sm btn-info" title="Edit">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                    <button type="submit" onclick="return confirm('Deleting this brand will also delete the associated products. Are you sure you want to proceed?')"
                                                        class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h1 class="text-center text-warning my-5">No brands found...</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
