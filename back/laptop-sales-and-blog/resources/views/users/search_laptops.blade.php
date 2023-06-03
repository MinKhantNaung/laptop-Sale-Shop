@extends('users.layouts.master')

@section('title', 'MM Laptops-Shop')

@section('content')
    <div class="col-12 my-4">
        <!-- Filter and items Section -->
        <div class="col-md-10 offset-md-1">
            <div class="row">
                <!-- items Section start -->
                <div class="col-md-8 order-md-2 mb-5">
                    <div class="row">
                        <div class="col-12">
                            @if (request()->query())
                                <h3>Search By:</h3>
                                <ul>
                                    @foreach (request()->query() as $name => $value)
                                        @php
                                            $brandId = request()->query('brand_id');
                                            $brand = App\Models\Shop\Brand::find($brandId);
                                        @endphp
                                        @if ($value != '')
                                            @if ($name == 'brand_id')
                                                <li>brand: {{ $brand->name }}</li>
                                            @elseif ($name == 'status')
                                                @if ($value == 'yes')
                                                    <li>status: available</li>
                                                @else
                                                    <li>status: not available</li>
                                                @endif
                                            @elseif($name == 'search')
                                                <li>name: {{ $value }}</li>
                                            @elseif ($name == 'page')
                                            @else
                                                <li>{{ $name }}: {{ $value }}</li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @if ($laptops->count() > 0)
                            @foreach ($laptops as $laptop)
                                <div class="col-12 col-sm-6 col-lg-4">
                                    <div class="card mt-3">
                                        <img src="{{ asset('storage/product_images/' . $laptop->image) }}"
                                            style="height:150px" class="card-img-top img-fluid object-fit-cover"
                                            alt="image">
                                        @if ($laptop->discount > 0)
                                            <span
                                                class="badge bg-danger position-absolute top-0 rounded-circle py-3">-{{ $laptop->discount * 100 }}%</span>
                                        @endif
                                        <div class="position-absolute top-50 start-50 translate-middle" id="detail-buttons">
                                            <button type="button"
                                                class="btn text-white bg-dark rounded-circle button-hover"
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
                                                <p class="card-text text-primary fs-6">${{ $laptop->discount_price }}
                                                    &nbsp;
                                                    <span class="text-decoration-line-through">${{ $laptop->price }}</span>
                                                </p>
                                            @else
                                                {{-- for only main price --}}
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
                                                            <input type="hidden" class="laptopId"
                                                                value="{{ $laptop->id }}">
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
                        @else
                            <h1 class="text-center text-warning my-5 py-5">No laptops found...</h1>
                        @endif
                    </div>
                    <div class="mt-2">
                        {{ $laptops->links() }}
                    </div>
                </div>
                <!-- items section end -->

                <!-- filter Section -->
                <div class="col-md-4 order-md-1">
                    <form action="{{ route('shop.search') }}" method="GET">
                        <h6>Filter By
                            <a href="{{ route('shop.search') }}" class="text-danger text-decoration-none float-end">Clear
                                Filter</a>
                        </h6>
                        <div class="my-4">
                            <h6 class="text-muted">Sorting</h6>
                            <input type="radio" id="latest" name="latestPopular" value="latest">
                            <label for="latest" class="user-select-none me-4">Latest</label>
                            <input type="radio" id="popular" name="latestPopular" value="popular">
                            <label for="popular" class="user-select-none">Popular</label>
                        </div>
                        <div class="mb-3">
                            <label for="name">Laptop Name</label>
                            <input type="text" name="name" id="name" class="form-control bg-light mt-2"
                                placeholder="Search by name">
                        </div>
                        <div class="mb-3 row">
                            <label>Price Range</label>
                            <div class="col-6">
                                <input type="number" name="min" class="form-control bg-light" placeholder="min">
                            </div>
                            <div class="col-6">
                                <input type="number" name="max" class="form-control bg-light" placeholder="max">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="brand_id">Brand</label>
                            <select name="brand_id" id="brand_id" class="form-select bg-light mt-2">
                                <option value="">Choose one</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="condition">Condition</label>
                            <select name="condition" id="condition" class="form-select bg-light mt-2">
                                <option value="">Choose one</option>
                                <option value="new">New</option>
                                <option value="second">Second</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-select bg-light mt-2">
                                <option value="">Choose one</option>
                                <option value="yes">Available</option>
                                <option value="no">Not available</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-info text-center py-3 w-100">Apply
                                Filter</button>
                        </div>
                    </form>
                </div>
                <!-- filter Seciton end -->
            </div>
        </div>
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
