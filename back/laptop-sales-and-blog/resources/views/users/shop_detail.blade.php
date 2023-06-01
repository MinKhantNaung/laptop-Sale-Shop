@extends('users.layouts.master')

@section('title', 'MM Laptops-Shop')

@section('content')
    <!-- Detail Section -->
    <div class="col-12 my-4">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('storage/product_images/' . $laptop->image) }}"
                    class="img-fluid object-fit-cover w-100 border">
            </div>
            <div class="col-md-6">
                <h3 class="fw-bold">
                    {{ $laptop->name }}
                </h3>
                <span class="badge bg-info mb-2">{{ $laptop->brand->name }}</span>
                <span class="badge {{ $laptop->condition == 'new' ? 'bg-info' : 'bg-secondary' }} mb-2">
                    {{ $laptop->condition == 'new' ? 'New' : 'Second' }}
                </span>
                <p>{{ number_format($laptop->users()->avg('rating'), 1) }} <i
                        class="fa-solid fa-star text-warning"></i>&nbsp; (ratings)</p>
                @if ($laptop->discount > 0)
                    <h3 class="fw-bold text-danger">${{ $laptop->discount_price }}
                        <span class="text-decoration-line-through text-primary">${{ $laptop->price }}</span>
                    </h3>
                @else
                    <h3 class="fw-bold text-danger">${{ $laptop->discount_price }}</h3>
                @endif
                <p class="text-muted">
                    {!! $laptop->description !!}
                </p>
                <div class="input-group bg-light d-flex align-items-center mt-3">
                    <button type="button" class="btn btn-white border-0 minus">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                    <input type="text" class="border-0 text-center quantity" style="width:50px;" value="1"
                        min="1" disabled>
                    <button type="button" class="btn btn-white border-0 plus">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-info text-white fw-bolder">
                        ADD TO CART
                    </button>
                    <button type="button" class="btn btn-sm btn-success ms-2" data-bs-toggle="modal"
                        data-bs-target="#rate{{ $laptop->id }}">
                        <i class="fa-solid fa-star text-warning"></i>
                        Rate this
                    </button>
                </div>
                <!-- for rate modal -->
                <div class="modal fade" id="rate{{ $laptop->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                    Rate this laptop?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <select name="rating" class="form-select">
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="5">5 Stars</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary">
                                    Rate
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="fs-6 fw-bold">Availability: <span
                            class="text-muted">{{ $laptop->status == 'yes' ? 'available' : 'not available' }}</span></p>
                    <p class="fs-6 fw-bold">Share on:
                        <a href="" class="btn btn-sm text-black rounded-circle bg-white me-1 link-hover"><i
                                class="fa-brands fa-facebook-f"></i></a>
                        <a href="" class="btn btn-sm text-black rounded-circle bg-white me-1 link-hover"><i
                                class="fa-brands fa-instagram"></i></a>
                        <a href="" class="btn btn-sm text-black rounded-circle bg-white me-1 link-hover"><i
                                class="fa-brands fa-telegram"></i></a>
                        <a href="" class="btn btn-sm text-black rounded-circle bg-white me-1 link-hover"><i
                                class="fa-brands fa-twitter"></i></a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Laptops Section -->
    <section id="items">
        <div class="row">
            <div class="col-md-10 offset-md-1 mt-sm-0 mt-3 mb-5">
                <h1 class="fw-bolder text-center mb-5 border-bottom border-3 pb-3">Related
                    Laptops
                </h1>
                <div class="row mt-sm-4">
                    @foreach ($related_laptops as $laptop)
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
                                        data-bs-toggle="modal" data-bs-target="#shopModal{{ $laptop->id }}">
                                        <i class="fa-solid fa-star"></i>
                                    </button>
                                    <a href="{{ route('shop.detail', $laptop->id) }}"
                                        class="btn text-white bg-dark rounded-circle button-hover">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                    </a>
                                </div>
                                <div class="card-body overlay" style="background: rgb(220, 231, 231);">
                                    <a href="" class="text-decoration-none">
                                        <h6 class="card-title text-capitalize">
                                            {{ $laptop->name }}
                                            <span
                                                class="{{ $laptop->condition == 'new' ? 'text-info' : 'text-secondary' }} fw-bold fs-6">
                                                {{ $laptop->condition }}
                                            </span>
                                        </h6>
                                    </a>
                                    @if ($laptop->discount > 0)
                                        <p class="card-text text-primary fs-6">
                                            ${{ $laptop->discount_price }}
                                            &nbsp;
                                            <span class="text-decoration-line-through">${{ $laptop->price }}</span>
                                        </p>
                                    @else
                                        <p class="card-text text-primary fs-6">
                                            ${{ $laptop->discount_price }}
                                        </p>
                                    @endif
                                </div>
                                <!-- for rate modal -->
                                <div class="modal fade" id="shopModal{{ $laptop->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                    Rate this laptop?</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
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
                                                <button type="button" class="btn btn-primary">
                                                    Rate
                                                </button>
                                            </div>
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
@endsection
