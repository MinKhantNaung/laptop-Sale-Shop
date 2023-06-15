@extends('admin.layouts.master')

@section('title', 'Admin Dashboard-Products')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Products
                <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary float-end">+ Add Product</a>
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
                    <h6 class="m-0 font-weight-bold text-primary">{{ $products->count() }} Products
                        <div class="float-end">
                            <form action="{{ route('products.index') }}">
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
                        {{ $products->links() }}
                    </div>
                    <div class="table-responsive">
                        @if ($products->count() > 0)
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Availability</th>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Brand</th>
                                        <th>Condition</th>
                                        <th>Rating</th>
                                        <th>Price</th>
                                        <th>Discount Price</th>
                                        <th>View</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $index => $product)
                                        <tr>
                                            <td class="text-nowrap">
                                                <input type="checkbox" class="checkbox"
                                                    {{ $product->status == 'yes' ? 'checked' : '' }}>
                                                <input type="hidden" id="product-id" value="{{ $product->id }}">
                                            </td>
                                            <td class="text-nowrap">{{ $index + $products->firstItem() }}</td>
                                            <td class="text-nowrap">{{ $product->name }}</td>
                                            <td class="text-nowrap">
                                                <img src="{{ asset('storage/product_images/' . $product->image) }}"
                                                    alt="product image" class="img-fluid object-fit-cover"
                                                    style="width:100px">
                                            </td>
                                            <td class="text-nowrap">{{ $product->brand->name }}</td>
                                            <td class="text-nowrap">
                                                <span
                                                    class="badge {{ $product->condition == 'new' ? 'bg-info' : 'bg-secondary' }} text-white">
                                                    {{ $product->condition == 'new' ? 'New' : 'Second' }}
                                                </span>
                                            </td>
                                            <td class="text-nowrap">
                                                {{ number_format($product->users()->avg('rating'), 1) }}
                                                <i class="fa-solid fa-star text-warning"></i>
                                            </td>
                                            <td class="text-nowrap">${{ $product->price }}</td>
                                            <td class="text-nowrap">${{ $product->discount_price }}</td>
                                            <td class="text-nowrap">{{ $product->view_count }}
                                                <i class="fa-solid fa-eye"></i>
                                            </td>
                                            <td class="text-nowrap">
                                                <form action="{{ route('products.destroy', $product->id) }}"
                                                    method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal" data-bs-target="#modal{{ $product->id }}"
                                                        title="Info">
                                                        <i class="fa-solid fa-circle-info"></i>
                                                    </button>
                                                    <!--Detail Modal -->
                                                    <div class="modal fade" id="modal{{ $product->id }}"
                                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-scrollable">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                                        {{ $product->name }} (Details)
                                                                    </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    {!! $product->description !!}
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
                                                    {{-- Detail Modal End --}}
                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                        class="btn btn-sm btn-info" title="Edit">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                    <button type="submit" onclick="return confirm('Sure to delete?')"
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
                            <h1 class="text-center text-warning my-5">No products found...</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.checkbox').change(function() {
                let parentNode = $(this).parents('tr');
                let productId = parentNode.find('#product-id').val();

                let checked = '';
                // check checkbox property
                if ($(this).prop('checked')) {
                    checked = 'true';
                    $.ajax({
                        type: "get",
                        url: "/admin/change-product-status",
                        data: {
                            'productId': productId,
                            'checked': checked
                        },
                        dataType: "json",
                    });
                } else {
                    checked = 'false';
                    $.ajax({
                        type: "get",
                        url: "/admin/change-product-status",
                        data: {
                            'productId': productId,
                            'checked': checked
                        },
                        dataType: "json",
                    });
                }
            })
        })
    </script>
@endsection
