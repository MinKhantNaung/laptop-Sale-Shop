@extends('admin.layouts.master')

@section('title', 'Admin Dashboard-Orders')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Table -->
            <div class="card shadow mb-4">
                <div class="col-md-6">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="text-primary">Order Info</h3>
                            <small class="text-danger">
                                <i class="fa-solid fa-person-biking text-black"></i>
                                Delivery Cost (Included)
                            </small>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <td>Customer</td>
                                    <td>:</td>
                                    <td>{{ $order->user->name }}</td>
                                </tr>
                                <tr>
                                    <td>Order Code</td>
                                    <td>:</td>
                                    <td class="text-primary">{{ $order->order_code }}</td>
                                </tr>
                                <tr>
                                    <td>Order Date</td>
                                    <td>:</td>
                                    <td>{{ $order->created_at->format('F j, Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>:</td>
                                    <td class="text-danger">${{ $order->total }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Order Products
                        <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-secondary float-end">
                            << back
                        </a>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Order Date</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($orderProducts as $orderProduct)
                                    <tr>
                                        <td class="text-nowrap">{{ $orderProduct->id }}</td>
                                        <td class="text-nowrap">
                                            <img src="{{ asset('storage/product_images/' . $orderProduct->product_image) }}" alt="image" class="img-fluid object-fit-cover" style="width:100px">
                                        </td>
                                        <td class="text-nowrap">
                                            {{ $orderProduct->product_name }}
                                        </td>
                                        <td class="text-nowrap">
                                            {{ $orderProduct->created_at->format('F j, Y') }}
                                        </td>
                                        <td class="text-nowrap">
                                            {{ $orderProduct->quantity }}
                                        </td>
                                        <td class="text-nowrap text-danger">
                                            ${{ $orderProduct->total }}
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
