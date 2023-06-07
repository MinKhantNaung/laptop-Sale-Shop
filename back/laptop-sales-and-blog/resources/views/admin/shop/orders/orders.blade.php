@extends('admin.layouts.master')

@section('title', 'Admin Dashboard-Orders')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">
                Orders
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
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $orders->count() }}
                        <i class="fa-solid fa-coins"></i>
                        <div class="float-end">
                            <form action="{{ route('admin.orders') }}">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="search" id="search" placeholder="Search by customer..."
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
                        {{ $orders->links() }}
                    </div>
                    <div class="table-responsive">
                        @if ($orders->count() > 0)
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer Name</th>
                                        <th>Order Date</th>
                                        <th>Order Code</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="filterTable">
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="text-nowrap orderId">{{ $order->id }}</td>
                                            <td class="text-nowrap">{{ $order->user_name }}</td>
                                            <td class="text-nowrap">{{ $order->created_at->format('F j, Y') }}</td>
                                            <td class="text-nowrap">{{ $order->order_code }}</td>
                                            <td class="text-nowrap">${{ $order->total }}</td>
                                            <td class="text-nowrap">
                                                <select class="selectStatus">
                                                    <option value="0" class="text-warning" {{ $order->status == 0 ? 'selected' : '' }}>Pending</option>
                                                    <option value="1" class="text-success" {{ $order->status == 1 ? 'selected' : '' }}>Accept</option>
                                                    <option value="2" class="text-danger" {{ $order->status == 2 ? 'selected' : '' }}>Reject</option>
                                                </select>
                                            </td>
                                            <td class="text-nowrap">
                                                <form action="{{ route('admin.orderDelete', $order->id) }}" method="POST">
                                                    @csrf

                                                    <a href="{{ route('admin.orderDetail', $order->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="fa-solid fa-circle-info"></i>
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
                            <h1 class="text-center text-warning my-5">No orders found...</h1>
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
            $('.selectStatus').change(function(e) {
                e.preventDefault();
                let parentNode = $(this).closest('tr');
                let orderId = Number(parentNode.find('.orderId').text());
                let status = parentNode.find('.selectStatus').val();

                $.ajax({
                    type: "get",
                    url: "/admin/change-order-status",
                    data: {
                        'orderId': orderId,
                        'status': status
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                    }
                });
            })
        })
    </script>
@endsection
