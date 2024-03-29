@extends('users.layouts.master')

@section('title', 'MM Laptops-Shop')

@section('content')
    <div class="col-12 my-4">
        {{-- Search section --}}
        <div class="col-md-6 offset-md-3 my-2" id="searchBar">
            <form action="{{ route('shop.search') }}" method="GET">
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" class="form-control bg-light py-2" placeholder="Search laptops">
                    <select name="brand_id">
                        <option value="">Brand</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-info ms-3">Search</button>
                </div>
            </form>
        </div>
        {{-- Search Section end --}}

        <!-- all laptops Section -->
        <section id="items">
            <div class="row">
                <div class="col-md-10 offset-md-1 mt-sm-0 mt-3">
                    <h5>All Laptops
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
                                                        @guest
                                                            <p>Please <a href="{{ route('login') }}">login</a> to rate this
                                                                laptop!</p>
                                                        @endguest

                                                        @auth
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">
                                                                Rate
                                                            </button>
                                                        @endauth
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-2">
                        {{ $laptops->links() }}
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
                            return Swal.fire(
                                'Sorry!',
                                'You already rated this laptop!',
                                'error'
                            );
                        } else {
                            // rate success
                            // for hiding modal
                            $(`#modal${laptopId}`).modal('hide');
                            return Swal.fire(
                                'Thank you!',
                                `You rated ${response.productName}.`,
                                'success'
                            );
                        }
                    }
                })
            })
        })
    </script>
@endsection
