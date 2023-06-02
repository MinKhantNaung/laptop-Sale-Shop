@extends('users.layouts.master')

@section('title', 'MM Laptops-Shop')

@section('content')
    <div class="col-12 my-4">
        <!-- Brands Section -->
        <section id="category">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h5>What are you looking for ?
                        <a href="{{ route('shop.brands') }}" class="text-decoration-none float-end fs-6">View More
                            ></a>
                    </h5>
                </div>
                <div class="col-md-10 offset-md-1">
                    <div class="row mb-sm-5 mt-sm-4">
                        @foreach ($brandsFilter as $brand)
                            <div class="col-lg-2 col-sm-3 col-4 mt-2">
                                <a href="">
                                    <div class="p-2 position-relative"
                                        style="height:120px; background: rgb(220, 231, 231);">
                                        <div class="position-absolute top-50 start-50 translate-middle">
                                            <div style="width:40px;height:40px">
                                                <img src="{{ asset('storage/brand_images/' . $brand->image) }}"
                                                    alt="image"
                                                    class="w-100 img-fluid object-fit-cover rounded-circle ms-2"
                                                    style="height:100%">
                                            </div>
                                            <div class="text-muted text-center fs-6 text-capitalize">
                                                {{ $brand->name }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Laptops Section -->
        <section id="items">
            <div class="row">
                <div class="col-md-10 offset-md-1 mt-sm-0 mt-3">
                    <h5>Recent Laptops
                        <a href="{{ route('shop.laptops') }}" class="text-decoration-none float-end fs-6">View More ></a>
                    </h5>
                    <div class="row mt-sm-4">
                        @foreach ($laptops as $laptop)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                <div class="card mt-3">
                                    <img src="{{ asset('storage/product_images/' . $laptop->image) }}" style="height:150px"
                                        class="card-img-top img-fluid object-fit-cover" alt="image">
                                    @if ($laptop->discount > 0)
                                        <span
                                            class="badge bg-danger position-absolute top-0 rounded-circle py-3">-{{ $laptop->discount * 100 }}%</span>
                                    @endif
                                    <div class="position-absolute top-50 start-50 translate-middle" id="detail-buttons">
                                        <button type="button" class="btn text-white bg-dark rounded-circle button-hover"
                                            data-bs-toggle="modal" data-bs-target="#modal{{ $laptop->id }}">
                                            <i class="fa-solid fa-star"></i>
                                        </button>
                                        <a href="{{ route('shop.detail', $laptop->id) }}"
                                            class="btn text-white bg-dark rounded-circle button-hover">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </a>
                                    </div>
                                    <div class="card-body overlay" style="background: rgb(220, 231, 231);">
                                        <h6 class="card-title text-capitalize">
                                            {{ $laptop->name }}
                                            <span
                                                class="{{ $laptop->condition == 'new' ? 'text-info' : 'text-secondary' }} fw-bold fs-6">
                                                {{ $laptop->condition }}
                                            </span>
                                        </h6>
                                        @if ($laptop->discount > 0)
                                            <p class="card-text text-primary fs-6">${{ $laptop->discount_price }} &nbsp;
                                                <span class="text-decoration-line-through">${{ $laptop->price }}</span>
                                            </p>
                                        @else
                                            <p class="card-text text-primary fs-6">${{ $laptop->discount_price }}
                                            </p>
                                        @endif
                                    </div>
                                    <!-- for rate modal -->
                                    <div class="modal fade" id="modal{{ $laptop->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                        Rate this laptop?</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form class="editForm">
                                                    <div class="modal-body">
                                                        <input type="hidden" class="laptopId" value="{{ $laptop->id }}">
                                                        <select name="rating" class="form-select">
                                                            <option value="1">1 Star</option>
                                                            <option value="2">2 Stars</option>
                                                            <option value="3">3 Stars</option>
                                                            <option value="4">4 Stars</option>
                                                            <option value="5">5 Stars</option>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">
                                                            Rate
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.editForm').submit(function(e) {
                e.preventDefault();
                let modalDiv = $(this).closest('.modal');
                // get laptopId and rating and user_id
                let laptopId = Number(modalDiv.find('.laptopId').val());
                let rating = Number(modalDiv.find('select[name="rating"]').val());

                $.ajax({
                    type: 'get',
                    url: '/shop/products/ratings',
                    data: {
                        'laptopId': laptopId,
                        'rating': rating
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'fail') {
                            // rate fail
                            // for hiding modal
                            $(`#modal${laptopId}`).modal('hide');
                            return swal('Sorry!', `You already rated this laptop!`,
                                'warning');
                        } else {
                            // rate success
                            // for hiding modal
                            $(`#modal${laptopId}`).modal('hide');
                            return swal('Thank you!', `You rated ${response.productName}.`,
                                'success');
                        }
                    }
                })
            })
        })
    </script>
@endsection
