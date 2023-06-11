@extends('admin.layouts.master')

@section('title', 'Admin Dashboard-Categories')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800 col-12">Categories
                <a href="{{ route('admin.categoryCreatePage') }}" class="btn btn-sm btn-primary float-end">+ Add Category</a>
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
                    <h6 class="m-0 font-weight-bold text-primary">All Categories
                        <div class="float-end">
                            <form action="{{ route('admin.categories') }}" method="GET">
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
                        {{ $categories->links() }}
                    </div>
                    <div class="table-responsive">
                        @if ($categories->count() > 0)
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $index => $category)
                                        <tr>
                                            <td class="text-nowrap">{{ $index + $categories->firstItem() }}</td>
                                            <td class="text-nowrap">{{ $category->name }}</td>
                                            <td class="text-nowrap">
                                                <form action="{{ route('admin.categoryDelete', $category->id) }}" method="POST">
                                                    @csrf

                                                    <a href="{{ route('admin.categoryEdit', $category->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                    <button type="submit" onclick="return confirm('Deleting this category will also delete the associated posts. Are you sure you want to proceed?')" class="btn btn-sm btn-danger">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h1 class="text-center text-warning my-5">No categories found...</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
