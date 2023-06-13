@extends('users.layouts.master')

@section('title', 'MM Laptops-Shop')

@section('content')
    <h1 class="fw-bolder text-center mb-3 border-bottom border-3 pb-3 text-white bg-info">
        Your Orders
    </h1>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr class="fw-bold">
                    <th class="text-nowrap">Date</th>
                    <th class="text-nowrap">Order Code</th>
                    <th class="text-nowrap">Total Price</th>
                    <th class="text-nowrap">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="fw-bold">
                        <td class="text-nowrap">{{ $order->created_at->diffForHumans() }}</td>
                        <td class="text-nowrap">{{ $order->order_code }}</td>
                        <td class="text-danger text-nowrap">${{ $order->total }}</td>
                        <td
                            class="text-nowrap @if ($order->status == 0) text-warning @elseif($order->status == 1) text-success @else text-danger @endif">
                            @if ($order->status == 0)
                                <i class="fa-solid fa-clock"></i>
                                pending
                            @elseif($order->status == 1)
                                <i class="fa-solid fa-circle-check"></i>
                                success
                            @else
                                <i class="fa-solid fa-circle-xmark"></i>
                                fail
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let successMessage = sessionStorage.getItem('successMessage');
            if (successMessage) {
                Swal.fire(
                    'Thank you!',
                    `${successMessage}`,
                    'success'
                );
                sessionStorage.removeItem('successMessage');
            }
        })
    </script>
@endsection
